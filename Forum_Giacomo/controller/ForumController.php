<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;

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
    public function addPost($id) {

        $postManager = new PostManager();
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);
        $addPost = $postManager->addPost();

        return [
            "view" => VIEW_DIR."forum/addPost.php",
            "meta_description" => "Ajoutez un message : ",
            "data" => [
                "addPost" => $addPost,
                "topic" => $topic
            ]
        ];
    }

    public function lockTopic($id) {

        $topicId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        $topicManager = new TopicManager();
        $lockSuccess = $topicManager->lockTopic($id);
        $getTopic = $topicManager->findTopicById($id);

        if ($lockSuccess) {
            // Redirection après le verrouillage
            header("Location: index.php?ctrl=forum&action=listTopicsByCategory&id=" . $_GET['category_Id']);
            exit;
        }
    }
}