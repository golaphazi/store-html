<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Block;

Class Block_30_Option extends BlockOptionAbstract
{
    protected $default_number_post = 1;
    protected $show_excerpt = true;
    protected $default_ajax_post = 1;

    public function compatible_column()
    {
        return array( 6 );
    }

    public function get_module_name()
    {
        return esc_html__('EPIC - Module 30', 'epic-ne');
    }

    public function additional_style()
    {
        parent::additional_style();

        $this->options[] = array(
            'type'          => 'colorpicker',
            'param_name'    => 'block_background',
            'group'         => esc_html__('Design', 'epic-ne'),
            'heading'       => esc_html__('Block Background', 'epic-ne'),
            'description'   => esc_html__('This option will change your Block Background', 'epic-ne'),
        );
    }
}
