<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;


class UserManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\User";
    protected $tableName = "user";

    public function __construct(){
        parent::connect();
    }

        
        public  function findUserByMail($mail){
            $sql = "SELECT *
                    FROM user
                    WHERE mail = :mail";

        return DAO::select($sql, ['mail' => $mail]);
        }

    public function addUser($data){
        $nickName= filter_input(INPUT_POST, "nickName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $mail= filter_input(INPUT_POST, "mail", FILTER_SANITIZE_EMAIL);
        $pass1= filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pass2= filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            // Définition de la table cible -> topic
        $this->tableName = 'user'; 
        $userData = [
                'nickName' => $nickName,
                'mail' => $mail,
                'dateInscription' => date('Y-m-d H:i:s'),
                'password' => $pass1
            ];

            // Insertion du topic et récupération de l'id du topic dans la variable $topicId
            $userData = $this->add($userData); 
    }
    public function getPassword($mail){
        $sql = "SELECT u.password
                FROM user u
                where u.mail = :mail";
        return DAO::select($sql, ['mail' => $mail]);
    }
}

