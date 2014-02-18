<?php

class ParserManagerTest extends TestCase {

    public function testFacade()
    {
        $this->assertEquals('', trim(Parser::parse('')));
    }

    
}