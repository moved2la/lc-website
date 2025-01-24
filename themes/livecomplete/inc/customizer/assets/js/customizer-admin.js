/*admin css*/
( function( live_complete_api ) {

	live_complete_api.sectionConstructor['live_complete_upsell'] = live_complete_api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
