<?php
namespace MetWoo\Core\Builders;
defined( 'ABSPATH' ) || exit;
/**
 * Action Class.
 * for post insert, update and get data.
 *
 * @since 1.0.0
 */
Class Action{

    use \MetWoo\Traits\Singleton;

    public $key_form_settings;
    private $post_type;

    private $fields;
    private $form_id;
    private $form_setting;
    private $title;
    private $response = [];
     /**
     * Public function __construct.
     * call function for all
     *
     * @since 1.0.0
     */
    public function __construct(){
        if( !current_user_can( 'manage_options' ) ){
            return;
        }

        $this->post_type = Base::instance()->form->get_name();
        $this->key_form_settings = 'metwoo_builders__post_meta';
        
        $this->response = [
            'saved' => false,
            'status' => esc_html("Something went wrong.", 'metwoo'),
            'data' => [
                ]
            ];
    }
    /**
     * Public function store.
     * store data for post
     *
     * @since 1.0.0
     */
    public function store( $form_id, $form_setting ){

        $this->fields = $this->get_fields();
        $this->sanitize( $form_setting );
        $this->form_id = $form_id;

        if($this->form_id == 0){
            $this->insert();
        }else{
            $this->update();
        }

        return $this->response;
        
    }
                
    public function insert(){

        $this->title = ($this->form_setting['form_title'] != '') ? $this->form_setting['form_title'] : 'New Template # '.time();

        $defaults = array(
            'post_title' => $this->title,
            'post_status' => 'publish',
            'post_type' => $this->post_type,
        );
        $this->form_id = wp_insert_post( $defaults );
        // save custom meta data
        update_post_meta( $this->form_id, $this->key_form_settings, $this->form_setting );

         //set default meta 
         $default = isset( $this->form_setting['set_defalut'] ) ? $this->form_setting['set_defalut'] : 'No';
         $type = isset( $this->form_setting['form_type'] ) ? $this->form_setting['form_type'] : 'single';
         
         update_post_meta( $this->form_id, $this->key_form_settings.'__type', $type );

        // check optins key value
        $keyType = $this->key_form_settings.'__'.$type;
        if($default == 'Yes'){
            update_option($keyType, $this->form_id);
        }

        // auto elementor canvas style 
        update_post_meta( $this->form_id, '_wp_page_template', 'elementor_canvas' );

        $this->response['saved'] = true;
        $this->response['status'] = esc_html('Template settings inserted','metform');

        /*if((!array_key_exists('store_entries',$this->form_setting)) && (!array_key_exists('enable_user_notification',$this->form_setting)) && (!array_key_exists('enable_admin_notification',$this->form_setting)) && (!array_key_exists('mf_mail_chimp',$this->form_setting)) && (!array_key_exists('mf_slack',$this->form_setting))){
            $this->response['saved'] = false;
            $this->response['status'] = esc_html('You must active at least one field of these fields "store entry/ Confirmation/ Notification/ MailChimp/ Slack". ','metwoo'); 
        }*/
                
        $this->response['data']['id'] = $this->form_id;
        $this->response['data']['title'] = $this->title;
        $this->response['data']['type'] = $this->post_type;

    }

    public function update(){

        $this->title = ($this->form_setting['form_title'] != '') ? $this->form_setting['form_title'] : 'New Template # '.time();

        if( isset( $this->form_setting['form_title'] ) ){
            $update_post = array(
                'ID'           => $this->form_id,
                'post_title'   => $this->title,
            );
            wp_update_post( $update_post );
        }

        // save custom meta data 
        update_post_meta( $this->form_id, $this->key_form_settings, $this->form_setting );

        //set default meta 
        $default = isset( $this->form_setting['set_defalut'] ) ? $this->form_setting['set_defalut'] : 'No';
        $type = isset( $this->form_setting['form_type'] ) ? $this->form_setting['form_type'] : 'single';
       
        update_post_meta( $this->form_id, $this->key_form_settings.'__type', $type );

        // check optins key value
        $keyType = $this->key_form_settings.'__'.$type;

        $getSetDefault = get_option($keyType, 0);
        if($default == 'Yes'){
           update_option($keyType, $this->form_id);
        }else if( $this->form_id == $getSetDefault ){
            update_option($keyType, 0);
        }
      
        //auto elementor canvas style 
        update_post_meta( $this->form_id, '_wp_page_template', 'elementor_canvas' );

        $this->response['saved'] = true;
        $this->response['status'] = esc_html('Template settings updated','metform');

       /* if((!array_key_exists('store_entries',$this->form_setting)) && (!array_key_exists('enable_user_notification',$this->form_setting)) && (!array_key_exists('enable_admin_notification',$this->form_setting)) && (!array_key_exists('mf_mail_chimp',$this->form_setting)) && (!array_key_exists('mf_slack',$this->form_setting))){
            $this->response['saved'] = false;
            $this->response['status'] = esc_html('You must active at least one field of these fields "store entry/ Confirmation/ Notification/ MailChimp/ Slack". ','metform'); 
        }*/

        $this->response['data']['id'] = $this->form_id;
        $this->response['data']['title'] = $this->title;
        $this->response['data']['type'] = $this->post_type;
    
    }
            
    public function get_fields(){

        return [
        
            'form_title' => [ 
                'name' => 'form_title',
            ],
            'form_type' => [ 
                'name' => 'form_type',
            ],
            'set_defalut' => [ 
                'name' => 'set_defalut',
            ],
        ];
    }

    public function sanitize( $form_setting, $fields = null ){
        if( $fields == null ){
            $fields = $this->fields;
        }
        foreach( $form_setting as $key => $value ){

            if( isset( $fields[$key] ) ){
                $this->form_setting[ $key ] = $value;
            }

        }
    }


    public function get_all_data( $post_id ){

        $post = get_post( $post_id );

        $data = get_post_meta( $post->ID, $this->key_form_settings,  true );

        // ceck set default
        $type = isset( $data['form_type'] ) ? $data['form_type'] : 'single'; 
        $keyType = $this->key_form_settings.'__'.$type;
        $getSetDefault = get_option($keyType, 0);

        // return data
        $data['form_title'] = get_the_title($post_id);
        $data['set_defalut'] = 'No'; 
        if($getSetDefault == $post->ID){
            $data['set_defalut'] = 'Yes';
        }
        return $data;   

    }

    
}