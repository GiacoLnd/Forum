<?php
    use APP\Session;
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
    $user = $_SESSION['user'][0];
?>

<h1>Liste des topics</h1>

<button><a href="index.php?ctrl=forum&action=addTopic&id=<?= $category->getId() ?>">Ajouter un topic</a></button>


<?php foreach ($topics as $topic): ?>
    <p>
        <a href="index.php?ctrl=forum&action=listPostInTopic&id=<?= $topic->getId() ?>">
            <?= $topic->getTitle() ?>
        </a>
        par <strong><?= $topic->getUserId() ?></strong> le <?= $topic->getCreationDate() ?>

        <!-- Bouton Verrouiller/Déverrouiller -->
        <button>
            <a href="index.php?ctrl=forum&action=lockTopic&id=<?= $topic->getId() ?>">
                <?= $topic->isLocked() ? 'Déverrouiller' : 'Verrouiller' ?>
            </a>
        </button>
    </p>
    <?php endforeach; ?>
