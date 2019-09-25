<?php
namespace MetWoo\Core\Builders;
defined( 'ABSPATH' ) || exit;

Class Base extends \MetWoo\Base\Common{

    use \MetWoo\Traits\Singleton;

   // $api veriable call for Cpt Class Instance 
    public $form;

    // $api veriable call for Api Class Instance 
    public $api;

    // set template type for template
    public $template_type = ['single' => 'Single', 'shop' => 'Shop', 'cart' => 'Cart', 'archive' => 'Archive', 'checkout' => 'Checkout', 'order' => 'Order / Thank you', 'my_account' => 'My Account', 'login' => 'Login / Register'];

    public function get_dir(){
        return dirname(__FILE__);
    }

    public function __construct(){

    }
    
    public function init(){
        // call custom post type
        $this->form = new Cpt();
        // call APi
        $this->api = new Api();

        // call hoook
        Hooks::instance()->Init();
        // Single Page
        App\Single::instance()->Init();
        // Cart Page
        App\Cart::instance()->Init();
        // checkout Page
        App\Checkout::instance()->Init();
        // Account Page
        App\Account::instance()->Init();
        // load admin footer
        add_action('admin_footer', [$this, 'modal_view']);  
    }

    public function modal_view(){
        
        $screen = get_current_screen();
        
        $form_prefix = 'metwoo';

        if($screen->id == 'edit-'.$this->form->get_name() || $screen->id == 'metwoo_page_mt-form-settings'){
            include_once $this->get_dir(). '/views/modal-editor.php';
        }
    }
}