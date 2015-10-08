<?php
require ('autoloader.php');
$art = new Article();
$panier = new Panier();

if (isset($_GET['id_article'])) {
         //  - si il ya déjà une commande de crée  (cookie commande présent)
        if(isset($_COOKIE['commande'])){
            
            $panier->Traiter_article($_GET['action'], $_GET['id_article'], $_COOKIE['commande']);
            
            }
       // - sinon on crée une nouvelle commande et un cookie commande
        else {
           $idCommande = $panier->Creer_commande();
           $panier->Ajouter_Article($_GET['id_article'], $idCommande);

        }   

}



require 'header.php';
?>
       <table>
           
           <tr>
               <th>LISTE DES PRODUITS</th>
           </tr>
           <tr>
               <td><?= $art->Afficher_les_articles();?></td>
           </tr>
        </table>
<br /><br /><br /><br />

 <?php
//$panier->Creer_commande();
//echo  $art->Afficher_les_articles();
 if(isset($_COOKIE['commande'])){
     var_dump($_COOKIE['commande']);
        echo $panier->Afficher_Panier($_COOKIE['commande']);
 }
require 'footer.php';
        ?>


