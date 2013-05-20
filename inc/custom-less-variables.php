<?php
/**
<<<<<<< HEAD
 * Functionality for converting the variable.less into 
=======
 * Functionality for converting the variable.less into
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
 * theme options page that will recompile into new CSS.
 *
 * To debug the generated CSS, add the following to your wp-config.php:
 * define( 'JCLV_UNCOMPRESSED', true );
 */


//
// Default settings
//

/**
 *  Setup which LESS files compiled into CSS files
 */
add_action( 'largo_custom_less_variables_init', 'largo_custom_less_variables_init', 1 );
function largo_custom_less_variables_init() {
	largo_clv_register_files( array( 'bootstrapify.less', 'carousel.less', 'editor-style.less', 'style.less', 'top-stories.less' ) );
<<<<<<< HEAD

	largo_clv_register_directory_paths( get_template_directory() . '/less/', get_template_directory_uri() . '/css/' );

=======
	largo_clv_register_directory_paths( get_template_directory() . '/less/', get_template_directory_uri() . '/css/' );
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
	largo_clv_register_variables_less_file( 'variables.less' );
}


//
// API Functions
//

/**
 * Register which Less files are to be compiled into CSS
 * for the user customized values to override variables.less.
 *
 * Example:
 *
 * largo_clv_register_files( array( 'style.less', 'editor.less' ) );
 *
 * @param array $files - list of filenames in the less directory
 */
function largo_clv_register_files( $files ) {
	Largo_Custom_Less_Variables::register_files( $files );
}


/**
<<<<<<< HEAD
 * Set the file path for the directory with the LESS files and 
=======
 * Set the file path for the directory with the LESS files and
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
 * URI for the directory with the outputted CSS.
 *
 * @param string $less_dir
 * @param string $css_dir_uri
 */
function largo_clv_register_directory_paths( $less_dir, $css_dir_uri ) {
<<<<<<< HEAD
	Largo_Custom_Less_Variables::register_directory_paths( $less_dir, $css_dir_uri );	
=======
	Largo_Custom_Less_Variables::register_directory_paths( $less_dir, $css_dir_uri );
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
}


/**
 * Set the filename of the variables file.
 *
 * @param string $variables_less_file - 'variables.less'
 */
function largo_clv_register_variables_less_file( $variables_less_file ) {
	Largo_Custom_Less_Variables::register_variables_less_file( $variables_less_file );
}



/**
 * Class to contain the logic
 */
class Largo_Custom_Less_Variables {

	// Variables
	static $less_files = array();
	static $css_files = array();
	static $field_type_callbacks = array();
	static $less_dir;
	static $css_dir_uri;
	static $variables_less_file = 'variables.less';

	const CACHE_DURATION = WEEK_IN_SECONDS;

	/**
	 * Initialize the plugin
	 */
	static function init() {
		// Alters the URL for the CSS files that are recompiled with the custom variables
		add_filter( 'style_loader_src', array( __CLASS__, 'style_loader_src' ), 10, 2 );

<<<<<<< HEAD
		// Used to output the rendered CSS for the customized LESS 
=======
		// Used to output the rendered CSS for the customized LESS
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
		add_action( 'template_redirect', array( __CLASS__, 'template_redirect') );

		// Add our admin page
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu') );

<<<<<<< HEAD

		// Register post type for saving the data to
		register_post_type( 'largo_custom_less_variables', array( 'public' => false, 'supports' => array( 'revisions' => true ) ));


=======
		// Register post type for saving the data to
		register_post_type( 'largo_custom_less_variables', array( 'public' => false, 'supports' => array( 'revisions' => true ) ));

>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
		self::$less_dir    = get_template_directory() . '/less/';
		self::$css_dir_uri = get_template_directory_uri() . '/css/';

		// Allow others to alter the settings
		do_action( 'largo_custom_less_variables_init' );

<<<<<<< HEAD

=======
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
		// Check if this page load is result of a save
		if ( is_admin() && isset( $_POST['customlessvariables'] ) && false != strstr( $_SERVER[ 'REQUEST_URI' ], 'themes.php' ) ) {
			check_admin_referer( 'customlessvariables', 'customlessvariables' );

<<<<<<< HEAD
			if ( isset( $_POST['field'] ) && is_array( $_POST['field'] ) ) {
				self::update_custom_values( $_POST['field'] );
			} else {
				self::update_custom_values( array() );
			}

			add_action( 'admin_notices', array( __CLASS__, 'success_admin_notices' ) );
		}

	}


=======
			if ( isset( $_POST['field'] ) && is_array( $_POST['field'] ) && isset( $_POST['submit-action'] ) && $_POST['submit-action'] == __( 'Reset All', 'largo' )) {
			// Reset all values
				self::reset_all();
				add_action( 'admin_notices', array( __CLASS__, 'reset_admin_notices' ) );
			// Update fields
			} else if ( isset( $_POST['field'] ) && is_array( $_POST['field'] ) ) {
				self::update_custom_values( $_POST['field'] );
				add_action( 'admin_notices', array( __CLASS__, 'success_admin_notices' ) );
			} else {
				self::update_custom_values( array() );
				add_action( 'admin_notices', array( __CLASS__, 'success_admin_notices' ) );	//we updated even without getting anything
			}
		}
	}

