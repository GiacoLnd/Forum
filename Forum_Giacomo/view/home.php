<div class="d-flex flex-column min-vh-100 align-items-center custom-bg p-5 rounded-custom mb-2">
    <h1 class="mb-0">PopcornTalk</h1>
    <p class="fw-light">Popcorn, Talk & Chill</p>

    <p class="text-center p-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit ut nemo quia voluptas numquam, itaque ipsa soluta ratione eum temporibus aliquid, facere rerum in laborum debitis labore aliquam ullam cumque.</p>

    <p class="d-flex flex-column flex-lg-row align-items-center justify-content-center gap-3 mt-3">
        <?php if(isset($_SESSION["user"])){?>
            <a href="index.php?ctrl=security&action=logout" class="btn btn-danger text-decoration-none">Deconnexion</a>
            <a href="index.php?ctrl=security&action=profile" class="btn btn-danger text-decoration-none">Profil</a>
            <a href="index.php?ctrl=forum&action=index" class="btn btn-danger text-decoration-none">Liste des catégories</a>
        <?php } else{?>
            <a href="index.php?ctrl=security&action=login" class="btn btn-danger text-decoration-none">Connexion</a> 
            <a href="index.php?ctrl=security&action=register" class="btn btn-danger text-decoration-none">Inscription</a>
        <?php } ?> 

    </p>
</div>