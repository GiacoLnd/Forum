<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?= $meta_description ?>">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
        <link rel="stylesheet" href="<?= PUBLIC_DIR ?>/css/style.css">
        <title>FORUM</title>
    </head>
    <body class="d-flex flex-column justify-content-center align-items-center text-white p-3 ">
        <div id="wrapper"> 
            <div id="mainpage">
                <!-- c'est ici que les messages (erreur ou succès) s'affichent-->
                <h3 class="message" style="color: red"><?= App\Session::getFlash("error") ?></h3>
                <h3 class="message" style="color: green"><?= App\Session::getFlash("success") ?></h3>
                <header>
                <div class="d-flex flex-column justify-content-center align-items-center mb-3"> 
                    <a href="index.php?ctrl=home" > 
                        <img src="public/img/logo.png" id="logo" class="img-fluid" alt="logo">
                    </a>   

                    <nav class="d-flex flex-column flex-lg-row align-items-center justify-content-center gap-3 mt-3">
                            <div id="nav-left" class="custom-bg p-3 rounded-custom text-center fs-5 fw-bold d-flex flex-wrap justify-content-center gap-3">
                                <a href="index.php?ctrl=home" class="text-decoration-none nav-hover">Accueil</a>
                                <a href="index.php?ctrl=forum&action=index" class=" text-decoration-none nav-hover">Liste des catégories</a>
                                <?php
                                // if(App\Session::isAdmin()){
                                    ?>
                                    <a href="index.php?ctrl=home&action=users" class=" text-decoration-none nav-hover">Voir la liste des gens</a>            

                                <?php 
                            // } 
                            ?>
                            </div>
                            <div id="nav-right" class="custom-bg p-3 rounded-custom text-center fs-5 fw-bold d-flex flex-wrap justify-content-center gap-3">
                            <?php
                                // si l'utilisateur est connecté 
                                if(App\Session::getUser()){
                                    ?>
                                    <a href="index.php?ctrl=security&action=profile" class=" text-decoration-none nav-hover"><span class="fas fa-user"></span>&nbsp;<?= App\Session::getUser()[0]['nickName']?></a>
                                    <a href="index.php?ctrl=security&action=logout" class=" text-decoration-none nav-hover">Déconnexion</a>
                                    <?php
                                }
                                else{
                                    ?>
                                    <a href="index.php?ctrl=security&action=login" class="text-decoration-none nav-hover">Connexion</a>
                                    <a href="index.php?ctrl=security&action=register" class="text-decoration-none nav-hover">Inscription</a>
                                    <a href="index.php?ctrl=forum&action=index" class="text-decoration-none nav-hover">Liste des catégories</a>
                                <?php
                                }
                            ?>
                            </div>
                        </nav>

                    </div>
                </header>
                
                <main id="forum">
                    <?= $page ?>
                </main>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <footer class="custom-bg rounded-custom d-inline-block text-center p-2">
                    <p>&copy; <?= date_create("now")->format("Y") ?> - <a href="#" class="text-white text-decoration-none">Règlement du forum</a> - <a href="#" class="text-white text-decoration-none">Mentions légales</a></p>
                </footer>
            </div>
        </div>
        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous">
        </script>
        <script>
            $(document).ready(function(){
                $(".message").each(function(){
                    if($(this).text().length > 0){
                        $(this).slideDown(500, function(){
                            $(this).delay(3000).slideUp(500)
                        })
                    }
                })
                $(".delete-btn").on("click", function(){
                    return confirm("Etes-vous sûr de vouloir supprimer?")
                })
                tinymce.init({
                    selector: '.post',
                    menubar: false,
                    plugins: [
                        'advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks code fullscreen',
                        'insertdatetime media table paste code help wordcount'
                    ],
                    toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                    content_css: '//www.tiny.cloud/css/codepen.min.css'
                });
            })
        </script>
               <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="<?= PUBLIC_DIR ?>/js/script.js"></script>
    </body>
</html>