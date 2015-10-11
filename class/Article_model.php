<?php
require_once ('autoloader.php');
/**
 * Description of Article
 *
 * @author Lafon Sébastien
 */
class Article_model  extends Database{
    private $id_article;
    private $a_designation;
    private $a_pht;
   // private $a_quantite_stock;
   // private $a_visible;
   // private $url_image;
   // private $id_tva;
 
    /**
     * AfficherArticles : affiche la liste des articles
     * @param type $param
     */
public function get_articles_from_db() 
    {   // requete sur la base de donnée             
       $sql = "SELECT * FROM tb_article ORDER BY a_designation ASC LIMIT 5 ";
       //exécution de la requête (query)
       $req =$this->db->query($sql);
       // je retourne la requête
       return $req;
    }

    


   
// boucle d'affichage des articles


    


       
}