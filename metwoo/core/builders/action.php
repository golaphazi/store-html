<?php
namespace MetWoo\Core\Builders;
defined( 'ABSPATH' ) || exit;

Class Action{

    //use \MetWoo\Traits\Singleton;

    private $key_form_settings;
    private $post_type;

    private $fields;
    private $form_id;
    private $form_setting;
    private $title;
    private $response = [];

    public function __construct(){
        if( !current_user_can( 'manage_options' ) ){
            return;
        }
        
        $this->key_form_settings = 'metwoo_builders__post_meta';
        $this->post_type = Base::instance()->form->get_name();

        $this->response = [
            'saved' => false,
            'status' => esc_html("Something went wrong.", 'metwoo'),
            'data' => [
                ]
            ];
    }

    public function store( $form_id, $form_setting ){

        $this->fields = $this->get_fields();
        $this->sanitize( $form_setting );
        $this->form_id = $form_id;

       // $map_data = \MetWoo\Core\Entries\Action::instance()->get_fields($form_id);
       // $email_name = \MetWoo\Core\Entries\Action::instance()->get_email_name($map_data);

        if($this->form_id == 0){
            $this->insert();
        }else{
            $this->update();
        }

        return $this->response;
        
    }
                
    public function insert(){

        $this->title = ($this->form_setting['form_title'] != '') ? $this->form_setting['form_title'] : 'New Form # '.time();

        $defaults = array(
            'post_title' => $this->title,
            'post_status' => 'publish',
            'post_type' => $this->post_type,
        );
        $this->form_id = wp_insert_post( $defaults );

        update_post_meta( $this->form_id, $this->key_form_settings, $this->form_setting );
        //update_post_meta( $this->form_id, '_wp_page_template', 'elementor_canvas' );

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

        update_post_meta( $this->form_id, $this->key_form_settings, $this->form_setting );
        update_post_meta( $this->form_id, '_wp_page_template', 'elementor_canvas' );

        $this->response['saved'] = true;
        $this->response['status'] = esc_html('Form settings updated','metform');

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
            'success_message' => [ 
                'name' => 'success_message',
            ],
            'store_entries' => [ 
                'name' => 'store_entries',
            ], 
            'hide_form_after_submission' => [
                'name' => 'hide_form_after_submission',
            ],
            'redirect_to' => [
                'name' => 'redirect_to',
            ],
            'require_login' => [
                'name' => 'require_login',
            ],
            'limit_total_entries_status' => [
                'name' => 'limit_total_entries_status',
            ],
            'limit_total_entries' => [
                'name' => 'limit_total_entries',
            ],
            'multiple_submission' => [
                'name' => 'multiple_submission',
            ],
            'enable_recaptcha' => [
                'name' => 'enable_recaptcha',
            ],
            'capture_user_browser_data' => [
                'name' => 'capture_user_browser_data',
            ],
            'enable_user_notification' => [
                'name' => 'enable_user_notification',
            ],
            'user_email_subject' => [
                'name' => 'user_email_subject',
            ],
            'user_email_from' => [
                'name' => 'user_email_from',
            ],
            'user_email_reply_to' => [
                'name' => 'user_email_reply_to',
            ],
            'user_email_body' => [
                'name' => 'user_email_body',
            ],
            'user_email_attach_submission_copy' => [
                'name' => 'user_email_attach_submission_copy',
            ],
            'enable_admin_notification' => [
                'name' => 'enable_admin_notification',
            ],
            'admin_email_subject' => [
                'name' => 'admin_email_subject',
            ],
            'admin_email_from' => [
                'name' => 'admin_email_from',
            ],
            'admin_email_to' => [
                'name' => 'admin_email_to',
            ],
            'admin_email_reply_to' => [
                'name' => 'admin_email_reply_to',
            ],
            'admin_email_body' => [
                'name' => 'admin_email_body',
            ],
            'admin_email_attach_submission_copy' => [
                'name' => 'admin_email_attach_submission_copy',
            ],
            'mf_mail_chimp' => [
                'name' => 'mf_mail_chimp',
            ],
            'mf_mailchimp_api_key' => [
                'name' => 'mf_mailchimp_api_key',
            ],
            'mf_mailchimp_list_id' => [
                'name' => 'mf_mailchimp_list_id',
            ],
            'mf_zapier' => [
                'name' => 'mf_zapier',
            ],
            'mf_zapier_webhook' => [
                'name' => 'mf_zapier_webhook',
            ],
            'mf_slack' => [
                'name' => 'mf_slack',
            ],
            'mf_slack_webhook' => [
                'name' => 'mf_slack_webhook',
            ],
            'mf_recaptcha' => [
                'name' => 'mf_recaptcha',
            ],
            'mf_recaptcha_site_key' => [
                'name' => 'mf_recaptcha_site_key',
            ],
            'mf_recaptcha_secret_key' => [
                'name' => 'mf_recaptcha_secret_key',
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

        $data['form_title'] = get_the_title($post_id);

        return $data;   

    }

    
}