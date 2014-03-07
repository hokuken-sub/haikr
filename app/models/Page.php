<?php
use Toiee\haik\Entities\SearchItemInterface;

class Page extends Eloquent implements SearchItemInterface {

    protected $table = 'haik_pages';
    
    /**
     * get title
     * @return string title
     */
    public function getTitle()
    {
        $title = $this->title;
        if ($title == '')
        {
            $title = $this->name;
        }

        return $title;
    }

    /**
     * get sub title
     * @return string sub title
     */
    public function getSubTitle()
    {
        if ($this->getTitle() == $this->name)
        {
            return '';
        }

        return $this->name;    
    }

    /**
     * get url
     * @return string url
     */
    public function getUrl()
    {
        return \Haik::pageUrl($this->name);
    }

    /**
     * get caption
     * @return string caption
     */
    public function getCaption()
    {
        $body = $this->body;
        $body = \Parser::parse($body);

        $body = preg_replace('!<style.*?>.*?</style.*?>!is', '', $body);
        $body = preg_replace('!<script.*?>.*?</script.*?>!is', '', $body);
        $body = strip_tags($body);
        $body = str_replace("\n", ' ', $body);
        $body = mb_strimwidth($body, 0, 124, '...');

        return $body;
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
        $search_columns = array('name', 'title', 'body');
        
        // search
        $query->select('name', 'title', 'body', 'updated_at');
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

    /**
     * Set haik site id
     * @param  Builder $query
     * @param  string $value publicity [public, close, forward, all]
     * @return Builder $query
     */
    public function scopePublicity($query, $value)
    {
        if ($value == 'all')
        {
            return $query;
        }
        
        $operator = '=';
        if ($value != 'public')
        {
            // if not public then need like search
            $value = $value . '%';
            $operator = 'like';
        }
        $query->where('public', $operator, $value);

        return $query;
    }

}
