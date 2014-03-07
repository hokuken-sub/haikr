<?php

use Toiee\haik\Form\FormManager;
use Toiee\haik\Form\FormRepository;

class FormManagerTest extends TestCase {

    protected $identifier = 'contact';
    protected $manager;
    protected $form;

    public function setUp()
    {
        parent::setUp();
        
        $form = with(new SiteForm())->setIdentifier($this->identifier);

        App::bind('FormRepositoryInterface', function() use ($form)
        {
            $mock = Mockery::mock('\Toiee\haik\Form\FormRepositoryInterface');
            $mock->shouldReceive('retrieve')->andReturn($form);
            $mock->shouldReceive('exists')->andReturn(true);
            $mock->shouldReceive('remove')->andReturn(true);
            return $mock;
        });

        $this->form = $form;
        $this->manager = App::make('FormManager');
    }

    public function tearDown()
    {
    }

    public function testFormDelete()
    {
        $identifier = $this->form->getIdentifier();
        $this->manager->formDelete($identifier);
        $this->assertFalse($this->form->exists($identifier));
    }

}