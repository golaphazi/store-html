<?php
/**
 * @author : Jegtheme
 */
namespace EPIC;

use EPIC\Module\ModuleManager;

/**
 * Class Frontend Ajax
 */
Class Asset
{
    /**
     * @var FrontendAjax
     */
    private static $instance;
    /**
     * @return FrontendAjax
     */
    public static function getInstance()
    {
        if (null === static::$instance)
        {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * FrontendAjax constructor.
     */
    private function __construct()
    {
        add_action( 'admin_enqueue_scripts', array($this, 'admin_script'), 99);
        add_action( 'wp_enqueue_scripts', array($this, 'load_style'), 98);
        add_action( 'wp_enqueue_scripts', array($this, 'load_script'), 98);

        add_action( 'admin_enqueue_scripts', array($this, 'vc_backend_script'), 99);
        add_action( 'wp_enqueue_scripts', array($this, 'vc_frontend_script'), 99);
    }

    public function is_login_page()
    {
        return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
    }

    public function vc_frontend_script()
    {
        if (function_exists('vc_is_page_editable') && vc_is_page_editable())
        {
            $js_url = EPIC_URL . '/assets/js/';

            wp_enqueue_script('epic-vc-page-iframe', $js_url . 'vc/epic.vc.page.iframe.js', null, null, true);
            wp_enqueue_script('epic-vc-inline', $js_url . 'vc/epic.vc.inline.js', null, null, true);
        }
    }

    public function vc_backend_script()
    {
        if(function_exists('vc_is_frontend_editor') && vc_is_frontend_editor())
        {
            $js_url = EPIC_URL . '/assets/js/';

            wp_enqueue_script('epic-vc-frontend', $js_url . 'vc/epic.vc.frontend.js', array('jquery'), null, true);
            wp_localize_script('epic-vc-frontend', 'modules', ModuleManager::getInstance()->populate_module());
        }
    }

    public function admin_script()
    {
        wp_enqueue_style( 'wp-color-picker' );

        $css_url = EPIC_URL . '/assets/css/';
        wp_enqueue_style( 'epic-admin', $css_url . 'admin/admin-style.css' );

        $font_url = EPIC_URL . '/assets/fonts/';
        wp_enqueue_style( 'font-awesome', $font_url . 'font-awesome/font-awesome.css' );

        $js_url = EPIC_URL . '/assets/js/';
	    wp_enqueue_script( 'bootstrap',                     $js_url . 'admin/bootstrap.min.js', array( 'jquery' ), null );
	    wp_enqueue_script( 'bootstrap-iconpicker-iconset',  $js_url . 'admin/bootstrap-iconpicker-iconset-all.min.js', array( 'jquery' ), null);
	    wp_enqueue_script( 'bootstrap-iconpicker',          $js_url . 'admin/bootstrap-iconpicker.min.js', array( 'jquery' ), null);
    }

    public function load_style()
    {
        if(!$this->is_login_page())
        {
            $css_url = EPIC_URL . '/assets/css/';
            $font_url = EPIC_URL . '/assets/fonts/';

            // font
            wp_enqueue_style('epic-icon', $font_url . 'jegicon/jegicon.css');
            wp_enqueue_style('font-awesome', $font_url . 'font-awesome/font-awesome.min.css');

            // Style
            wp_enqueue_style('epic-style', $css_url . 'style.min.css');
        }
    }

    public function load_script()
    {
        if(!$this->is_login_page())
        {
            $js_url = EPIC_URL . '/assets/js/';

            wp_enqueue_script( 'wp-mediaelement' );
            wp_enqueue_script( 'imagesloaded' );

            wp_enqueue_script('epic-script', $js_url . 'script.min.js', null, null, true);
            wp_localize_script('epic-script', 'epicoption', $this->localize_script());
        }
    }

    public function localize_script()
    {
        $option['prefix'] = ModuleManager::$module_ajax_prefix;
        $option['rtl'] = is_rtl() ? 1 : 0;

        if(is_admin_bar_showing())
        {
            if(function_exists('vc_is_page_editable') && vc_is_page_editable())
            {
                $option['admin_bar'] = 0;
            } else {
                $option['admin_bar'] = 1;
            }
        } else {
            $option['admin_bar'] = 0;
        }

        return $option;
    }
}
