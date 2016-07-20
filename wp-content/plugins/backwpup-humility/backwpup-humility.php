<?php
/**
 * Main plugin file.
 * Just tames the BackWPup plugin when finishing updates to not get on the
 *    nerves of admins... :) Saves time, cleans admin dashboard.
 *
 * @package   BackWPup Humility
 * @author    David Decker
 * @copyright Copyright (c) 2013, David Decker - DECKERWEB
 * @link      http://deckerweb.de/twitter
 *
 * Plugin Name: BackWPup Humility
 * Plugin URI: http://genesisthemes.de/en/wp-plugins/backwpup-humility/
 * Description: Just tames the BackWPup plugin when finishing updates to not get on the nerves of admins... :) Saves time, cleans admin dashboard.
 * Version: 1.0.0
 * Author: David Decker - DECKERWEB
 * Author URI: http://deckerweb.de/
 * License: GPL-2.0+
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 *
 * Copyright (c) 2013 David Decker - DECKERWEB
 *
 *     This file is part of BackWPup Humility,
 *     a plugin for WordPress.
 *
 *     BackWPup Humility is free software:
 *     You can redistribute it and/or modify it under the terms of the
 *     GNU General Public License as published by the Free Software
 *     Foundation, either version 2 of the License, or (at your option)
 *     any later version.
 *
 *     BackWPup Humility is distributed in the hope that
 *     it will be useful, but WITHOUT ANY WARRANTY; without even the
 *     implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 *     PURPOSE. See the GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with WordPress. If not, see <http://www.gnu.org/licenses/>.
 */

add_action( 'plugins_loaded', 'ddw_backwpup_humility_check', 12 );
/**
 * Just tame "BackWPup" plugin to not get on the nerves of Admins when
 *    finishing updates...! :) Saves time, cleans admin dashboard.
 *
 * @since 1.0.0
 *
 * @uses  current_user_can()
 * @uses  get_site_option()
 * @uses  update_site_option()
 * @uses  BackWPup_Admin::getInstance()
 * @uses  remove_action()
 */
function ddw_backwpup_humility_check() {

	/** Bail early if there's no BackWPup v3.x branch. */
	if ( ! in_array( 'backwpup/backwpup.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )
		|| defined( 'BACKWPUP_USER_CAPABILITY' )
	) {
		return;
	}

	/** Check for capability and BackWPup option */
	if ( current_user_can( 'activate_plugins' ) && ! get_site_option( 'backwpup_about_page' ) ) {

		/** Yes, we saw the "About" page already. Saved. */
		update_site_option( 'backwpup_about_page', TRUE );

		/** Remove the senseless admin notice. */
		$ddw_backwpup_instance = BackWPup_Admin::getInstance();
		remove_action( 'admin_notices', array( $ddw_backwpup_instance, 'admin_notices' ) );

	}  // end-if BackWPup fixes

}  // end of function ddw_backwpup_humility_check