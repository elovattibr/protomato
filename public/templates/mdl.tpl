<script type="text/html" name="page" mode="tag">

    <div class="mdl-page mdl-layout mdl-js-layout {{if props.fixed_header}} mdl-layout--fixed-header {{/if}} {{if props.fixed_drawer}} mdl-layout--fixed-drawer {{/if}}">
        {{include tmpl=~tagCtx.content /}}
    </div>

    {{require 
        "material-design-lite" 
        onSuccess="function upgrade(){ window.componentHandler.upgradeDom() }; window.app.events.on('domupdate', upgrade); upgrade(); "
    /}}

    {{import type="style" src="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en"/}}
    {{import type="style" src="https://fonts.googleapis.com/icon?family=Material+Icons"/}}
    
</script>

<script type="text/html" name="header" mode="tag">
    <header class="mdl-layout__header"> 
        {{if props.button}}
        <button class="mdl-layout-icon mdl-button mdl-js-button mdl-button--icon">
            <i class="material-icons">{{:props.button}}</i>
        </button>   
        {{/if}}    
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title">{{:props.title}}</span>
            <div class="mdl-layout-spacer"></div>
            {{if props.links}}
            <nav class="mdl-navigation">
                {{for props.links}}
                <a method="{{:method||'navigate'}}" href="{{:href}}" class="mdl-navigation__link" title="{{:label}}"><i class="material-icons">{{:icon}}</i>{{:label}}</a>
                    {{/for}}
            </nav>              
            {{/if}}
            {{if props.menu}}
            <nav class="options-menu">
                <button id="options-menu" class="mdl-button mdl-js-button mdl-button--icon">
                    <i class="material-icons">more_vert</i>
                </button>
                <ul for="options-menu" class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect">
                    {{for props.menu}}

                        <li class="mdl-menu__item">

                            <a method="{{:method||'navigate'}}" href="{{:href}}" class="mdl-navigation__link" title="{{:title}}"><i class="material-icons">{{:icon}}</i>{{:label}}</a>
                        </li>
                    {{/for}}    
                </ul>        
            </nav>            
            {{/if}}            
        </div>
        {{include tmpl=~tagCtx.content /}}
    </header>
</script>

<script type="text/html" name="drawer" mode="tag">
    <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">{{:props.title}}</span>
        <nav class="mdl-navigation">
            {{for props.options}}
                <a method="{{:method||'navigate'}}" href="{{:href}}" class="mdl-navigation__link" href="#">{{:label}}</a>
            {{/for}}            
        </nav>
    </div>    
</script>    

<script type="text/html" name="contents" mode="tag">
    <main class="mdl-layout__content ">
        <div class="page-content">
            <div class="mdl-grid {{if props.borderless == 'true'}} mdl-grid--no-spacing {{/if}}">
                {{cell phone="4" tablet="8" desktop="12" content=~tagCtx.content}}
                    {{include tmpl=props.content /}}
                {{/cell}}
            </div>
        </div>
        {{if buffer}}
            <footer class="mdl-mega-footer">
                <div class="mdl-mega-footer__top-section">
                    <h5>Controller output buffer</h5>
                    <pre>{{:buffer}}</pre>
                </div>
            </footer>
        {{/if}}        
    </main>
</script>

<script type="text/html" name="grid" mode="tag">
    <div class="mdl-grid {{:props.class}} {{if props.borderless = 'true'}} mdl-grid--no-spacing {{/if}}">
        {{include tmpl=~tagCtx.content /}}
    </div>
</script>
    
<script type="text/html" name="cell" mode="tag">
    <div class="mdl-cell {{if props.cols > 0}}mdl-cell--{{:props.cols}}-col{{/if}} {{if props.offset > 0}}mdl-cell--{{:props.offset}}-offset{{/if}} {{if props.phone > 0}}mdl-cell--{{:props.phone}}-col-phone{{/if}} {{if props.phone_offset > 0}}mdl-cell--{{:props.phone_offset}}-offset-phone{{/if}} {{if props.tablet > 0}}mdl-cell--{{:props.tablet}}-col-tablet{{/if}} {{if props.tablet_offset > 0}}mdl-cell--{{:props.tablet_offset}}-offset-tablet{{/if}} {{if props.desktop > 0}}mdl-cell--{{:props.desktop}}-col-desktop{{/if}} {{if props.desktop_offset > 0}}mdl-cell--{{:props.desktop_offset}}-offset-desktop{{/if}}" style="{{if props.background}}background-color: {{:props.background}};{{/if}}">
        {{include tmpl=~tagCtx.content /}}
    </div>
</script>            
           
<script type="text/html" name="form" mode="tag">
    <form name="{{:props.name}}" url="{{:props.action}}" method="POST">
        {{include tmpl=~tagCtx.content /}}
    </form>
</script>           
    
