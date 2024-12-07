<div class="d-flex flex-column justify-content-center align-items-center ">
    <h1>Mon profil</h1>
    <?php
    if (isset($_SESSION["user"])): 
    ?>
        <div class="text-start">
        <p>Pseudo : <?= $_SESSION["user"][0]['nickName'] ?></p>
        <p>Email : <?= $_SESSION["user"][0]['mail'] ?></p>
        <p>Date de création du profil : <?= $_SESSION["user"][0]['dateInscription'] ?></p>
        <p>Role : <?= $_SESSION["user"][0]['role'] ?></p>
        </div>
    <?php 
    else: 
    ?>
        <p>Vous n'êtes pas connecté. <a href="index.php?ctrl=security&action=login">Connectez-vous</a>.</p>
    <?php endif; ?>
</div>