<?php
namespace Toiee\haik\Form;

class FormRepository implements FormRepositoryInterface {

    protected $identifierColumn = 'key';

    /**
     * The Eloquent user model.
     *
     * @var string
     */
    protected $model;

    protected $perPage = 50;

    /**
    * Create a new database file repository.
    *
    * @param  string  $model
    * @return void
    */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Get list
     *
     * @return array of forms
     */
    public function listGet()
    {
        $query = $this->createModel()->newQuery();
        return $query->site(\Haik::getID())->orderBy('updated_at', 'desc')->paginate($this->perPage)->getItems();
    }

    /**
     * Is form exists?
     *
     * @param string $identifier
     * @return existance
     */
    public function exists($identifier)
    {
        $query = $this->createModel()->newQuery();
        
        try
        {
            return $this->retrieve($identifier)->exists;
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    /**
     * Get form by key
     * @param string $identifier
     * @return SiteForm
     */
    public function retrieve($identifier)
    {
        $query = $this->createModel()->newQuery();
        return $query->site(\Haik::getID())->where($this->identifierColumn, $identifier)->first();
    }

    /**
     * Delete form by key
     * @param string $identifier
     * @return boolean when success return true
     */
    public function remove($identifier)
    {
        if ($this->exists($identifier))
        {
            $form = $this->retrieve($identifier);
            return $form->delete();
        }
        
        return false;
    }

    /**
     * Save form
     * @param array $data form data
     * @return boolean when success return true
     */
    public function save($data)
    {
        $identifier = $data[$this->identifierColumn];
        if ($identifier === '')
        {
            return false;
        }
        
        if ($this->exists($identifier))
        {
            $form = $this->retrieve($identifier);
        }
        else
        {
            $form = $this->factory($identifier);
        }

        if (isset($data['note']))
        {
            $form->note = $data['note'];
        }

        if (isset($data['body']))
        {
            $form->body = $data['body'];
        }

        if (isset($data['transaction']))
        {
            $form->transaction = $data['transaction'];
        }

        return $form->save();
    }

    /**
     * Get new form object
     *
     * @return string $identifier
     * @return SiteForm
     */
    public function factory($identifier = null)
    {
        $form = $this->createModel()->setIdentifier($identifier);
        $form->haik_site_id = \Haik::getID();
        return $form;
    }

    /**
     * Create a new instance of the model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function createModel()
    {
        $class = '\\'.ltrim($this->model, '\\');
        return new $class;
    }

}
