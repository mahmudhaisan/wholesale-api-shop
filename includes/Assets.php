<?php
namespace WHOLESALE\Includes;

class Assets
{

    public function __construct()
    {
        if (is_admin()) {
            add_action('admin_enqueue_scripts', [$this, 'register'], 5);
        } else {
            add_action('wp_enqueue_scripts', [$this, 'register'], 5);
        }
    }

    /**
     * Regsiter Scripts & Styles
     * @since 1.0.0
     */
    public function register()
    {
        $this->register_scripts($this->get_scripts());
        $this->register_styles($this->get_styles());
    }

    /**
     * Register Scritps
     * @since 1.0.0
     */
    public function register_scripts($scripts)
    {
        foreach ($scripts as $handle => $script) {
            $deps = isset($script['deps']) ? $script['deps'] : false;
            $in_footer = isset($script['in_footer']) ? $script['in_footer'] : false;
            $version = isset($script['version']) ? $script['version'] : WHOLESALE_VERSION;

            wp_register_script($handle, $script['src'], $deps, $version, $in_footer);
        }
    }

    /**
     * Regsiter Styles
     * @since 1.0.0
     */
    public function register_styles($styles)
    {
        foreach ($styles as $handle => $style) {
            $deps = isset($style['deps']) ? $style['deps'] : false;

            wp_register_style($handle, $style['src'], $deps, WHOLESALE_VERSION);
        }
    }

    /**
     * Get All Registered Scripts
     * @since 1.0.0
     */
    public function get_scripts()
    {
        $prefix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '.min' : '';

        $scripts = [
            'wlsale-manifest' => [
                'src' => WHOLESALE_PLUGIN_URL . '/assets/js/manifest.js',
                'deps' => [],
                'version' => \filemtime (WHOLESALE_PLUGIN_PATH . '/assets/js/manifest.js'),
                'in_footer' => true,
            ],
            'wlsale-vendor' => [
                'src' => WHOLESALE_PLUGIN_URL . '/assets/js/vendor.js',
                'deps' => ['wlsale-manifest'],
                'version' => \filemtime (WHOLESALE_PLUGIN_PATH . '/assets/js/vendor.js'),
                'in_footer' => true,
            ],
            'wlsale-admin' => [
                'src' => WHOLESALE_PLUGIN_URL . '/assets/js/admin.js',
                'deps' => ['wlsale-vender'],
                'version' => \filemtime (WHOLESALE_PLUGIN_PATH . '/assets/js/admin.js'),
                'in_footer' => true,
            ],
            'wlsale-frontend' => [
                'src' => WHOLESALE_PLUGIN_URL . '/assets/js/frontend.js',
                'deps' => ['jquery', 'wlsale-vender'],
                'version' => \filemtime (WHOLESALE_PLUGIN_PATH . '/assets/js/frontend.js'),
                'in_footer' => true,
            ],
        ];

        return $scripts;
    }

    /**
     * Get All Register Styles
     * @since 1.0.0
     */
    public function get_styles()
    {
        $styles = [
            'wlsale-style' => [
                'src' => WHOLESALE_PLUGIN_URL . '/assets/css/style.css',
            ],
            'wlsale-admin' => [
                'src' => WHOLESALE_PLUGIN_URL . '/assets/css/admin.css',
            ],
            'wlsale-frontend' => [
                'src' => WHOLESALE_PLUGIN_URL . '/assets/css/frontend.css',
            ],
        ];

        return $styles;
    }

}
