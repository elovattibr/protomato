;(function(window, document, undefined){

    define(['app/utils'], function(utils){

        return new function Router() {

            var self = this;

            self.request = function(url, data, callback) {

                utils.post(url, data, function(status, response){

                   return callback((status>0)?response:{}, status);
                });
            }
        }
    });

})(this, this.document, undefined);