<?php
use Toiee\haik\Themes\LayoutDataInterface;

class LayoutDataTest extends TestCase {
    
    public function testFacade()
    {
        $data = Theme::getAll();
        $this->assertInternalType('array', $data);
    }
    
    public function testHasKeyExists()
    {
        Theme::set('key_exists', 'value');
        $result = Theme::has('key_exists');
        $this->assertTrue($result);
    }
    
    public function testHasKeyNotExists()
    {
        Theme::delete('key_not_exists');
        $result = Theme::has('key_not_exists');
        $this->assertFalse($result);
    }
    
    public function testGet()
    {
        Theme::set('key', 'value');
        $result = Theme::get('key');
        $this->assertEquals('value', $result);
    }
    
    public function testGetNotExists()
    {
        Theme::delete('key_not_exists');
        $result = Theme::get('key_not_exists');
        $this->assertFalse($result);
    }
    
    public function testDelete()
    {
        Theme::set('key_for_delete', 'value');
        $value_first = Theme::get('key_for_delete');
        Theme::delete('key_for_delete');
        $value_second = Theme::get('key_for_delete');
        $this->assertEquals('value', $value_first);
        $this->assertFalse($value_second);
    }
    
    public function testGetAll()
    {
        Theme::set('key_first', 'value_first');
        Theme::set('key_second', 'value_second');
        
        $result = Theme::getAll();
        $this->assertEquals('value_first', $result['key_first']);
        $this->assertEquals('value_second', $result['key_second']);
    }
    
    public function testSetAll()
    {
        $data = array(
            'key_first'  => 'value_first',
            'key_second' => 'value_second',
        );
        Theme::setAll($data);

        $result = Theme::getAll();
        
        $this->assertEquals($data, $result);
    }
    
    public function testAppend()
    {
        Theme::set('key', 'default_value');
        Theme::append('key', ':append_value');
        $result = Theme::get('key');
        $this->assertEquals('default_value:append_value', $result);
    }
    
    public function testPrepend()
    {
        Theme::set('key', 'default_value');
        Theme::prepend('key', 'prepend_value:');
        $result = Theme::get('key');
        $this->assertEquals('prepend_value:default_value', $result);
    }
    
    public function testAppendToTheKeyNotExists()
    {
        Theme::delete('key_for_append');
        Theme::append('key_for_append', 'append_value');
        $result = Theme::get('key_for_append');
        $this->assertEquals('append_value', $result);

        Theme::append('key_for_append', ':second_value');
        $result = Theme::get('key_for_append');
        $this->assertEquals('append_value:second_value', $result);
    }
    
    public function testPrependToTheKeyNotExists()
    {
        Theme::delete('key_for_prepend');
        Theme::append('key_for_prepend', 'prepend_value');
        $result = Theme::get('key_for_prepend');
        $this->assertEquals('prepend_value', $result);

        Theme::prepend('key_for_prepend', 'second_value:');
        $result = Theme::get('key_for_prepend');
        $this->assertEquals('second_value:prepend_value', $result);
    }
    
    public function testSetOnce()
    {
        Theme::setOnce('set_at_once', 'key', 'value');
        $result = Theme::get('key');
        Theme::setOnce('set_at_once', 'key', 'value_second');
        $result = Theme::get('key');
        $this->assertEquals('value', $result);
    }
    
    public function testAppendOnce()
    {
        Theme::delete('key');
        Theme::appendOnce('append_at_once', 'key', 'append_value');
        $result = Theme::get('key');
        Theme::appendOnce('append_at_once', 'key', 'value_second');
        $result = Theme::get('key');
        $this->assertEquals('append_value', $result);

        Theme::appendOnce('append_another_context', 'key', ':value_third');
        $result = Theme::get('key');
        $this->assertEquals('append_value:value_third', $result);
    }

    public function testPrependOnce()
    {
        Theme::delete('key');
        Theme::prependOnce('prepend_at_once', 'key', 'prepend_value');
        $result = Theme::get('key');
        Theme::prependOnce('prepend_at_once', 'key', 'value_second');
        $result = Theme::get('key');
        $this->assertEquals('prepend_value', $result);

        Theme::prependOnce('prepend_another_context', 'key', 'value_third:');
        $result = Theme::get('key');
        $this->assertEquals('value_third:prepend_value', $result);
    }
}