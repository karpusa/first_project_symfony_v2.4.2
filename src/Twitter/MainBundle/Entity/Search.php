<?php

namespace Twitter\MainBundle\Entity;

class Search
{
    protected $name;

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }

}