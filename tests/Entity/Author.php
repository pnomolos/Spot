<?php
/**
 * Author
 *
 * @package Spot
 */
class Entity_Author extends \Spot\Entity
{
    protected static $_datasource = 'test_authors';

    public static function fields()
    {
        return array(
            'id' => array('type' => 'int', 'primary' => true, 'serial' => true),
            'name' => array('type' => 'string', 'required' => true),
            'email' => array('type' => 'text', 'required' => true),
            'post_id' => array('type' => 'integer', 'required' => true)
        );
    }
}
