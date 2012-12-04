<?php
/**
 * Post Widget
 *
 * @package Spot
 */
class Entity_Post_Widget extends \Spot\Entity
{
    protected static $_datasource = 'test_widgets';

    public static function fields()
    {
        return array(
            'id' => array('type' => 'int', 'primary' => true, 'serial' => true),
            'name' => array('type' => 'string', 'required' => true)
        );
    }
}
