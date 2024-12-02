<?php
    $topics = $result["data"]['topics'];
    $posts = $result["data"]['post']; 
?>

<h1>Liste des posts</h1>
<button><a href="index.php?ctrl=forum&action=addPost&id=<?= $topics->getId() ?>">Ajouter un post</a></button>
<?php
foreach($posts as $post ){ ?>
    <p><?= $post ?> par <strong> <?= $post->getUser() ?> </strong> le <?= $post->getDatePost() ?> </p>
<?php }

