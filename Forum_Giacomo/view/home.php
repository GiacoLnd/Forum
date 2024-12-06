<h1>BIENVENUE SUR LE FORUM</h1>
<?php if (isset($_SESSION['user'][0])) { // si un utilisateur est connecté 
    $nickName = $_SESSION['user'][0]['nickName']; 
    echo "<h2>Bienvenue, $nickName !</h1>";
} else { // Si utilisateur pas connecté -> invité
    echo "<h2>Bienvenue, invité !</h1>";
}?>

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit ut nemo quia voluptas numquam, itaque ipsa soluta ratione eum temporibus aliquid, facere rerum in laborum debitis labore aliquam ullam cumque.</p>

<p>
    <?php if(isset($_SESSION["user"])){?>
        <a href="index.php?ctrl=security&action=logout">Deconnexion</a>
        <a href="index.php?ctrl=security&action=profile">Profil</a>
        <a href="index.php?ctrl=forum&action=index">Liste des catégories</a>
    <?php } else{?>
        <a href="index.php?ctrl=security&action=login">Connexion</a> 
        <a href="index.php?ctrl=security&action=register">Inscription</a>
    <?php } ?> 

</p>