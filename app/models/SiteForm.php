<?php
use Toiee\haik\Entities\SearchItemInterface;

class SiteForm extends Eloquent implements SearchItemInterface {

    protected $table = 'haik_forms';
    
    /**
     * get body attribute
     *
     * @param  string $value json string
     * @return string form identifier
     */
    public function getBodyAttribute($value)
    {
        $body = json_decode($value, true);
        if ( ! $body)
        {
            $body = array();
        }
        return $body;
    }    

    /**
     * set body attribute
     *
     * @param  string $value form body data
     * @return string form identifier
     */
    public function setBodyAttribute($value)
    {
        $this->attributes['body'] = json_encode($value, true);
    }
    
    /**
     * get identifier
     *
     * @return string form identifier
     */
    public function getIdentifier()
    {
        return $this->key;
    }

    /**
     * set identifier
     *
     * @param form model for method chain
     */
    public function setIdentifier($identifier)
    {
        $this->key = $identifier;
        return $this;
    }

    /**
     * Make form html
     *
     * @return string form html
     */
    public function render()
    {
        $html = '';

        $form_type = $this->body['type'];
        $class = '\Toiee\haik\Form\\' . camel_case($form_type) . 'FormFactory';
        $form = new $class($form_type);

        foreach ($this->body['parts'] as $part)
        {
            if (in_array($part['type'], $form->parts()))
            {
                $parts[] = $form->partsFactory($part['type'], $part)->render();
            }
        }
        $parts = join('', $parts);

        $button = $form->buttonFactory($this->body['button'])->render();

        $namespace = $form_type;
        $viewfile = $namespace . '::' . 'form';

        if ( ! \View::exists($viewfile))
        {
            $dirname = app_path().'/lib/Toiee/haik/Form/views/' . $form_type;
            \View::addLocation($dirname);
            \View::addNamespace($namespace, $dirname);
        }
        
        return \View::make($viewfile, array(
                        'parts' => $parts,
                        'button' => $button
                ))->render();
    }

    /**
     * parse transaction data 
     *
     */
    public function parseTransaction()
    {
        $data = json_decode($this->transaction);
        $this->transaction = $data;
        return $this;
    }

    /**
     * get title
     * @return string title
     */
    public function getTitle()
    {
        $title = $this->note;
        if ($title == '')
        {
            $title = $this->key;
        }

        return $title;
    }

    /**
     * get sub title
     * @return string sub title
     */
    public function getSubTitle()
    {
        return '';
    }

    /**
     * get url
     * @return string url
     */
    public function getUrl()
    {
        // ! edit用のURLを返す
        return '';
    }

    /**
     * get caption
     * @return string caption
     */
    public function getCaption()
    {
        return '';
    }

    /**
     * get thumbnail
     * @return string thumbnail
     */
    public function getThumbnail()
    {
        return '';
    }    

    /**
     * get update date
     * @return Carbon/Carbon update date
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * search word (i.e Page::search)
     * @param  Builder $query
     * @param  string  $word search word
     * @return \Illuminate\Pagination\Paginator
     */
    public function scopeSearch($query, $word)
    {
        $search_columns = array('key', 'note');
        
        // search
        $query->select('key', 'note', 'updated_at');
        $query = $this->scopeLike($query, $search_columns, $word);

        return $query;
    }

    /**
     * partial match retrieval
     * @param  Builder $query
     * @param  mixed  $colums array or string search columns
     * @param  string $search string search words
     * @return Builder $query
     * @throws RuntimeException when unimplement
     */
    public function scopeLike($query, $columns, $search)
    {
        //全角スペースを半角スペースに変換
        $keyword = mb_convert_kana($search, 's');

        //検索文字を半角スペースで区切って配列に代入
        $keywords = preg_split('/[\s]+/', $keyword, -1, PREG_SPLIT_NO_EMPTY);
        
        if ( ! is_array($columns))
        {
            $columns = array($columns);
        }

        //配列の数だけ繰り返し
        foreach($keywords as $value)
        {
            $query->where(function($subquery) use ($columns, $value)
            {
                foreach ($columns as $col)
                {
                   $subquery->where($col, 'like', '%' . $value . '%', 'or');
                }
            });
        }

        return $query;
    }
    
    /**
     * Set haik site id
     * @param  Builder $query
     * @param  integer $value site id
     * @return Builder $query
     */
    public function scopeSite($query, $value)
    {
        $query->where('haik_site_id', $value);
        return $query;
    }

}
