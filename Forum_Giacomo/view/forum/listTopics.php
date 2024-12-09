<?php
    use APP\Session;
    use Model\Entities\User;
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
    $user = new User(Session::getUser()); 
?>
<div class="d-flex flex-column min-vh-100 align-items-center custom-bg p-5 rounded-custom mb-2 custom-bg p-5 rounded-custom mb-2">
    <h1 class="mb-5">Liste des topics</h1>

    <button class="btn btn-primary btn-sm"><a href="index.php?ctrl=forum&action=addTopic&id=<?= $category->getId() ?>" class="text-white text-decoration-none">Ajouter un topic</a></button>

    <?php foreach ($topics as $topic): ?>
        <p>
            <a href="index.php?ctrl=forum&action=listPostInTopic&id=<?= $topic->getId() ?>" class="text-white text-decoration-none btn btn-danger">
                <?= $topic->getTitle() ?>
            </a>
            <?php if ($topic->isLocked()): ?>
                <span class="locked-icon">🔒</span> 
            <?php endif; ?>
            par <strong><?= $topic->getUser()->getNickName() ?></strong> le <?= $topic->getCreationDate() ?>

            <!-- Bouton Verrouiller/Déverrouiller -->
            <?php if ($user->hasRole('ROLE_ADMIN') || $user->getId() === $topic->getUser()->getId())?>
                <button class="btn btn-dark btn-sm">
                    <a href="index.php?ctrl=forum&action=toggleLock&id=<?= $topic->getId() ?>" class="text-white text-decoration-none">
                        <?= $topic->isLocked() ? 'Déverrouiller' : 'Verrouiller' ?>
                    </a>
                </button>
        </p>
    <?php endforeach; ?>
</div>