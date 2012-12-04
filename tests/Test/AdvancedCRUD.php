<?php
/**
 * @package Spot
 * @link http://spot.os.ly
 */
class Test_AdvancedCRUD extends PHPUnit_Framework_TestCase
{
    protected $backupGlobals = false;

    public static function setupBeforeClass()
    {
        $mapper = test_spot_mapper();
        $mapper->migrate('Entity_Post');
        $mapper->migrate('Entity_Post_Comment');
        $mapper->migrate('Entity_Author');
    }
    public function setUp()
    {
        $mapper = test_spot_mapper();
        $mapper->truncateDatasource('Entity_Post');
        $mapper->truncateDatasource('Entity_Post_Comment');
        $mapper->truncateDatasource('Entity_Author');
    }

    public function testNestedSaveHasOne()
    {
        $mapper = test_spot_mapper();
        $data = array(
            'title' => 'Test Post',
            'body' => 'Test Body',
            'author' => array(
                'name' => 'Testy Author',
                'email' => 'test@author.com'
            )
        );
        
        $post_id = $mapper->saveNested('Entity_Post', $data);
        $this->assertTrue(false !== $post_id);
        
        $author = $mapper->first('Entity_Author', array('post_id' => $post_id));
        $this->assertInstanceOf('Entity_Author', $author);
    }


    public function testNestedSaveHasOneErrors()
    {
        $mapper = test_spot_mapper();
        $data = array(
            'title' => 'Test Post',
            'body' => 'Test Body',
            'author' => array(
                'name' => 'Testy Author',
            )
        );
        
        $post_id = $mapper->saveNested('Entity_Post', $data);
        $this->assertFalse($post_id);
        
        $this->assertSame(0, $mapper->all('Entity_Post')->count());
    }


    public function testNestedSaveHasMany()
    {
        $mapper = test_spot_mapper();
        $data = array(
            'title' => 'Test Post',
            'body' => 'Test Body',
            'comments' => array(
                array(
                    'name' => 'Test 1',
                    'email' => 'test1@test.com',
                    'body' => 'Comment 1'
                ),
                array(
                    'name' => 'Test 2',
                    'email' => 'test2@test.com',
                    'body' => 'Comment 2'
                )
            )
        );
        
        $post_id = $mapper->saveNested('Entity_Post', $data);
        $this->assertTrue(false !== $post_id);
        
        $comments = $mapper->all('Entity_Post_Comment', array('post_id' => $post_id));
        $this->assertSame(2, $comments->count());
    }


    public function testNestedSaveHasManyErrors()
    {
        $mapper = test_spot_mapper();
        $data = array(
            'title' => 'Test Post',
            'body' => 'Test Body',
            'comments' => array(
                array(
                    'name' => 'Test 1',
                    'email' => 'test1@test.com',
                    'body' => 'Comment 1'
                ),
                array(
                    'name' => 'Test 2',
                    'email' => 'test2@test.com',
                )
            )
        );
        
        $post_id = $mapper->saveNested('Entity_Post', $data);
        $this->assertFalse(false);
        
        // Make sure the base object wasn't saved
        $this->assertSame(0, $mapper->all('Entity_Post')->count());
        
        // Make sure no comments were actually saved
        $comments = $mapper->all('Entity_Post_Comment');
        $this->assertSame(0, $comments->count());
    }
}