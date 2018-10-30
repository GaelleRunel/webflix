<?php require_once(__DIR__.'/partials/header.php'); ?>

     <!-- ======================= MAIN =========================== -->

<?php

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
        
        if (empty($title)) { // Vérifie si le nom est vide
            $errors['movie-title'] = 'Il manque le nom du film. <br />';
        }
        
        if ($cover['error']=== 4) {
            $errors['movie-cover'] = 'L\'image n\'est pas valide. <br />';
        }
        
        if (empty($link)) {
            $errors['video-link'] = 'Il manque le lien du film. <br />';
        }

        // if (!empty($link) && !filter_var($link, FILTER_VALIDATE_URL)) { // Vérifie si l'url est valide
        //     $errors['video-link'] = 'Le lien url n\'est pas valide. <br />';
        // }

        if (strlen($description) < 10) { 
            $errors['movie-description'] = 'La description n\'est pas valide. <br />';
        }
        
        if (empty($release)) { // Vérifie si la date est vide
            $errors['movie-release'] = 'Il manque la date de sortie du film. <br />';
        } 
        
        if (empty($category) || !in_array($category, ['comédie', 'drame', 'thriller', 'action', 'science-fiction', 'comédie-musicale','horreur'])){ 
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
    // verifier la taille du fichier  -  'size' est en en octets  -  le 30 est défini en Ko
    if($cover['size']/1024 > 30){
        $errors['movie-cover'] = 'L\'image est trop lourde';
    }
    if(!isset($errors['movie-cover'])){
        move_uploaded_file($file, __DIR__.'/assets/'.$fileName);  // on déplace le fichier uploadé où on le souhaite
    }
    // --------------------------------------------------------------------------------------------------

    
    // S'il n'y a pas d'erreurs dans le formulaire
    if (empty($errors)) {
        $query = $db->prepare('INSERT INTO movie (`title`, `cover`, `video_link`, `description`, `released_at`,`category_id`,) VALUES (:title, :cover, :link, :description, :release, :category)');
        $query->bindValue(':title', $title, PDO::PARAM_STR);
        $query->bindValue(':cover', $filename, PDO::PARAM_STR);
        $query->bindValue(':link', $link, PDO::PARAM_STR);
        $query->bindValue(':description', $description, PDO::PARAM_STR);
        $query->bindValue(':release', $release, PDO::PARAM_STR);
        $query->bindValue(':category', $category, PDO::PARAM_STR);

        $insert_id = $db->lastInsertId();

        if ($query->execute()) { // On insère le film dans la BDD
            $success = true;

        
        }
    }
}
?>

<main class="container">

    <h1 class="page-title"><i class="fab fa-hotjar"></i> Ajout d'un film</h1>

        <?php if (isset($success) && $success) { ?>
            <div class="alert alert-success alert-dismissible fade show">
                Le film <strong><?php echo $title; ?></strong> a bien été ajouté avec l'id <strong><?php echo $db->lastInsertId(); ?></strong> !
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>

     <form method="POST" enctype="multipart/form-data"">

                <div class="form-group">
                    <label for="movie-title">Titre du film</label>
                    <input type="text" class="form-control <?= (isset($errors['movie-title'])) ? 'is-invalid' : ''; ?>"
                            name= "movie-title" value="<?= $title; ?>">
                    <div class="invalid-feedback">
                        <?php echo (isset($errors['movie-title'])) ? $errors['movie-title']: ''; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="movie-cover">Affiche du film</label>
                    <input type="file" class="form-control" id="movie-cover" 
                            name= "movie-cover">
                    <div class="invalid-feedback">
                        <?php echo (isset($errors['movie-cover'])) ? $errors['movie-cover']: ''; ?>
                    </div>        
                </div>

                <div class="form-group">
                    <label for="video-link">Lien vidéo</label>
                    <input type="text" class="form-control <?= (isset($errors['video-link'])) ? 'is-invalid' : ''; ?>" id="video-link" 
                            name= "video-link" value="<?= $link; ?>">
                    <div class="invalid-feedback">
                        <?php echo (isset($errors['video-link'])) ? $errors['video-link']: ''; ?>
                    </div>        
                </div>

                <div class="form-group">
                    <label for="movie-description">Description</label>
                    <textarea class="form-control <?= (isset($errors['movie-description'])) ? 'is-invalid' : ''; ?>" id="movie-description" 
                            rows= "4" name="movie-description" value="<?= $description; ?>"></textarea>
                    <div class="invalid-feedback">
                        <?php echo (isset($errors['movie-description'])) ? $errors['movie-description']: ''; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="movie-release">Date de sortie</label>
                    <input type="text" class="form-control <?= (isset($errors['movie-release'])) ? 'is-invalid' : ''; ?>"
                            name= "movie-release" value="<?= $release; ?>">
                    <div class="invalid-feedback">
                        <?php echo (isset($errors['movie-release'])) ? $errors['movie-release']: ''; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="movie-category">Catégorie</label>
                    <select class="form-control <?= (isset($errors['movie-category'])) ? 'is-invalid' : ''; ?>" 
                            name="movie-category">
                        <option value ="">Choisir la catégorie</option>
                        <option <?php echo ($category === 'comédie')? 'selected' : ''; ?> value ="comédie">Comédie</option>
                        <option <?php echo ($category === 'drame')? 'selected' : ''; ?> value ="drame">Drame</option>
                        <option <?php echo ($category === 'thriller')? 'selected' : ''; ?> value ="thriller">Thriller</option>
                        <option <?php echo ($category === 'action')? 'selected' : ''; ?> value ="action">Action</option> 
                        <option <?php echo ($category === 'science-fiction')? 'selected' : ''; ?> value ="science-fiction">Science-Fiction</option>
                        <option <?php echo ($category === 'comédie musicale')? 'selected' : ''; ?> value ="comédie musicale">Comédie musicale</option> 
                        <option <?php echo ($category === 'horreur')? 'selected' : ''; ?> value ="horreur">Horreur</option> 
                    </select>
                    <div class="invalid-feedback">
                        <?php echo (isset($errors['movie-category'])) ? $errors['movie-category']: ''; ?>
                    </div>
                </div>
                
                <button class="btn btn-danger btn-block">OK</button>
                <!-- <?php= $errors?> -->
                
            </form>

</main>

    <!-- ======================= SCRIPTS =========================== -->

<!-- Le fichier footer.php est inclus dans la page -->
<?php require_once(__DIR__.'/partials/footer.php'); 
?>
   