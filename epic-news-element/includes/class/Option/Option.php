<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Option;

use Jeg\Customizer;

Class Option
{
    /**
     * @var Option
     */
    private static $instance;

    /**
     * @return Option
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
        add_action('jeg_register_customizer_option', array($this, 'register_lazy_section'), 91);
        add_filter('jeg_register_lazy_section', array($this, 'load_customizer'));
    }

    public function register_lazy_section()
    {
        $customizer = Customizer\Customizer::get_instance();
        $this->build_module_option( $customizer );
	    $this->build_custom_template_option( $customizer );
    }

    public function build_custom_template_option( $customizer ) {

	    $customizer->add_panel(array(
		    'id' => 'epic_single_post_panel',
		    'title' => esc_html__('EPIC : Custom Template Option', 'epic-ne'),
		    'description' => esc_html__('Jeg ', 'epic-ne'),
		    'priority' => 171
	    ));

	    $customizer->add_section(array(
		    'id'            => 'epic_single_post_template_section',
		    'title'         => esc_html__('Single Post Template', 'epic-ne'),
		    'panel'         => 'epic_single_post_panel',
		    'priority'      => 171,
		    'type'          => 'jeg-lazy-section',
		    'dependency'    => array()
	    ));

	    $customizer->add_section(array(
		    'id'            => 'epic_single_archive_template_section',
		    'title'         => esc_html__('Single Archive Template', 'epic-ne'),
		    'panel'         => 'epic_single_post_panel',
		    'priority'      => 171,
		    'type'          => 'jeg-lazy-section',
		    'dependency'    => array()
	    ));
    }

    public function build_module_option( $customizer ) {

	    $customizer->add_panel(array(
		    'id' => 'epic_module_panel',
		    'title' => esc_html__('EPIC : Module Element Option', 'epic-ne'),
		    'description' => esc_html__('Jeg ', 'epic-ne'),
		    'priority' => 171
	    ));

	    $customizer->add_section(array(
		    'id'            => 'epic_module_image_section',
		    'title'         => esc_html__('Module Image Setting', 'epic-ne'),
		    'panel'         => 'epic_module_panel',
		    'priority'      => 171,
		    'type'          => 'jeg-lazy-section',
		    'dependency'    => array()
	    ));

	    $customizer->add_section(array(
		    'id'            => 'epic_module_loader_section',
		    'title'         => esc_html__('Module Loader', 'epic-ne'),
		    'panel'         => 'epic_module_panel',
		    'priority'      => 171,
		    'type'          => 'jeg-lazy-section',
		    'dependency'    => array()
	    ));

	    $customizer->add_section(array(
		    'id'            => 'epic_module_meta_section',
		    'title'         => esc_html__('Module Meta Option', 'epic-ne'),
		    'panel'         => 'epic_module_panel',
		    'priority'      => 171,
		    'type'          => 'jeg-lazy-section',
		    'dependency'    => array()
	    ));

	    $customizer->add_section(array(
		    'id'            => 'epic_module_custom_post_type_section',
		    'title'         => esc_html__('Module Custom Post Type', 'epic-ne'),
		    'panel'         => 'epic_module_panel',
		    'priority'      => 171,
		    'type'          => 'jeg-lazy-section',
		    'dependency'    => array()
	    ));

	    $customizer->add_section(array(
		    'id'            => 'epic_module_font_section',
		    'title'         => esc_html__('Module Global Font', 'epic-ne'),
		    'panel'         => 'epic_module_panel',
		    'priority'      => 171,
		    'type'          => 'jeg-lazy-section',
		    'dependency'    => array()
	    ));
    }

    public function load_customizer($result)
    {
        $array = [
            'module_image',
            'module_loader',
            'module_meta',
	        'module_font',
	        'module_custom_post_type',
	        'single_post_template',
	        'single_archive_template'
        ];

        $path = EPIC_DIR . "includes/class/Option/sections/";

        foreach($array as $id) {
            $result["epic_{$id}_section"][] = "{$path}{$id}.php";
        }

        return $result;
    }
}
