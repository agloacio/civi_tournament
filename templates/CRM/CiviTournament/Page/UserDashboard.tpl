
{* CiviTournament DashBoard (launch page) *}

{capture assign=component_path}civicrm/tournament{/capture}

{ts}
<h3>Tournament Dashboard</h3>

<ol>
    <li><h4>Your Contact Data</h4>Welcome, <a href="{crmURL p="{$component_path}/person" q="&cid={$user->_id}"}" target="_blank">{$user->_label}</a>. The links on this page (and the Tournaments navigation menu above) will guide you through the steps of tournament registration.
If you are new to this system, the first step is to double-check <a href="{$user->_contactUrl}" target="_blank">your contact information</a>. You probably only need to do this once, ever.</li>
    <li><h4>Billing Organizations (e.g., School Districts)</h4>The next step is to double-check your organization's contact information. You probably only need to do this once, ever.<p>You are a contact for these organizations:</p>
        <ol>
            {foreach from=$user->_billingOrganizations item=organization}
                <li><a href="{crmURL p="{$component_path}/billing_organization" q="&cid={$organization->_id}"}" target="_blank">{$organization->_name}</a></li>
            {/foreach}
        </ol>
    </li>
    <li><h4>Contacts (Players, coaches, etc.)</h4>The next step is to enter contacts for your group(s). You probably only need to do this once per contact, ever.
<p>This only enters them into the database. It doesn't mean anyone is actually committed to attending a tournament. You can enter contacts at any time during the year. The only deadline for entering contacts is that a contact must be in the database before you can register that contact for a tournament.</p>
You have access to contacts in these groups:        
    <ol>
        {foreach from=$user->_registrationGroups item=group}
            <li>{$group->_name}</li>
        {/foreach}
    </ol>
    </li>
    <li><h4>Register Contacts for Tournament</h4>Once you have entered all the contacts for your group(s), you can register them to attend a tournament. (Be sure to indicate which competitions they will enter. That's important for the team registration step.)
<p><a target="_blank" href="">Use this link to register a contact for the tournament</a>.</p>
<p><a target="_blank" href="">Use this link to list/edit contacts already registered for the tournament.</a>.</p>
    <em>Note: </em>Tournament registration will close at : 2025-03-29 00:00:00
    </li>
    <li><h4>Combine Registered Players into Teams</h4>Once you have registered all the players for your district/league, you can combine them into teams.
<p><a target="_blank" href="">Use this link to start a new team</a>.</p>
<p><a target="_blank" href="">Use this link to list/edit your teams.</a>.</p>
    <em>Note: </em>Tournament registration will close at : 2025-03-29 00:00:00
    </li>
</ol>
{/ts}