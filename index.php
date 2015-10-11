<?php
/*@author - Sébastien LAFON*/
require ('autoloader.php');
require ('header.php');

$article_controller = new Article_controller();
$liste = $article_controller->creer_liste_articles();

$panier = new Panier_controller();

if (isset($_GET['id_article'])) 
    {
         //  - si il ya déjà une commande de crée  (cookie commande présent)
        if(isset($_COOKIE['commande_speedymarket']))
        {
            $panier->traiter_article($_GET['action'], $_GET['id_article'], $_COOKIE['commande_speedymarket']);
        }
        // - sinon on crée une nouvelle commande et un cookie commande
        else 
        {
           $idCommande = $panier->create_commande();
        /* @var $idCommande type */
        $panier->ajouter_article($_GET['id_article'], $idCommande);
        }   

    }
if (isset($_GET['valider']))
    {
        $panier->mise_a_jour_stock( $_COOKIE['commande_speedymarket']);
    }
?>
       <table>
           <tr>
               <th>LISTE DES PRODUITS</th>
           </tr>
           <tr>
               <td><?php echo $liste;
               ?></td>
           </tr>
        </table>
<br /><br /><br /><br />

 <?php
//$panier->Creer_commande();
//echo  $art->Afficher_les_articles(); 
 if(isset($_COOKIE['commande_speedymarket']))
    {
        echo $panier->afficher_panier($_COOKIE['commande_speedymarket']);
        echo $panier->afficher_totaux($_COOKIE['commande_speedymarket']);
         echo $panier->afficher_bouton_valider($_COOKIE['commande_speedymarket']);
    }
require 'footer.php';
        ?>


