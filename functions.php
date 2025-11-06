<?php

/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package entervia
 * @since 1.0.0
 */

/**
 * Enqueue the CSS files.
 *
 * @since 1.0.0
 *
 * @return void
 */
if ( ! function_exists( 'ent_fs' ) ) {
    // Create a helper function for easy SDK access.
    function ent_fs() {
        global $ent_fs;

        if ( ! isset( $ent_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/vendor/freemius/start.php';

            $ent_fs = fs_dynamic_init( array(
                'id'                  => '21627',
                'slug'                => 'entervia',
                'type'                => 'theme',
                'public_key'          => 'pk_a3a23e6b092e9e0e7cab4ca8bf12f',
                'is_premium'          => false,
                'has_addons'          => false,
                'has_paid_plans'      => false,
                'menu'                => array(
                    'support'        => false,
                ),
            ) );
        }

        return $ent_fs;
    }

    // Init Freemius.
    ent_fs();
    // Signal that SDK was initiated.
    do_action( 'ent_fs_loaded' );
}

if (! function_exists('entervia_support')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */

	function entervia_support()
	{

		add_editor_style(get_template_directory_uri() . '/assets/css/editor.css');

		load_theme_textdomain('entervia', get_template_directory() . '/languages');

		// Add support for block styles.
		add_theme_support('wp-block-styles');

		// Add support for post thumbnails
		add_theme_support('post-thumbnails');
	}

endif;
add_action('after_setup_theme', 'entervia_support');

function entervia_styles()
{
	wp_enqueue_style(
		'entervia-style',
		get_stylesheet_uri(),
		[],
		wp_get_theme()->get('Version')
	);

	wp_enqueue_style(
		'entervia-font-awesome',
		get_template_directory_uri() . '/assets/css/font-awesome/css/all.css',
		[],
		wp_get_theme()->get('Version')
	);

	wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'entervia_styles');

// admin style
function entervia_admin_styles()
{
	wp_enqueue_style(
		'entervia-admin-style',
		get_template_directory_uri() . '/assets/css/theme-info.css',
		[],
		wp_get_theme()->get('Version')
	);
}
add_action('admin_enqueue_scripts', 'entervia_admin_styles');

// enqueue dashicons
add_action('enqueue_block_assets', function (): void {
	wp_enqueue_style('dashicons');
	wp_enqueue_script('entervia-main-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), '1.0.0', true);
	wp_enqueue_script('entervia-custom.js', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), '1.0.0', true);
});

function entervia_excerpt_length($length)
{

	$excerpt_length = 20;
	if (is_admin()) return $length;
	return $excerpt_length;
}
add_filter('excerpt_length', 'entervia_excerpt_length');


// add block patterns
require get_template_directory() . '/inc/block-patterns.php';

// tgm-plugin
require get_template_directory() . '/inc/tgm-plugin/tgmpa-hook.php';
/**
 * Register block styles.
 */

if (! function_exists('entervia_block_styles')) :
	/**
	 * Register custom block styles
	 *
	 * @since enterviae
	 * @return void
	 */
	function entervia_block_styles()
	{

		register_block_style(
			'core/paragraph',
			array(
				'name'         => 'admin-icon',
				'label'        => __('Admin Icon', 'entervia'),
				/*
				 * Styles for the custom Arrow icon style of the Details block
				 */
				'inline_style' => '
				.is-style-admin-icon:before {
					content: "\f110";
					font-family: "dashicons";
				}
				.is-style-admin-icon span{
					display: none;
				}',
			)
		);
	}
endif;

add_action('init', 'entervia_block_styles');
