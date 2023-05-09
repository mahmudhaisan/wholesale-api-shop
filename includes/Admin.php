<?php
namespace WHOLESALE\Includes;

class Admin
{

    /**
     * Construct Function
     */
    public function __construct()
    {
        add_action('admin_menu', [$this, 'admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'register_scripts_styles']);
    }

    public function register_scripts_styles()
    {

        $this->load_scripts();
        $this->load_styles();
    }

    /**
     * Load Scripts
     *
     * @return void
     */
    public function load_scripts()
    {
        wp_register_script('wlsale-manifest', WHOLESALE_PLUGIN_URL . 'assets/js/manifest.js', [], 1, true);
        wp_register_script('wlsale-vendor', WHOLESALE_PLUGIN_URL . 'assets/js/vendor.js', ['wlsale-manifest'], 1, true);
        wp_register_script('wlsale-admin', WHOLESALE_PLUGIN_URL . 'assets/js/admin.js', ['wlsale-vendor'], 1, true);

        wp_enqueue_script('wlsale-manifest');
        wp_enqueue_script('wlsale-vendor');
        wp_enqueue_script('wlsale-admin');

        wp_localize_script('wlsale-admin', 'WholeSaleAdminLocalizer', [
            'adminUrl' => admin_url('/'),
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'apiUrl' => home_url('/wp-json'),
        ]);
    }

    public function load_styles()
    {
        wp_register_style('wlsale-admin', WHOLESALE_PLUGIN_URL . 'assets/css/admin.css');

        wp_enqueue_style('wlsale-admin');
    }

    /**
     * Register Menu Page
     * @since 1.0.0
     */
    public function admin_menu()
    {
        global $submenu;

        $capability = 'manage_options';
        $slug = 'restaurant-management-solution';

        $hook = add_menu_page(
            __('Resturant Management Solution', 'textdomain'),
            __('Resturant Management Solution', 'textdomain'),
            $capability,
            $slug,
            [$this, 'menu_page_template'],
            'dashicons-buddicons-replies'
        );

        if (current_user_can($capability)) {
            $submenu[$slug][] = [__('Dashboard', 'textdomain'), $capability, 'admin.php?page=' . $slug . '#/'];
            $submenu[$slug][] = [__('Settings', 'textdomain'), $capability, 'admin.php?page=' . $slug . '#/settings'];
        }

        // add_action( 'load-' . $hook, [ $this, 'init_hooks' ] );
    }

    /**
     * Init Hooks for Admin Pages
     * @since 1.0.0
     */
    public function init_hooks()
    {
        add_action('admin_enqueu_scripts', [$this, 'enqueue_scripts']);
    }

    /**
     * Load Necessary Scripts & Styles
     * @since 1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_style('wlsale-admin');
        wp_enqueue_script('wlsale-admin');
    }

    /**
     * Render Admin Page
     * @since 1.0.0
     */
    public function menu_page_template()
    {
        echo '<div class="wrap"><div id="app"></div></div>';
    }

}
