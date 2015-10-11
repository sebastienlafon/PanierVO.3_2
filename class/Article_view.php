<?php
require_once ('autoloader.php');
/**
 * gére l'affichage de la vue liste des articles
 * @author Sébastien LAFON
 */
class Article_view {
/**
 * affiche une liste de 5 articles 
 * classés par ordre alphabétique de désignation
 * @param string liste d'articles 
 * @return string tableau html avec la liste des articles
 */    
public function afficher_articles($liste_articles) 
    {
       $html = "<table>";        // note : fetch(PDO::FETCH_OBJ) permet de renvoyer une association de type objet
       while ($ligne_article = $liste_articles->fetch(PDO::FETCH_OBJ)) 
        {
           $html .= "<tr> "
            . "<td>$ligne_article->id_article</td>"
            . "<td> $ligne_article->a_designation</td>"
            . "<td>$ligne_article->a_pht</td>"
            . "<td> <a href=\"?id_article=$ligne_article->id_article&action=add\"> Ajouter</a> </td>"
            . "<td> <a href=\"?id_article=$ligne_article->id_article&action=substract\"> Retirer</a> </td>"
            . "<td> <a href=\"?id_article=$ligne_article->id_article&action=del\"> Supprimer</a> </td>"
            . "</tr>";
       }
       $html.="</table>";
       $list ='<form method="get" action="">'.$html.'</form>';
       return $list;
    }     
    
    
    
}
