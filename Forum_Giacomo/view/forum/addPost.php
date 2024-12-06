
<?php $topic = $result["data"]['topic']; ?>

<body>
    <h1>Nouveau message dans le topic <?= $topic->getTitle() ?></h1>

<form method="POST">
<?php if ($topic): ?>
    <?php if ($topic->isLocked()): ?>
        <p>Ce topic est verrouillé. Vous ne pouvez pas y répondre.</p>
    <?php else: ?>
        <form method="post" action="index.php?ctrl=forum&action=addPost">
            <textarea name="content" placeholder="Votre réponse"></textarea>
            <input type="hidden" name="topic_id" value="<?= $topic->getId() ?>">
            <button type="submit">Répondre</button>
        </form>
    <?php endif; ?>
<?php else: ?>
    <p>Erreur : topic introuvable.</p>
<?php endif; ?>
</form>
</body>
