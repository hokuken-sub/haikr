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
    

    /**
     * @dataProvider partProvider
     */
    public function testRender($parts, $assert)
    {
        $form = SiteForm::site($this->siteId)->orderBy("updated_at", "desc")->first();
        
        $body = array(
            'parts' => $parts,
            'button' => array(),
            'type' => 'horizontal',
        );
        
        $form->body = json_encode($body);
        $form->save();

        $viewdata = $this->manager->render($form->key);
        $viewdata = preg_replace('/\n| {2,}/', '', trim($viewdata));

        $this->assertEquals($assert, $viewdata);
    }
    
    /**
     * @dataProvider partProvider
     */
    public function partProvider()
    {
        $param = array(
            'id' => 1,
            'type' => 'text',
            'name' => 'ginger',
            'label' => 'organic',
            'class' => '',
            'size'  => 'col-sm-8',
            'before' => '¥',
            'after' => '円',
            'value' => 1000,
            'placeholder' => '果汁',
            'required' => 1,
            'help' => 'おいしいジュースです',
        );

        $test = array(
            'text' => array(
                'parts'   => array($param),
                'assert' => ''
                    .'<div class="form-group">'
                    .  '<label for="haik_form_' . $param['id'] .'_' . $param['name'] . '" class="control-label">'
                    .    $param['label']
                    .  '</label>'
                    .  '<div class="form-control' . $param['class'] . '">'
                    .    '<div class="row">'
                    .      '<div class="' . $param['size'] . '">'
                    .		'<div class="input-group">'
                    .          '<span class="input-group-addon">' . e($param['before']) . '</span>'
                    .          '<input type="text" name="data[' . $param['name'] . ']" value="' . e($param['value']) . '" id="haik_form_' . $param['id'] . '_' . $param['name'] . '" class="form-control" placeholder="' . e($param['placeholder']) . '" required>'
                    .          '<span class="input-group-addon">' . e($param['after']) . '</span>'
                    .        '</div>'
                    .      '</div>'
                    .    '</div>'
                    .    '<span class="help-block">'
                    .      $param['help']
                    .    '</span>'
                    .  '</div>'
                    .'</div>',
            ),
        );
        
        return $test;
    }

}