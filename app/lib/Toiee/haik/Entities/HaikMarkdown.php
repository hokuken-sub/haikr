<?php
namespace Toiee\haik\Entities;

use Michelf\_MarkdownExtra_TmpImpl;

class HaikMarkdown extends _MarkdownExtra_TmpImpl {
    
    public function __construct()
    {
		$this->span_gamut += array(
			"doInlinePlugins"    => 2,
			"doHaikLinks"        => 1,
			);
		
		parent::__construct();
    }
    
    public function doHaikLinks()
    {
        
    }
    
    public function doInlinePlugins()
    {
        
    }
    
}