<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class PostManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Post";
    protected $tableName = "post";

    public function __construct(){
        parent::connect();
    }

    // récupérer tous les topics d'une catégorie spécifique (par son id)
    public function findPostByTopic($id) {

        $sql = "SELECT p.id_post, p.content, DATE_FORMAT(p.datePost, '%d/%m/%Y %H:%i') AS datePost, p.topic_id, p.user_id
                FROM ".$this->tableName." p 
                WHERE p.topic_id = :id
                ORDER BY p.datePost DESC";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }

    public function addPost() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $content = htmlspecialchars(trim($_POST['content']), ENT_QUOTES, 'UTF-8');
            $userId = 1; 
            $topicId = intval($_GET['id']); 

                // Définition de la table cible -> post
                $this->tableName = 'post'; 
                $topicData = [
                    'content' => $content,
                    'user_id' => $userId,
                    'datePost' => date('Y-m-d H:i:s'),
                    'topic_id' => $topicId
                ];

                $this->add($topicData);
                header("Location: index.php?ctrl=forum&action=listPostInTopic&id=$topicId");
        }
    }    
}