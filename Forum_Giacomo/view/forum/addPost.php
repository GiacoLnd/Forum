
<?php $topic = $result["data"]['topic']; ?>

<div class="d-flex flex-column justify-content-center align-items-center ">
    <h1>Nouveau message dans le topic <?= $topic->getTitle() ?></h1>

    <form method="POST">
    <?php if ($topic): ?>
        <?php if ($topic->isLocked()): ?>
            <p class="text-danger">Ce topic est verrouillé. Vous ne pouvez pas y répondre.</p>
        <?php else: ?>
            <div class="d-flex flex-column justify-content-center align-items-center gap-2 ">
                <form method="post" action="index.php?ctrl=forum&action=addPost" >
                    <textarea name="content" placeholder="Votre réponse"></textarea>
                    <input type="hidden" name="topic_id" value="<?= $topic->getId() ?>">
                    <button type="submit">Répondre</button>
                </form>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <p class="text-danger">Erreur : topic introuvable.</p>
    <?php endif; ?>
    </form>
</div>