>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
	/**
	 * Register the Less files to compile into CSS files
	 *
	 * @param array $files - the LESS files to compile into CSS
	 */
	static function register_files( $files ) {
		self::$less_files = (array) $files;

		// Keep a copy list with the '.css' extension
		$css_files = array();
		foreach ($files as $key => $file ) {
			$css_files[$key] = preg_replace( '#\.less$#', '.css', $file );
		}
		self::$css_files = $css_files;
	}

<<<<<<< HEAD

	/**
	 * Set the file path for the directory with the LESS files and 
=======
	/**
	 * Set the file path for the directory with the LESS files and
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
	 * URI for the directory with the outputted CSS.
	 *
	 * @param string $less_dir
	 * @param string $css_dir_uri
	 */
	static function register_directory_paths( $less_dir, $css_dir_uri ) {
		self::$less_dir = $less_dir;
		self::$css_dir_uri  = $css_dir_uri;
	}

<<<<<<< HEAD


=======
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
	/**
	 * Set the variables.less file
	 *
	 * @param string $variables_less_file - example 'variables.less'
	 */
	static function register_variables_less_file( $variables_less_file ) {
		self::$variables_less_file = $variables_less_file;
	}

<<<<<<< HEAD


=======
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
	/**
	 * Get the compiled CSS for a LESS file.
	 *
	 * It will retrieved it from saved generated CSS or go
	 * ahead and compile it.
	 *
	 * @param string $less_file - the LESS file to compile
	 *
	 * @return string the generated CSS
	 */
	static function get_css( $less_file ) {
		$variables = self::get_custom_values();

		// Use the cached version saved to the DB
		if ( !empty( $variables['meta']->ID ) ) {
			$css = get_post_meta( $variables['meta']->ID, $less_file );

			if ( !empty( $css ) ) {
				$css = $css[0];
			} else {
				$css = self::compile_less( $less_file );
<<<<<<< HEAD
				add_post_meta( $variables['meta']->ID, $less_file, $css );
=======
				add_post_meta( $variables['meta']->ID, $less_file, addslashes( $css ) );
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
			}

			return $css;
		}

		return self::compile_less( $less_file );
	}


	/**
	 * Compile a LESS file with our custom variables
	 *
	 * @param $string $less_file - 'style.less'
	 *
	 * @return string - the resulting CSS
	 */
	static function compile_less( $less_file ) {

		// Load LESS compiler if loaded
		if ( !class_exists('lessc') ) {
<<<<<<< HEAD
			require( dirname( __FILE__ ) . '/lib/lessc.inc.php' );
=======
			require( dirname( __FILE__ ) . '/../lib/lessc.inc.php' );
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
		}

		$compiler = new lessc();
		// Set to compressed mode unless SCRIPT_DEBUG is true
		if ( !defined( 'JCLV_UNCOMPRESSED' ) || !JCLV_UNCOMPRESSED ) {
			$compiler->setFormatter("compressed");
		}
		$compiler->addImportDir( self::$less_dir );

		try {
			// Get the Less file and then replace variables.less with the update version
			$less = file_get_contents( self::$less_dir . $less_file );
			$less = self::replace_with_custom_variables( $less );

<<<<<<< HEAD
			return $compiler->compile( $less );
=======
			$css = $compiler->compile( $less );
			$css = self::fix_urls( $css );
			return $css;
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
		} catch ( Exception $e ) {
			return $less;
		}

	}

