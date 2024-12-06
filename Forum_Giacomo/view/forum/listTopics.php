<?php
    use APP\Session;
    use Model\Entities\User;
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
    $user = new User($_SESSION['user'][0]); 
?>

<h1>Liste des topics</h1>

<button><a href="index.php?ctrl=forum&action=addTopic&id=<?= $category->getId() ?>">Ajouter un topic</a></button>

<?php foreach ($topics as $topic): ?>
    <p>
        <a href="index.php?ctrl=forum&action=listPostInTopic&id=<?= $topic->getId() ?>">
            <?= $topic->getTitle() ?>
        </a>
        <?php if ($topic->isLocked()): ?>
            <span class="locked-icon">🔒</span> 
        <?php endif; ?>
        par <strong><?= $topic->getUser()->getNickName() ?></strong> le <?= $topic->getCreationDate() ?>

        <!-- Bouton Verrouiller/Déverrouiller -->
        <?php if ($user->hasRole('ROLE_ADMIN') || $user->getId() === $topic->getUserId()): ?>
            <button>
                <a href="index.php?ctrl=forum&action=toggleLock&id=<?= $topic->getId() ?>">
                    <?= $topic->isLocked() ? 'Déverrouiller' : 'Verrouiller' ?>
                </a>
            </button>
        <?php endif; ?>
    </p>
<?php endforeach; ?>