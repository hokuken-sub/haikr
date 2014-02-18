<?php
namespace Toiee\haik\Entities;

interface ParserInterface {
    
    /**
     * Parse text to HTML
     * @params string $text to parse
     * @return string parsed HTML
     */
    public function parse($text);
}