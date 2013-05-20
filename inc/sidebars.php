<?php

/**
 * Register our sidebars and other widget areas
 *
 * @since 1.0
 */
function largo_register_sidebars() {
	register_sidebar( array(
		'name' 			=> __( 'Main Sidebar', 'largo' ),
		'description' 	=> __( 'The sidebar for the homepage. If you do not add widgets to any of the other sidebars, this will also be used on all of the other pages of your site.', 'largo' ),
		'id' 			=> 'sidebar-main',
		'before_widget' => '<aside id="%1$s" class="%2$s clearfix">',
		'after_widget' 	=> "</aside>",
		'before_title' 	=> '<h3 class="widgettitle">',
		'after_title' 	=> '</h3>',
	) );

	register_sidebar( array(
		'name' 			=> __( 'Single Sidebar', 'largo' ),
		'description' 	=> __( 'The sidebar for posts and pages', 'largo' ),
		'id' 			=> 'sidebar-single',
		'before_widget' => '<aside id="%1$s" class="%2$s clearfix">',
		'after_widget' 	=> "</aside>",
		'before_title' 	=> '<h3 class="widgettitle">',
		'after_title' 	=> '</h3>',
	) );

	if ( of_get_option( 'use_topic_sidebar' ) ) {
		register_sidebar( array(
			'name' 			=> __( 'Archive/Topic Sidebar', 'largo' ),
			'description' 	=> __( 'The sidebar for category, tag and other archive pages', 'largo' ),
			'id' 			=> 'topic-sidebar',
			'before_widget' => '<aside id="%1$s" class="%2$s clearfix">',
			'after_widget' 	=> "</aside>",
			'before_title' 	=> '<h3 class="widgettitle">',
			'after_title' 	=> '</h3>',
		) );
	}

	register_sidebar( array(
		'name' 			=> __( 'Footer 1', 'largo' ),
		'description' 	=> __( 'The first footer widget area.', 'largo' ),
		'id' 			=> 'footer-1',
		'before_widget' => '<aside id="%1$s" class="%2$s clearfix">',
		'after_widget' 	=> "</aside>",
		'before_title' 	=> '<h3 class="widgettitle">',
		'after_title' 	=> '</h3>',
	) );

	register_sidebar( array(
		'name' 			=> __( 'Footer 2', 'largo' ),
		'description' 	=> __( 'The second footer widget area.', 'largo' ),
		'id' 			=> 'footer-2',
		'before_widget' => '<aside id="%1$s" class="%2$s clearfix">',
		'after_widget' 	=> "</aside>",
		'before_title' 	=> '<h3 class="widgettitle">',
		'after_title' 	=> '</h3>',
	) );

	register_sidebar( array(
		'name' 			=> __( 'Footer 3', 'largo' ),
		'description' 	=> __( 'The third footer widget area.', 'largo' ),
		'id' 			=> 'footer-3',
		'before_widget' => '<aside id="%1$s" class="%2$s clearfix">',
		'after_widget' 	=> "</aside>",
		'before_title' 	=> '<h3 class="widgettitle">',
		'after_title' 	=> '</h3>',
	) );

	// @todo - probably add an option to enable this because not everyone is going to have ads here
	// @todo - add additional widget area in the footer for a leaderboard ad unit there too
	register_sidebar( array(
		'name' => 'Header',
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>'
	) );

	if ( of_get_option('footer_layout') == '4col' ) :
		register_sidebar( array(
			'name' 			=> __( 'Footer 4', 'largo' ),
			'description' 	=> __( 'The fourth footer widget area.', 'largo' ),
			'id' 			=> 'footer-4',
			'before_widget' => '<aside id="%1$s" class="%2$s clearfix">',
			'after_widget' 	=> "</aside>",
			'before_title' 	=> '<h3 class="widgettitle">',
			'after_title' 	=> '</h3>',
		) );
	endif;

	if ( of_get_option('homepage_layout') == '3col' ) :
		register_sidebar( array(
			'name' 			=> __( 'Homepage Left Rail', 'largo' ),
			'description' 	=> __( 'An optional widget area that, when enabled, appears to the left of the main content area on the homepage.', 'largo' ),
			'id' 			=> 'homepage-left-rail',
			'before_widget' => '<div id="%1$s" class="%2$s">',
			'after_widget' 	=> '</div>',
			'before_title' 	=> '<h3 class="widgettitle">',
			'after_title' 	=> '</h3>',
		) );
	endif;

	if ( of_get_option('homepage_bottom') == 'widgets' ) :
		register_sidebar( array(
			'name' 			=> __( 'Homepage Bottom', 'largo' ),
			'description' 	=> __( 'An optional widget area at the bottom of the homepage', 'largo' ),
			'id' 			=> 'homepage-bottom',
			'before_widget' => '<div id="%1$s" class="%2$s span6">',
			'after_widget' 	=> '</div>',
			'before_title' 	=> '<h3 class="widgettitle">',
			'after_title' 	=> '</h3>',
		) );
	endif;
}
add_action( 'widgets_init', 'largo_register_sidebars' );

