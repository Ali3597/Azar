<?php
namespace App\Entity;

class Search {

   /**
     * @var string|null
     */
    private $queryName ;

    /**
     *
     * @return  string
     */ 
    public function getQueryName()
    {
        return $this->queryName;
    }

    /**
     *
     * @param  string  $queryName
     *
     * @return  self
     */ 
    public function setQueryName($queryName)
    {
        $this->queryName = $queryName;

        return $this;
    }
}