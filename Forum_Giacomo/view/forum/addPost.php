
<?php $topic = $result["data"]['topic']; ?>

<body>
    <h1>Nouveau message dans le topic <?= $topic->getTitle() ?></h1>

<form method="POST">

    <label for="content">Contenu :</label>
    <textarea id="content" name="content" rows="5" required></textarea>
    <br>

    <button type="submit">Lancer le message</button>

</form>
</body>
