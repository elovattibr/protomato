{{page fixed_header=true}}

	{{header title=title button="back"/}}

    {{contents}}
		
    	{{form}}

    		{{if !user}}

				{{cell desktop="4" tablet="4" phone="4" desktop_offset="4" tablet_offset="2"}}

					{{input type="text" label="User name" name="username" value=""/}}

					{{input type="text" label="Password" name="password" value=""/}}

					<br>

					{{input type="button" label="Submit" method="submit" href="/login/authenticate"/}}

					<p>{{:message}}</p>

				{{/cell}}
				
    		{{else}}

		        <center>
		            <h4>Login identificado</h4>
		            <br/>
		            <br/>

		            {{input type="button" label="Entrar com outro usuário" href="/login/logout"/}}
		            
		        </center>

    		{{/if}}

    	{{/form}}
	

    {{/contents}}

{{/page}}  