<?php
/**
 * File: AddNew
 *
 * @package    Boldgrid\Library
 * @subpackage Form
 * @author     BoldGrid <wpb@boldgrid.com>
 */

namespace Boldgrid\Library\Form;

use Boldgrid\Library\Library\Filter;
use Boldgrid\Library\Util\Plugin;

/**
 * Class: AddNew
 *
 * This class is responsible for modifying the Plugins > Add New > BoldGrid tab in the WordPress admin dashboard.
 *
 * @since 1.2.0
 */
class AddNew {
	/**
	 * Initiallize class and set class properties.
	 *
	 * @since 1.2.0
	 */
	public function __construct() {
		Filter::add( $this );
	}

	/**
	 * Modify the Library's wp.org saved plugin data.
	 *
	 * Add our wporg plugins to the Plugins >> Add New page.
	 * Remove the old reference to boldgrid-ninja-forms.
	 *
	 * @since 1.2.0
	 *
	 * @hook: Boldgrid\Library\Plugin\Installer\init
	 *
	 * @param  object $plugins A collection of plugins.
	 * @return object
	 */
	public function add_wporg_plugins( $plugins ) {
		$plugins       = (array) $plugins;
		$wporg_plugins = get_site_transient( 'boldgrid_wporg_plugins', false );

		if ( $wporg_plugins ) {
			$plugins = array_merge( $plugins, (array) $wporg_plugins );
		}

		// Remove boldgrid-ninja-forms if user doesn't already have it.
		$file = Plugin::getPluginFile( 'boldgrid-ninja-forms' );

		if ( ! empty( $plugins['boldgrid-ninja-forms'] ) && empty( $file ) ) {
			unset( $plugins['boldgrid-ninja-forms'] );
		}

		return (object) $plugins;
	}
}
