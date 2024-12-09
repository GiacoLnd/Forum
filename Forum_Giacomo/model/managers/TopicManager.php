<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;
use App\Session;
use Model\Entities\User;
use Model\Entities\Category;
use Model\Entities\Topic;
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
    // récupère les topics par leur id
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
    //fonction qui retourne l'id de la catégorie par son id de topic
    public function getCategoryIdByTopicId(int $topicId): ?int {
        $sql = "SELECT category_id
                FROM topic
                WHERE id_topic = :id_topic";
    
        $result = DAO::select($sql, ['id_topic' => $topicId], false);
    
        if ($result && isset($result['category_id'])) {
            return (int) $result['category_id'];
        }
    
        return null; // Retourne null si aucun résultat trouvé
    }
    
    //fonction qui retourne l'id du user par son id de topic
    public function getTopicCreator($id): ?int {
        $sql = "SELECT user_id 
                FROM " . $this->tableName . " 
                WHERE id_topic = :id_topic";
    
        $result = DAO::select($sql, ['id_topic' => $id], false);
    
        // Retourner l'ID ou null si aucun résultat
        return $result ? (int) $result['user_id'] : null;
    }
    // fonction qui retourne l'id de la catégorie par son id de topic
    public function getTopicCategory($id) {
        $sql = "SELECT category_id 
                FROM ".$this->tableName." t 
                WHERE t.id_topic = :id_topic";
                
                $result = DAO::select($sql, ['id_topic' => $id], false);

                
                return $result ? (int) $result['category_id'] : null;
    }
    //fonction d'ajout de topic dans une catégorie
    public function addTopic(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
            $user = Session::getUser();

            if (!$user || !isset($user[0]['id_user'])) {
                $_SESSION['error'] = "Utilisateur introuvable ou non connecté.";
                header("Location: index.php?ctrl=security&action=login");
                exit;
            }
            $userId = $user[0]['id_user'];
    
            $categoryId = intval($_GET['id']);
            if (!$categoryId) {
                $_SESSION['error'] = "Catégorie invalide.";
                header("Location: index.php?ctrl=forum&action=listCategories");
                exit;
            }
    
            // Définition de la table cible -> topic
            $this->tableName = 'topic'; 
            $topicData = [
                'title' => $title,
                'user_id' => $userId,
                'creationDate' => date('Y-m-d H:i:s'),
                'category_id' => $categoryId
            ];
    
            // Insertion du topic
            $topicId = $this->add($topicData);
            if (!$topicId) {
                $_SESSION['error'] = "Échec de l'ajout du topic.";
                header("Location: index.php?ctrl=forum&action=addTopicForm");
                exit;
            }
    
            // Définition de la table cible -> post
            $this->tableName = 'post'; 
            $messageData = [
                'content' => $content,
                'topic_id' => $topicId,
                'user_id' => $userId,
                'datePost' => date('Y-m-d H:i:s')
            ];
    
            // Ajout du premier message
            if (!$this->add($messageData)) {
                $_SESSION['error'] = "Échec de l'ajout du premier message.";
                header("Location: index.php?ctrl=forum&action=addTopicForm");
                exit;
            }
    
            $_SESSION['success'] = "Topic ajouté avec succès.";
            header("Location: index.php?ctrl=forum&action=listTopicsByCategory&id=$categoryId");
            exit;
        }
    }
    //fonction qui permet de verrouiller et déverrouiller un topic 
    public function toggleLockState(int $id, bool $newLockState): void {
        $sql = "UPDATE topic SET `lock` = :lockState WHERE id_topic = :id_topic";
        DAO::update($sql, [
            'lockState' => $newLockState ? 1 : 0,
            'id_topic' => $id
        ]);
    }
}