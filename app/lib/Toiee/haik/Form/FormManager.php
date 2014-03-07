<?php
namespace Toiee\haik\Form;

class FormManager {

    /**
     * FormRepositoryInterface
     */
    protected $forms;

    /**
     * constructor
     */
    public function __construct(FormRepositoryInterface $repository)
    {
        $this->forms = $repository;
    }

    public function listGet()
    {
        return $this->files->listGet();
    }

    public function formGet($identifier)
    {
        return $this->forms->retrieve($identifier);
    }

    public function render()
    {
        $html = '';
        return $html;
    }

    public function add()
    {
        return $this->forms->add();
    }

    public function remove()
    {
        return $this->forms->delete();
    }

    public function copy()
    {
        
    }

}
