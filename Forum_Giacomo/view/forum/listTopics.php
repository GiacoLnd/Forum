<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
?>

<h1>Liste des topics</h1>

<button><a href="index.php?ctrl=forum&action=addTopic&id=<?= $category->getId() ?>">Ajouter un topic</a></button>

<?php
foreach($topics as $topic ){ ?>
    <p><a href="index.php?ctrl=forum&action=listPostInTopic&id=<?= $topic->getId() ?>"><?= $topic ?></a> par <strong> <?= $topic->getUser() ?> </strong> le <?= $topic->getCreationDate()?></p>
<?php } ?>

