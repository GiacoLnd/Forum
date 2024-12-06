<?php
namespace Model\Entities;

use App\Entity;



final class Topic extends Entity{

    private $id;
    private $title;
    private $user;
    private $category;
    private $creationDate;
    private $lock;
    private $category_id;
    private $userId;

    public function __construct($data){         
        $this->hydrate($data);        
    }

    /**
     * Get the value of id
     */ 
    public function getId(){
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id){
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle(){
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title){
        $this->title = $title;
        return $this;
    }


    /**
     * Get the value of creationDate
     */ 
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set the value of creationDate
     *
     * @return  self
     */ 
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }


    /**
     * Get the value of category
     */ 


    /**
     * Get the value of category_id
     */ 


    /**
     * Get the value of category
     */ 
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @return  self
     */ 
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }
    
    
    
        /**
         * Get the value of user
         */ 
        public function getUser()
        {
            return $this->user;
        }
    
        /**
         * Set the value of user
         *
         * @return  self
         */ 
        public function setUser($user)
        {
            $this->user = $user;
    
            return $this;
        }
    

    public function getLock()
    {
        return $this->lock;
    }
    
    
    public function setLock($lock)
    {
        $this->lock = $lock;
        
        return $this;
    }
    
    /**
     * Get the value of userId
     */ 
    public function getUserId()
    {
        return $this->userId;
    }
    
    /**
     * Set the value of userId
     *
     * @return  self
     */ 
    public function setUserId($userId)
    {
        $this->userId = $userId;
        
        return $this;
    }

    
    public function isLocked(): bool {
        return $this->lock == 1;
    }

    public function __toString(){
        return $this->title;
    }



}