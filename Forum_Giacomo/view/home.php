<h1>BIENVENUE SUR LE FORUM</h1>

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit ut nemo quia voluptas numquam, itaque ipsa soluta ratione eum temporibus aliquid, facere rerum in laborum debitis labore aliquam ullam cumque.</p>

<p>
    <?php if(isset($_SESSION["user"])){?>
        <a href="traitement.php?action=logout">Deconnexion</a>
        <a href="traitement.php?action=profil">Profil</a>
    <?php } else { ?> 
        <a href="index.php?ctrl=security&action=login">Connexion</a> 
        <a href="index.php?ctrl=security&action=register">Inscription</a>
    <?php } ?> 

</p>