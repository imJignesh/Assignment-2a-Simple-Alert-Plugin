/**
 * All of the code for your admin-facing JavaScript source
 * should reside in this file.
 *
 * @package    Simple_Alert
 **/

	(function ($) {
		'use strict';

		$( document ).on(
			'change', '.sa_check',
			function () {
				var me = $( this );
				if ($( this ).is( ':checked' )) {
					me.parent().parent().find( 'select' ).removeClass( 'sa_hidden' );
				} else {
					me.parent().parent().find( 'select' ).addClass( 'sa_hidden' );

				}
			}
		);

	})( jQuery );
