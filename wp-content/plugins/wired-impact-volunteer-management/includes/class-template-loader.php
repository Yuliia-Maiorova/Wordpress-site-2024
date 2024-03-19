<?php

/**
 * Template Loader for Plugins.
 *
 * @link       http://wiredimpact.com
 * @since      0.1
 *
 * @package    WI_Volunteer_Management
 * @subpackage WI_Volunteer_Management/Includes
 */

/**
 * Template Loader for Plugins.
 *
 * Template loader for plugins which first checks for a theme override, and if not
 * then loads the template from the plugin.
 *
 * @since      0.1
 * @package    WI_Volunteer_Management
 * @subpackage WI_Volunteer_Management/Includes
 * @author     Gary Jones
 * @link       http://github.com/GaryJones/Gamajo-Template-Loader
 * @copyright  2013 Gary Jones
 * @license    GPL-2.0+
 * @version    1.1.0
 */

if ( ! class_exists( 'WI_Volunteer_Management_Template_Loader' ) ) {
	/**
	 * Template loader.
	 *
	 * Originally based on functions in Easy Digital Downloads (thanks Pippin!).
	 *
	 * When using in a plugin, create a new class that extends this one and just overrides the properties.
	 *
	 * @package Gamajo_Template_Loader
	 * @author  Gary Jones
	 */
	class WI_Volunteer_Management_Template_Loader {
		/**
		 * Prefix for filter names.
		 *
		 * @since 1.0.0
		 *
		 * @type string
		 */
		protected $filter_prefix = 'wivm';

		/**
		 * Directory name where custom templates for this plugin should be found in the theme.
		 *
		 * @since 1.0.0
		 *
		 * @type string
		 */
		protected $theme_template_directory = 'wivm'; // or 'your-plugin-templates' etc.

		/**
		 * Reference to the root directory path of this plugin.
		 *
		 * Can either be a defined constant, or a relative reference from where the subclass lives.
		 *
		 * @since 1.0.0
		 *
		 * @type string
		 */
		protected $plugin_directory = WIVM_DIR; // or plugin_dir_path( dirname( __FILE__ ) ); etc.

		/**
		 * Directory name where templates are found in this plugin.
		 *
		 * Can either be a defined constant, or a relative reference from where the subclass lives.
		 *
		 * @since 1.1.0
		 *
		 * @type string
		 */
		protected $plugin_template_directory = 'templates'; // or includes/templates, etc.

		/**
		 * Retrieve a template part.
		 *
		 * @since 1.0.0
		 *
		 * @uses Gamajo_Template_Loader::get_template_possble_parts() Create file names of templates.
		 * @uses Gamajo_Template_Loader::locate_template() Retrieve the name of the highest priority template
		 *     file that exists.
		 *
		 * @param string  $slug
		 * @param string  $name Optional. Default null.
		 * @param bool    $load Optional. Default true.
		 * @param array   $options Optional. Default null.
		 *
		 * @return string
		 */
		public function get_template_part( $slug, $name = null, $load = true, $options = null ) {

			// Execute code for this part
			do_action( 'get_template_part_' . $slug, $slug, $name );

			// Get files names of templates, for given slug and name.
			$templates = $this->get_template_file_names( $slug, $name );

			// Return the part that is found
			return $this->locate_template( $templates, $load, false, $options );
		}

		/**
		 * Given a slug and optional name, create the file names of templates.
		 *
		 * @since 1.0.0
		 *
		 * @param string  $slug
		 * @param string  $name
		 *
		 * @return array
		 */
		protected function get_template_file_names( $slug, $name ) {
			$templates = array();
			if ( isset( $name ) ) {
				$templates[] = $slug . '-' . $name . '.php';
			}
			$templates[] = $slug . '.php';

			/**
			 * Allow template choices to be filtered.
			 *
			 * The resulting array should be in the order of most specific first, to least specific last.
			 * e.g. 0 => recipe-instructions.php, 1 => recipe.php
			 *
			 * @since 1.0.0
			 *
			 * @param array $templates Names of template files that should be looked for, for given slug and name.
			 * @param string $slug Template slug.
			 * @param string $name Template name.
			 */
			return apply_filters( $this->filter_prefix . '_get_template_part', $templates, $slug, $name );
		}

		/**
		 * Retrieve the name of the highest priority template file that exists.
		 *
		 * Searches in the STYLESHEETPATH before TEMPLATEPATH so that themes which
		 * inherit from a parent theme can just overload one file. If the template is
		 * not found in either of those, it looks in the theme-compat folder last.
		 *
		 * @since 1.0.0
		 *
		 * @uses Gamajo_Tech_Loader::get_template_paths() Return a list of paths to check for template locations.
		 *
		 * @param string|array $template_names Template file(s) to search for, in order.
		 * @param bool         $load           If true the template file will be loaded if it is found.
		 * @param bool         $require_once   Whether to require_once or require. Default true.
		 * @param array        $options        Optional. Default null.
		 *   Has no effect if $load is false.
		 *
		 * @return string The template filename if one is located.
		 */
		public function locate_template( $template_names, $load = false, $require_once = true, $options = null ) {
			// No file found yet
			$located = false;

			// Remove empty entries
			$template_names = array_filter( (array) $template_names );
			$template_paths = $this->get_template_paths();

			// Try to find a template file
			foreach ( $template_names as $template_name ) {
				// Trim off any slashes from the template name
				$template_name = ltrim( $template_name, '/' );

				// Try locating this template file by looping through the template paths
				foreach ( $template_paths as $template_path ) {
					if ( file_exists( $template_path . $template_name ) ) {
						$located = $template_path . $template_name;
						break 2;
					}
				}
			}

			if ( $load && $located ) {

				/**
				 * Call this classes load_template function instead of the WordPress core load_template().
				 * This classes load_template function is nearly identical to the WordPress core function
				 * except it accepts an additional optional parameter which can be used to pass in variables
				 * to the required template which eliminates the need to use global variables in the script
				 * that utilizes the WI_Volunteer_Management_Template_Loader class.
				 */
				$this->load_template( $located, $require_once, $options );
			}

			return $located;
		}

		/**
		 * Return a list of paths to check for template locations.
		 *
		 * Default is to check in a child theme (if relevant) before a parent theme, so that themes which inherit from a
		 * parent theme can just overload one file. If the template is not found in either of those, it looks in the
		 * theme-compat folder last.
		 *
		 * @since 1.0.0
		 *
		 * @return mixed|void
		 */
		protected function get_template_paths() {
			$theme_directory = trailingslashit( $this->theme_template_directory );

			$file_paths = array(
				10  => trailingslashit( get_template_directory() ) . $theme_directory,
				100 => $this->get_templates_dir(),
			);

			// Only add this conditionally, so non-child themes don't redundantly check active theme twice.
			if ( is_child_theme() ) {
				$file_paths[1] = trailingslashit( get_stylesheet_directory() ) . $theme_directory;
			}

			/**
			 * Allow ordered list of template paths to be amended.
			 *
			 * @since 1.0.0
			 *
			 * @param array $var Default is directory in child theme at index 1, parent theme at 10, and plugin at 100.
			 */
			$file_paths = apply_filters( $this->filter_prefix . '_template_paths', $file_paths );

			// sort the file paths based on priority
			ksort( $file_paths, SORT_NUMERIC );

			return array_map( 'trailingslashit', $file_paths );
		}

		/**
		 * Return the path to the templates directory in this plugin.
		 *
		 * May be overridden in subclass.
		 *
		 * @since 1.0.0
		 *
		 * @return string
		 */
		protected function get_templates_dir() {
			return trailingslashit( $this->plugin_directory ) . $this->plugin_template_directory;
		}

      /**
       * This is a modification of the core WordPress load_template function. This
       * modification accepts an additonal array parameter which makes variables from 
       * the script that called the get_template_part function of the WI_Volunteer_Management_Template_Loader 
       * class available in the template file that is being required.
       *
       * Require the template file with WordPress environment.
       *
       * The globals are set up for the template file to ensure that the WordPress
       * environment is available from within the function. The query variables are
       * also available.
       *
       * @global array      $posts
       * @global WP_Post    $post
       * @global bool       $wp_did_header
       * @global WP_Query   $wp_query
       * @global WP_Rewrite $wp_rewrite
       * @global wpdb       $wpdb
       * @global string     $wp_version
       * @global WP         $wp
       * @global int        $id
       * @global WP_Comment $comment
       * @global int        $user_ID
       *
       * @param string $_template_file Path to template file.
       * @param bool   $require_once   Whether to require_once or require. Default true.
       * @param array  $options Optional. Array of key value pairs that can be used in the required template. Default null.
       */
      protected function load_template( $_template_file, $require_once = true, $options = null ) {
         global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

         if ( is_array( $wp_query->query_vars ) ) {
            extract( $wp_query->query_vars, EXTR_SKIP );
         }

         if ( isset( $s ) ) {
            $s = esc_attr( $s );
         }

         if ( $require_once ) {
            require_once( $_template_file );
         } else {
            require( $_template_file );
         }
      }
	}
}