<<<<<<< HEAD

=======
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
	/**
	 * Get the variable.less file path
	 */
	static function variable_file_path() {
		return self::$less_dir . '/' . self::$variables_less_file;
	}

<<<<<<< HEAD

=======
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
	/**
	 * Replace the include for the variable file with a modified version
	 * with the custom values.
	 */
	static function replace_with_custom_variables( $less ) {

		// First, take variables.less and replace the values of the over-ridden variables.
		$variables_less = file_get_contents( self::variable_file_path() );

		// Parse out the variables. Each is defined per line in format: @<varName>: <varValue>;
		preg_match_all( '#^\s*@(?P<name>[\w-_]+):\s*(?P<value>[^;]*);#m', $variables_less, $matches );

		$variables = self::get_custom_values();

		foreach ( $matches[0] as $index => $rule ) {
			$name = $matches['name'][$index];

			if ( !empty( $variables['variables'][$name] ) ) {
				$replacement_rule = "@{$name}: {$variables['variables'][$name]};";
				$variables_less = str_replace( $rule, $replacement_rule, $variables_less);
			}
		}

		// Second, replace the import statements for variables.less with our output
		$filename = str_replace( '\.less', '(\.less)?', preg_quote( self::$variables_less_file ) );
		$less = preg_replace( '#^@import ["\']'.$filename.'["\'];#m', $variables_less, $less );

		return $less;
	}


	/**
<<<<<<< HEAD
=======
	 *
	 */
	static function fix_urls( $css ) {
		preg_match_all('#url\(([^)]+)\)#', $css, $matches );

		$find = array();
		$replace = array();

		foreach ( $matches[1] as $raw_url ) {
			$url = trim( $raw_url, " \t\n\r\0\x0B'\"" );

			// Don't replace for URLs with domain name, starting at the root, or just a fragment
			if ( 0 == preg_match( '@^(\w://|//|/|#)@', $url ) ) {
				$find[] = 'url('.$raw_url.')';
				$replace[] = 'url(' . self::$css_dir_uri . $url . ')';
			}
		}

		$css = str_replace( $find, $replace, $css );

		return $css;
	}

	/**
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
	 * Change the URL for the stylesheets that are the output of the LESS files.
	 */
	static function style_loader_src( $src, $handle ) {
		$base_url = get_template_directory_uri() . '/css/';
		$base_url_escape = preg_quote( $base_url );

		// Check if the src is one of our to replace with LESS intercept
		foreach ( self::$css_files as $key => $filename ) {
			if ( preg_match( '!^'.$base_url_escape. preg_quote( $filename ) .'(?<extra>[#\?].*)?$!', $src, $matches ) ) {
				$variables = self::get_custom_values();
<<<<<<< HEAD
				return add_query_arg( 
=======
				if (is_null($variables['meta'])) $variables['meta'] = (object) array('post_modified_gmt' => 0);	//check if none defined
				return add_query_arg(
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
					array( 'largo_custom_less_variable' => 1, 'css_file' => $filename, 'timestamp' => $variables['meta']->post_modified_gmt ),
					home_url( $matches['extra'] )
				);
			}
		}
		return $src;
	}

<<<<<<< HEAD

=======
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
	/**
	 * Intercept the loading of the page to determine if we output the rendered CSS
	 */
	static function template_redirect() {
		// Exit if not our call
		if ( !filter_input( INPUT_GET, 'largo_custom_less_variable', FILTER_VALIDATE_BOOLEAN ) ) {
			return;
		}

		$css_file = filter_input( INPUT_GET, 'css_file', FILTER_SANITIZE_STRING );

		header( 'Content-Type: text/css', true, 200 );
		header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', time() + 31536000) . ' GMT' ); // 1 year

<<<<<<< HEAD

=======
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
		// Echo nothing if the file is missing
		if ( empty( $css_file ) ) {
			echo '';
			exit;
		}

		// Get the array index for $css_files because it matches $less_files
		$key = array_search( $css_file, self::$css_files );

		// Echo nothing if file is not registered
		if ( $key===false ) {
			echo '';
			exit;
		}

		$variables = self::get_custom_values();
		echo "/* Custom LESS Variables {$variables['meta']->post_modified_gmt} */\n";
		echo self::get_css( self::$less_files[$key] );

		exit;
	}

<<<<<<< HEAD

=======
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
	/**
	 * Display a success message
	 */
	static function success_admin_notices() {
		echo '<div id="message" class="updated fade"><p><strong>' . __( 'CSS custom variables saved.', 'largo' ) . '</strong></p></div>';
	}

<<<<<<< HEAD
=======
	/**
	 * Display a success message
	 */
	static function reset_admin_notices() {
		echo '<div id="message" class="error fade"><p><strong>' . __( 'Values reset to defaults.', 'largo' ) . '</strong></p></div>';
	}
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e

	/**
	 * Register the admin page
	 */
	static function admin_menu() {
		$parent = 'themes.php';
		$title = __( 'CSS Variables', 'largo' );
		$hook = add_theme_page( $title, $title, 'edit_theme_options', 'largo_custom_less_variables', array( __CLASS__, 'admin' ) );

		add_action( "admin_head-$hook", array( __CLASS__, 'admin_head' ) );
		//add_action( "load-revision.php", array( 'Jetpack_Custom_CSS', 'prettify_post_revisions' ) );
		//add_action( "load-$hook", array( 'Largo_Custom_Less_Variables', 'update_title' ) );
	}

<<<<<<< HEAD

=======
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
	/**
	 * Render the admin page content
	 */
	static function admin() {

<<<<<<< HEAD
		add_meta_box( 'submitdiv', __( 'Publish', 'largo' ), array( __CLASS__, 'publish_box' ), 'customlessvariables', 'side' );

=======
		add_meta_box( 'submitdiv', __( 'Publishing Options', 'largo' ), array( __CLASS__, 'publish_box' ), 'customlessvariables', 'side' );
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e

		//if ( ! empty( $safecss_post ) && 0 < $safecss_post['ID'] && wp_get_post_revisions( $safecss_post['ID'] ) )
		//	add_meta_box( 'revisionsdiv', __( 'CSS Variables Revisions', 'largo' ), array( __CLASS__, 'revisions_meta_box' ), 'customlessvariables', 'side' );

		?>
		<div class="wrap columns-2">
			<h2><?php _e( 'CSS Variables', 'largo' ); ?></h2>
			<form id="custom-css-variables" action="" method="post">
				<?php wp_nonce_field( 'customlessvariables', 'customlessvariables' ) ?>
				<?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
				<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
				<input type="hidden" name="action" value="save" />
				<div id="poststuff" class="metabox-holder has-right-sidebar">
<<<<<<< HEAD
					<p class="css-support"><?php echo apply_filters( 'largo_custom_less_variables_intro', __( 'Customize the variables within the LESS variables.', 'largo' ) ); ?></p>
=======
					<p class="css-support"><?php echo apply_filters( 'largo_custom_less_variables_intro', __( 'Customize the appearance of this theme by changing key LESS used for generating CSS.', 'largo' ) ); ?></p>
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
					<div id="postbox-container-1" class="inner-sidebar">
						<?php do_meta_boxes( 'customlessvariables', 'side', array() ); ?>
					</div>
					<div id="post-body">
						<div id="post-body-content">
							<div class="custom-less-variables">
								<?php
								$field_groups = self::get_editable_variables();

								$group_names = apply_filters( 'largo_custom_less_variables_group_order', array_keys( $field_groups ) );

								// Setup the field callbacks
								$field_type_callbacks = array(
									'color' => array( __CLASS__, 'color_type_field' ),
<<<<<<< HEAD
=======
									'pixels' => array( __CLASS__, 'pixels_field' ),
									'dropdown' => array( __CLASS__, 'dropdown_field' ),
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
								);
								$field_type_callbacks = apply_filters( 'largo_custom_less_variables_types_callbacks', $field_type_callbacks );

								$values = self::get_custom_values();

								foreach ( $group_names as $group_name ) {
									if ( $group_name != '_default' ) {
										echo '<h3>', esc_html( $group_name ), '</h3>';
									}

									foreach ( $field_groups[$group_name] as $field_name => $field ) {
										echo '<div class="field field-', esc_attr($field['type']), '" id="field-',$field_name,'-row">';
										$form_name = 'field['.$field_name.']';
										$form_id = 'field-'.$field_name;
										$value = empty( $values['variables'][$field_name] ) ? trim( $field['default_value'] ) : $values['variables'][$field_name];
										echo '<label id="',$form_id,'">', $field['label'], '</label> ';

										if ( isset( $field_type_callbacks[$field['type']] ) ) {
<<<<<<< HEAD
											call_user_func_array( $field_type_callbacks[$field['type']], array( $field, $value, $form_name, $form_id ) );
										} else {
											echo '<input type="text" name="', $form_name, '" id="', $form_id, '" value="', esc_attr($value),'" />';
=======
											call_user_func_array( $field_type_callbacks[$field['type']], array( $field, $value, $field['default_value'], $form_name, $form_id ) );
										} else {
											echo '<input type="text" name="', $form_name, '" id="', $form_id, '" size="40" value="', esc_attr($value),'" />';
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
										}

										echo '</div>';
									}
								}

								?>
							</div>
						</div>
					</div>
					<br class="clear" />
				</div>
			</form>
		</div>
		<?php
	}


	/**
	 * Register Javascript files and stylesheets.
	 */
	static function admin_head() {
		wp_enqueue_script( 'iris' ); // Colorpicker
<<<<<<< HEAD

		wp_enqueue_script( 'largo_custom_less_variable', get_template_directory_uri().'/js/custom-less-variables.js', array( 'jquery', 'iris' ), '20130405', true );

		wp_enqueue_style( 'largo_custom_less_variable', get_template_directory_uri().'/css/custom-less-variables.css', '20130405' );


		do_action( 'largo_custom_less_variable_head' );
	}


=======
		wp_enqueue_script( 'largo_custom_less_variable', get_template_directory_uri().'/js/custom-less-variables.js', array( 'jquery', 'iris' ), '20130405', true );
		wp_enqueue_style( 'largo_custom_less_variable', get_template_directory_uri().'/css/custom-less-variables.css', '20130405' );
		do_action( 'largo_custom_less_variable_head' );
	}

