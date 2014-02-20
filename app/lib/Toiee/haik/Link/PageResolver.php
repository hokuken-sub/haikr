<?php
namespace Toiee\haik\Link;

class PageResolver implements LinkResolverInterface
{

    /**
     * return url
     * @params string $link page name or url or ...
     * @return string converted url
     * @throws LinkNotResolveException when page is not found
     */
    public function resolve($link)
    {
        if (\Haik::pageExists($link))
        {
            return \Haik::url($link);
        }
        
        throw new LinkNotResolveException;    
    }
}