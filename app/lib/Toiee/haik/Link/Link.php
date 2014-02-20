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
        // split hash because of hash is not need resolve 
        list($link_token, $hash) = array_pad(explode('#', $link, 2), 2, '');
        $hash = ($hash === "") ? "" : "#{$hash}";

        try {
            foreach ($this->resolvers as $resolver)
            {
                return $resolver->resolve($link_token) . $hash;
            }
        }
        catch(\Exception $e)
        {
            return $link;
        }
    }

}
