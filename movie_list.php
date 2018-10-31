<!-- Le fichier header.php est inclus dans la page -->
<?php require_once(__DIR__.'/partials/header.php'); 

//récuperer la liste des films
$query = $db->query('SELECT * FROM movie');
$movies = $query->fetchAll();


?>


     <!-- ======================= MAIN =========================== -->

<main class="container">
     
     <h1 class="page-title"><i class="fab fa-hotjar"></i> Nos films</h1>

     <div class="row">
        
        <?php
        // on affiche la liste des pizzas
            foreach ($movies as $movie){ ?>

                 <div class= "col-md-4">
                     <div class="card mb-4">
                         <div class="card-img-top-container">
                             <img class="card-img-top card-img-top-zoom-effect" src="assets/<?php echo $movie['cover']; ?>" alt="<?php $movie['title']; ?>"> 
                             
                         </div>

                         <div class="card-body">
                            <h4 class="card-title"><?php $movie['title']; ?></h4>
                            <a href="<?="movie_single.php?id=". $movie['id'] ?>" class="btn btn-dark">Voir la fiche du film</a>
                             <!-- quand on clique sur le lien, on doit se rendre sur la page film-single.php
                                 et l'URL doit ressembler à movie_single.php?id=ID du film -->
                                 
                         </div>
                     </div>
                 </div>

        <?php } ?>
     </div>      
 </main>


    <!-- ======================= SCRIPTS =========================== -->

<!-- Le fichier footer.php est inclus dans la page -->
<?php require_once(__DIR__.'/partials/footer.php'); ?>
   