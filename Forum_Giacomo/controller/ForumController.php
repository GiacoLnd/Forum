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
        $user = Session::getUser();

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
    public function addPost($topicId) {
        $postManager = new PostManager();
        $topicManager = new TopicManager();
    
        $topic = $topicManager->findTopicById($topicId);
    
        // Utilisation de  getUser pour récupérer l'utilisateur
        $user = Session::getUser();

        if (!$user || !isset($user[0]['id_user'])) {
            $_SESSION['error'] = "Vous devez être connecté pour poster un message.";
            header("Location: index.php?ctrl=security&action=login");
            exit;
        }
    
        // Si method POST dans Form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
            if (!$content) {
                $_SESSION['error'] = "Le contenu du message est obligatoire.";
                header("Location: index.php?ctrl=forum&action=listPostInTopic&id=" . $topicId);
                exit;
            }
    
            $postManager->addPost([
                'content' => $content,
                'user_id' => $user[0]['id_user'],
                'topic_id' => $topicId
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
    $currentUserId = $_SESSION['user'][0]['id_user'];

    $topicManager = new TopicManager();
    $topic = $topicManager->findTopicById($id);
    $creatorId = $topicManager->getTopicCreator($id);
    // var_dump($topic);die;

    
    $categoryManager = new CategoryManager();
    $category = $categoryManager->findOneById($id);

    $categoryId = $topicManager->getCategoryIdByTopicId($id);
    
    // Vérifie si l'utilisateur est autorisé à intéragir (admin ou créateur)
    if (!$user->hasRole('ROLE_ADMIN') && $currentUserId !== $creatorId) {
        $_SESSION['error'] = "Vous n'êtes pas autorisé à modifier ce topic.";
        header("Location: index.php?ctrl=forum&action=listTopicsByCategory&id=" . $categoryId);
        exit;
    }

    // Basculer l'état de verrouillage via le manager
    $topicManager->toggleLockState($id, !$topic->isLocked());

    //Message de confirmation en cas de succès
    $_SESSION['success'] = $topic->isLocked() ? "Le topic a été déverrouillé." : "Le topic a été verrouillé.";

    // Redirection après succès
    header("Location: index.php?ctrl=forum&action=listTopicsByCategory&id=". $categoryId);
    exit;
    }
}