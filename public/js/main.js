;(function(window, document, undefined){

	define(['app/ui/views', 'app/ui/events', 'app/ui/handler', 'app/ui/router', 'app/utils'], function(Views, Events, Handler, router, utils){

	    return function Application(){

	        var self = this;

            function setup(){

                self.events = new Events();

                self.views = new Views();
                
                self.events.on('ready', function(e){

                    self.load(window.location.pathname);
                });

                self.events.on('interaction', Handler);

                return self;
            };

            self.load = function(url, data, callback){

                router.request(url, data, function(response, status){

                    if(!status) throw new Error("Error loading " + url, [status]);

                    if(!response.template) throw new Error("Template not set for " + url, [status, response]); 

                    self.views.load(response, function(status){

                        (callback||function(){})(response,status);

                    });
                });
            };     

            self.navigate = function(url, data){

                self.load(url, data, function(response, status){

                    if(!status) throw new Error("Error navigating to " + url, [status, response]);

                    window.trigger('navigate', { 
                        url: response.redirect||url, 
                        data:data, 
                        response: response
                    });
                });
            };	     

	        return setup();

	    }

    });

})(this, this.document, undefined);