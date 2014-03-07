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
        return $query->where($this->identifierColumn, $identifier)->first()->exists;
    }

    /**
     * Get form by key
     * @param string $identifier
     * @return FormInterface
     */
    public function retrieve($identifier)
    {
        $query = $this->createModel()->newQuery();
        return $query->where($this->identifierColumn, $identifier)->first();
    }

    /**
     * Get new form object
     *
     * @return string $identifier
     * @return FileInterface
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
