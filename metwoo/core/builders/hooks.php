<?php
namespace MetWoo\Core\Builders;
defined( 'ABSPATH' ) || exit;
Class Hooks{

  use \MetWoo\Traits\Singleton;

  public $cpt;
  public $action;
  public $base;

  public $actionPost_type = ['product']; // only for woocommerce product

  public function Init(){
    $this->cpt = new Cpt();
    $this->action = new Action();
    $this->base = new Base();

    // check admin init
    add_action( 'admin_init', [ $this, 'add_author_support' ], 10 );
    add_filter( 'manage_'.$this->cpt->get_name().'_posts_columns', [ $this, 'set_columns' ] );
    add_action( 'manage_'.$this->cpt->get_name().'_posts_custom_column', [ $this, 'render_column' ], 10, 2 );
    
    // add filter for search
    add_action( 'restrict_manage_posts', [ $this, 'add_filter'] );
    // query filter
    add_filter( 'parse_query', [ $this, 'query_filter' ] );

    // add meta box for template
    add_action( 'add_meta_boxes', [ $this, 'template_selected' ] );

    // save meta box data
    add_action( 'save_post', array( $this, 'template_save' ), 1, 2  );
  }

/**
   * Public function add_author_support.
   * check author support
   *
   * @since 1.0.0
   */
  public function add_author_support(){
    add_post_type_support( $this->cpt->get_name(), 'author' );
  }
 /**
   * Public function set_columns.
   * set column for custom post type
   *
   * @since 1.0.0
   */
  public function set_columns( $columns ) {

    $date_column = $columns['date'];
    $author_column = $columns['author'];

    unset( $columns['date'] );
    unset( $columns['author'] );
    
    $columns['type'] = esc_html__( 'Type', 'metwoo' );
    $columns['set_default'] = esc_html__( 'Default', 'metwoo' );
    $columns['author']      = esc_html( $author_column );
    $columns['date']      = esc_html( $date_column );

    return $columns;
  }

  /**
   * Public function render_column.
   *  Render column for custom post type
   *
   * @since 1.0.0
   */
  public function render_column( $column, $post_id ) {
    $data = get_post_meta(  $post_id,  $this->action->key_form_settings,  true );
    switch ( $column ) {
      case 'type':
        $type = isset($data['form_type']) ? $data['form_type'] : '';
        $allType = $this->base->template_type;
        echo isset( $allType[$type] ) ? $allType[$type] : '';
      break;

      case 'set_default':
        $type = isset($data['form_type']) ? $data['form_type'] : '';  
        $keyType = $this->action->key_form_settings.'__'.$type;
        $getSetDefault = get_option($keyType, 0);
        if( $getSetDefault == $post_id ){
          echo '<span class="metWoo-defult met-active"> '. __('Active', 'metwoo') .' </span>';
        }else{
          echo '<span class="metWoo-defult  met-deactive"> '. __('DeActive', 'metwoo') .' </span>';
        }
      break;
     
    }
  }
  /**
   * Public function query_filter.
   * Search query filter added in search query
   *
   * @since 1.0.0
   */
  public function  query_filter( $query ) {
      global $pagenow;
      $current_page = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';

      if ( 
          is_admin() 
          && 'metwoo-form' == $current_page 
          && 'edit.php' == $pagenow   
          && isset( $_GET['type'] ) 
          && $_GET['type'] != ''
          && $_GET['type'] != 'all'
      ){
          $type = isset($_GET['type']) ? $_GET['type'] : '';
          $query->query_vars['meta_key'] = $this->action->key_form_settings.'__type';
          $query->query_vars['meta_value'] = $type;
          $query->query_vars['meta_compare'] = '=';
      }
  }

  /**
   * Public function add_filter.
   * Added search filter for type of template
   *
   * @since 1.0.0
   */
  public function add_filter(){
      global $typenow;
      global $wp_query;
      if ( $typenow == $this->cpt->get_name() ) { 
          $current_plugin = '';
          if( isset( $_GET['type'] ) ) {
            $current_plugin = $_GET['type']; 
          } 
        ?>
        <select name="type" id="type">
          <option value="all" <?php selected( 'all', $current_plugin ); ?>><?php _e( 'Template Type ', 'metwoo' ); ?></option>
          <?php 
            if( is_array($this->base->template_type) && sizeof($this->base->template_type) > 0 ):
            foreach( $this->base->template_type as $key=>$value ) { ?>
            <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $current_plugin ); ?>><?php echo esc_attr( $value ); ?></option>
          <?php }
          endif;
          ?>
        </select>
        <?php
      }
  }

  /**
   * Public function template_selected.
   * add meta box for choose template MetWoo
   *
   * @since 1.0.0
   */
  public function template_selected(){
    global $post;
		if(  in_array($post->post_type, $this->actionPost_type) ): 
      foreach($this->actionPost_type as $k=>$v):
        add_meta_box(
            'metwoo_template',
            esc_html__('MetWoo Template', 'metwoo'),
            [$this, 'metwoo_template'],
            $v,
            'side',
            'low'
          );
      endforeach;
		endif;
  }
 /**
   * Public function template_save.
   * MetWoo Template save for product 
   *
   * @since 1.0.0
   */
  public function template_save( $post_id, $post ){
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
    }

    if(  in_array($post->post_type, $this->actionPost_type) ):
      if( isset( $_POST['metWoo-template'] ) ){
          update_post_meta( $post_id,  $this->action->key_form_settings.'__template', sanitize_text_field($_POST['metWoo-template']) );
      }
    endif;
  }

   /**
   * Public function metwoo_template.
   * MetWoo Template Html
   *
   * @since 1.0.0
   */
  public function metwoo_template(){
    global $post;

    if(!isset($post->ID) ){
      return '';
    }
    $page_template = get_post_meta(  $post->ID,  $this->action->key_form_settings.'__template',  true );

    $template = $this->get_post_single();
    echo '<select name="metWoo-template">';
    echo '<option value="0"> '.__('Defalut', 'metwoo').' </option>';
    if( is_array($template) && sizeof($template) > 0){
        foreach($template as $k=>$v){
            $select = '';
            if( $page_template == $k){
              $select = 'selected';
            }
          echo '<option value="'.$k.'" '.$select.'> '.__($v, 'metwoo').' </option>';
        }
    }
    echo '</select>';
  }

  // get query post query
  public function get_post_single(){
       
    $args['post_status'] = 	'publish';
    $args['post_type'] = $this->cpt->get_name();
    $args['meta_query'] = [
        'relation' => 'AND',
        array(
            'key' => $this->action->key_form_settings.'__type',
            'value' => 'single',
            'compare' => '='
        ),
    ];

    $posts = get_posts($args);    
    $options = [];
    $count = count($posts);
    if($count > 0):
        foreach ($posts as $post) {
            $options[$post->ID] = $post->post_title;
        }
    endif;  

    return $options;
}

}