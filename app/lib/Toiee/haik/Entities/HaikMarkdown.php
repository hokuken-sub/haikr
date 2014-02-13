<?php
namespace Toiee\haik\Entities;

use Michelf\_MarkdownExtra_TmpImpl;
use Validator;

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
        
        $pagename = $matches[2];
        $hash = isset($matches[3]) ? $matches[3] : '';
        return $this->_makeHaikLinks($pagename, '', $hash);
    }

    protected function _doHaikLinks_alias_callback($matches)
    {
        $whole_match = $matches[1];
        $alias = $this->encodeAttribute($matches[2]);
        $pagename = $matches[3];
        $hash = isset($matches[4]) ? $matches[4] : '';
        
        return $this->_makeHaikLinks($pagename, $alias, $hash);
    }
    
    /**
     *
     */
    protected function _makeHaikLinks($pagename,  $alias = '', $hash = '')
    {
        $validator = Validator::make(
            array('url' => $pagename),
            array('url' => 'required|url')
        );
        
        if ($validator->passes())
        {
            $url = $pagename;
            
            $title = $alias ? $alias : '';
            $link_text = $alias ? $alias : $url;
        }
        else if ($alias)
        {
            $link_text = $title = $alias;
        }
        else
        {
            $link_text = $title = $pagename;
        }

        if ($pagename === '' && $hash)
        {
            $base_url = '';
            if ( ! $alias)
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
        
        if (isset($url))
        {
            $url .= $hash;
        }
        else
        {
            $url = rtrim($base_url . '/'  .$pagename, '/') . $hash;
        }
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

    protected function doInlinePlugins($text)
    {
        // first, plugin name only
        // ex) &br;
        
		$text = preg_replace_callback('{
			(					# wrap whole match in $1
			  &([a-zA-Z0-9_-]+); # plugin name = $2
			)
			}xs',
			array(&$this, '_doInlinePlugins_pluginname_only_callback'), $text);

        // second, plugin name and params
        // ex) &icon(user);
		$text = preg_replace_callback('{
			(					# wrap whole match in $1
			  &([a-zA-Z0-9_-]+) # plugin name = $2
			  \(([^\)]*?)\)      # params = $3
			  ;
			)
			}xs',
			array(&$this, '_doInlinePlugins_pluginname_and_params_callback'), $text);

        // third, plugin name and body
        // ex) &hoge{body};
		$text = preg_replace_callback('{
			(					# wrap whole match in $1
			  &([a-zA-Z0-9_-]+) # plugin name = $2
			  \{([^\}]*)\}      # body = $3
			  ;
			)
			}xs',
			array(&$this, '_doInlinePlugins_pluginname_and_body_callback'), $text);

        // finally, plugin name and params and body
        // ex) &deco(b,w){body};
		$text = preg_replace_callback('{
			(					# wrap whole match in $1
			  &([a-zA-Z0-9_-]+) # plugin name = $2
			  \(([^\)]*?)\)      # params = $3
			  \{([^\}]*)\}      # body = $4
			  ;
			)
			}xs',
			array(&$this, '_doInlinePlugins_pluginname_and_params_and_body_callback'), $text);

        return $text;
    }
    
    protected function _doInlinePlugins_pluginname_only_callback($matches)
    {
        $plugin_id = $matches[2];
        return $this->_doInlinePlugin($plugin_id);
    }
    
    protected function _doInlinePlugins_pluginname_and_params_callback($matches)
    {
        $plugin_id = $matches[2];
        $params = $matches[3];
        return $this->_doInlinePlugin($plugin_id, $params);
    }

    protected function _doInlinePlugins_pluginname_and_body_callback($matches)
    {
        $plugin_id = $matches[2];
        $body = $matches[3];
        return $this->_doInlinePlugin($plugin_id, array(), $body);
    }
    
    protected function _doInlinePlugins_pluginname_and_params_and_body_callback($matches)
    {
        $plugin_id = $matches[2];
        $params = $matches[3];
        $body = $matches[4];
        return $this->_doInlinePlugin($plugin_id, $params, $body);
    }
    
    protected function _doInlinePlugin($plugin_id, $params = array(), $body = '')
    {
        $result = \Plugin::get($plugin_id)->inline($params, $body);
        return $this->hashPart($result);        
        
    }
    
}