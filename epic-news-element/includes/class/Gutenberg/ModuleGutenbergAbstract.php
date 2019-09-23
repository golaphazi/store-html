<?php
/**
 * @author : Jegtheme
 */

namespace EPIC\Gutenberg;

abstract Class ModuleGutenbergAbstract
{
	private $class;

	public function __construct()
	{
		$this->class = get_class($this);
	}

	public function render( $attributes )
	{
		$args       = array();
		$name       = epic_get_view_class_from_shortcode( $this->class );
		$instance   = epic_get_module_instance($name);

		foreach ( $this->attribute() as $key => $value )
		{
			if ($key === 'compatible_column_notice') continue;

			if ($key === 'className')
			{
				$args['el_class'] = $attributes[$key];
			} else {
				$args[$key] = $attributes[$key];
			}
		}

		return $this->build_module($instance, $args);
	}

	public function attribute()
	{
		$options    = array();
		$name       = epic_get_option_class_from_shortcode( $this->class );
		$instance   = epic_get_module_instance($name);

		foreach ( $instance->get_options() as $option )
		{
			$type = ( in_array( $option['type'], array('slider', 'number', 'attach_image') ) ) ? 'number' : 'string';

			$options[$option['param_name']] = array(
				'type'      => $type,
				'default'   => isset( $option['std'] ) && $option['std'] ? $option['std'] : ''
			);

			if ( $option['type'] === 'attach_image' )
			{
				$options[$option['param_name'] . '_url'] = array(
					'type' => 'string'
				);
			}
		}

		return $options;
	}

	public function build_module( $instance, $args )
	{
		return $instance->build_module($args);
	}
}
