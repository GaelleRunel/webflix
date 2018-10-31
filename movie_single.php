<?php 

$id = $_GET['id'];

require_once(__DIR__.'/partials/header.php'); 

// recupération des films
$query = $db->prepare('SELECT * FROM movie WHERE id=:id'); 
$query ->bindValue(':id', $id, PDO::PARAM_INT);
$query ->execute(); // execute la requete
$movie = $query->fetch();


// récupération des catégories associées
$query = $db->prepare('SELECT * FROM category WHERE id=:id'); 
$query ->bindValue(':id', $movie['category_id'], PDO::PARAM_INT);
$query ->execute(); // execute la requete
$category = $query->fetch();

?>

     <!-- ======================= MAIN =========================== -->
    

    
<main class="container">

    <h1 class="page-title"><i class="fab fa-hotjar"></i> Votre sélection</h1>
    

    <div class="row">
        <div class= "col-md-6">
            <div class="movie">
                <img class="img-fluid" src="assets/<?php echo $movie['cover']; ?>" alt="<?php echo $movie['title']; ?>">
            </div>
        </div>
        
        <div class= "col-md-6">
            <h3><?php echo $movie['title'];?></h3></br>
            <div class="description">
                <h4>Catégorie : <?php echo $category['name'] ; ?></h4></br>
                <h5>Date de sortie : <?php echo $movie['released_at'];?></h5></br>
                <h6><?php echo $movie['description']; ?></h6></br>
            </div>
            <div><a href= <?php echo $movie['video_link'];?> class="btn btn-danger"> Regarder le film </a></div><hr>
            <a href="<?="movie_edit.php?id=". $movie['id'] ?>" class="btn btn-outline-info">Modifier</a>
            <a href="<?="movie_delete.php?id=".$movie['id'] ?>" class="btn btn-outline-warning">Supprimer</a>
        </div>
    </div>
            

 </main>
        
    <!-- ======================= SCRIPTS =========================== -->

<!-- Le fichier footer.php est inclus dans la page -->
<?php require_once(__DIR__.'/partials/footer.php'); ?>
   