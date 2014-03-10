<?php
namespace Toiee\haik\File;

class FileManager {

    const IDENTIFIER_REGEX = '/\A[0-9a-zA-Z][0-9a-zA-Z_-]*[0-9a-zA-Z]\z/';
    const AUTO_IDENTIFIER_SEED = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const AUTO_IDENTIFIER_MIN_LENGTH = 4;
    const AUTO_IDENTIFIER_TRY_LIMIT = 10000;

    /**
     * FileRepositoryInterface
     */
    protected $files;

    /**
     * Available storage drivers
     */
    protected $storageDrivers = array();

    /**
     * Instance of last saved
     */
    protected $lastSaved = null;


    public function __construct(FileRepositoryInterface $repository)
    {
        $this->files = $repository;
    }

    public function listGet($page = 1)
    {
        return $this->files->listGet($page);
    }

    public function listByType($type, $page = 1)
    {
        return $this->files->listByType($type, $page);
    }

    public function listStarred($page = 1)
    {
        return $this->files->listStarred($page);
    }

    public function fileExists($identifier)
    {
        return $this->files->exists($identifier);
    }

    public function fileGet($identifier)
    {
        return $this->files->retrieve($identifier);
    }

    /**
     * Get file content.
     * When file not found then system delete the file record and return false.
     *
     * @param string $identifier
     * @return string|false file content or false
     */
    public function fileGetContent($identifier)
    {
        $file = $this->fileGet($identifier);

        try {
            return $this->getStorageDriver($file->getStorage())->get($file);
        }
        catch (Exception $c)
        {
            $file->delete();
            return false;
        }
    }

    /**
     * Save file content.
     *
     * @param FileInterface $file Prepared FileInterface object
     * @param string $content
     * @return boolean when success return true
     */
    public function fileSaveContent($file, $content = '')
    {
        if ($file->exists())
        {
            $identifier = $file->getIdentifier();
            $file = $this->fileGet($identifier);
            if ($this->getStorageDriver($file->getStorage())->save($file, $content))
            {
                $file->touch();
                return true;
            }
        }
        else
        {
            // When file is set identifier, use it.
            $identifier = trim($file->getIdentifier());
            if ($identifier === '' OR $this->files->exists($identifier))
            {
                $identifier = $this->createIdentifier();
            }

            if ($this->getStorageDriver()->save($identifier, $content))
            {
                $file->setIdentifier($identifier);
                $file->save();
                return true;
            }
        }
        return false;
    }

    public function fileSaveUploaded()
    {
        // !TODO: $_FILES から FileInterface object を作成して保存する
    }

    public function urlSaveAsFile($url)
    {
        // !TODO: URLを haik-link として保存する
    }

    public function fileSaveByUrl($url)
    {
        // !TODO: Get file by URL and save FileInterface objeect
    }

    /**
     * Create empty file for save
     *
     * @param string $identifier
     * @return FileInterface
     */
    public function fileCreate($identifier = '', $options = array())
    {
        $file = $this->files->factory($identifier);
        $file->setIdentify($this->createIdentifier($file));
        $file->init($options);
        return $file;
    }

    public function fileDelete($identifier)
    {
        if ($this->fileExists($identifier))
        {
            $file = $this->fileGet($identifier);
            $this->getStorageDriver($file->getStorage())->delete($file);
        }
        return false;
    }
    public function access($identifier)
    {
        $file = $this->fileGet($identifier);
        $this->getStorageDriver($file->getStorage())->passthru($file->getIdentifier());
        exit;
    }

    public function download($identifier)
    {
        $file = $this->fileGet($identifier);
        $this->getStorageDriver($file->getStorage())->download($file->getIdentifier());
    }

    protected function createIdentifier(FileInterface $file = null)
    {
        do
        {
            $identifier = $this->generateIdentifier($file);
        }
        while ($this->files->exists($identifier));
        return $identifier;
    }
    
    protected function generateIdentifier(FileInterface $file = null)
    {
        $identifier = '';
        $seed_length = strlen(self::AUTO_IDENTIFIER_SEED);
        $length = $this->getAutoIdentifierLength();
        for ($i = 0; $i < $length; $i++)
        {
            $index = rand(0, $seed_length - 1);
            $identifier .= substr(self::AUTO_IDENTIFIER_SEED, $index, 1);
        }
        return $identifier;
    }
    
    protected function getAutoIdentifierLength()
    {
        static $call_count = 0,
               $increment = 0;
        $call_count++;
        if ($call_count > self::AUTO_IDENTIFIER_TRY_LIMIT)
        {
            $increment++;
            $call_count = 0;
        }
        return self::AUTO_IDENTIFIER_MIN_LENGTH + $increment;
    }

    protected function validateIdentifier($identifier)
    {
        return preg_match(self::IDENTIFIER_REGEX, $identifier);
    }

    public function setLastSaved($file)
    {
        $this->lastSaved = $file;
    }

    public function getLastSaved()
    {
        return $this->lastSaved;
    }

    protected function getStorageDriver($storage = '')
    {
        $storage = $storage ? $storage : \Config::get('file.storage');

        if (array_key_exists($storage, $this->storageDrivers))
        {
            return $this->storageDrivers[$storage];
        }
        return $this->createStorageDriver($storage);
    }

    protected function storageDrivers()
    {
        return $this->storageDrivers;
    }

    protected function createStorageDriver($storage)
    {
        $method_name = camel_case('create_' . $storage . '_storage_driver');
        if (method_exists($this, $method_name))
        {
            return $this->$method_name();
        }
        return null;
    }

    protected function createLocalStorageDriver()
    {
        return $this->storageDrivers['local'] = \App::make('LocalStorage');
    }

    protected function createDatabaseStorageDriver()
    {
        // TODO: create DatabaseStorage
        return null;
    }

    protected function createS3StorageDriver()
    {
        // !TODO: create S3Storage
        return null;
    }

}
