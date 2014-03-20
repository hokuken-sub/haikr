<?php
namespace Toiee\haik\Form;

interface FormRepositoryInterface {

    /**
     * Get list
     *
     * @return array of forms
     */
    public function listGet();

    /**
     * Is form exists?
     *
     * @param string $identifier
     * @return existance
     */
    public function exists($identifier);

    /**
     * Get form by key
     * @param string $identifier
     * @return SiteForm
     */
    public function retrieve($identifier);

    /**
     * Delete form by key
     * @param string $identifier
     * @return boolean when success return true
     */
    public function remove($identifier);

    /**
     * Save form
     * @param array $data form data
     * @return boolean when success return true
     */
    public function save($data);

    /**
     * Get new form object
     *
     * @return string $identifier
     * @return SiteForm
     */
    public function factory($identifier = null);

}
