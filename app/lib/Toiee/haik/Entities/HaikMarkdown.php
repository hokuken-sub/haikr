<?php
namespace Toiee\haik\Entities;

use Michelf\_MarkdownExtra_TmpImpl;

class HaikMarkdown extends _MarkdownExtra_TmpImpl {
    
    public function __construct()
    {
        $this->empty_element_suffix = '>';

		$this->span_gamut += array(
            "doInlinePlugins"    => 2,
            "doHaikLinks"        => 1,
        );
		
		parent::__construct();
    }
    
    protected function doHaikLinks($text)
    {
	#
	# Turn Markdown link shortcuts into XHTML <a> tags.
	#
		if ($this->in_anchor) return $text;
		$this->in_anchor = true;

		#
		# First, handle only page name links: [[PageName]]
		#
		$text = preg_replace_callback('{
			(					# wrap whole match in $1
			  \[\[
				([^>\]]*?)      # page name text = $2
				(\#[^>\]]+)?    # hash text = $3
			  \]\]
			)
			}xs',
			array(&$this, '_doHaikLinks_pagename_only_callback'), $text);

		#
		# Next, alias links: [[Alias>PageName]]
		#
		$text = preg_replace_callback('{
			(				# wrap whole match in $1
			  \[\[
				([^>\]]+?)	  # alias text = $2
				>
				([^>\]]*?)    # page name text = $3
				(\#[^\]]+)?  # hash text = $4
			  \]\]
			)
			}xs',
			array(&$this, '_doHaikLinks_alias_callback'), $text);

		$this->in_anchor = false;
		return $text;
    }

    protected function _doHaikLinks_pagename_only_callback($matches)
    {
        $whole_match = $matches[1];
        $link_text = $title = $pagename = $matches[2];
        $hash = isset($matches[3]) ? $matches[3] : '';

        if ($pagename === '' && $hash)
        {
            $base_url = '';
            $link_text = ltrim($hash, '#');
        }
        else
        {
            // !TODO: Config::get(app.url) -> Haik::url() in future
            $base_url = \Config::get('app.url');
        }

        if ($pagename === \Config::get('app.haik.defaultPage'))
        {
            $pagename = '';
            $hash = $hash ? ('/' . $hash) : $hash;
        }
        
        $url = rtrim($base_url . '/'  .$pagename, '/') . $hash;
        $url = $this->encodeAttribute($url);

        $result = "<a href=\"$url\"";
        if (isset($title) && strlen($title) > 0)
        {
            $title = $this->encodeAttribute($title);
            $result .=  " title=\"$title\"";
        }

        $result .= ">$link_text</a>";

        return $this->hashPart($result);
    }

    protected function _doHaikLinks_alias_callback($matches)
    {
        $whole_match = $matches[1];
        $title = $link_text = $this->encodeAttribute($matches[2]);
        $pagename = $matches[3];
        $hash = isset($matches[4]) ? $matches[4] : '';

        if ($pagename === '' && $hash)
        {
            $base_url = '';
        }
        else
        {
            // !TODO: Config::get(app.url) -> Haik::url() in future
            $base_url = \Config::get('app.url');
        }

        if ($pagename === \Config::get('app.haik.defaultPage'))
        {
            $pagename = '';
            $hash = $hash ? ('/' . $hash) : '';
        }
        $url = rtrim($base_url . '/'  .$pagename, '/') . $hash;
        $url = $this->encodeAttribute($url);

        $result = "<a href=\"$url\"";
        $result .=  " title=\"$title\"";

        $result .= ">$link_text</a>";

        return $this->hashPart($result);
    }

    protected function doInlinePlugins($text)
    {
        return $text;
    }
    
}