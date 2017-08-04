<?php
/**
 * BoldGrid Library Form Add New
 *
 * @package Boldgrid\Library
 * @subpackage Form
 *
 * @version 1.0.2
 * @author BoldGrid <wpb@boldgrid.com>
 */

namespace Boldgrid\Library\Form\Wpforms;

use Boldgrid\Library\Library\Filter;
use Boldgrid\Library\Util\Plugin;

/**
 * BoldGrid Library Form Add New Class.
 *
 * This class is responsible for modifying the Plugins > Add New >
 * BoldGrid tab in the WordPress admin dashboard.
 *
 * @since 1.0.2
 */
class AddNew {

	/**
	 * Initiallize class and set class properties.
	 *
	 * @param array $configs array of library configuration options.
	 */
	public function __construct() {
		Filter::add( $this );
		$this->tracking = new Tracking();
	}

	/**
	 * Modify the Library's wp.org saved plugin data.
	 *
	 * @since 1.0.2
	 *
	 * @hook: Boldgrid\Library\Plugin\Installer\init
	 *
	 * @return object $plugins The plugins to save update information for.
	 */
	public function wpformsData( $plugins ) {
		$plugins = ( array ) $plugins;

		// Add wpforms to plugins > add new page.
		if ( $wporgPlugins = get_site_transient( 'boldgrid_wporg_plugins', false ) ) {
			$plugins = array_merge( $plugins, ( array ) $wporgPlugins );
		}

		// Remove boldgrid-ninja-forms if user doesn't already have it.
		$file = Plugin::getPluginFile( 'boldgrid-ninja-forms' );

		if ( ! empty( $plugins['boldgrid-ninja-forms'] ) && empty( $file ) ) {
			unset( $plugins['boldgrid-ninja-forms'] );
		}

		return ( object ) $plugins;
	}
}
