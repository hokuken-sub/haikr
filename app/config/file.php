<?php

return array(
    /*
     * Default File Storage Engine
     * ===========================
     *
     * local|s3|db
     */
    'storage'  => 'local',
    
    /*
     * Local Storage
     * ================
     */
    'local' => array(
        'path' => app_path() . '/storage/files/',
    ),

    /*
     * File Uploading
     * ================
     */
    'upload' => array(

        /* * default name of `input:file */
        'name' => 'file',
    ),

);
