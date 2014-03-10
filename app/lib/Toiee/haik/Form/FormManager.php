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

    /**
     * Get list
     *
     * @return array of forms
     */
    public function listGet()
    {
        return $this->forms->listGet();
    }

    /**
     * Get form
     *
     * @param  string $identifier form key
     * @return SiteForm
     */
    public function formGet($identifier)
    {
        return $this->forms->retrieve($identifier);
    }

    /**
     * render form
     *
     * @return string html
     */
    public function render()
    {
        $html = '';
        return $html;
    }

    /**
     * Delete form
     *
     * @param  array $data form data
     * @return boolean return true when return success
     */
    public function formSave($data)
    {
        return $this->forms->save($data);
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
