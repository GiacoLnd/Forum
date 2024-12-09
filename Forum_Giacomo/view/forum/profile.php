<div class="d-flex flex-column min-vh-100 align-items-center custom-bg p-5 rounded-custom mb-2 custom-bg p-5 rounded-custom mb-2">
    <h1 class="mb-5">Mon profil</h1>
    <?php
    if (isset($_SESSION["user"])): 
    ?>
        <div class="text-center">
        <p><span class="text-danger fs-5">Pseudo :</span> <span class="text-white fs-3"><?= $_SESSION["user"][0]['nickName'] ?></span></p>
        <p><span class="text-danger fs-5">Email :</span> <span class="text-white fs-3"><?= $_SESSION["user"][0]['mail'] ?></p>
        <p><span class="text-danger fs-5">Date de création du profil :</span> <span class="text-white fs-3"><?= $_SESSION["user"][0]['dateInscription'] ?></span></p>
        <p><span class="text-danger fs-5">Role :</span> <span class="text-white fs-3"><?= $_SESSION["user"][0]['role'] ?></span></p>
        </div>
    <?php 
    else: 
    ?>
        <p>Vous n'êtes pas connecté. <a href="index.php?ctrl=security&action=login">Connectez-vous</a>.</p>
    <?php endif; ?>
</div>