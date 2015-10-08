<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Article
 *
 * @author jdpaoli
 */
class Article  extends Database{
    //put your code here
    
    private  $id;
    private $designation;
    private $prixHT;
    private $stock;
    private $visible;
    private $image;
    private $tva;
 
    /**
     * AfficherArticles : affiche la liste des articles
     * @param type $param
     */
    public function Afficher_les_articles() {
        
         // requete sur la base de donnée             
        $sql = "SELECT * FROM tb_article ORDER BY a_designation ASC LIMIT 5 ";            
        $req =$this->db->query($sql);  
        
        // boucle d'affichage des articles
        $html = "<table>"; 
        
        // note : fetch(PDO::FETCH_OBJ) permet de renvoyer une association de type objet
        while ($article = $req->fetch(PDO::FETCH_OBJ)) {
               
               $html .= "<tr> "
                            . "<td>$article->id_article</td>"
                            . "<td> $article->a_designation</td>"
                            . "<td>$article->a_pht</td>"
                            . "<td> <a href=\"?id_article=$article->id_article&action=add\"> Ajouter</a> </td>"
                            . "<td> <a href=\"?id_article=$article->id_article&action=substract\"> retirer</a> </td>"
                            . "<td> <a href=\"?id_article=$article->id_article&action=del\"> supprimer</a> </td>"
                            . "</tr>";
        }
        $html.="</table>";
        $list ='<form method="get" action="">'.$html.'</form>';
            return $list;
    }
    


       
}