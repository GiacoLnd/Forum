<?php
    $categories = $result["data"]['categories']; 
?>

<div class="d-flex flex-column min-vh-100 align-items-center custom-bg p-5 rounded-custom mb-2 custom-bg p-5 rounded-custom mb-2">
    <h1 class="mb-5">Liste des catégories</h1>

    <?php
    foreach($categories as $category ){ ?>
        <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>" class="text-white text-decoration-none btn btn-danger"><?= $category->getName() ?></a></p>
    <?php } ?>
</div>


  
