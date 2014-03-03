<?php
namespace Toiee\haik\Entities;

use Michelf\MarkdownExtra;
use Validator;

class HaikMarkdown extends MarkdownExtra implements ParserInterface {
    
    protected $running;

    public function __construct()
    {
        $running = false;

        $this->empty_element_suffix = '>';
        
        $this->document_gamut += array(
            'doConvertPlugins'   => 10,
        );

		$this->span_gamut += array(
            "doInlinePlugins"    => 2,
            "doHaikLinks"        => 1,
        );
		
		parent::__construct();
    }
    
    public function parse($text)
    {
        if ($this->running)
        {
            return with(new HaikMarkdown())->parse($text);
        }

        $this->running = true;
        $html = $this->transform($text);
        $this->running = false;

        return $html;
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
        $link_text = $title = $alias ? $this->unhash($this->runSpanGamut($alias)) : $alias;
        $title = $title ? strip_tags($title) : $title;

        //hash only
        if ($pagename === '' && $hash)
        {
            $url = $hash;
            if ( ! $alias)
            {
                $link_text = ltrim($hash, '#');
            }
        }
        //page name provided
        else if (\Haik::pageExists($pagename))
        {
            $url = \Link::url($pagename . $hash);
            if ( ! $alias)
            {
                $link_text = $title = $pagename;
            }
        }
        //other link token
        else
        {
            $url = \Link::url($pagename);
            $link_text = $alias ? $alias : $url;
        }

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
        $text = preg_replace_callback('/
                &
                (      # (1) plain
                  (\w+) # (2) plugin name
                  (?:
                    \(
                      ((?:(?!\)[;{]).)*) # (3) parameter
                    \)
                  )?
                )
                (?:
                  \{
                    ((?:(?R)|(?!};).)*) # (4) body
                  \}
                )?
                ;
			/xs', array(&$this, '_doInlinePlugins_callback'), $text);

        return $text;
    }

    protected function _doInlinePlugins_callback($matches)
    {
        $plugin_id = $matches[2];
        $params = isset($matches[3]) && $matches[3] ? str_getcsv($matches[3], ',', '"', '\\') : array();
        $body = isset($matches[4]) ? $this->unhash($this->runSpanGamut($matches[4])) : '';

        $result = \Plugin::get($plugin_id)->inline($params, $body);
        return $this->hashPart($result);        
    }
    
    protected function doConvertPlugins($text)
    {
        // single line
		$text = preg_replace_callback('/
				(?:\n|\A)
				(?:
				    \{\#
				        (\w+)   # (1) plugin name
				        (?:
				            \(
				            ([^\n]*) # (2) parameter
				            \)
				        )?
				    \}
				)
				[ ]* (?= \n ) # Whitespace and newline following marker.
			/xm',
			array(&$this, '_doConvertPlugin_singleline_callback'), $text);
       
        // multi line
		$text = preg_replace_callback('/
				(?:\n|\A)
				# (1) Opening marker
				(
					(?::{3,}) # 3 or more colons.
				)
				[ ]*
				(?:
				    \{\#
				        (\w+)   # (2) plugin name
				        (?:
				            \(
				            ((?:(?!\n).)*) # (3) parameter
				            \)
				        )?
				    \}
				)
				[ :]* \n # Whitespace and newline following marker.
				
				# (4) Content
				(
					(?>
						(?!\1 [ ]* \n)	# Not a closing marker.
						.*\n+
					)+
				)
				
				# Closing marker.
				\1 [ ]* (?= \n )
			/xm',
			array(&$this, '_doConvertPlugin_multiline_callback'), $text);

		return $text;
    }
    
    protected function _doConvertPlugin_singleline_callback($matches)
    {
        return $this->_doConvertPlugin(
            $matches[1],
            isset($matches[2]) ? $matches[2] : ''
        );
    }
    
    protected function _doConvertPlugin_multiline_callback($matches)
    {
        return $this->_doConvertPlugin(
            $matches[2],
            isset($matches[3]) ? $matches[3] : '',
            isset($matches[4]) ? $matches[4] : ''
        );
    }
    
    protected function _doConvertPlugin($plugin_id, $params = '', $body = '')
    {
        $params = ($params !== '') ? str_getcsv($params, ',', '"', '\\') : array();
        $body = $this->unHash($body);

        $result = \Plugin::get($plugin_id)->convert($params, $body);
		return "\n\n".$this->hashBlock($result)."\n\n";
    }
    
}
