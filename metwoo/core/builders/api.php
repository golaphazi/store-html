<?php
namespace MetWoo\Core\Builders;
defined( 'ABSPATH' ) || exit;

Class Api extends \MetWoo\Base\Api{

    public function config(){
        $this->prefix = 'template';
        $this->param  = "/(?P<id>\d+)";
    }

    public function post_update(){
        $form_id = $this->request['id'];

        $form_setting = $this->request->get_params();

        return Action::instance()->store($form_id, $form_setting);
    }

    public function get_get(){
        $post_id = $this->request['id'];

        return Action::instance()->get_all_data($post_id);
    }

}