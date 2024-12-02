<?php
    $topics = $result["data"]['topics'];
    $posts = $result["data"]['post']; 
?>

<h1>Liste des posts</h1>

<?php
foreach($posts as $post ){ ?>
    <p><a href="#"><?= $post ?></a> par <?= $post->getUser() ?></p>
<?php }

