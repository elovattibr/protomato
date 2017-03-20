require.config({
    baseUrl:'/public/',
    packages:[
	    {
	    	name: 'app',
	    	location: 'js/'
	    },
	    {
	    	name: 'jsrender',
	    	location: 'bower_components/jsrender',
	    	main: 'jsrender.min'
	    }
    ]
});

requirejs(['app', 'app/std'], function(Application){

    window.app = new Application();
});