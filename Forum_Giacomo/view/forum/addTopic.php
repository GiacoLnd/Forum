
<?php $category = $result["data"]['category']; ?>

<body>
    <h1>Nouveau topic dans la catégorie <?= $category->getName() ?></h1>

<form method="POST">
    <label for="title">Titre du Topic :</label>
    <input type="text" id="title" name="title" required>
    <br>

    <label for="content">Contenu :</label>
    <textarea id="content" name="content" rows="5" required></textarea>
    <br>

    <button type="submit">Créer le Topic</button>

</form>
</body>