>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
	/**
	 * Revision meta box
	 */
	static function revisions_meta_box() {
<<<<<<< HEAD

	}


=======
	}

>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
	/**
	 * Render the publish meta box
	 */
	static function publish_box() {
		?>
		<div id="minor-publishing">
<<<<<<< HEAD
			<?php /*
			<div id="misc-publishing-actions">
				

				// $safecss_post = Jetpack_Custom_CSS::get_current_revision();

				
				<?php do_action( 'largo_custom_less_variables_submitbox_misc_actions' ); ?>
			</div>
			*/ ?>
=======
			<!-- div id="misc-publishing-actions">
				<?php /* // $safecss_post = Jetpack_Custom_CSS::get_current_revision();
				<?php do_action( 'largo_custom_less_variables_submitbox_misc_actions' ); ?> */ ?>
				<p><a data-action="reset" class="button">Reset to defaults</a> <br/></p>
			</div -->
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
		</div>
		<div id="major-publishing-actions">
			<?php // <input type="button" class="button" id="preview" name="preview" value="<?php esc_attr_e( 'Preview', 'jetpack' ) " />
			?>
			<div id="publishing-action">
<<<<<<< HEAD
				<input type="submit" class="button-primary" id="save" name="save" value="<?php esc_attr_e( 'Save CSS Variables', 'largo' ); ?>" />
			</div>
			<div class="clear"></div>
		</div>
		<?php
	}


