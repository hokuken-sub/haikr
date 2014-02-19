<?php
namespace Toiee\haik\Link;

use Toiee\haik\Link\LinkResolverInterface;

class Link implements LinkInterface {
    
    protected $resolvers;
    
    public function __construct($resolvers = array())
    {
        $this->resolvers = $resolvers;
    }
        
    public function url($link)
    {
        try {
            foreach ($this->resolvers as $resolver)
            {
                return $resolver->url($link);
            }
        }
        catch(\Exception $e)
        {
            return $link;
        }
    }

}
