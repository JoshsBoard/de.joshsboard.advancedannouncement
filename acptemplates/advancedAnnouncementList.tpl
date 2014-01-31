{include file='header' pageTitle='wcf.acp.advancedannouncements.title'}

<header class="boxHeadline">
	<h1>{lang}wcf.acp.advancedannouncements.title{/lang}</h1>

	<script data-relocate="true" type="text/javascript">
		//<![CDATA[
		$(function() {
			new WCF.Action.Delete('wcf\\data\\advancedannouncement\\AdvancedAnnouncementAction', '.jsJCPRow');
			new WCF.Action.Toggle('wcf\\data\\advancedannouncement\\AdvancedAnnouncementAction', $('.jsJCPRow'));
		});
		//]]>
	</script>
</header>

<div class="contentNavigation">
	{pages print=true assign=pagesLinks controller="AdvancedAnnouncementList" link="pageNo=%d&sortField=$sortField&sortOrder=$sortOrder"}

	<nav>
		<ul><li><a href="{link controller='AdvancedAnnouncementAdd'}{/link}" title="" class="button"><span class="icon icon16 icon-plus"></span> <span>{lang}wcf.acp.advancedannouncements.add{/lang}</span></a></li></ul>
				{event name='additonalNavigationLinks'}
	</nav>
</div>

{hascontent}
<div class="tabularBox tabularBoxTitle marginTop">
	<header>
		<h2>{lang}wcf.acp.advancedannouncements.title{/lang} <span class="badge badgeInverse">{#$items}</span></h2>
	</header>

	<table class="table">
		<thead>
			<tr>
				<th class="columnID columnPremiumGroupID{if $sortField == 'advancedannouncementID'} active {@$sortOrder}{/if}" colspan="2"><a href="{link controller='AdvancedAnnouncementList'}pageNo={@$pageNo}&sortField=advancedannouncementID&sortOrder={if $sortField == 'advancedannouncementID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.global.objectID{/lang}</a></th>
				<th class="columnTitle columnName{if $sortField == 'name'} active {@$sortOrder}{/if}"><a href="{link controller='AdvancedAnnouncementList'}pageNo={@$pageNo}&sortField=name&sortOrder={if $sortField == 'name' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.acp.advancedannouncements.name{/lang}</a></th>
				<th class="columnInteger columnPriority{if $sortField == 'priority'} active {@$sortOrder}{/if}"><a href="{link controller='AdvancedAnnouncementList'}pageNo={@$pageNo}&sortField=priority&sortOrder={if $sortField == 'priority' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.acp.advancedannouncements.priority{/lang}</a></th>

				{event name='headColumns'}
			</tr>
		</thead>

		<tbody>
			{content}
			{foreach from=$objects item=aa}
				<tr class="jsJCPRow">
					<td class="columnIcon">
						<span class="icon icon16 icon-check{if $aa->isDisabled}-empty{/if} jsToggleButton jsTooltip pointer" title="{lang}wcf.global.button.{if $aa->isDisabled}enable{else}disable{/if}{/lang}" data-object-id="{@$aa->advancedannouncementID}" data-disable-message="{lang}wcf.global.button.disable{/lang}" data-enable-message="{lang}wcf.global.button.enable{/lang}"></span>

						<a href="{link controller='AdvancedAnnouncementEdit' id=$aa->getObjectID()}{/link}" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip"><span class="icon icon16 icon-pencil"></span></a>

						<span class="icon icon16 icon-remove jsDeleteButton jsTooltip pointer" data-object-id="{@$aa->advancedannouncementID}" title="{lang}wcf.global.button.delete{/lang}"></span>



						{event name='buttons'}
					</td>
					<td class="columnID"><p>{@$aa->advancedannouncementID}</p></td>
					<td class="columnTitle columnName">{$aa->name}</td>
					<td class="columnText columnPriority"><p>{#$aa->priority}</p></td>

					{event name='columns'}
				</tr>
			{/foreach}
			{/content}
		</tbody>
	</table>

</div>
{hascontentelse}
<p class="info">{lang}wcf.acp.advancedannouncements.noannouncements{/lang}</p>
{/hascontent}

{include file='footer'}