=======
				<input type="submit" name="submit-action" value="<?php esc_attr_e( 'Reset All', 'largo' ); ?>" class="button" />
				<input type="submit" class="button-primary" id="save" name="save" value="<?php esc_attr_e( 'Save Variables', 'largo' ); ?>" />
			</div>
			<div class="clear"></div>
		</div>


		<?php
	}

>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
	/**
	 * Get the custom values
	 *
	 * @param string $theme optional - the folder name of the theme, defaults to active theme
	 * @param int $revision optional - the revision ID, defaults to the current version
	 *
	 * @return associated array of values
	 */
	static function get_custom_values( $theme=null, $revision=null ) {
		if ( empty( $theme ) ) {
			$theme_data = wp_get_theme();
			$theme = $theme_data->get_stylesheet();
		}

		// Try to retrieve cached values
		$cache_key = 'customlessvars_'.$theme;
		$cached = get_transient( $cache_key );
		if ( $cached !== false ) {
			return $cached;
		}

		// Need the current version of the settings
		$post = get_posts( array(
			'post_type'      => 'largo_less_variables',
			'post_name'      => sanitize_title( $theme ),
			'posts_per_page' => 1,
		));

		if ( count( $post ) == 0 ) {
			$data = array( 'meta' => null, 'variables' => array() );
			set_transient( $cache_key, $data, self::CACHE_DURATION );
			return $data;
		}
		$post = $post[0];
		$post_version = $post;

		// If a current revision is defined
		if ( !empty($revision) && $post->ID != $revision ) {
			$post_version = get_posts( array(
				'post_parent'    => $post->ID,
				'post_type'      => 'revision',
				'post_status'    => 'inherit',
				'posts_per_page' => 1
			));

			if ( count( $post_version) == 0 ) {
				$data = array( 'meta' => null, 'variables' => array() );
				set_transient( $cache_key, $data, self::CACHE_DURATION );
				return $data;
			}

			$post_version = $post_version[0];
		}

<<<<<<< HEAD

=======
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
		// Get the values
		$values = json_decode( $post_version->post_content, true );

		if ( empty( $values ) || !is_array( $values ) ) {
			$data = array( 'meta' => null, 'variables' => array() );
		} else {
			$data = array( 'meta' => $post_version, 'variables' => $values );
		}
		set_transient( $cache_key, $data, self::CACHE_DURATION );
		return $data;
	}

