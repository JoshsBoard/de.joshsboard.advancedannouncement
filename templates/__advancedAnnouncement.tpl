<!-- AdvancedAnnouncement will be presented by JoshsBoard.de -->
{foreach from=$aa_active_announcements item=announcement}
	{@$announcement->parse()}
{/foreach}