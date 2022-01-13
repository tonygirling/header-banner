<?php
/**
 * Handle theming of Header Banner.
 *
 * @package BannerHeader
 */

/*
Plugin Name: Banner Header
Plugin URI: https://morningtonsoftware.co.uk/
Description: Add styling and customisation to a header banner
Version: 1.0.2
Author: Tony Girling
Author URI: https://morningtonsoftware.co.uk
License: Private
Text Domain: banner-header
*/

/**
 * BannerHeader.
 */
class BannerHeader {

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'wp_head', array( $this, 'write_styles' ) );
		add_action( 'kadence_before_wrapper', array( $this, 'write_header_content' ) );
		add_action( 'kadence_after_wrapper', array( $this, 'write_header_content' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'writeScripts' ) );
		add_action( 'wp_dashboard_setup', array( $this, 'banner_headboard_widget' ) );
	}

	/**
	 * Write the styles.
	 *
	 * @return void
	 */
	public function write_styles() {
		if ( class_exists( 'ACF' ) ) {
			$short_banner_height    = '1.5rem';
			$right_hand_text_height = '1.6rem';
			$apply_theming          = get_field( 'theme_header_bar' );
			$use_short_banner       = get_field( 'short_banner' );

			if ( $apply_theming ) {
				$css_selector           = get_field( 'banner_selector' );
				$colour                 = get_field( 'banner_foreground_colour' );
				$background_colour      = get_field( 'banner_background_colour' );
				$title_match_background = get_field( 'title_match_background' );

				echo ( '<!-- Injected banner style -->' );
				echo ( '<style id="injected-banner-style">' );
				echo sprintf( '%s .menu a { color:%s !Important; }', esc_html( $css_selector ), esc_html( $colour ) );
				echo sprintf( '%s { color:%s; background-color:%s; ', esc_html( $css_selector ), esc_html( $colour ), esc_html( $background_colour ) );

				if ( $use_short_banner ) {
					echo sprintf( 'height:%s;', esc_html( $short_banner_height ) );
				}

				echo ' }';

				if ( $use_short_banner ) {
					echo sprintf( '%s .site-header-bottom-section-left { height:%s; }', esc_html( $css_selector ), esc_html( $short_banner_height ) );
					echo sprintf( '%s .site-header-bottom-section-right { height:%s; }', esc_html( $css_selector ), esc_html( $short_banner_height ) );
					echo sprintf( '%s { line-height:%s!Important; }', '.bottom-right-area', esc_html( $right_hand_text_height ) );
				}

				if ( $title_match_background ) {
					echo sprintf( '%s { color:%s; }', '.site .page-title h1', esc_html( $background_colour ) );
				}

				echo '</style>';
			}
		}

		wp_enqueue_style(
			'banner_style',
			plugin_dir_url( __FILE__ ) . '/css/header_banner_styles.css',
			array(),
			'v1.0.0.2',
			false
		);
	}

	/**
	 * Write Header Content.
	 *
	 * @return void
	 */
	public function write_header_content() {
		if ( class_exists( 'ACF' ) ) {
			$header_text = get_field( 'header_text' );
			echo sprintf( '<input type="hidden" id="themed-section-text-src-desktop" value="%s" />', esc_html( $header_text ) );

			$header_text = get_field( 'header_text_mobile' );
			$make_link   = get_field( 'make_link' );

			if ( $make_link ) {
				$header_text = '<a class="linked-content" href="tel:' . esc_html( $header_text ) . '">' . esc_html( $header_text ) . '</a>';
			}

			echo sprintf( '<input type="hidden" id="themed-section-text-src-mobile" value="%s" />', esc_html( $header_text ) );

			$bottom_right_text = get_field( 'bottom_right_text' );
			echo sprintf( '<input type="hidden" id="site-header-bottom-section-right" value="%s" />', esc_html( $bottom_right_text ) );
		}
	}

	/**
	 * Write Scripts.
	 *
	 * @return void
	 */
	public function writeScripts() {
		wp_enqueue_script( 'render-script', plugin_dir_url( __FILE__ ) . 'js/write_header.js', array(), null, true );
	}

	/**
	 * Banner headboard widget.
	 *
	 * @return void
	 */
	public function banner_headboard_widget():void {
		global $wp_meta_boxes;
 
		wp_add_dashboard_widget( 'banner_help_widget', 'Themed Header Banner', array( $this, 'banner_dashboard_help' ) );
	}

	/**
	 * Banner dashboard help.
	 *
	 * @return void
	 */
	public function banner_dashboard_help():void {
		$help = file_get_contents( 'banner-help.html', true );
		$help = str_replace( '{plugin_url}',  plugin_dir_url( __FILE__ ), $help );
		echo $help;
	}
}

$banner_header = new BannerHeader();
