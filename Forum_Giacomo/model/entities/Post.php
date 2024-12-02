<?php
namespace Model\Entities;

use App\Entity;

final class Post extends Entity{
    private $id;
    private $content;
    private $datePost;
    private $topic;
    private $user;

    public function __construct($data){         
        $this->hydrate($data);        
    }

    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of datePost
     */ 
    public function getDatePost()
    {
        return $this->datePost;
    }

    public function setDatePost($datePost)
    {
        $this->datePost = $datePost;

        return $this;
    }

    /**
     * Get the value of topic
     */ 
    public function getTopic()
    {
        return $this->topic;
    }


    /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user){
        $this->user = $user;
        return $this;
    }

    public function __toString(){
        return $this->content;
    }


    /**
     * Set the value of datePost
     *
     * @return  self
     */ 

}