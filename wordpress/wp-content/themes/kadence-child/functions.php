<?php
/**
 * Kadence-child Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package kadence-child
 */

add_action( 'wp_enqueue_scripts', 'kadence_parent_theme_enqueue_styles' );

/**
 * Enqueue scripts and styles.
 */
function kadence_parent_theme_enqueue_styles() {
	wp_enqueue_style( 'kadence-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'kadence-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[ 'kadence-style' ]
	);
}
