
<?php $category = $result["data"]['category']; ?>

    <div class="d-flex flex-column align-items-center min-vh-100 justify-content-center custom-bg p-5 rounded-custom mb-2 custom-bg p-5 rounded-custom mb-2">
        <h1 class="fw-bolder mb-5">Nouveau topic dans la catégorie <?= $category->getName() ?></h1>

        <form method="POST" class="d-flex flex-column justify-content-center align-items-center p-4 border rounded shadow-sm w-100">
            <label for="title" class="form-label fs-4 fw-bold">Titre du Topic :</label>
            <input type="text" id="title" name="title" class="form-control text-center" required>
            <br>

            <label for="content" class="form-label fs-4 fw-bold">Contenu :</label>
            <textarea id="content" name="content" rows="5" class="form-control text-center" required></textarea>
            <br>

            <button type="submit" class="btn btn-danger w-100">Créer le Topic</button>

        </form>
    </div>
