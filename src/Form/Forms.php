<?php
/**
 * BoldGrid Source Code
 *
 * @package Boldgrid\Library\Form
 * @copyright BoldGrid.com
 * @version $Id$
 * @author BoldGrid.com <wpb@boldgrid.com>
 */

namespace Boldgrid\Library\Form;

/**
 * BoldGrid Inspirations Forms class.
 *
 * @since 1.0.0
 */
class Forms {
	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
	if ( ! $this->get_ninjaforms_slug() ) {
		$wpforms = new Wpforms();

		// Add a filter for converting Ninja Forms into WPForms shortcodes.
		add_filter( 'boldgrid_deployment_pre_insert_post', array(
			$wpforms, 'convert_nf_shortcodes',
		) );
	}
	}
	/**
	 * Get a plugin slug (folder/file).
	 *
	 * If the plugin is not found, then an empty string is returned.
	 *
	 * @since 1.0.0
	 *
	 * @param array $match_names An array of plugin names to match.
	 * @return string
	 */
	public function get_plugin_slug( array $match_names ) {
		$plugins = get_plugins();

		foreach ( $plugins as $plugin_slug => $plugin_data ) {
			if ( in_array( $plugin_data['Name'], $match_names, true ) ) {
				return $plugin_slug;
			}
		}

		return '';
	}

	/**
	 * Get the BoldGrid Ninja Forms slug (folder/file).
	 *
	 * @since 1.0.0
	 *
	 * @see \Boldgrid\Library\Form\Forms::get_plugin_slug()
	 *
	 * @return string
	 */
	public function get_ninjaforms_slug() {
		$match_names = array(
			'BoldGrid Ninja Forms',
		);

		return $this->get_plugin_slug( $match_names );
	}

	/**
	 * Get the WPForms slug (folder/file).
	 *
	 * @since 1.0.0
	 *
	 * @see \Boldgrid\Library\Form\Forms::get_plugin_slug()
	 * @uses Wpforms::$match_names
	 *
	 * @return string
	 */
	public function get_wpforms_slug() {
		return $this->get_plugin_slug( Wpforms::$match_names );
	}

	/**
	 * Get the preferred form plugin slug (folder/file).
	 *
	 * @since 1.0.0
	 *
	 * @see \Boldgrid\Library\Form\Forms::get_wpforms_slug()
	 * @see \Boldgrid\Library\Form\Forms::get_ninjaforms_slug()
	 *
	 * @return string
	 */
	public function get_preferred_slug() {
		( $slug = $this->get_wpforms_slug() ) ||
			( $slug = $this->get_ninjaforms_slug() );

		$slug = apply_filters( 'boldgrid_form_preferred_slug', $slug );

		return $slug;
	}

	/**
	 * Activate the preferred forms plugin.
	 *
	 * @since 1.0.0
	 *
	 * @see \Boldgrid\Library\Form\Forms::get_preferred_slug()
	 * @see is_plugin_active()
	 * @see activate_plugin()
	 *
	 * @return bool
	 */
	public function activate_preferred_plugin() {
		$preferred_slug = $this->get_preferred_slug();

		if ( ! $preferred_slug ) {
			return false;
		}

		if ( is_plugin_active( $preferred_slug ) ) {
			return true;
		}

		$result = activate_plugin( $preferred_slug );

		if ( is_wp_error( $result ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Is there a form plugin installed?
	 *
	 * @since 1.0.0
	 *
	 * @see \Boldgrid\Library\Form\Forms::get_preferred_slug()
	 *
	 * @return bool
	 */
	public function has_form_plugin() {
		return (bool) $this->get_preferred_slug();
	}

	/**
	 * Install and activate the WPForms plugin and import forms.
	 *
	 * @since 1.0.0
	 *
	 * @see \Boldgrid\Library\Form\Wpforms()
	 * @see \Boldgrid\Library\Form\Wpforms::install_plugin()
	 * @see \Boldgrid\Library\Form\Forms::activate_preferred_plugin()
	 * @see \Boldgrid\Library\Form\Wpforms::import_forms()
	 *
	 * @return bool
	 */
	public function install() {
		if ( $this->has_form_plugin() ) {
			return false;
		}

		$wpforms = new Wpforms();

		$result = $wpforms->install_plugin();

		if ( $result ) {
			$result = $this->activate_preferred_plugin();
			$wpforms->import_forms();
		}

		return $result;
	}

	/**
	 * Check to ensure that all WPForms are imported.
	 *
	 * @since 1.0.0
	 *
	 * @see \Boldgrid\Library\Form\Forms::get_wpforms_slug()
	 * @see \Boldgrid\Library\Form\Wpforms::import_forms()
	 */
	public function check_wpforms() {
		if ( $this->get_wpforms_slug() ) {
			$wpforms = new Wpforms();

			$wpforms->import_forms();
		}
	}
}
