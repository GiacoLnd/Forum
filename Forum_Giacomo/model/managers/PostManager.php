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

    // récupère tous les topics d'une catégorie
    public function findPostByTopic($id) {

        $sql = "SELECT p.id_post, p.content, DATE_FORMAT(p.datePost, '%d/%m/%Y %H:%i') AS datePost, p.topic_id, p.user_id
                FROM ".$this->tableName." p 
                WHERE p.topic_id = :id
                ORDER BY p.datePost DESC";
       

        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }
    // Fonction qui ajoute un post dans un topic
    public function addPost(array $data): void {
        $topicManager = new TopicManager();
        $topic = $topicManager->findTopicById($data['topic_id']);
    
        // Vérifie si le topic est verrouillé avec fonction isLocked() -> empêche d'écrire un post si topic fermé
        if ($topic->isLocked()) {
            $_SESSION['error'] = "Ce topic est verrouillé. Vous ne pouvez pas y ajouter de message.";
            header("Location: index.php?ctrl=forum&action=listPostInTopic&id=" . $data['topic_id']);
            exit;
        }

        $this->tableName = 'post';
        $this->add([
            'content' => $data['content'],
            'user_id' => $data['user_id'],
            'datePost' => date('Y-m-d H:i:s'),
            'topic_id' => $data['topic_id']
        ]);
    
        $_SESSION['success'] = "Votre message a bien été ajouté.";
        header("Location: index.php?ctrl=forum&action=listPostInTopic&id=" . $data['topic_id']);
        exit;
    }
}