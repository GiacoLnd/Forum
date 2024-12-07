<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use App\Session;
use APP\Manager;
use Model\Managers\UserManager;

class SecurityController extends AbstractController{
    // contiendra les méthodes liées à l'authentification : register, login et logout

public function register() {
    // initialisation du manager    
    $registerManager = new UserManager();

        // récupération des données du formulaire
        $nickName = filter_input(INPUT_POST, "nickName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $mail = filter_input(INPUT_POST, "mail", FILTER_SANITIZE_EMAIL);
        $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $role = 'ROLE_USER';

        $regex = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-_@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/";


        //Si les entrées sont correctement remplies
        if ($nickName && $mail && $pass1 && $pass2) {
            $user = $registerManager->findUserByMail($mail);
    
            if (!$user) { 
                if (!preg_match($regex, $pass1)) {
                    $_SESSION['error'] = "Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
                    header("Location: index.php?ctrl=security&action=register");
                    exit;
                }
                if ($pass1 === $pass2 && strlen($pass1) >= 5) {

                    $userData = [
                        'nickName' => $nickName,
                        'mail' => $mail,
                        'password' => $pass1, 
                        'role' => $role
                    ];
                    //utilisation de la fonction addUser incluant les data précédemment récupérées et définies
                    $registerManager->addUser($userData);
                    
                    $_SESSION['success'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
                    header("Location: index.php?ctrl=security&action=login");
                    exit;
                } else {
                    $_SESSION['error'] = "Les mots de passe doivent correspondre et contenir au moins 5 caractères.";
                    header("Location: index.php?ctrl=security&action=register");
                    exit;
                }
            } else {
                $_SESSION['error'] = "Un compte avec cet e-mail existe déjà.";
            }
        }

     return [
         "view" => VIEW_DIR."forum/register.php",
         "meta_description" => "S'inscrire",
     ];
    }

    public function login() {

        $mail = filter_input(INPUT_POST, "mail", FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST,"password", FILTER_SANITIZE_EMAIL);
    
        if ($mail && $password) {
            $userManager = new UserManager();
            $user = $userManager->findUserByMail($mail);
    
            if ($user) {
                $dbPassword = $userManager->retrievePassword($mail);
    
                if ($dbPassword) {
                    $dbPass = $dbPassword->getPassword();
    
                    if (password_verify($password, $dbPass)) {
                        Session::setUser($user);
    
                        header("Location: index.php?ctrl=home");
                        exit;
                    } else {
                        $_SESSION['error'] = "Mot de passe incorrect.";
                    }
                } else {
                    $_SESSION['error'] = "Erreur lors de la récupération du mot de passe.";
                }
            } else {
                $_SESSION['error'] = "Aucun utilisateur trouvé avec cet e-mail.";
            }
        }
    
        return [
            "view" => VIEW_DIR . "forum/login.php",
            "meta_description" => "Se connecter"
        ];
    }
    // Fonction de deconnexion gardant les infos user coté serveur mais les supprimant de la session
    public function logout() {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
        header("Location: index.php?ctrl=home");
        return [
            "view" => VIEW_DIR . "forum/home.php",
            "meta_description" => "Déconnexion",
        ];
    }
    //fonction récupérant les infos de profil
    public function profile(){
        $user = $_SESSION['user'][0];
        return [
            "view" => VIEW_DIR . "forum/profile.php",
            "data" => [
                "user" => $user
            ],
            "meta_description" => "Page de profil"
        ];
    }
}


