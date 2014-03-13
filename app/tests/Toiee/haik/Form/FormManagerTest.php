<?php

use Toiee\haik\Form\FormManager;
use Toiee\haik\Form\FormRepository;

class FormManagerTest extends TestCase {

    protected $manager;

    public function setUp()
    {
        parent::setUp();

        $this->forms = new FormRepository('SiteForm');
        $this->siteId = \Haik::getID();

        $this->seedForms();
        $this->manager = new FormManager($this->forms);
    }

    public function seedForms()
    {
        SiteForm::truncate();

        $form1 = new SiteForm;
        $form1->haik_site_id = $this->siteId;
        $form1->key      = 'contact';
        $form1->note     = 'お問い合わせ用';
        $form1->body = '';
        $form1->transaction = '';
        $form1->save();
        
        $form2 = new SiteForm;
        $form2->haik_site_id = $this->siteId;
        $form2->key      = 'starbucks';
        $form2->note     = 'order coffee';
        $form2->body = '';
        $form2->transaction = '';
        $form2->save();
    }


    public function tearDown()
    {
        parent::tearDown();
        SiteForm::truncate();
    }

    public function testFormDelete()
    {
        $form = SiteForm::site($this->siteId)->orderBy("updated_at", "desc")->first();
        $identifier = $form->getIdentifier();
        $this->manager->formDelete($identifier);
        $this->assertFalse($this->forms->exists($identifier));
    }

    public function testFormCopy()
    {
        $dest_id = 'order';
        $form = SiteForm::site($this->siteId)->orderBy("updated_at", "desc")->first();
        $cmpnote = $form->note;

        $identifier = $form->getIdentifier();
        $this->manager->formCopy($identifier, $dest_id);

        $form2 = $this->manager->formGet($dest_id);
        $this->assertEquals($cmpnote, $form2->note);
    }
    
    public function testRender()
    {
        $form = SiteForm::site($this->siteId)->orderBy("updated_at", "desc")->first();
        $form->body = array(
            'type'   => 'horizontal',
            'parts'  => array(
                            array(
                                'id'    => 1,
                                'type'  => 'text',
                                'name'  => 'coffee',
                                'label' => 'coffee',
                                'placehoder' => 'cafe mist',
                            ),
                            array(
                                'id' => 2,
                                'type'  => 'text',
                                'name'  => 'cake',
                                'label' => 'cake',
                                'placehoder' => 'orange cake',
                            ),
                        ),
            'button' => '',
        );
        
        var_dump($form->render());

        $this->assertEquals('', $form->render());

    }

}