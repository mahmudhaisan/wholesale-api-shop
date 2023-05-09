<?php
namespace WHOLESALE\Includes;

class Frontend
{

    public function __construct()
    {
        add_shortcode('wlsale-app', [$this, 'render_frontend']);
        add_action('wp_enqueue_scripts', [$this, 'register_frontend_scripts_styles']);
    }

    public function register_frontend_scripts_styles()
    {
        $this->load_scripts();
        $this->load_styles();
    }

    public function load_scripts()
    {
        wp_register_script('wlsale-manifest', WHOLESALE_PLUGIN_URL . 'assets/js/manifest.js', [], 1, true);
        wp_register_script('wlsale-vendor', WHOLESALE_PLUGIN_URL . 'assets/js/vendor.js', ['wlsale-manifest'], 1, true);
        wp_register_script('wlsale-frontend', WHOLESALE_PLUGIN_URL . 'assets/js/frontend.js', ['wlsale-vendor'], 1, true);

        wp_enqueue_script('wlsale-manifest');
        wp_enqueue_script('wlsale-vendor');
        wp_enqueue_script('wlsale-frontend');

    }

    public function load_styles()
    {
        wp_register_style('wlsale-admin', WHOLESALE_PLUGIN_URL . 'assets/css/admin.css');
        wp_register_style('wlsale-frontend', WHOLESALE_PLUGIN_URL . 'assets/css/frontend.css');

        wp_enqueue_style('wlsale-admin');
    }

    /**
     * Render Frontend
     * @since 1.0.0
     */
    public function render_frontend($atts, $content = '')
    {
        wp_enqueue_style('wlsale-frontend');
        wp_enqueue_script('wlsale-frontend');

        $content .= '<div id="wlsale-frontend-app">frontend</div>';

        return $content;
    }

}
