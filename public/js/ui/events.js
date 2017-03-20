;(function(document, window, ctx){

	var events = {},
		bonds = {
			'domupdate':[
				'DOMNodeInserted', 'DOMNodeRemoved'
			],
			'interaction':[
				'click'
			],
		};

    define(['app/utils', 'app/ui/router'], function(utils, router) {

		bonds.each(function(handler, evts){

			evts.each(function(idx, event){

				document.on(event, function(evt){
					trigger(handler, evt);
				});
			});
		})

		function trigger(evt, data){

			if(typeof events[evt] !== 'object') return;

			events[evt].each(function(idx, func){

				if(typeof func === 'function'){
					func(data);
				}
			});			
		}

		function bind(evt, callback){

			if(typeof events[evt] === 'undefined'){
				events[evt] = [];
			}

			events[evt].push(callback);
		}

		return function Events(){

    		return {
    			on: bind,
    			trigger: trigger,
    		};
    	};
    })

})(document, window, this);

