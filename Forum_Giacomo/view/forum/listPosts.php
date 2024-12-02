<?php
    $topics = $result["data"]['topics'];
    $posts = $result["data"]['post']; 
?>

<h1>Liste des posts</h1>

<?php
foreach($posts as $post ){ ?>
    <p><?= $post ?> par <?= $post->getUser() ?> le <?= (new DateTime($post->getDatePost()))->format('d/m/Y H:i') ?> </p>
<?php }

