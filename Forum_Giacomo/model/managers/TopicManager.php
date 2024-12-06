<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;
use App\Session;
use Model\Entities\User;
use Model\Entities\Category;
class TopicManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Topic";
    protected $tableName = "topic";

    public function __construct(){
        parent::connect();
    }

    // récupérer tous les topics d'une catégorie spécifique (par son id)
    public function findTopicsByCategory($id) {

        $sql = "SELECT t.id_topic, t.title, t.category_id, t.user_id, DATE_FORMAT(t.creationDate, '%d/%m/%Y %H:%i') AS creationDate, t.lock
                FROM ".$this->tableName." t 
                WHERE t.category_id = :id
                ORDER BY t.creationDate DESC";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }

    public function findTopicById($id){
        $sql = "
            SELECT t.*, 
                   c.id_category AS category_id, c.name AS category_name,
                   u.id_user AS user_id, u.nickName AS user_name

            FROM ".$this->tableName." t
            LEFT JOIN category c ON t.category_id = c.id_category
            LEFT JOIN user u ON t.user_id = u.id_user
            WHERE t.id_topic = :id_topic";
    
        $result = DAO::select($sql, ['id_topic' => $id], false);
    
       
        return $this->getOneOrNullResult($result, $this->className);
    }

    public function getTopicCreator($id) {
        $sql = "SELECT user_id 
                FROM ".$this->tableName." t 
                WHERE t.id_topic = :id_topic";
        return DAO::select($sql, ['id_topic' => $id]);
    }
    public function getTopicCategory($id) {
        $sql = "SELECT category_id 
                FROM ".$this->tableName." t 
                WHERE t.id_topic = :id_topic";
                
                $result = DAO::select($sql, ['id_topic' => $id], false);

                // Vérifie et retourne directement l'ID de la catégorie
                return $result ? (int) $result['category_id'] : null;
    }
    
    public function addTopic(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
            $userId = $_SESSION['user'][0]['id_user']; // Récupération du id_user dans la session du user connecté
        
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
        
            // Définition de la table cible -> post
            $this->tableName = 'post'; 
            $messageData = [
                'content' => $content,
                'topic_id' => $topicId,
                'user_id' => $userId,
                'datePost' => date('Y-m-d H:i:s')
            ];
        

            $this->add($messageData); 
            

            header("Location: index.php?ctrl=forum&action=listTopicsByCategory&id=$categoryId");
            exit;
        }
    }
    public function lockTopic(int $id): void {
        $user = new User($_SESSION['user'][0]);
    

        $categoryId = $this->getTopicCategory($id);
        if (!$categoryId) {
            $_SESSION['error'] = "La catégorie associée au topic est introuvable.";
            header("Location: index.php?ctrl=forum&action=listCategories");
            exit;
        }
    
        
        $topic = $this->findTopicById($id);
        if (!$topic) {
            $_SESSION['error'] = "Le topic spécifié est introuvable.";
            header("Location: index.php?ctrl=forum&action=listCategories");
            exit;
        }
    
        if ($user->hasRole('ROLE_ADMIN') || $user->getId() === $topic->getUserId()) {

            $newLockState = $topic->isLocked() ? 0 : 1;
    

            $sql = "UPDATE topic SET lock = :lockState WHERE id_topic = :id_topic";
            DAO::update($sql, ['lockState' => $newLockState, 'id_topic' => $id]);
    

            $_SESSION['success'] = $newLockState ? "Le topic a été verrouillé." : "Le topic a été déverrouillé.";
    

            header("Location: index.php?ctrl=forum&action=listTopicsByCategory&id=" . $categoryId);
            exit;
        }
    

        $_SESSION['error'] = "Vous n'êtes pas autorisé à modifier l'état de ce topic.";
        header("Location: index.php?ctrl=forum&action=listTopicsByCategory&id=" . $categoryId);
        exit;
    }

}
