<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * The file that defines the core plugin class.
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.logicrays.com/
 * @since      1.1
 * @package    LR_Banner_Image
 * @subpackage LR_Banner_Image/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.1
 * @package    LR_Banner_Image
 * @subpackage LR_Banner_Image/includes
 * @author     Logicrays WP Team <info@logicrays.com>
 */

class LR_Banner_Image {

    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_banner_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_banner_meta' ) );
        add_shortcode( 'BANNER-IMG', array( $this, 'render_banner_shortcode' ) );

        // Enqueue the scripts for the media uploader
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
    }

    /**
     * Enqueue scripts and styles for the admin area.
     */
    public function enqueue_admin_scripts() {
        
        // Register the script for the media uploader
        wp_register_script(
            'lr-banner-image-script',
            plugin_dir_url( dirname( __FILE__ ) ) . 'js/banner-image.js',
            array( 'jquery' ),
            null,
            true
        );

        // Register the style if you have any CSS specific to this plugin
        wp_register_style(
            'lr-banner-image-style',
            plugin_dir_url( dirname( __FILE__ ) ) . 'css/banner-image.css',
            array(),
            null,
            'all'
        );

        // Enqueue the registered script
        wp_enqueue_script('lr-banner-image-script');

        // Enqueue the registered style
        wp_enqueue_style('lr-banner-image-style');

        // Enqueue the media uploader script (this is a WordPress core script)
        wp_enqueue_media();

    }

    /**
     * Add Banner background image meta box to the post and page editors.
     */
    public function add_banner_meta_boxes() {
        add_meta_box(
            'banner-bg',
            __( 'Banner Image', 'lr-banner-image' ),
            array( $this, 'render_banner_meta_box' ),
            array( 'post', 'page' ),
            'side',
            'low'
        );
    }

    /**
     * Render the Banner background image meta box.
     *
     * @param WP_Post $post The post object.
     */
    public function render_banner_meta_box( $post ) {
        wp_nonce_field( 'banner_bg_save', 'banner_bg_nonce' );
        $banner_image = get_post_meta( $post->ID, 'meta-image', true );
        ?>
        <p>
            <img style="max-width:250px;height:auto;" id="meta-image-preview" src="<?php echo esc_url( $banner_image ); ?>" />
            <br/>
            <input type="text" name="meta-image" id="meta-image" class="meta_image" value="<?php echo esc_url( $banner_image ); ?>" />
            <br/>
            <?php //if ( ! $banner_image ) : ?>
            <input type="button" id="meta-image-button" class="button" value="<?php esc_attr_e( 'Choose or Upload an Image', 'lr-banner-image' ); ?>" />
            <?php //endif; ?>
            <br />
            <?php if ( $banner_image ) : ?>
            <a href="#" id="remove-banner-image" style="color: red;"><?php esc_html_e( 'Remove Banner Image', 'lr-banner-image' ); ?></a>
            <?php endif; ?>
        </p>
        <?php
    }

    /**
     * Save the banner background image meta box data.
     *
     * @param int $post_id The post ID.
     */
    public function save_banner_meta( $post_id ) {
        // Check if it's an autosave or a revision.
        if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
            return;
        }

        // Verify the nonce before proceeding.
        if ( ! isset( $_POST['banner_bg_nonce'] ) || ! wp_verify_nonce( $_POST['banner_bg_nonce'], 'banner_bg_save' ) ) {
            return;
        }

        // Sanitize and save the meta image.
        if ( isset( $_POST['meta-image'] ) ) {
            $banner_image = sanitize_text_field( $_POST['meta-image'] );
            update_post_meta( $post_id, 'meta-image', $banner_image );
        }
    }

    /**
     * Render the banner image via shortcode.
     *
     * @return string
    */
    public function render_banner_shortcode() {
        ob_start();
        $banner_image = get_post_meta( get_the_ID(), 'meta-image', true );
        if ( $banner_image ) {
            ?>
            <div class="banner-image">
                <img src="<?php echo esc_url( $banner_image ); ?>" alt="<?php esc_attr_e( 'Banner Image', 'lr-banner-image' ); ?>" />
            </div>
            <?php
        }
        return ob_get_clean();
    }
}

// Initialize the plugin.
new LR_Banner_Image();