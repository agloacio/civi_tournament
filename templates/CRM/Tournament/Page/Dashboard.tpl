<h3>Tournament Dashboard</h3>

{* Example: Display a variable directly *}
<ol>
    <li><h4>Your Contact Data</h4>Welcome, <a href="{$userHref}" target="_blank">{$displayName}</a>. The links on this page (and the Tournaments navigation menu above) will guide you through the steps of tournament registration.
If you are new to this system, the first step is to double-check your contact information. You probably only need to do this once, ever.</li>
    </ol>


{* Example: Display a translated string -- which happens to include a variable *}
<p>{ts 1=$currentTime}(In your native language) The current time is %1.{/ts}</p>
