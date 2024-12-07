
<?php $category = $result["data"]['category']; ?>

    <div class="d-flex flex-column justify-content-center align-items-center">
        <h1>Nouveau topic dans la catégorie <?= $category->getName() ?></h1>

        <form method="POST" class="d-flex flex-column justify-content-center align-items-center">
            <label for="title">Titre du Topic :</label>
            <input type="text" id="title" name="title" required>
            <br>

            <label for="content">Contenu :</label>
            <textarea id="content" name="content" rows="5" required></textarea>
            <br>

            <button type="submit">Créer le Topic</button>

        </form>
    </div>
