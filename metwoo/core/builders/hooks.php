<?php
namespace MetWoo\Core\Builders;
defined( 'ABSPATH' ) || exit;
Class Hooks{

  use \MetWoo\Traits\Singleton;

  public $cpt;

  public function Init(){
    $this->cpt = new Cpt();
    
    add_action( 'admin_init', [ $this, 'add_author_support' ], 10 );
    add_filter( 'manage_'.$this->cpt->get_name().'_posts_columns', [ $this, 'set_columns' ] );
    add_action( 'manage_'.$this->cpt->get_name().'_posts_custom_column', [ $this, 'render_column' ], 10, 2 );
  }


  public function add_author_support(){
    add_post_type_support( $this->cpt->get_name(), 'author' );
  }

  public function set_columns( $columns ) {

    $date_column = $columns['date'];
    $author_column = $columns['author'];

    unset( $columns['date'] );
    unset( $columns['author'] );

    $columns['type'] = esc_html__( 'Type', 'metwoo' );
    $columns['author']      = esc_html( $author_column );
    $columns['date']      = esc_html( $date_column );

    return $columns;
  }

  public function render_column( $column, $post_id ) {
    switch ( $column ) {
      case 'type':
        echo 'Sigle';
        break;
     
    }
  }
  
}