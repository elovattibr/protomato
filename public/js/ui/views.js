;(function(window, document, undefined){

    /*THESE REMAINS WHILE RE-REQURE*/
    var cache = {
        requires: {},
        imports: {},
    };

    define(['jsrender','app/utils', 'app/ui/helpers'], function(renderer, utils, helpers){

        function Views() {

            var self = this,
                body = document.getElementsByTagName('body');

            self.helpers = new helpers();    

            function registerHelpers(){

                renderer.views.helpers(self.helpers);
            }

            function registerTags(){

                renderer.views.tags("dump", function(){
                    console.log(['dump', ['args',this.tagCtx.args], ['props',this.tagCtx.props]]);
                    console.log('Args', this);
                });

                renderer.views.tags("require", function(){

                    var tag = this;
                        args = tag.tagCtx.args||[],
                        success = tag.tagCtx.props.onSuccess||'';

                    for(var i=0, item; i < args.length, item=args[i]; i++){

                        if(typeof cache.requires[item] === 'undefined'){
                            
                            utils.getBowerComponent(item, function(){
                                console.log(item)
                                window.eval(success);
                            });
                        };

                        cache.requires[item] = true;
                    }
                });

                renderer.views.tags("import", function(){

                    var tag = this;
                        props = tag.tagCtx.props,
                        type = props.type,
                        src = props.src;

                    switch(true){
                        case (typeof cache.imports[src] !== 'undefined'): break;
                        case (type === 'style'): utils.importStyle(src); break;
                        case (type === 'script'): utils.importScript(src); break;
                    }

                    cache.imports[src] = true;

                });

                renderer.views.tags("template", function(){

                    var tag    = this,
                        props  = tag.tagCtx.props,
                        name   = props.name,
                        render = props.render||false,
                        append = props.append||false,
                        dtsrc  = props.datasource||false,
                        tmpl   = tag.tagCtx.content;
                        markup = (render==true)?tmpl.render(tag.ctx.root):tmpl.markup;

                    return '<script type="text/html" class="template" name="'+name+'" data-datasource="'+dtsrc+'" data-append_to="'+append+'">'+markup+'</script>';

                });
            }

            function registerComponents(){

                var componentsLocation = '/public/templates/mdl.tpl';

                utils.getFile(componentsLocation, function(status, response){

                    if(status === false){
                        throw new Error("UI Components not found in "+componentsLocation);
                        return; 
                    }

                    var parser = new DOMParser(),
                        html = parser.parseFromString(response, "text/html"),
                        scripts = html.getElementsByTagName('script');

                    for (var i=0; i<scripts.length; i++) {

                        var item = scripts[i],
                            name = item.getAttribute('name')||'unamed',
                            mode = item.getAttribute('mode')||'template',
                            markup = item.text;

                        renderer.views.templates(name, markup);

                        if(mode === 'tag'){
                            renderer.views.tags(name, function(){

                                var tag = this,
                                    name = tag.tagName,
                                    set = utils.extend({}, tag.ctx.root, {
                                        'props':tag.tagCtx.props,
                                        'args':tag.tagCtx.args
                                    });

                                return renderer.render[name](set, tag);
                            });
                        }
                    }                    

                    window.app.events.trigger('ready');

                });
            }

            self.setup = function(){

                //renderer.views.settings.allowCode(true);

                registerTags();

                registerHelpers();

                registerComponents();
            };

            self.load = function(data, callback){

                document.body.innerHTML = null;

               return (callback||function(){})( document.body.innerHTML = self.render(data.template, data) );
            };

            self.render = function(template, data){

                var tmpl = renderer.templates(template);

                return tmpl.render(data);
            }

            return self.setup()
        }

        return Views;        

    });

})(this, this.document, undefined);