<?php
/**
 * @author : Jegtheme
 */
namespace EPIC\Module\Block;

Class Block_1_View extends BlockViewAbstract
{
    public function render_block_type_1($post, $image_size)
    {
        // element
        $thumbnail          = $this->get_thumbnail($post->ID, $image_size);
        $primary_category   = $this->get_primary_category($post->ID);

        $output =
            "<div class=\"jeg_thumb\">
                " . epic_edit_post( $post->ID ) . "
                <a href=\"" . get_the_permalink($post) . "\">" . $thumbnail . "</a>
                <div class=\"jeg_post_category\">
                    <span>{$primary_category}</span>
                </div>
            </div>
            <div class=\"jeg_postblock_content\">
                <h3 property=\"headline\" class=\"jeg_post_title\">
                    <a href=\"" . get_the_permalink($post) . "\">" . get_the_title($post) . "</a>
                </h3>
                " . $this->post_meta_1($post) . "
                <div class=\"jeg_post_excerpt\">
                    <p>" . $this->get_excerpt($post) . "</p>
                    <a href=\"" . get_the_permalink($post) . "\" class=\"jeg_readmore\">" . esc_html__('Read more','epic-ne') . "</a>
                </div>
            </div>";

        return $output;
    }


    public function render_block_type_2($post, $image_size)
    {
        $thumbnail = $this->get_thumbnail($post->ID, $image_size);
        $additional_class = (!has_post_thumbnail($post->ID)) ? ' no_thumbnail' : '';

        $output =
            "<article " . epic_post_class("jeg_post jeg_pl_sm" . $additional_class, $post->ID) . ">
                <div class=\"jeg_thumb\">
                    " . epic_edit_post( $post->ID ) . "
                    <a href=\"" . get_the_permalink($post) . "\">
                        {$thumbnail}
                    </a>
                </div>
                <div class=\"jeg_postblock_content\">
                    <h3 class=\"jeg_post_title\">
                        <a href=\"" . get_the_permalink($post) . "\">" . get_the_title($post) . "</a>
                    </h3>
                    " . $this->post_meta_2($post) . "
                </div>
            </article>";

        return $output;
    }

    public function render_block_type_3($post)
    {
        $output =
            "<article " . epic_post_class("jeg_post jeg_pl_xs_2", $post->ID) . ">
                <div class=\"jeg_postblock_content\">
                    <h3 class=\"jeg_post_title\"><a href=\"" . get_permalink($post) . "\">" . get_the_title($post) . "</a></h3>
                    " . $this->post_meta_2($post) . "
                </div>
            </article>";

        return $output;
    }


    public function build_column_1($results)
    {
        $first_block = $this->render_block_type_1($results[0], 'epic-360x180');

        $second_block = '';
        for($i = 1; $i < sizeof($results); $i++) {
            $second_block .= $this->render_block_type_2($results[$i], 'epic-120x86');
        }

        $output =
            "<div class=\"jeg_posts\">
                <article " . epic_post_class("jeg_post jeg_pl_lg_1", $results[0]->ID) . ">
                    $first_block
                </article>
                <div class=\"jeg_postsmall\">
                    $second_block
                </div>
            </div>";

        return $output;
    }

    public function build_column_1_alt($results)
    {
        $first_block = '';

        for($i = 0; $i < sizeof($results); $i++) {
            $first_block .= $this->render_block_type_2($results[$i], 'epic-120x86');
        }

        $output =
            "<div class=\"jeg_posts\">
                <div class=\"jeg_postsmall\">
                    $first_block
                </div>
            </div>";

        return $output;
    }

    public function build_column_2($results)
    {
        $first_block = $this->render_block_type_1($results[0], 'epic-360x180');

        $second_block = '';
        for($i = 1; $i < sizeof($results); $i++) {
            $second_block .= $this->render_block_type_2($results[$i], 'epic-120x86');
        }

        $output =
            "<div class=\"jeg_posts row\">
                <article " . epic_post_class("jeg_post jeg_pl_lg_1 col-sm-6", $results[0]->ID) . ">
                    $first_block
                </article>
                <div class=\"jeg_postsmall col-sm-6\">
                    $second_block
                </div>
            </div>";

        return $output;
    }

    public function build_column_3($results)
    {
        $first_block = $this->render_block_type_1($results[0], 'epic-360x180');

        $size           = sizeof($results);
        $first_limit    = (int) ceil(( $size - 1 ) * 2 / 5) + 1 ;


        $second_block = '';
        for($i = 1; $i < $first_limit; $i++) {
            $second_block .= $this->render_block_type_2($results[$i], 'epic-120x86');
        }

        $third_block = '';
        for($i = $first_limit; $i < $size; $i++) {
            $third_block .= $this->render_block_type_3($results[$i]);
        }

        $output =
            "<div class=\"jeg_posts row\">
                <article " . epic_post_class("jeg_post jeg_pl_lg_1 col-sm-4", $results[0]->ID) . ">
                    $first_block
                </article>
                <div class=\"jeg_postsmall col-sm-4\">
                    $second_block
                </div>
                <div class=\"jeg_postsmall col-sm-4\">
                    $third_block
                </div>
            </div>";

        return $output;
    }

    public function render_output($attr, $column_class)
    {
	    if ( isset( $attr['results'] ) ) {
		    $results = $attr['results'];
	    } else {
		    $results = $this->build_query($attr);
	    }

	    $navigation = $this->render_navigation($attr, $results['next'], $results['prev'], $results['total_page']);

        if(!empty($results['result'])) {
            $content = $this->render_column($results['result'], $column_class);
        } else {
            $content = $this->empty_content();
        }

        return
            "<div class=\"jeg_block_container jeg_load_more_flag\">
                {$this->get_content_before($attr)}
                {$content}
                {$this->get_content_after($attr)}
            </div>
            <div class=\"jeg_block_navigation\">
                {$this->get_navigation_before($attr)}
                {$navigation}
                {$this->get_navigation_after($attr)}
            </div>";
    }

    public function render_column($result, $column_class)
    {
        switch($column_class)
        {
            case "jeg_col_1o3" :
                $content = $this->build_column_1($result);
                break;
            case "jeg_col_3o3" :
                $content = $this->build_column_3($result);
                break;
            case "jeg_col_2o3" :
            default :
                $content = $this->build_column_2($result);
                break;
        }

        return $content;
    }

    public function render_column_alt($result, $column_class)
    {
        switch($column_class)
        {
            case "jeg_col_1o3" :
                $content = $this->build_column_1_alt($result);
                break;
            case "jeg_col_3o3" :
                $content = $this->build_column_3($result);
                break;
            case "jeg_col_2o3" :
            default :
                $content = $this->build_column_2($result);
                break;
        }

        return $content;
    }
}
