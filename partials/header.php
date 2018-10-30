<?php

// inclusion du fichier functions.php
require_once(__DIR__.'/../config/functions.php');
// inclusion du fichier database.php
require_once(__DIR__.'/../config/database.php');
?>


<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <title>Webflix</title>
  </head>

 <!-- ======================= NAVBAR =========================== -->
    
 <nav class="navbar navbar-expand-lg">
  <a class="navbar-brand" href="index.php"><i class="fab fa-hotjar"></i> Webflix</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Accueil</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="movie_list.php">Liste des films</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="movie_add.php">Ajouter un film</a>
      </li>
      
    </ul>
  </div>
</nav>

