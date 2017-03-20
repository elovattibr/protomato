;(function(window, document, undefined){

    define(['app/utils'], function(utils){

        function Helpers(){

            return {
                app: window.app,
                arr:function(str){
                    return eval(str);
                },
                log:function(data){
                    console.log(data);
                },
                dump:function(data){
                    switch(typeof data){
                        case 'object':
                        case 'array':
                            return JSON.stringify(data);
                    }
                    return data;
                },
                typeof:function(value){
                    return typeof value;
                },
                checked:function(value){
                    switch(value){
                        case 'on': return 'checked';
                        case '1': return 'checked';
                        case 'true': return 'checked';
                        case true: return 'checked';
                        case (value>0): return 'checked';
                    }
                    return "";
                }
            }
        }

        return Helpers;        

    });

})(this, this.document, undefined);