<<<<<<< HEAD
=======
	/**
	 * Delete all custom variables saved
	 */
	static function reset_all() {

		//delete from posts
		$clv_posts = get_posts('numberposts=-1&post_type=largo_less_variables&post_status=any');
		foreach ($clv_posts as $clv_post) {
			wp_delete_post( $clv_post->ID, true );
		}

		//delete anything transient just in case
		$theme_data = wp_get_theme();
		$theme = $theme_data->get_stylesheet();
		$cache_key = 'customlessvars_'.$theme;
		print delete_transient( $cache_key );
	}
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e

	/**
	 * Save or update custom values
	 *
	 * @param array $values - an associative array of values
	 * @param string $theme optional - the theme name, defaults to the active the theme
	 */
<<<<<<< HEAD
	static function update_custom_values( $values, $theme=null ) {
=======
	static function update_custom_values( $values, $theme = null ) {
		global $post;
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
		if ( empty( $theme ) ) {
			$theme_data = wp_get_theme();
			$theme = $theme_data->get_stylesheet();
		}

		// Need the current version of the settings
<<<<<<< HEAD
		$post = get_posts( array(
=======
		$_ = get_posts( array(
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
			'post_type'      => 'largo_less_variables',
			'post_name'      => $theme,
			'posts_per_page' => 1,
			'post_status'    => 'any'
		));

		$post_id = null;

		if ( count( $post ) != 0 ) {
			$post_id = $post[0]->ID;
		}

		if ( !is_array( $values ) ) {
			$values = array();
<<<<<<< HEAD
		}


=======
		} else {
			foreach ($values as $field => $value) {
				//fix the pixels ones
				if (strpos($field, "-pixels")) {
					$values[ str_replace("-pixels", "", $field) ] = $value . "px";
					unset($values[$field]);
				}
			}
		}

>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
		$post_data = array(
			'post_content' => json_encode( $values ),
			'post_name'   => $theme,
			'post_type'   => 'largo_less_variables',
			'post_status' => 'publish'
		);

		if ( empty( $post_id ) ) {
			$post_id = wp_insert_post( $post_data );
		} else {
			$post_data['ID'] = $post_id;
			wp_update_post( $post_data );

			// Clear out meta data
			$meta_keys = get_post_custom_keys( $post_id );
<<<<<<< HEAD
			foreach ( $meta_keys as $meta_key ) {
				delete_post_meta( $post_id, $meta_key );
			}
		}
		
=======
			if (count($meta_keys)) {
				foreach ( $meta_keys as $meta_key ) {
					delete_post_meta( $post_id, $meta_key );
				}
			}
		}

>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
		// clear cache
		$cache_key = 'customlessvars_'.$theme;
		delete_transient( $cache_key );
	}

<<<<<<< HEAD

=======
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
	/**
	 * Parse the variable.less to retrieve the editable values
	 */
	static function get_editable_variables() {
		$variable_groups = array(
			'_default' => array()
		);

		$less = file_get_contents( self::variable_file_path() );

<<<<<<< HEAD

=======
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
		// Parse
		$pattern = '#/\*\*\s+(?<comment>.*)\s+\*/\s*@(?P<name>[\w-_]+):\s*(?P<value>[^;]*);#Us';
		$comment_pattern = '#^\s*\*\s*@(?P<prop>\w+)\s+(?P<value>.*)$#mU';

		preg_match_all( $pattern, $less, $matches );

		foreach ( $matches['comment'] as $key => $comment ) {
			$name = $matches['name'][$key];
			$value = $matches['value'][$key];
			$props = array();

			// Parse out the properties in the comment block
			preg_match_all( $comment_pattern, $comment, $comment_matches );
<<<<<<< HEAD
			
=======

>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
			foreach ( $comment_matches['prop'] as $pkey => $prop ) {
				$props[$prop] = trim( $comment_matches['value'][$pkey] );
			}

			// Only add those with a type defined
			if ( isset( $props['type'] ) ) {

				// Ensure there is a group to add the variable to
				$group = empty( $props['group'] ) ? '_default' : $props['group'];
				if ( !isset( $variable_groups[$group] ) ) {
					$variable_groups[$group] = array();
				}

				// Ensure there is a label
				$label = empty( $props['label'] ) ? ucwords( str_replace( array('-', '_'), ' ', preg_replace( '/([a-z])([A-Z])/', '$1 $2', $name ) ) ) : $props['label'];

				// Ensure there is a default value
				$default_value = empty( $props['default_value'] ) ? $value : $props['default_value'];

				$variable_groups[$group][$name] = array(
					'name' => $name,
					'default_value' => $default_value,
					'properties' => $props,
					'label' => $label,
					'type' => $props['type'],
				);
			}
		}
<<<<<<< HEAD
		
=======

>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
		return $variable_groups;
	}


<<<<<<< HEAD


	/**
	 * Render the color field in the admin
	 */
	static function color_type_field( $field, $value, $name, $id ) {
		echo '<input name="', $name, '" id="', $id, '" data-widget="colorpicker" value="', esc_attr($value), '" />';
	}
}

