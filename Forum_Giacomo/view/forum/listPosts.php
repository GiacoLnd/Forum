<?php
    $topics = $result["data"]['topics'];
    $posts = $result["data"]['post']; 
?>
<div class="d-flex flex-column min-vh-100 align-items-center custom-bg p-5 rounded-custom mb-2 custom-bg p-5 rounded-custom mb-2">
    <h1 class="mb-5">Liste des posts</h1>
    <button class="btn btn-primary btn-sm mb-3"><a href="index.php?ctrl=forum&action=addPost&id=<?= $topics->getId() ?>" class="text-white text-decoration-none">Répondre</a></button>
    <?php
    foreach($posts as $post ){ ?>
        <p class="text-start mb-0 text-white fs-4"><?= $post ?> <div class="text-danger fw-bolder"> <?= $post->getUser() ?> </> le <?= $post->getDatePost() ?> </div> </p>
    <?php } ?>
</div>
