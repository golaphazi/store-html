<?php
/**
 * @author : Jegtheme
 */
namespace EPIC;

use EPIC\Module\ModuleManager;


/**
 * Class Frontend Ajax
 */
Class FrontendAjax
{
    /**
     * @var FrontendAjax
     */
    private static $instance;

    private $endpoint = 'epic-ajax-request';

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
        add_action( 'wp_head',              array( $this, 'frontend_ajax_script' ), 1 );

        add_action( 'parse_request',        array( $this, 'ajax_parse_request' ) );
        add_filter( 'query_vars',           array( $this, 'ajax_query_vars' ) );
    }

    public function ajax_query_vars( $vars )
    {
        $vars[] = $this->endpoint;
        $vars[] = 'action';
        return $vars;
    }

    public function is_doing_ajax()
    {
        return true;
    }

    public function ajax_parse_request( $wp )
    {
        if ( array_key_exists( $this->endpoint, $wp->query_vars ) )
        {
            // need to flag this request is ajax request
            add_filter('wp_doing_ajax', array($this, 'is_doing_ajax'));

            $action = $wp->query_vars['action'];

            // Module Ajax
            $module_prefix = ModuleManager::$module_ajax_prefix;
            if(0 === strpos($action, $module_prefix))
            {
                $module_name = str_replace($module_prefix, '', $action);
                ModuleManager::getInstance()->module_ajax($module_name);
            }

            do_action( 'epic_ajax_' . $action );
            exit;
        }
    }

    public function ajax_url()
    {
        return add_query_arg( array( $this->endpoint => 'epic-ne' ), home_url('/') );
    }

    public function frontend_ajax_script()
    {
        if(!is_admin())
        {
            ?>
            <script type="text/javascript"> var epic_ajax_url = '<?php echo esc_url( $this->ajax_url() ); ?>'; </script>
            <?php
        }
    }
}