Largo_Custom_Less_Variables::init();
=======
	/**
	 * Render the color field in the admin
	 */
	static function color_type_field( $field, $value, $default_value, $name, $id ) {
		echo '<input name="', $name, '" id="', $id, '" data-widget="colorpicker" value="', esc_attr($value), '" data-default-value="', $default_value,'" />';
	}

	/**
	 * Render a pixels field in the admin
	 */
	static function pixels_field( $field, $value, $default_value, $name, $id ) {
		$display_value = esc_attr(rtrim($value, 'px'));	//strip out "px", will be added back in before save
		echo '<input name="', str_replace("]","-pixels]", $name), '" id="', $id, '" type="number" step="1" value="', $display_value, '" data-default-value="', $default_value,'" /> pixels';
	}

	/**
	 * Render a dropdown in the admin
	 */
	static function dropdown_field( $field, $value, $default_value, $name, $id ) {
		$options = explode('|', $field['properties']['options']);
		echo '<select name="', $name, '" id="', $id, '" data-default-value="', $default_value,'">';
		foreach ($options as $opt) {
			echo '<option value="', esc_attr($opt), '"', selected($opt, $value, 0), '>', $opt, "</option>\n";
		}
		echo '</select>';
	}

}

Largo_Custom_Less_Variables::init();
>>>>>>> b3a83f9a75cf2d6581d13e35404ebeb2517f391e
