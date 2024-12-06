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

     //Retourne l'utilisateur correspondant au mail fourni   
    public  function findUserByMail($mail){
        $sql = "SELECT *
                FROM user
                WHERE mail = :mail";

    return DAO::select($sql, ['mail' => $mail]);
    }
    // Fonction d'inscription d'utilisateur 
    public function addUser($data){
        // Définition de la table cible -> topic
        $this->tableName = 'user'; 
        $userData = [
            'nickName' => $data['nickName'],
            'mail' => $data['mail'],
            'dateInscription' => date('Y-m-d H:i:s'),
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => 'ROLE_USER'
            ];

        $this->add($userData); 
    }
    //Fonction de récupération du mot de passe d'un utilisateur
    public function retrievePassword($mail){
        $sql = "SELECT *
                FROM ". $this->tableName ." a
                WHERE a.mail = :mail";
        
        return $this->getOneOrNullResult(
            DAO::select($sql, ['mail' => $mail], false), $this->className);
    }
}

