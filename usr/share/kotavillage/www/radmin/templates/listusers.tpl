{include file="header.tpl" Name="Edit Users" activepage="edituser"}
<!-- TODO: This file appears obsolete. Remove -->
<div id="edituserList">
<h2>Edit User</h2>
<div class="errorPage" style="display: {if $error}block;{else}none;{/if}"><span id="errorMessage">{foreach from=$error item=msg}{$msg}<br/>{/foreach}</span> </div>
<ul>
{foreach from=$users item=user key=id}
	<li><a id='user_{$user.id}' style='{$user.account_status}' href='?username={$user.Username}'>{$user.Username}</a><br/></li>
{/foreach}
</ul>
</div>
{include file="footer.tpl"}
