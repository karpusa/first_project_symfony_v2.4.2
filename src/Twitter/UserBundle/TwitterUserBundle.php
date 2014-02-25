<?php

namespace Twitter\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TwitterUserBundle extends Bundle
{
    public function getParent() {
        return 'FOSUserBundle';
    }    
}
