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
            'type'   => 'linear',
            'parts'  => array(
                            array(
                                'id'    => 1,
                                'type'  => 'text',
                                'name'  => 'coffee',
                                'label' => 'coffee',
                                'placeholder' => 'cafe mist',
                            ),
                            array(
                                'id' => 2,
                                'type'  => 'email',
                                'name'  => 'email',
                                'label' => 'email',
                                'placeholder' => 'put you ara hands up!',
                                'required' => 1,
                            ),
                            array(
                                'id' => 3,
                                'type'  => 'textarea',
                                'name'  => 'note',
                                'label' => 'memo',
                                'placeholder' => 'Leave me alone!',
                                'required' => 0,
                            ),
                            array(
                                'id' => 4,
                                'type'  => 'checkbox',
                                'name'  => 'seasons',
                                'label' => 'seasons',
                                'valign' => 'horizontal',
                                'value' => '',
                                'options' => array('salt','pepper','honey'),
                                'required' => 0,
                            ),
                            array(
                                'id' => 5,
                                'type'  => 'radio',
                                'name'  => 'vegitable',
                                'label' => 'vegitable',
                                'value' => 'onion',
                                'valign' => 'vertical',
                                'options' => array('lemon','carrot','onion'),
                                'required' => 0,
                            ),
                            array(
                                'id' => 5,
                                'type'  => 'select',
                                'name'  => 'tea',
                                'label' => 'tea',
                                'value' => 'woolong',
                                'empty' => 'choose!!',
                                'options' => array('woolong', 'earl gray', 'dargiling', 'green tea'),
                                'required' => 0,
                            ),
                            array(
                                'id' => 6,
                                'type'  => 'select',
                                'name'  => 'tea',
                                'label' => 'tea',
                                'value' => '',
                                'empty' => 'choose tea !!',
                                'options' => array('woolong', 'earl gray', 'dargiling', 'green tea'),
                                'multiple' => 1,
                                'required' => 0,
                            ),
                            array(
                                'id' => 7,
                                'type'  => 'file',
                                'name'  => 'image',
                                'label' => 'imagefile',
                                'value' => '',
                                'required' => 0,
                            ),
                            array(
                                'id' => 8,
                                'type'  => 'agree',
                                'name'  => 'agreement',
                                'label' => 'agreement',
                                'terms_text' => 'Are you sure?',
                                'value' => '',
                                'required' => 1,
                            ),
            ),
            'button' => array(
                'color'   => 'success',
                'confirm' => 'Confirm',
                'send'    => 'Send',
            ),
        );

        $this->assertEquals('', $form->render());
    }

}