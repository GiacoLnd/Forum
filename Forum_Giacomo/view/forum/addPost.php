
<?php $topic = $result["data"]['topic']; ?>

<div class="d-flex flex-column min-vh-100 align-items-center justify-content-center custom-bg p-5 rounded-custom mb-2 custom-bg p-5 rounded-custom mb-2">
    <h1 class="fw-bolder mb-5">Nouveau message dans le topic <?= $topic->getTitle() ?></h1>

    <form method="POST" class="w-100">
    <?php if ($topic): ?>
        <?php if ($topic->isLocked()): ?>
            <p class="text-danger">Ce topic est verrouillé. Vous ne pouvez pas y répondre.</p>
        <?php else: ?>
            <div class="d-flex flex-column justify-content-center align-items-center gap-2 p-4 border rounded shadow-sm">
                <form method="post" action="index.php?ctrl=forum&action=addPost" >
                    <textarea name="content" placeholder="Votre réponse" class="form-control p-3 mb-3"></textarea>
                    <input type="hidden" name="topic_id" value="<?= $topic->getId() ?>">
                    <button type="submit" class="btn btn-danger w-100" >Répondre</button>
                </form>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <p class="text-danger">Erreur : topic introuvable.</p>
    <?php endif; ?>
    </form>
</div>
