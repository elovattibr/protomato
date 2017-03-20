;(function(document, window, ctx, undefined){
  
    define(['exports'],function(exports) {

        var Post = exports.post = function (url, data, callback){

          function param(object) {
              var encodedString = '';
              for (var prop in object) {
                  if (object.hasOwnProperty(prop)) {
                      if (encodedString.length > 0) {
                          encodedString += '&';
                      }
                      encodedString += encodeURI(prop + '=' + object[prop]);
                  }
              }
              return encodedString;
          }

          var xhr = new XMLHttpRequest(),
              data = param(data);

          xhr.open('POST', url, true);

          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

          xhr.onload = function(){

            callback(xhr.status, JSON.parse(xhr.response));
          };

          xhr.send(data);
          
        }

        var getFile = exports.getFile = function (path, callback, evaluate){

            var request = new XMLHttpRequest();

            request.open('GET', path, true);

            request.onload = function() {

                var status = (request.status===200);

                if(evaluate===true){
                    callback(status, eval(request.response));
                    return;
                }
                
                callback(status, request.response);
            };

            request.onerror = function() {
              callback(false, request);
            };

            return request.send();
        }    

        var getBowerComponent = exports.getBowerComponent = function (name, onload){

            var location = '/public/bower_components/'+name+'/';

            function appendScript(path){

                var head = document.getElementsByTagName('head')[0],
                    script = false;


                switch(path.split('.').pop()){

                  case 'js':
                    script = document.createElement('script');              
                    script.type = 'text/javascript';
                    script.onload = onload||function(){};
                    script.src = path;
                    break;

                  case 'css':
                    script = document.createElement('link');              
                    script.type = "text/css";
                    script.rel = "stylesheet";
                    script.href = path;
                    break;

                }

                if(script !== false){
                  head.appendChild(script);
                }

            }

           getFile(location + 'bower.json', function(status, response){

              if(!status){
                return new Error("Bower component not found");
              }

              var bowerConfig = JSON.parse(response);

              switch(true){

                case (typeof bowerConfig.main === 'object' && bowerConfig.main.length > 0):
                  for(var i=0, item; i < bowerConfig.main.length, item=bowerConfig.main[i]; i++){
                      appendScript(location+item);
                  }
                  break;

                case (typeof bowerConfig.main === 'string'):
                      appendScript(location+bowerConfig.main);
                  break;

                default:
                  new Error("Bower component has no main entry.");

              }

            })
        };

        var importStyle = exports.importStyle = function (src){

          var head = document.getElementsByTagName('head')[0],
              script = document.createElement('link'); 

            script.type = "text/css";
            script.rel = "stylesheet";
            script.href = src;
            head.appendChild(script);
        };

        var importStyle = exports.importScript = function (src){

          var head = document.getElementsByTagName('head')[0],
              script = document.createElement('script');              
          
            script.type = 'text/javascript';
            script.onload = onload||function(){};
            script.src = src;

            head.appendChild(script);
        };

        var Guid = exports.guid = function guid(){
          function s4() {
            return Math.floor((1 + Math.random()) * 0x10000)
              .toString(16)
              .substring(1);
          }
          return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
            s4() + '-' + s4() + s4() + s4();
        };

        var Extend = exports.extend = function extend(){
            for(var i=1; i<arguments.length; i++)
                for(var key in arguments[i])
                    if(arguments[i].hasOwnProperty(key))
                        arguments[0][key] = arguments[i][key];
            return arguments[0];
        };

    });
})(document, window, this, undefined);    


