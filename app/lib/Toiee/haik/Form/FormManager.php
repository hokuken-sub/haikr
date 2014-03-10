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
        return $this->forms->listGet();
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

    /**
     * Delete form
     *
     * @param string $identifier
     * @return boolean return true when return success
     */
    public function formDelete($identifier)
    {
        return $this->forms->remove($identifier);
    }

    /**
     * Copy form
     *
     * @param string $identifier source form
     * @param string $dest_id the destination form
     * @return boolean when success return true
     */
    public function formCopy($identifier, $dest_id)
    {
        if ($this->forms->exists($identifier))
        {

            // create new object
            $newform = $this->formGet($identifier)->replicate();
            $newform->key = $dest_id;
    
            // make any required changes to object
            $newform->save();
        }
    }

}
