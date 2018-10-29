<?php
try{
$db = new PDO('mysql:host=localhost;dbname=webflix;charset=utf8', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
}catch (Exception $e){
    echo $e->getMessage();
    echo '<img src= "assets/img/questioncat.gif">';
}
?>