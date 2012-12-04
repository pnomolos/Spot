<?php
/**
 * Post to Widget
 *
 * @package Spot
 */
class Entity_Post_PostsWidgets extends \Spot\Entity
{
    protected static $_datasource = 'test_posts_widgets';

    public static function fields()
    {
        return array(
            'id' => array('type' => 'int', 'primary' => true, 'serial' => true),
            'post_id' => array('type' => 'int'),
            'post_widget_id' => array('type' => 'int'),
        );
    }
}
