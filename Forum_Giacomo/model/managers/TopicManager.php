<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class TopicManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Topic";
    protected $tableName = "topic";

    public function __construct(){
        parent::connect();
    }

    // récupérer tous les topics d'une catégorie spécifique (par son id)
    public function findTopicsByCategory($id) {

        $sql = "SELECT t.id_topic, t.title, t.category_id, t.user_id, DATE_FORMAT(t.creationDate, '%d/%m/%Y %H:%i') AS creationDate
                FROM ".$this->tableName." t 
                WHERE t.category_id = :id
                ORDER BY t.creationDate DESC";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }

    
    public function addTopic(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Récupération des données du formulaire
            $title = htmlspecialchars(trim($_POST['title']), ENT_QUOTES, 'UTF-8');
            $content = htmlspecialchars(trim($_POST['content']), ENT_QUOTES, 'UTF-8');
            $userId = 1; // ID fixe - Connexion encore inexistante
            $categoryId = intval($_GET['id']); // Récupère l'id de l'URL et force en int

                // Définition de la table cible -> topic
                $this->tableName = 'topic'; 
                $topicData = [
                    'title' => $title,
                    'user_id' => $userId,
                    'creationDate' => date('Y-m-d H:i:s'),
                    'category_id' => $categoryId
                ];

                // Insertion du topic et récupération de l'id du topic dans la variable $topicId
                $topicId = $this->add($topicData); 


                //Définition de la table cible -> post
                $this->tableName = 'post'; 
                $messageData = [
                    'content' => $content,
                    'topic_id' => $topicId,
                    'user_id' => $userId,
                    'datePost' => date('Y-m-d H:i:s')
                ];

                //Insertion de la partie content dans la table post
                $this->add($messageData); 
                
                //Redirection vers la liste des topics de la catégorie
                header("Location: index.php?ctrl=forum&action=listTopicsByCategory&id=$categoryId");
        } 
    }
    
}