/**
 * Also, register any custom-created sidebars from Theme Options
 *
 * @since 1.0
 */
function largo_custom_sidebars() {
	$custom_sidebars = preg_split( '/$\R?^/m', of_get_option( 'custom_sidebars' ) );
	if ( is_array( $custom_sidebars ) ) {
		foreach( $custom_sidebars as $sidebar ) {
			$sidebar_slug = largo_make_slug( $sidebar );
			if ( $sidebar_slug ) {
				register_sidebar( array(
					'name' 			=> __( $sidebar, 'largo' ),
					'id' 			=> $sidebar_slug,
					'before_widget' => '<aside id="%1$s" class="%2$s clearfix">',
					'after_widget' 	=> '</aside>',
					'before_title' 	=> '<h3 class="widgettitle">',
					'after_title' 	=> '</h3>'
				) );
			}
		}
	}
}
add_action( 'widgets_init', 'largo_custom_sidebars' );

/**
 * Helper function to transform user-entered text into WP-compatible slugs
 *
 * @since 1.0
 */
function largo_make_slug($string, $maxLength = 63) {
  $result = preg_replace("/[^a-z0-9\s-]/", "", strtolower($string));
  $result = trim(preg_replace("/[\s-]+/", " ", $result));
  $result = trim(substr($result, 0, $maxLength));
  return preg_replace("/\s/", "-", $result);
}

/**
 * Builds a dropdown menu of the custom sidebars
 * Used in the meta box on post/page edit screen
 *
 * @since 1.0
 */
if( !function_exists( 'custom_sidebars_dropdown' ) ) {
	function custom_sidebars_dropdown() {
		global $wp_registered_sidebars, $post;
		$custom = get_post_meta( $post->ID, 'custom_sidebar', true );
		$val = ( $custom ) ? $custom : 'none';

		// Add a default option
		$output .= '<option';
		if( $val == 'default' ) $output .= ' selected="selected"';
		$output .= ' value="default">' . __( 'Default', 'largo' ) . '</option>';

		// Build an array of sidebars, making sure they're real
	  	$custom_sidebars = preg_split( '/$\R?^/m', of_get_option( 'custom_sidebars' ) );
		$sidebar_slugs = array_map( 'largo_make_slug', $custom_sidebars );

		// Fill the select element with all registered sidebars that are custom
		foreach( $wp_registered_sidebars as $sidebar_id => $sidebar ) {
			if ( !in_array( $sidebar_id, $sidebar_slugs ) ) continue;
			$output .= '<option';
			if ( $sidebar_id == $val ) $output .= ' selected="selected"';
			$output .= ' value="' . $sidebar_id . '">' . $sidebar['name'] . '</option>';
		}

		$output .= '</select>';
		echo $output;
	}
}