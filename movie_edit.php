<!-- Le fichier header.php est inclus dans la page -->
<?php require_once(__DIR__.'/partials/header.php'); ?>

     <!-- ======================= MAIN =========================== -->

<?php

$id = $_GET['id'];


    $query = $db->prepare('SELECT * FROM movie WHERE id = :id');
    
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute(); // Execute la requête
    $pizza = $query->fetch();
    // if ($query->execute()) {
    //     $movie = $query->fetch(); 
    //     $success = true;
    // }
 


$title = null;
$cover = null;
$link = null;
$description = null;
$release = null;
$category = null;

if (!empty($_POST)) { // Récupére les informations saisies dans le formulaire
    $title = $_POST['movie-title'];
    $cover = $_FILES['movie-cover']; // tableau avec toutes les info sur l'image uploadée
    $link = $_POST['video-link'];  
    $description = $_POST['movie-description'];
    $release = $_POST['movie-release'];
    $category = $_POST['movie-category'];

    $errors = [];
        
        // vérification des données du formulaire -----------------------------------------------------
        if (empty($title)) { 
            $errors['movie-title'] = 'Il manque le nom du film. <br />';
        }
            
        if ($cover['error']=== 4) {
            $errors['movie-cover'] = 'L\'image n\'est pas valide. <br />';
        }
        
        if (empty($link)) {
            $errors['video-link'] = 'Il manque le lien du film. <br />';
        }

        if (!empty($link) && !filter_var($link, FILTER_VALIDATE_URL)) { // Vérifie si l'url est valide
            $errors['video-link'] = 'Le lien url n\'est pas valide. <br />';
        }

        if (strlen($description) < 10) { 
            $errors['movie-description'] = 'La description n\'est pas valide. <br />';
        }
        
        if (empty($release)) { // Vérifie si la date est vide
            $errors['movie-release'] = 'Il manque la date de sortie du film. <br />';
        } 
        
        if (empty($category) || !in_array($category, ['1', '2', '3', '4', '5', '6','7'])){ 
            $errors['movie-category'] = 'Il manque la catégorie du film. <br />';
        }
        
        // UPLOAD DU COVER -------------------------------------------------------------------------
        
    $file = $cover['tmp_name']; // emplacement du fichier temporaire
    $fileName = 'img/'.$cover['name']; // variable pour la BDD
    $finfo = finfo_open(FILEINFO_MIME_TYPE); // permet d'ouvrir un fichier
    $mimeType = finfo_file($finfo, $file);  // ouvre le fichier et renvoie image/jpg
    $allowedExtensions = ['image/jpg', 'image/jpeg', 'image/png'];
    
    // si l'extension n'est pas autorisée, il y a une erreur
    if(!in_array($mimeType, $allowedExtensions)){
        $errors['movie-cover'] = 'Ce type de fichier n\'est pas autorisé';
    }
    // verifier la taille du fichier  -  'size' est en en octets  -  le 40 est défini en Ko
    if($cover['size']/1024 > 100){
        $errors['movie-cover'] = 'L\'image est trop lourde';
    }
    if(!isset($errors['movie-cover'])){
        move_uploaded_file($file, __DIR__.'/assets/'.$fileName);  // on déplace le fichier uploadé où on le souhaite
    }
    // --------------------------------------------------------------------------------------------------

    
    // S'il n'y a pas d'erreurs dans le formulaire, on insère dans la base de données
    if (empty($errors)) {
        // if (empty($errors)) {
		// 	echo 'Envoi du mail';
		// 	}
        $query = $db->prepare('INSERT INTO movie (`title`, `cover`, `video_link`, `description`, `released_at`,`category_id`) 
                                VALUES (:title, :cover, :link, :description, :release, :category)');
    
        $query->bindValue(':title', $title, PDO::PARAM_STR);
        $query->bindValue(':cover', $fileName, PDO::PARAM_STR);
        $query->bindValue(':link', $link, PDO::PARAM_STR);
        $query->bindValue(':description', $description, PDO::PARAM_STR);
        $query->bindValue(':release', $release, PDO::PARAM_STR);
        $query->bindValue(':category', $category, PDO::PARAM_STR);

        if ($query->execute()) { // On insère le film dans la BDD
            $success = true;
        }
    }
}
?> 




<main class="container">

    <h1 class="page-title"><i class="fab fa-hotjar"></i> Modification d'un film</h1>
     
    <!-- <?php if (isset($success) && $success) { ?>
            <div class="alert alert-success alert-dismissible fade show">
                Le film <strong><?php echo $title; ?></strong> a bien été ajouté avec l'id <strong><?php echo $db->lastInsertId(); ?></strong> !
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?> -->

     <form method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label for="movie-title">Titre du film </label>
            <input type="text" class="form-control <?= (isset($errors['movie-title'])) ? 'is-invalid' : ''; ?>"
                    name= "movie-title" value="<?= $title; ?>">
                    <?php if (isset($errors['movie-title'])) {
                    echo '<div class="invalid-feedback">';
                        echo $errors['movie-title'];
                    echo '</div>';
                    } ?>
        </div>

        <div class="form-group">
            <label for="movie-cover">Affiche du film</label>
            <input type="file" class="form-control <?= (isset($errors['movie-cover'])) ? 'is-invalid' : ''; ?>" id="movie-cover" 
                    name= "movie-cover" >
                    <?php if (isset($errors['movie-cover'])) {
                    echo '<div class="invalid-feedback">';
                        echo $errors['movie-cover'];
                    echo '</div>';
                    } ?>     
        </div>

        <div class="form-group">
            <label for="video-link">Lien vidéo</label>
            <input type="text" class="form-control <?= (isset($errors['video-link'])) ? 'is-invalid' : ''; ?>" id="video-link" 
                    name= "video-link" value="<?= $link; ?>">
                    <?php if (isset($errors['video-link'])) {
                    echo '<div class="invalid-feedback">';
                        echo $errors['video-link'];
                    echo '</div>';
                    } ?>       
        </div> 

        <div class="form-group">
            <label for="movie-description">Description</label>
            <textarea class="form-control <?= (isset($errors['movie-description'])) ? 'is-invalid' : ''; ?>" id="movie-description" 
                    rows= "4" name="movie-description" value="<?= $description; ?>"></textarea>
                    <?php if (isset($errors['movie-description'])) {
                    echo '<div class="invalid-feedback">';
                        echo $errors['movie-description'];
                    echo '</div>';
                    } ?>
        </div>

        <div class="form-group">
            <label for="movie-release">Date de sortie</label>
            <input type="text" class="form-control <?= (isset($errors['movie-release'])) ? 'is-invalid' : ''; ?>"
                    name= "movie-release" value="<?= $release; ?>">
                    <?php if (isset($errors['movie-release'])) {
                    echo '<div class="invalid-feedback">';
                        echo $errors['movie-release'];
                    echo '</div>';
                    } ?>
        </div>

        <div class="form-group">
            <label for="movie-category">Catégorie</label>
            <select class="form-control <?= (isset($errors['movie-category'])) ? 'is-invalid' : ''; ?>" 
                    name="movie-category">
                <option value ="">Choisir la catégorie</option>
                <option <?php echo ($category === '1')? 'selected' : ''; ?> value ="1">Comédie</option>
                <option <?php echo ($category === '2')? 'selected' : ''; ?> value ="2">Drame</option>
                <option <?php echo ($category === '3')? 'selected' : ''; ?> value ="3">Thriller</option>
                <option <?php echo ($category === '4')? 'selected' : ''; ?> value ="4">Action</option> 
                <option <?php echo ($category === '5')? 'selected' : ''; ?> value ="5">Science-Fiction</option>
                <option <?php echo ($category === '6')? 'selected' : ''; ?> value ="6">Comédie musicale</option> 
                <option <?php echo ($category === '7')? 'selected' : ''; ?> value ="7">Horreur</option> 
            </select>
                <?php if (isset($errors['movie-category'])) {
                        echo '<div class="invalid-feedback">';
                            echo $errors['movie-category'];
                        echo '</div>';
                } ?>
        </div>
        
        <button class="btn btn-danger btn-block">Modifier</button>
        
    </form>

</main>

    <!-- ======================= SCRIPTS =========================== -->

<!-- Le fichier footer.php est inclus dans la page -->
<?php require_once(__DIR__.'/partials/footer.php'); ?>
   