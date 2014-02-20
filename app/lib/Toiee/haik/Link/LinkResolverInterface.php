<?php
namespace Toiee\haik\Link;

interface LinkResolverInterface {
    
    /**
     * return url
     * @params string $link page name or url or ...
     * @return string converted url
     * @throws LinkNotResolveException when link is not found
     */
    public function resolve($link);

}