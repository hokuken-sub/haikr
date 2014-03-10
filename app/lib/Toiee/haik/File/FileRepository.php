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
     * @param string $identifier
     * @return existance
     */
    public function exists($identifier)
    {
        $query = $this->createModel()->newQuery();
        return $query->where($this->identifierColumn, $identifier)->first()->exists;
    }

    /**
     * Get file by ID
     * @param string $identifier
     * @return FileInterface
     */
    public function retrieve($identifier)
    {
        $query = $this->createModel()->newQuery();
        $query->where($this->identifierColumn, $identifier);
        return $query->first();
    }

    /**
     * Get new file object
     *
     * @return string $identifier
     * @return FileInterface
     */
    public function factory($identifier = null)
    {
        $file = $this->createModel()->setIdentifier($identifier);
        $file->haik_site_id = \Haik::getID();
        return $file;
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
