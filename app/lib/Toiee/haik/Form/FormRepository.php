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
            return $query->where($this->identifierColumn, $identifier)->first()->exists;
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
        return $query->where($this->identifierColumn, $identifier)->first();
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
            $query = $this->retrieve($identifier);
            return $query->delete();
        }
        
        return false;
    }

    /**
     * Get new form object
     *
     * @return string $identifier
     * @return SiteForm
     */
    public function factory($identifier = null)
    {
        return $this->createModel()->setIdentifier($identifier);
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
