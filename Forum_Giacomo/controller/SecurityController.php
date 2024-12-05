<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use App\Session;
use APP\Manager;
use Model\Managers\UserManager;

class SecurityController extends AbstractController{
    // contiendra les méthodes liées à l'authentification : register, login et logout

    public function register () {
   
    $registerManager = new UserManager();


     $nickName= filter_input(INPUT_POST, "nickName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
     $mail= filter_input(INPUT_POST, "mail", FILTER_SANITIZE_EMAIL);
     $pass1= filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
     $pass2= filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

     //Si chaque entrée est remplie
     if($nickName && $mail && $pass1 && $pass2) {

        $user = $registerManager->findUserByMail($mail);
        //  demander à la couche modele de vous creer un objet à partir du mail 
         
         // var_dump($user);

         if (!$user) {  // Si l'utilisateur n'existe pas
             if ($pass1 == $pass2 && strlen($pass1) >= 5) {
                $userData = $registerManager->addUser($user);
             } 
         } else {
             echo "Ce compte existe déjà";
         }   
     }
     

     return [
         "view" => VIEW_DIR."forum/register.php",
         "meta_description" => "S'inscrire",
         "data" => [
            //  "user" => $user
         ]
     ];
    }

    public function login () {
        
        $loginManager = new UserManager();

        $mail= filter_input(INPUT_POST, "mail", FILTER_SANITIZE_EMAIL);
        $password= filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($mail && $password) {
                    

            $user = $loginManager->findUserByMail($mail);
            $dbpass = $loginManager->retrievePassword($mail);

            // est ce que l'utilisateur existe ? 
            if($user){
                $hash = $dbpass->getPassword(); 
                if(password_verify($password, $hash)){
                    $connected = Session->setUser($user);;
                    header("location: index.php?ctrl=home"); exit;
                } else {
                    header("location: index.php?ctrl=security&action=login"); exit;
                }
            } else {
                echo "L'utilisateur n'existe pas !";
            }
        }

        return [
            "view" => VIEW_DIR."forum/login.php",
            "meta_description" => "Se connecter",
            "data" => [
                "user" => $loginManager
            ]
        ];
    }

    public function logout () {
        
    }
}