<script type="text/html" name="input" mode="tag">
    
    {{if props.type=="hidden"}}
        <input type="hidden" name="{{:props.name}}" autocomplete="off" value="{{:props.value}}"/>
    {{/if}}
    
    {{if !props.type || props.type=="text"}}
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label " style="width:100%;">
            <input class="mdl-textfield__input " autocomplete="off"  type="text" name="{{:props.name}}" id="{{:props.name}}" value="{{:props.value}}">
            <label class="mdl-textfield__label" for="{{:props.name}}">{{:props.label}}</label>
            <span class="mdl-textfield__error"></span>
        </div>
    {{/if}}

    {{if props.type=="date"}}
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:100%;">
            <input class="mdl-textfield__input" autocomplete="off" type="text" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" name="{{:props.name}}" id="{{:props.name}}" value="{{:props.value}}">
            <label class="mdl-textfield__label" for="{{:props.name}}">{{:props.label}}</label>
            <span class="mdl-textfield__error"></span>
        </div>
    {{/if}}

    {{if props.type=="number"}}
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:100%;">
            <input class="mdl-textfield__input" autocomplete="off" type="text" pattern="-?[0-9]*(\.[0-9]+)?" name="{{:props.name}}" id="{{:props.name}}" value="{{:props.value}}">
            <label class="mdl-textfield__label" for="{{:props.name}}">{{:props.label}}</label>
            <span class="mdl-textfield__error"></span>
        </div>
    {{/if}}

    {{if props.type=="checkbox"}}
        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="{{:props.name}}">
          <input type="checkbox" name="{{:props.name}}" id="{{:props.name}}" class="mdl-checkbox__input" {{:~checked(props.checked)}}>
          <span class="mdl-switch__label">{{:props.label}}</span>
          <span class="mdl-textfield__error"></span>
        </label>
    {{/if}}

    {{if props.type=="switch"}}
        <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="{{:props.name}}">
          <input type="checkbox" name="{{:props.name}}" id="{{:props.name}}" class="mdl-switch__input" {{:~checked(props.checked)}}>
          <span class="mdl-switch__label">{{:props.label}}</span>
          <span class="mdl-textfield__error"></span>
        </label>
    {{/if}}

    {{if props.type=="toggle"}}
        <label class="mdl-icon-toggle mdl-js-icon-toggle mdl-js-ripple-effect" for="{{:props.name}}">
          <input type="checkbox" name="{{:props.name}}" id="{{:props.name}}" class="mdl-icon-toggle__input" {{:~checked(props.checked)}}>
          <i class="mdl-icon-toggle__label material-icons">{{:props.icon}}</i>
          <span class="mdl-textfield__error"></span>
        </label>
    {{/if}}

    {{if props.type=="button"}}
        <button method="{{:props.method||'navigate'}}" href="{{:props.href}}" onclick="{{:props.onClick}}" data-onsuccess="{{:props.onSuccess}}" data-onfail="{{:props.onFail}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect {{:props.class}}">{{:props.label}}</button>     
    {{/if}}

    {{if !props.type || props.type=="password"}}
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:100%;">
            <input class="mdl-textfield__input" autocomplete="off" type="password" name="{{:props.name}}" id="{{:props.name}}">
            <label class="mdl-textfield__label" for="{{:props.name}}">{{:props.label}}</label>
            <span class="mdl-textfield__error"></span>
        </div>
    {{/if}}    

    {{if props.type=="textarea"}}
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:100%;">
            <textarea class="mdl-textfield__input" autocomplete="off" type="text" rows="{{:props.rows}}" name="{{:props.name}}" id="{{:props.name}}">{{:props.value}}</textarea>
            <label class="mdl-textfield__label" for="{{:props.name}}">{{:props.label}}</label>
        </div>
    {{/if}}

    {{if props.type=="select"}}
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select" style="width:100%;">
            <input class="mdl-textfield__input" autocomplete="off" id="{{:props.name}}" name="{{:props.name}}" type="text" readonly data-val="{{:props.value}}"/>
            <label class="mdl-textfield__label" for="{{:props.name}}">{{:props.label}}</label>
            <ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu" for="{{:props.name}}">
                {{for props.options}}
                    <li class="mdl-menu__item" data-val="{{if value}}{{:value}}{{else}}{{:_id}}{{/if}}">{{:label}}</li>
                {{/for}}
            </ul>
            <span class="mdl-textfield__error"></span>
        </div>
    {{/if}}
</script>            

<script type="text/html" name="list">

    <ul class="mdl-list">
        {{for props.items}}
            <li class="mdl-list__item mdl-list__item--three-line">
                <span class="mdl-list__item-primary-content">
                    <span>{{:title}}</span>
                    <span class="mdl-list__item-text-body">
                        {{:description}}
                    </span>
                </span>
                <span class="mdl-list__item-secondary-content">
                    <button id="item-{{:id}}" class="mdl-button mdl-js-button mdl-button--icon">
                      <i class="material-icons">more_vert</i>
                    </button>
                    <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="item-{{:id}}">
                      <li navigate url="notes/form" data-post_id="{{:id}}" class="mdl-menu__item">Update</li>
                      <li class="mdl-menu__item--full-bleed-divider"></li>
                      <li request url="notes/delete" data-post_id="{{:id}}" class="mdl-menu__item">Delete</li>
                    </ul>
                </span>
            </li>
        {{/for}}
    </ul>   
</script>

<script type="text/html" name="table" mode="tag">
    {{include props}}
    <table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable fullwidth mdl-shadow--2dp">
        <thead>                 
        {{for cols}}
          <th width="{{:width}}" class="mdl-data-table__cell--non-numeric">{{:label}}</th>
        {{/for}}
        </thead>
        <tbody>
        {{for rows ~columns=cols}}
        <tr>
            {{for ~columns ~data=#data}}
              <td class="mdl-data-table__cell--non-numeric">{{:~data[column]}}</td>
            {{/for}}
        </tr>
        {{/for}}
        </tbody>  
    </table>
    {{/include}}
</script>

