<div class="d-flex flex-column align-items-center justify-content-center custom-bg p-5 rounded-custom mb-2 custom-bg p-5 rounded-custom mb-2">
    <h1 class="fw-bolder mb-5">S'inscrire !</h1>
    <form method="POST" class="d-flex flex-column justify-content-center align-items-center p-4 border rounded shadow-sm">
        <label for="nickName" class="form-label fs-4 fw-bold">Pseudo</label>
        <input type="text" name="nickName" id="nickName" class="form-control text-center"><br>

        <label for="mail" class="form-label fs-4 fw-bold">Mail</label>
        <input type="email" name="mail" id="mail" class="form-control text-center"><br>
        
        <label for="pass1" class="form-label fs-4 fw-bold">Mot de passe</label>
        <input type="password" name="pass1" id="pass1" class="form-control text-center"><br>

        <label for="pass2" class="form-label fs-4 fw-bold">Confirmez votre Mot de passe</label>
        <input type="password" name="pass2" id="pass2" class="form-control text-center"><br>
        
        <input type="submit" name ="submit" id="submit" class="btn btn-danger w-100" value="S'enregistrer">
    </form>
</div>