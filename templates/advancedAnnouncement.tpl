<p class="{$announcement->additionalStyleClasses}{if $announcement->removable} aaremovable{/if}" data-object-id="{$announcement->getObjectID()}" id="advancedAnnouncement{$announcement->getObjectID()}">
	{@$announcement->getContent()}
	
	{if $announcement->removable && $__wcf->session->userID != 0}
		<button type="button" class="aaclose" data-object-id="{$announcement->getObjectID()}">&times;</button>
	{/if}
</p>