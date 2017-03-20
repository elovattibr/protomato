;(function(window, document, undefined){

	window.on('navigate', function(event){

		var data = event.detail,
			url = data.url;

		return history.pushState(data, null, data.url);
	});

	window.on('popstate', function(e){

        var state = e.state||window.history.state||{},
            url = state.url||"/",
            data = state.data||false;

	    window.app.load(url, data);
        return true;

	});

    define(['app/utils'], function(utils){

    	function Navigation(element){

			var self = this,
				method = element.getAttribute('method'),
				location = element.getAttribute('href');

			self.navigate = function(){

				window.app.navigate(location, {});
			}

			self.request = function(){}   

			self.submit = function(button){

				var form = button.parents('form'),
					data = form.serializeObject();

				window.app.navigate(location, data);
			}   

			/*Default prevention ignore*/
			if(self[method] === 'undefined'){
				return true;
			}

			/*Default prevention*/
			self[method](element);

			return false;

    	}
        
        return function Handler(e){

            var self = this,
            	event = e||window.event, 
            	type = event.type||false,
            	element = event.target||event.srcElement||false;

        	switch(true){

        		case (type==='click' && element.hasAttribute("method")):
        			event.preventDefault();
	        		return new Navigation(element);

        	}

	        return true;

	    }
    });

})(this, this.document, undefined);