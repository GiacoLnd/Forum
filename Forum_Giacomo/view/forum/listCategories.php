<?php
    $categories = $result["data"]['categories']; 
?>

<div class="d-flex flex-column justify-content-center align-items-center">
    <h1>Liste des catégories</h1>

    <?php
    foreach($categories as $category ){ ?>
        <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a></p>
    <?php } ?>
</div>


  
