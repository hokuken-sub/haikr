<?php

use Michelf\MarkdownExtra;

class PageController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        
        if (Request::isMethod('post'))
        {
            $pagename = Input::get('pagename');


            // editに飛ばす
            return Redirect::to('haik-admin/edit/'.$pagename);

        }
        
        $html  = '';
        $html .= '<form action="/haik-admin/create/" method="post">';
        $html .= '<input type="text" name="pagename" value="" />';
        $html .= '<button>Submit</button>';
        $html .= '</form>';

        $this->layout->content = $html;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
        if (Request::isMethod('post'))
        {
            $pagename = Input::get('pagename');
            $page = Page::where('pagename', $pagename)->first();
            
            if ( ! $page)
            {
                $page = new Page;
                $page->pagename = $pagename;
                $page->haik_site_id = 1;
            }
            $page->contents = Input::get('contents');
            $page->title = Input::get('title');
            
            
            if ($page->save())
            {
                
            }
            else
            {
                
            }
            
            return Redirect::to($pagename);
        }
        return Redirect::to($pagename);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($pagename = '')
    {
        if ($pagename === '')
        {
            // ! TODO: /app/config/app.php 内の設定が読めないんだが...
            //var_dump(Config::get('haik.defaultPage'));
            $pagename = Config::get('haik.defaultPage', 'FrontPage');
        }

        $page = Page::where('pagename', '=', $pagename)->first();
        
        if ($page)
        {
            $title = $page->title;
            $md = $page->contents;
        }
        else
        {
            //TODO: 404 error
            App::abort(404);
        }
        
        $html = '<h1>' . e($title) . '</h1>';
        $html .= MarkdownExtra::defaultTransform($md);
        $html .= '<hr>';
        $html .= '<a href="/haik-admin/edit/'.$pagename.'">編集</a>';
        $html .= " ";
        $html .= '<a href="/haik-admin/destroy/' .$pagename.'">削除</a>';
        $html .= " ";
        $html .= '<a href="/haik-admin/create/">追加</a>';

        $this->layout = View::make('settings.layouts.editor');
        $this->layout->content = $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($pagename)
    {
        // TODO: $id からページのソースをひっぱってきて
        // textarea に入れる
        
        $page = Page::where('pagename', '=', $pagename)->first();
        
        $md = '';
        $title = $pagename;
        
        if ($page)
        {
            $title = $page->title;
            $md = $page->contents;
        }
        else
        {
            //TODO: 404 error
/*
            var_dump($page);
            exit;
*/
        }
        
        $html  = '';
        $html .= '<form action="/haik-admin/edit/" method="post">';
        $html .= '<input type="text" name="title" value="'.$title.'">';
        $html .= '<br>';
        $html .= '<input type="hidden" name="pagename" value="'.$pagename.'" />';
        $html .= '<textarea name="contents" rows="5" cols="50">' . $md . '</textarea>';
        $html .= '<button>Submit</button>';
        $html .= '</form>';
        
        
        $this->layout = View::make('settings.layouts.editor');
/*         $this->layout = View::make('settings.edit'); */
        $this->layout->content = View::make('settings.edit')->with('title', $title)->with('md', $md)->with('pagename', $pagename);

/*         $this->layout->nest = View::make('settings.edit'); */
        
/*         $this->layout->content = $content; */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($pagename)
    {
        $page = Page::where('pagename', $pagename)->first();
        $page->delete();
        
        return Redirect::to('FrontPage');
        
    }

}