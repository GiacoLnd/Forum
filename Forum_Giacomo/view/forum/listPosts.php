<?php
    $topics = $result["data"]['topics'];
    $posts = $result["data"]['post']; 
?>
<div class="d-flex flex-column justify-content-center align-items-center gap-2">
<h1>Liste des posts</h1>
<button><a href="index.php?ctrl=forum&action=addPost&id=<?= $topics->getId() ?>">Ajouter un post</a></button>
<?php
foreach($posts as $post ){ ?>
    <p class="text-start"><?= $post ?> par <strong> <?= $post->getUser() ?> </strong> le <?= $post->getDatePost() ?> </p>
<?php } ?>
</div>
