/* eslint no-alert: 0 */
/* global wp, notification, jQuery, ajaxurl, alert */
( function( $ ) {
	const __ = wp.i18n.__;
	const Clipboard = require( 'clipboard' );

	$( document ).ready( function() {
		// Copy Merge Tag.
		const mergeTagClipboard = new Clipboard( 'code.notification-merge-tag' );

		mergeTagClipboard.on( 'success', function( e ) {
			const $code = $( e.trigger ),
				tag = $code.text();

			notification.hooks.doAction( 'notification.merge_tag.copied', tag, $code );

			$code.text( __( 'Copied', 'notification' ) );

			setTimeout( function() {
				$code.text( tag );
			}, 800 );
		} );

		// Initialize accordion.
		let collapse = $( '.notification_merge_tags_accordion' ).collapse();

		// Swap Merge Tags list for new Trigger.
		notification.hooks.addAction( 'notification.trigger.changed', function( $trigger ) {
			const triggerSlug = $trigger.val();

			const data = {
				action: 'get_merge_tags_for_trigger',
				trigger_slug: triggerSlug,
			};

			$.post( ajaxurl, data, function( response ) {
				if ( response.success === false ) {
					alert( response.data );
				} else {
					$( '#notification_merge_tags .inside' ).html( response.data );
					collapse = $( '.notification_merge_tags_accordion' ).collapse();
				}
			} );
		} );

		// Search Merge Tags.
		$( 'body' ).on( 'keyup', '#notification-search-merge-tags', function() {
			const val = $( this ).val().toLowerCase();

			if ( $( this ).val().length > 0 ) {
				collapse.trigger( 'open' );

				$( '.notification_merge_tags_accordion h2, .notification_merge_tags_accordion .tags-group' ).hide();

				$( '.inside li' ).each( function() {
					$( this ).hide();

					const text = $( this ).find( '.intro code' ).text().toLowerCase();

					if ( -1 !== text.indexOf( val ) ) {
						$( this ).show();
						const parentClass = $( this ).parents( 'ul' ).data( 'group' );
						$( '[data-group=' + parentClass + ']' ).show();
					}
				} );
			} else {
				$( '.notification_merge_tags_accordion h2, .inside li' ).show();
				collapse.trigger( 'close' );
			}
		} );
	} );
}( jQuery ) );
