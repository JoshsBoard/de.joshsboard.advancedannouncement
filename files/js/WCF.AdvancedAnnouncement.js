/**
 * WCF.AdvancedAnnouncement is a class, which contains a collection of functions for
 * the 'de.joshsboard.advancedannouncement'-package.
 * 
 * @author 		Joshua Ruesweg
 * @copyright		JoshsBoard 2013
 * @package		de.joshsboard.advancedannouncement
 */
WCF.AdvancedAnnouncement = {};

/**
 * Handles clicks on 'dismiss'-button to hide announcements.
 */
WCF.AdvancedAnnouncement.Dismiss = Class.extend({
	/**
	 * action proxy
	 * @var	WCF.Action.Proxy
	 */
	_proxy: null,
	_container: null,
	/**
	 * Creates a new object of this class.
	 */
	init: function(container) {
		this._container = container;

		this._proxy = new WCF.Action.Proxy({
			success: $.proxy(this._success, this)
		});

		this._container.each($.proxy(function(index, container) {
			$(container).find('.aaclose').click($.proxy(this._click, this));
		}, this));


	},
	/**
	 * Sends request after clicking on a button.
	 */
	_click: function(event) {
		var $button = $(event.target);
		var $aaID = $button.data('objectID');

		this._proxy.setOption('data', {
			actionName: 'dismiss',
			className: 'wcf\\data\\advancedannouncement\\AdvancedAnnouncementAction',
			objectIDs: [$aaID]
		});

		this._proxy.sendRequest();
	},
	/**
	 * Shows a notification on success.
	 * @param	object		data
	 * @param	string		textStatus
	 * @param	jQuery		jqXHR
	 */
	_success: function(data, textStatus, jqXHR) {
		$.each(data.objectIDs, function(index, value) {
			$('#advancedAnnouncement'+value).fadeOut('slow');
		});
	}
});