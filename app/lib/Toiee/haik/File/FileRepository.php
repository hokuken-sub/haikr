<?php
namespace Toiee\haik\File;

class FileRepository implements FileRepositoryInterface {

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
     * Get list in range
     *
     * @param integer $page
     * @return array of files
     */
    public function listGet($page = 1)
    {
        $query = $this->createModel()->newQuery();
        return $query->where("haik_site_id", \Haik::getID())
                     ->orderBy('updated_at', 'desc')
                     ->forPage($page, $this->perPage)->get();
    }

    /**
     * Get list by type in range
     *
     * @param string $type type of file
     * @param integer $page
     * @return array of files
     */
    public function listByType($type, $page = 1)
    {
        $query = $this->createModel()->newQuery();
        return $query->where("haik_site_id", \Haik::getID())
                     ->where("type", $type)
                     ->orderBy('updated_at', 'desc')
                     ->forPage($page, $this->perPage)->get();
    }

    /**
     * Get starred file list in range
     *
     * @param integer $page
     * @return array of files
     */
    public function listStarred($page = 1)
    {
        $query = $this->createModel()->newQuery();
        return $query->where("haik_site_id", \Haik::getID())
                     ->where("starred", 1)
                     ->orderBy('updated_at', 'desc')
                     ->forPage($page, $this->perPage)->get();
        
    }

    /**
     * Is file exists?
     *
     * @param string $id
     * @return existance
     */
    public function exists($id)
    {
        $query = $this->createModel()->newQuery();
        return $query->where($this->identifierColumn, $id)->first()->exists;
    }

    /**
     * Get file by ID
     * @param string $id
     * @return FileInterface
     */
    public function retrieve($id)
    {
        $query = $this->createModel()->newQuery();
        $query->where($this->identifierColumn, $id);
        return $query->first();
    }

    /**
     * Create a new instance of the model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createModel()
    {
        $class = '\\'.ltrim($this->model, '\\');

        return new $class;
    }
}