<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Entities\User;

class ForumController extends AbstractController implements ControllerInterface{

    public function index() {
        
        // créer une nouvelle instance de CategoryManager
        $categoryManager = new CategoryManager();
        // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
        $categories = $categoryManager->findAll(["name", "DESC"]);

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [
            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [
                "categories" => $categories
            ]
        ];
    }
    //Liste les topics par catégorie
    public function listTopicsByCategory($id) {

        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        $topics = $topicManager->findTopicsByCategory($id);

        return [
            "view" => VIEW_DIR."forum/listTopics.php",
            "meta_description" => "Liste des topics par catégorie : ".$category,
            "data" => [
                "category" => $category,
                "topics" => $topics
            ]
        ];
    }
    //Liste les post dans les topics
    public function listPostInTopic($id) {

        $postManager = new PostManager();
        $topicManager = new TopicManager();
        $topics = $topicManager->findOneById($id);
        $posts = $postManager->findPostByTopic($id);

        return [
            "view" => VIEW_DIR."forum/listPosts.php",
            "meta_description" => "Liste des posts : ".$topics,
            "data" => [
                "topics" => $topics,
                "post" => $posts
            ]
        ];
    }
    //Fonction qui récupère le manager pour ajouter un topic dans une catégorie
    public function addTopic($id) {

        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        $addTopics = $topicManager->addTopic();

        return [
            "view" => VIEW_DIR."forum/addTopic.php",
            "meta_description" => "Ajoutez un topic : ",
            "data" => [
                "addTopics" => $addTopics,
                "category" => $category
            ]
        ];
    }
    //Fonction qui ajoute un post dans un topic
    public function addPost($id): array {
        $topicManager = new TopicManager();
        $postManager = new PostManager();
    
        // Filtrage de l'ID en URL pour éviter sa manipulation par l'utilisateur
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
        if (!$id) {
            $_SESSION['error'] = "ID de topic invalide ou manquant.";
            header("Location: index.php?ctrl=forum&action=listCategories");
            exit;
        }
    
        // récupération du topic par son ID
        $topic = $topicManager->findTopicById($id);
    
        if (!$topic) {
            $_SESSION['error'] = "Le topic spécifié est introuvable.";
            header("Location: index.php?ctrl=forum&action=listCategories");
            exit;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
            if (!$content) {
                $_SESSION['error'] = "Le contenu du message est vide.";
                header("Location: index.php?ctrl=forum&action=addPost&id=" . $id);
                exit;
            }
    
            // Récupère la session du user 
            $userId = $_SESSION['user'][0]['id_user'];
    
            // Appel de la méthode du manager pour ajouter le message
            $postManager->addPost([
                'content' => $content,
                'user_id' => $userId,
                'topic_id' => $id
            ]);
        }
    
        return [
            "view" => VIEW_DIR . "forum/addPost.php",
            "meta_description" => "Ajoutez un message : ",
            "data" => [
                "topic" => $topic
            ]
        ];
    }

    //Fonction qui permet de verrouiller et déverouiller un topic par son créateur ou un admin
 public function toggleLock(int $id) {

    $user = new User($_SESSION['user'][0]);
    
    $topicManager = new TopicManager();
    $topic = $topicManager->findTopicById($id);
    // var_dump($topic);die;
    //récupère l'id de la catégorie
    
    // Récupère les informations du topic
    $categoryManager = new CategoryManager();
    $category = $categoryManager->findOneById($id);

    $categoryId = $topicManager->getCategoryIdByTopicId($id);
    
    if (!$topic) {
        $_SESSION['error'] = "Le topic spécifié est introuvable.";
        header("Location: index.php?ctrl=forum&action=listCategories");
        exit;
    }
    // Vérifie si l'utilisateur est autorisé à intéragir (admin ou créateur)
    if (!$user->hasRole('ROLE_ADMIN') && $user->getId() !== $topic->getUserId()) {
        $_SESSION['error'] = "Vous n'êtes pas autorisé à modifier ce topic.";
        header("Location: index.php?ctrl=forum&action=listTopicsByCategory&id=" . $categoryId);
        exit;
    }

    // Basculer l'état de verrouillage via le manager
    $topicManager->toggleLockState($id, !$topic->isLocked());

    //Message de confirmation en cas de succès
    $_SESSION['success'] = $topic->isLocked() ? "Le topic a été déverrouillé." : "Le topic a été verrouillé.";

    // Redirection après succès
    header("Location: index.php?ctrl0=forum&action=listTopicsByCategory&id=". $categoryId);
    exit;
}
    }