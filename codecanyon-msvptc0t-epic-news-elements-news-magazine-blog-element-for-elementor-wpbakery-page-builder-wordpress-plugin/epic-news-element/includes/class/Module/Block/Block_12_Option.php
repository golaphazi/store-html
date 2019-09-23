<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Block;

Class Block_12_Option extends BlockOptionAbstract
{
    protected $default_number_post = 4;
    protected $show_excerpt = true;
    protected $show_ads = true;
    protected $default_ajax_post = 4;

    public function get_module_name()
    {
        return esc_html__('EPIC - Module 12', 'epic-ne');
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
