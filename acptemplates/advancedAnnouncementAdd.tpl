{include file='header' pageTitle='wcf.acp.advancedannouncements.add'}

{include file='multipleLanguageInputJavascript' elementIdentifier='aa_content' forceSelection=false}

<header class="boxHeadline">
	<hgroup>
		<h1>{lang}wcf.acp.advancedannouncements.{$action}{/lang}</h1>
	</hgroup>
</header>

{include file='formError'}

{if $success|isset}
	<p class="success">{lang}wcf.global.success.{$action}{/lang}</p>	
{/if}

<div class="contentNavigation">

</div>

<form method="post" action="{if $action == 'add'}{link controller='AdvancedAnnouncementAdd'}{/link}{else}{link controller='AdvancedAnnouncementEdit' id=$advancedAnnouncement->getObjectID()}{/link}{/if}">
	<div class="container containerPadding marginTop">
		<fieldset>
			<legend>{lang}wcf.acp.advancedannouncements.settings{/lang}</legend>
			<!-- name (id) -->
			<dl{if $errorField == 'name'} class="formError"{/if}>
				<dt><label for="name">{lang}wcf.acp.advancedannouncements.name{/lang}</label></dt>
				<dd>
					<input type="text" value="{$name}" id="name" name="name" />
					{if $errorField == 'name'}
						<small class="innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{/if}
						</small>
					{/if}
				</dd>
			</dl>

			<!-- removable -->
			<dl{if $errorField == 'removable'} class="formError"{/if}>
				<dt></dt>
				<dd>
					<label for="removable"><input type="checkbox" name="removable" id="removable" value="1"{if $removable} checked="checked"{/if} /> {lang}wcf.acp.advancedannouncements.removable{/lang}</label>
				</dd>
			</dl>

			<!-- priority -->
			<dl{if $errorField == 'priority'} class="formError"{/if}>
				<dt><label for="priority">{lang}wcf.acp.advancedannouncements.priority{/lang}</label></dt>
				<dd>
					<input type="integer" value="{$priority}" name="priority" />
					<small></small>
				</dd>
			</dl>
		</fieldset>

		<fieldset>
			<legend>{lang}wcf.acp.advancedannouncements.criteria{/lang}</legend>

			<!-- INUSERGROUP -->
			<dl{if $errorField == 'inUserGroup'} class="formError"{/if}>
				<dt><label for="inUserGroup">{lang}wcf.acp.advancedannouncements.criteria.inusergroup{/lang}</label></dt>
				<dd>
					<select name="inUserGroup[]" size="10" id="inUserGroup" multiple="multiple">
						{foreach from=$groups item="group"}
							<option value="{$group->getObjectID()}"{if $group->getObjectID()|in_array:$inUserGroup} selected="selected"{/if}>{$group}</option>
						{/foreach}
					</select>
				</dd>
			</dl>

			<!-- NOT INUSERGROUP -->
			<dl{if $errorField == 'notInUserGroup'} class="formError"{/if}>
				<dt><label for="notInUserGroup">{lang}wcf.acp.advancedannouncements.criteria.notinusergroup{/lang}</label></dt>
				<dd>
					<select name="notInUserGroup[]" size="10" id="notInUserGroup" multiple="multiple">
						{foreach from=$groups item="group"}
							<option value="{$group->getObjectID()}"{if $group->getObjectID()|in_array:$notInUserGroup} selected="selected"{/if}>{$group}</option>
						{/foreach}
					</select>
				</dd>
			</dl>

			<!-- hasBirthday -->
			<dl{if $errorField == 'hasBirthday'} class="formError"{/if}>
				<dt><label for="hasBirthday">{lang}wcf.acp.advancedannouncements.criteria.hasbirthday{/lang}</label></dt>
				<dd>
					<select name="hasBirthday" id="hasBirthday">
						<option value="-1"{if $hasBirthday == -1} selected="selected"{/if}>{lang}wcf.acp.advancedannouncements.criteria.notmatter{/lang}</option>
						<option value="1"{if $hasBirthday == 1} selected="selected"{/if}>{lang}wcf.acp.advancedannouncements.criteria.true{/lang}</option>
						<option value="0"{if $hasBirthday == 0} selected="selected"{/if}>{lang}wcf.acp.advancedannouncements.criteria.false{/lang}</option>
					</select>
				</dd>
			</dl>

			<!-- minActivityPoints -->
			<dl{if $errorField == 'minActivityPoints'} class="formError"{/if}>
				<dt><label for="minActivityPoints">{lang}wcf.acp.advancedannouncements.criteria.minactivitypoints{/lang}</label></dt>
				<dd>
					<input type="integer" value="{$minActivityPoints}" name="minActivityPoints" />
				</dd>
			</dl>

			<!-- maxActivityPoints -->
			<dl{if $errorField == 'maxActivityPoints'} class="formError"{/if}>
				<dt><label for="maxActivityPoints">{lang}wcf.acp.advancedannouncements.criteria.maxactivitypoints{/lang}</label></dt>
				<dd>
					<input type="integer" value="{$maxActivityPoints}" name="maxActivityPoints" />
				</dd>
			</dl>

			<!-- timeIsYoungerThan -->
			<dl{if $errorField == 'timeIsYoungerThan'} class="formError"{/if}>
				<dt><label for="timeIsYoungerThan">{lang}wcf.acp.advancedannouncements.criteria.timeisyoungerthan{/lang}</label></dt>
				<dd>
					<input type="integer" value="{if $timeIsYoungerThan != -1}{if $errorField == 'timeIsYoungerThan' && $errorType == 'notValid'}{$timeIsYoungerThan}{else}{$timeIsYoungerThan|date:"Y-m-d H:i"}{/if}{else}-1{/if}" name="timeIsYoungerThan" />
					{if $errorField == 'timeIsYoungerThan'}
						<small class="innerError">
							{if $errorType == 'notValid'}
								{lang}wcf.acp.advancedannouncements.criteria.timeisolderthan.notvalid{/lang}
							{/if}
						</small>
					{/if}
					
					<small>{lang}wcf.acp.advancedannouncements.criteria.timeisyoungerthan.description{/lang}</small>
				</dd>
			</dl>

			<!-- timeIsOlderThan -->
			<dl{if $errorField == 'timeIsOlderThan'} class="formError"{/if}>
				<dt><label for="timeIsOlderThan">{lang}wcf.acp.advancedannouncements.criteria.timeisolderthan{/lang}</label></dt>
				<dd>
					<input type="integer" value="{if $timeIsOlderThan != -1}{if $errorField == 'timeIsOlderThan' && $errorType == 'notValid'}{$timeIsOlderThan}{else}{$timeIsOlderThan|date:"Y-m-d H:i"}{/if}{else}-1{/if}" name="timeIsOlderThan" />
					{if $errorField == 'timeIsOlderThan'}
						<small class="innerError">
							{if $errorType == 'notValid'}
								{lang}wcf.acp.advancedannouncements.criteria.timeisolderthan.notvalid{/lang}
							{/if}
						</small>
					{/if}
					
					<small>{lang}wcf.acp.advancedannouncements.criteria.timeisolderthan.description{/lang}</small>
				</dd>
			</dl>

			<!-- noAvatar -->
			<dl{if $errorField == 'noAvatar'} class="formError"{/if}>
				<dt><label for="noAvatar">{lang}wcf.acp.advancedannouncements.criteria.noavatar{/lang}</label></dt>
				<dd>
					<select name="noAvatar" id="noAvatar">
						<option value="-1"{if $noAvatar == -1} selected="selected"{/if}>{lang}wcf.acp.advancedannouncements.criteria.notmatter{/lang}</option>
						<option value="1"{if $noAvatar == 1} selected="selected"{/if}>{lang}wcf.acp.advancedannouncements.criteria.true{/lang}</option>
						<option value="0"{if $noAvatar == 0} selected="selected"{/if}>{lang}wcf.acp.advancedannouncements.criteria.false{/lang}</option>
					</select>
				</dd>
			</dl>

			<!-- onSite -->
			<dl{if $errorField == 'onSite'} class="formError"{/if}>
				<dt><label for="onSite">{lang}wcf.acp.advancedannouncements.criteria.onsite{/lang}</label></dt>
				<dd>
					<select name="onSite" id="onSite">
						<option value="-1"{if $onSite == -1} selected="selected"{/if}>{lang}wcf.acp.advancedannouncements.criteria.onsite.nomatter{/lang}</option>
						<option value="1"{if $onSite == 1} selected="selected"{/if}>{lang}wcf.acp.advancedannouncements.criteria.onsite.true{/lang}</option>
						<option value="0"{if $onSite == 0} selected="selected"{/if}>{lang}wcf.acp.advancedannouncements.criteria.onsite.false{/lang}</option>
					</select>
				</dd>
			</dl>

			<!-- onSiteSites -->
			<dl{if $errorField == 'onSiteSites'} class="formError"{/if}>
				<dt><label for="onSiteSites">{lang}wcf.acp.advancedannouncements.criteria.onsitesites{/lang}</label></dt>
				<dd>
					<textarea name="onSiteSites" cols="40" rows="10" id="onSiteSites">{foreach from=$onSiteSites item="site"}{$site}
						{/foreach}
						</textarea>
						<small>{lang}wcf.acp.advancedannouncements.criteria.onsitesites.description{/lang}</small>
					</dd>
				</dl>

				<!-- objectID -->
				<dl{if $errorField == 'objectID'} class="formError"{/if}>
					<dt><label for="objectID">{lang}wcf.acp.advancedannouncements.criteria.objectid{/lang}</label></dt>
					<dd>
						<input type="integer" value="{foreach from=$objectID item="object"}{$object}, {/foreach}" name="objectID" />
						<small>{lang}wcf.acp.advancedannouncements.criteria.objectid.description{/lang}</small>
					</dd>
				</dl>

				<!-- parentObjectID -->
				<dl{if $errorField == 'parentObjectID'} class="formError"{/if}>
					<dt><label for="parentObjectID">{lang}wcf.acp.advancedannouncements.criteria.parentobjectid{/lang}</label></dt>
					<dd>
						<input type="integer" value="{foreach from=$parentObjectID item="object"}{$object}, {/foreach}" name="parentObjectID" />
						<small>{lang}wcf.acp.advancedannouncements.criteria.parentobjectid.description{/lang}</small>
					</dd>
				</dl>

				<!-- objectType -->
				<dl{if $errorField == 'objectType'} class="formError"{/if}>
					<dt><label for="objectType">{lang}wcf.acp.advancedannouncements.criteria.objecttype{/lang}</label></dt>
					<dd>
						<input type="text" maxlength="255" value="{foreach from=$objectType item="object"}{$object}, {/foreach}" name="objectType" />
						<small>{lang}wcf.acp.advancedannouncements.criteria.objecttype.description{/lang}</small>
					</dd>
				</dl>

				<!-- parentObjectType -->
				<dl{if $errorField == 'parentObjectType'} class="formError"{/if}>
					<dt><label for="parentObjectType">{lang}wcf.acp.advancedannouncements.criteria.parentobjecttype{/lang}</label></dt>
					<dd>
						<input type="text" maxlength="255" value="{foreach from=$parentObjectType item="object"}{$object}, {/foreach}" name="parentObjectType" />
						<small>{lang}wcf.acp.advancedannouncements.criteria.parentobjecttype.description{/lang}</small>
					</dd>
				</dl>
			</fieldset>

			<fieldset>
				<legend>{lang}wcf.acp.advancedannouncements.content{/lang}</legend>

				<!-- content -->
				<dl{if $errorField == 'content'} class="formError"{/if}>
					<dt><label for="aa_content">{lang}wcf.acp.advancedannouncements.content{/lang}</label></dt>
					<dd>
						<textarea name="aa_content" id="aa_content" cols="40" rows="10">{$i18nPlainValues['aa_content']}</textarea>
						{if $errorField == 'aa_content'}
							<small class="innerError">
								{if $errorType == 'empty'}
									{lang}wcf.global.form.error.empty{/lang}
								{/if}
							</small>
						{/if}
					</dd>
				</dl>

				<!-- parseBBCodes -->
				<dl{if $errorField == 'parseBBCodes'} class="formError"{/if}>
					<dt></dt>
					<dd>
						<label for="parseBBCodes"><input type="checkbox" id="parseBBCodes" name="parseBBCodes" value="1" {if $parseBBCodes} checked="checked"{/if}/> {lang}wcf.acp.advancedannouncements.parsebbcodes{/lang}</label>
					</dd>
				</dl>

				<!-- allowHTML -->
				<dl{if $errorField == 'allowHTML'} class="formError"{/if}>
					<dt></dt>
					<dd>
						<label for="allowHTML"> <input type="checkbox" name="allowHTML" id="allowHTML" value="1" {if $allowHTML} checked="checked"{/if}/> {lang}wcf.acp.advancedannouncements.allowhtml{/lang}</label>
					</dd>
				</dl>

				<!-- allowSmileys -->
				<dl{if $errorField == 'allowSmileys'} class="formError"{/if}>
					<dt></dt>
					<dd>
						<label for="allowSmileys"> <input type="checkbox" name="allowSmileys" id="allowSmileys" value="1" {if $allowSmileys} checked="checked"{/if}/> {lang}wcf.acp.advancedannouncements.allowSmileys{/lang}</label>
					</dd>
				</dl>

			</fieldset>


			<fieldset>
				<legend>{lang}wcf.acp.advancedannouncements.style{/lang}</legend>

				<!-- div -->
				<dl{if $errorField == 'additionalStyleClasses'} class="formError"{/if}>
					<dt><label for="additionalStyleClasses">{lang}wcf.acp.advancedannouncements.additionalstyleclasses{/lang}</label></dt>
					<dd>
						<textarea name="additionalStyleClasses" id="additionalStyleClasses" cols="40" rows="10">{$additionalStyleClasses}</textarea>
						<small>{lang}wcf.acp.advancedannouncements.additionalstyleclasses.description{/lang}</small>
					</dd>
				</dl>

			</fieldset>
		</div>

		<div class="formSubmit">
			<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
			{@SECURITY_TOKEN_INPUT_TAG}
		</div>
	</form>

	{include file='footer'}