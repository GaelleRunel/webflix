<!-- Le fichier header.php est inclus dans la page -->
<?php require_once(__DIR__.'/partials/header.php'); ?>

     <!-- ======================= MAIN =========================== -->


<!-- ////////// SOLUTION SI ON INSCRIT DIRECTEMENT LE TITRE DU FILM DANS UN FORMULAIRE ///////////////////////////////////// 

// <?php 
// $title = null;

// if (!empty($_POST)) { // Récupére les informations saisies dans le formulaire
//     $title = $_POST['movie-title'];
    
//     $errors = [];
    
//     // vérification que le titre n'est pas vide  -----------------------------------------------------
//     if (empty($title)) { 
//         $errors['movie-title'] = 'Il manque le nom du film. <br />';
//     }
    
//     // vérification que le film existe dans la base de données
//     $query = $db->prepare('SELECT title FROM movie WHERE title = :title');
//     $query->bindValue(':title', $title, PDO::PARAM_STR);
//     $query->execute();
//     $result = $query->fetch();
//     if (empty($result)) // Si une valeur est retournée c'est qu'un membre possède déjà le pseudo.
//         {
//         $errors['movie-title'] = 'le film n\'existe pas';
//         }

//     if (empty($errors)) {
//         // if (empty($errors)) {
//         // 	echo 'Envoi du mail';
//         // 	}
// }
// ?>
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<?php
 
$id = $_GET['id'];

if(!empty($id)){    
    $query = $db->prepare('DELETE FROM movie WHERE id = :id');
    
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    if ($query->execute()) { 
        $success = true;
    }
}  
?>


 <main class="container"> 

    <h1 class="page-title"><i class="fab fa-hotjar"></i> Suppression d'un film</h1>
     

    <?php if (isset($success) && $success) { ?>
            <div class="alert alert-success alert-dismissible fade show">
                Le film a bien été <strong>supprimé </strong> !
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
    <?php } ?>


</main>

     <!-- ======================= SCRIPTS ===========================  -->

<!-- Le fichier footer.php est inclus dans la page -->
<?php require_once(__DIR__.'/partials/footer.php'); ?>
   