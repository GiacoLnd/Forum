<h1>Mon profil</h1>
    <?php if(isset($_SESSION["user"])){
        $infoSession = $_SESSION["user"];
    }?>
    <p>pseudo : <?php $infoSession["nickName"] ?></p>
    <p>Email : <?php $infoSession["mail"] ?></p>
    <p>Date de création du profil : <?php $infoSession["dateInscription"] ?></p>