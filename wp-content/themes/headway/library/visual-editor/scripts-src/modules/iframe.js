define(['jquery', 'deps/itstylesheet', 'util.saving', 'util.usability', 'util.tooltips'], function($, itstylesheet, saving) {

	$i = function(element) {

		if ( typeof Headway.iframe == 'undefined' || typeof Headway.iframe.contents() == 'undefined' )
			return $();

		return Headway.iframe.contents().find(element);

	}

	$iDocument = function() {

		return $(Headway.iframe.contents());

	}


	loadIframe = function(callback, url) {

		if ( typeof url == 'undefined' || !url)
			var url = Headway.homeURL;

		/* Choose contents iframe or preview iframe depending on argument */
			var iframe = Headway.iframe;

		/* Make the title talk */
		startTitleActivityIndicator();
		showIframeLoadingOverlay();

		/* Close Grid Wizard */
		closeBox('grid-wizard');

		/* Build the URL */
			iframeURL = url;
			iframeURL = updateQueryStringParameter(iframeURL, 've-iframe', 'true');
			iframeURL = updateQueryStringParameter(iframeURL, 've-layout', Headway.viewModels.layoutSelector.currentLayout());
			iframeURL = updateQueryStringParameter(iframeURL, 've-iframe-mode', Headway.mode);
			iframeURL = updateQueryStringParameter(iframeURL, 'rand', Math.floor(Math.random() * 100000001));

		/* Clear out existing iframe contents */
			if ( iframe.contents().find('.ui-headway-grid').length && typeof iframe.contents().find('.ui-headway-grid').headwayGrid != 'undefined' ) {
				iframe.contents().find('.ui-headway-grid').headwayGrid('destroy');
			}

			iframe.contents().find('*')
				.unbind()
				.remove();

		iframe[0].src = iframeURL;
		waitForIframeLoad(callback, iframe);

	}


	waitForIframeLoad = function(callback, iframeEl) {

		if ( typeof iframeEl == 'undefined' || !iframeEl )
			var iframeEl = Headway.iframe;

		/* Setup timeout */
			if ( typeof iframeTimeout == 'undefined' )
				iframeTimeout = setTimeout(iframe.loadTimeout, 40000);

		/* Check if iframe body has iframe-loaded class which is added via inline script in the footer of the iframe */
			if ( typeof iframeEl == 'undefined' || iframeEl.contents().find('body.iframe-loaded').length != 1 ) {

				return setTimeout(function() {
					waitForIframeLoad(callback, iframeEl);
				}, 100);

			}

		/* Cancel out timeout callback */
			clearTimeout(iframeTimeout);

		return iframe.loadCallback(callback);

	}


	showIframeOverlay = function() {
		
		var overlay = $('div#iframe-overlay');		
		overlay.show();
		
	}
	

	hideIframeOverlay = function(delay) {

		if ( typeof delay != 'undefined' && delay == false )
			return $('div#iframe-overlay').hide();
		
		/* Add a timeout for intense draggers */
		setTimeout(function(){
			$('div#iframe-overlay').hide();
		}, 250);
		
	}


	showIframeLoadingOverlay = function() {

		/* Restrict scrolling */
		$('div#iframe-container').css('overflow', 'hidden');

		/* Position loading overlay */
		$('div#iframe-loading-overlay').css({
			top: $('div#iframe-container').scrollTop()
		});

		/* Only show if not already visible */
		if ( !$('div#iframe-loading-overlay').is(':visible') ) {
			createCog($('div#iframe-loading-overlay'), true);
			$('div#iframe-loading-overlay').show();
		}
		
		return $('div#iframe-loading-overlay');

	},


	hideIframeLoadingOverlay = function() {

		$('div#iframe-container').css('overflow', 'auto');
		$('div#iframe-loading-overlay').hide().html('');

	}


	var iframe = {
		init: function() {

			$(document).ready(function() {

				Headway.iframe = $('iframe#content');

				iframe.bindFocusBlur();

			});

		},

		bindFocusBlur: function() {

			Headway.iframe.on('mouseleave', function() {
				$(this).trigger('blur');

				/* Hide any tooltips */
				$i('[data-hasqtip]').qtip('disable', true);
			});

			Headway.iframe.on('mouseenter mousedown', function() {
				//If there is another textarea/input that's focused, don't focus the iframe.
				if ( $('textarea:focus, input:focus').length === 1 )
					return;

				$i('[data-hasqtip]').qtip('enable');
				$(this).trigger('focus');
			});

		},

		loadCallback: function(callback) {

			clearUnsavedValues();
						
			/* Fire callback if it exists */
			if ( typeof callback === 'function' )
				callback();
			
			iframe.defaultLoadCallback();

			iframe.stopFirefoxLoadingIndicator();

			/* Fire callback! */
			$('body').triggerHandler('headwayIframeLoad');

			return true;

		},

		defaultLoadCallback: function() {

			stopTitleActivityIndicator();

			changeTitle('Visual Editor: ' + Headway.viewModels.layoutSelector.currentLayoutName());
			$('span#current-layout').text(Headway.viewModels.layoutSelector.currentLayoutName());

			/* Set up tooltips */
			setupTooltips();
			setupTooltips('iframe');
			/* End Tooltips */

			/* Stylesheets for more accurate live designing */
				/* Main Headway stylesheet, used primarily by design editor */
				stylesheet = new ITStylesheet({document: Headway.iframe.contents()[0], href: Headway.homeURL + '/?headway-trigger=compiler&file=general-design-editor'}, 'find');

				/* Catch-all adhoc stylesheet used for overriding */
				css = new ITStylesheet({document: Headway.iframe.contents()[0]}, 'load');
			/* End stylesheets */

			/* Hide iframe overlay if it exists */
				hideIframeOverlay(false);

			/* Add the template notice if it's layout mode and a template is active */
				if ( Headway.viewModels.layoutSelector.currentLayoutTemplate() ) {
					showIframeOverlay();
					$i('body').prepend('<div id="no-edit-notice"><div><h1>To edit this layout, remove the shared layout from this layout.</h1></div></div>');
				}
				
			/* Disallow certain keys so user doesn't accidentally leave the VE */
			disableBadKeys();
			
			/* Bind visual editor key shortcuts */
			bindKeyShortcuts();

			/* Funnel any keydown, keypress, keyup events to the parent window */
				$i('html, body').bind('keydown', function(event) {
					$(document).trigger(event);
					event.stopPropagation();
				});

				$i('html, body').bind('keypress', function(event) {
					$(document).trigger(event);
					event.stopPropagation();
				});

				$i('html, body').bind('keyup', function(event) {
					$(document).trigger(event);
					event.stopPropagation();
				});

			/* Deactivate all links and buttons */
			if ( Headway.touch )
				Headway.iframe.contents().find('body').css('-webkit-touch-callout', 'none');

			Headway.iframe.contents().find('body').delegate('a, input[type="submit"], button', 'click', function(event) {

				if ( $(this).hasClass('allow-click') )
					return;

				event.preventDefault();
				
				return false;
				
			});
			
			/* Show the load message */
			if ( typeof headwayIframeLoadNotification !== 'undefined' ) {
				showNotification({
					id: 'iframe-load-notification',
					message: headwayIframeLoadNotification,
					overwriteExisting: true
				});
				
				delete headwayIframeLoadNotification;
			}
			
			/* Remove the tabs that are set to close on layout switch */
			removeLayoutSwitchPanels();
			
			/* Show the grid wizard if the current layout isn't customized and not using a tmeplate */
			var layoutNode = $('div#layout-selector span.layout[data-layout-id="' + Headway.viewModels.layoutSelector.currentLayout() + '"]');
			var layoutLi = layoutNode.parent();

			if ( 
				!$i('.block').length
				&& !(Headway.viewModels.layoutSelector.currentLayoutCustomized() && Headway.viewModels.layoutSelector.currentLayout().indexOf('template-') !== 0)
				&& !Headway.viewModels.layoutSelector.currentLayoutTemplate()
				&& Headway.mode == 'grid' 
			) {
			
				hidePanel();

				$(document).ready(function() {
					openBox('grid-wizard');
				});

			} else {

				closeBox('grid-wizard');
				
			}

			/* Clear out and disable iframe loading indicator */
			hideIframeLoadingOverlay();

		},

		loadTimeout: function() {

			iframeTimeout = true;	
			
			stopTitleActivityIndicator();

			changeTitle('Visual Editor: Error!');	

			/* Hide all controls */
			$('#iframe-container, #menu, #panel, #layout-selector-offset').hide();			
									
			alert("ERROR: There was a problem while loading the visual editor.\n\nYour browser will automatically refresh to attempt loading again.");

			document.location.reload(true);

		},

		stopFirefoxLoadingIndicator: function() {

			//http://www.shanison.com/2010/05/10/stop-the-browser-%E2%80%9Cthrobber-of-doom%E2%80%9D-while-loading-comet-forever-iframe/
			if ( /Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent) ) {
				
				var fake_iframe;

				if ( fake_iframe == null ){
					fake_iframe = document.createElement('iframe');
					fake_iframe.style.display = 'none';
				}

				document.body.appendChild(fake_iframe);
				document.body.removeChild(fake_iframe);
				
			}

		}

	}

	return iframe;

});