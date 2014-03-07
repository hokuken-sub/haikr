<?php
use Toiee\haik\Form\FormRepository;

class FormRepositoryTest extends TestCase {
    
    public function setUp()
    {
        parent::setUp();

        $this->forms = new FormRepository('SiteForm');
        $this->siteId = \Haik::getID();

        $this->seedForms();
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

    public function testListGet()
    {
        $list = $this->forms->listGet();

        // test return array
        $this->assertInternalType('array', $list);

        // test list data
        $newest_file = SiteForm::site($this->siteId)->orderBy("updated_at", "desc")->first();
        $this->assertEquals($newest_file, $list[0]);
    }

    public function testExists()
    {
        $file = SiteForm::site($this->siteId)->orderBy("updated_at", "desc")->first();
        $idenfier = $file->getIdentifier();
        $this->assertTrue($this->forms->exists($idenfier));
    }

    public function testRetrieve()
    {
        $form = SiteForm::site($this->siteId)->orderBy("updated_at", "desc")->first();
        $idenfier = $form->getIdentifier();
        $this->assertEquals($form, $this->forms->retrieve($idenfier));
    }

    public function testRemove()
    {
        $form = SiteForm::site($this->siteId)->orderBy("updated_at", "desc")->first();
        $idenfier = $form->getIdentifier();
        $this->forms->remove($idenfier);
        $this->assertFalse($this->forms->exists($idenfier));
    }


    public function testFactory()
    {
        $identifier = 'foobar';
        $form = $this->forms->factory($identifier);
        $this->assertInstanceOf('\SiteForm', $form);
        $this->assertEquals($identifier, $form->getIdentifier());
    }

}