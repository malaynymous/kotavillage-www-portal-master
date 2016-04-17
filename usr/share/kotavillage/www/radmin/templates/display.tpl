{include file="header.tpl" Name="List Users" activepage="users" helptext="Click on a username to edit that user.
Click on the * to see the users password
Click on ether the Data Usage or Time Usage to see the users sessions"}

<div id='userslist' style="overflow:hidden;"><!-- jQuery UI bug #5601 requires overflow:hidden style due to float left menu -->
    <ul id="tabselector">
    {foreach from=$users_groups item=group key=groupname name=groupmenuloop}
        <li><a href="#list{$groupname|underscorespaces}">{if $groupsettings.$groupname.GroupLabel}{$groupsettings.$groupname.GroupLabel}{else}{$groupname}{/if}</a></li>
    {/foreach}
    </ul>
    {foreach from=$users_groups item=group key=groupname name=grouploop}
    <div id="list{$groupname|underscorespaces}" class="tabcontent">
{* We now show group limits in edit user page, commented out of here for now as it looks odd
    {if $groupsettings.$groupname.MaxOctets}{t}Data Limit{/t} {$groupdata.$groupname.MaxOctets|bytes}<br/>{/if}
    {if $groupsettings.$groupname.MaxSeconds}{t}Time Limit{/t} {$groupdata.$groupname.MaxSeconds|seconds}<br/>{/if}    
    {if $groupdata.$groupname.TimeRecurLimit}{t 1=$groupdata.$groupname.TimeRecurTimeFormatted}%1 Time Limit{/t} {$groupdata.$groupname.TimeRecurLimitS|seconds}<br/>{/if}
    {if $groupdata.$groupname.DataRecurLimit}{t 1=$groupdata.$groupname.DataRecurTimeFormatted}%1 Data Limit{/t} {$groupdata.$groupname.DataRecurLimitB|bytes}<br/>{/if}
    *}
        {* TODO This below if statement is faulty due to it trying to match a translated string. Find a better way to do this? *}
        {if $groupname != 'All' && $groupname != 'Out Of Quota' && $groupname != 'Low Quota' && $groupname != 'Expired'}
            <small><a href="export.php?format=html&group={$groupname|underscorespaces}" target="print_html">Print
                    Group</a> | <a href="export.php?format=csv&group={$groupname|underscorespaces}" target="print_html">Export
                    Group (CSV)</a></small>
        {/if}

        <table id="{$groupname|underscorespaces}userslistTable" class="userslistTable stripeMe">
	    <col style="width: 6em"/>
	    {if $groupname == 'All'}<col style="width: 5em"/>{/if}
	    <col span="4" style="width: 6em"/>	    	    
	    <col span="3" style="width: 7em"/>
	    <col span="1" style="width: 6em"/>	
		<thead>
		<tr id='{$groupname|underscorespaces}userattributesRow' class="userattributesRow">
			<th>{t}Username{/t}</th>
		    {if $groupname == 'All'}<th>{t}Group{/t}</th>{/if}
			<th>{t}Data Limit{/t}</th>
			<th><a class="helpbutton ui-icon ui-icon-info" title='{t}Total Data usage for the current month{/t}'><img src="/grase/images/icons/help.png" alt=""/></a> {t}Data Usage (M){/t}</th>
			<th><a class="helpbutton ui-icon ui-icon-info" title='{t}Total Data usage, from previous months, excluding current month{/t}' ><img src="/grase/images/icons/help.png" alt=""/></a> {t}Data Usage (T){/t}</th>
			<th>{t}Time Remaining{/t}</th>
			<th>{t}Time Usage (Total){/t}</th>			
			<th>{t}Account Expiry{/t}</th>
			<th><a class="helpbutton ui-icon ui-icon-info" title='{t}Last Logoff timestamp from current month only{/t}' ><img src="/grase/images/icons/help.png" alt=""/></a> {t}Last Logoff{/t}</th>
			<th>{t}Comment{/t}</th>
		</tr>
		</thead>
		<tbody>	
		{foreach from=$group item=user name=usersloop}

		<tr id="user_{$user.Username}_{$groupname|underscorespaces}_Row" class="userrow {$user.account_status}">
			<td class='info_username'>{if $user.isComputer}# {/if}<span class='info_password'>{if $user.isComputer}<span title="{t}Password Hidden{/t}">*</span>{else}<span title="{$user.Password}"><a href='javascript:alert("Password for {$user.Username} is {$user.Password}")'>*</a></span>{/if}</span><a href="edituser?username={$user.Username|escape:'url'}">{$user.Username}</a> {if $user.AccountLock}{t}(Account Locked){/t}{/if}</td>

			{if $groupname == 'All'}<td class='info_group'>{$user.Group}</td>{/if}
			<td class='info_datalimit' title='{$user.MaxOctets}'>{$user.MaxOctets|bytes}</td>
			<td class='info_datausage' title='{$user.AcctTotalOctets}'><a href="sessions?username={$user.Username|escape:'url'}">{$user.AcctTotalOctets|bytes}</a></td>			
			<td class='info_datausage_t' title='{$user.TotalOctets}'>{$user.TotalOctets|bytes}</td>			
			<td class='info_timelimit'>{if isset($user.MaxAllSession)}{$user.RemainingSeconds|seconds}{/if}</td>			
			<td class='info_timeusage' title='{$user.TotalTimeAll}'><a href="sessions?username={$user.Username|escape:'url'}">{$user.TotalTimeMonth|seconds} ({$user.TotalTimeAll|seconds})</a></td>						
			<td class='info_expiry'>{$user.FormatExpiration}</td>
			<td class='info_lastlogout'>{$user.LastLogout}</td>
			<td class='info_comment'>{$user.Comment}</td>			
		</tr>
		{/foreach}
		</tbody>

	</table>        
    </div>
    {/foreach}

    	
</div>

{include file="footer.tpl"}
