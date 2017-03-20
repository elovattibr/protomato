{{page fixed_header="true"}}

    {{header title="Erro "+code/}}

    {{contents}}
        
        <center>
            <h4>Erro {{:code}}</h4>
            <br/>
            <br/>
            <br/>
            <br/>
            <p>{{:message}}</p>
            <br/>

            {{input type="button" label="Voltar" onClick="window.history.back()"/}}
            
        </center>

    {{/contents}}

{{/page}}  