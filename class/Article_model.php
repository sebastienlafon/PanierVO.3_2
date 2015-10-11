<?php
require_once ('autoloader.php');
/**
 * Article_model gère la connexion avec la BD 
 *
 * @author Lafon Sébastien
 */
class Article_model  extends Database{
    /**
     *
     * @var integer identifiant d'article
     */
    private $id_article;
    /**
     *
     * @var string designation d'article
     */
    private $a_designation;
    /**
     *
     * @var integer  prix hors taxes
     */
    private $a_pht;

    /**
     * obtient une liste de 5 articles
     * @return objet de type PDO statement
     */
    public function get_articles_from_db() 
    {   
       $sql = "SELECT * FROM tb_article ORDER BY a_designation ASC LIMIT 5 ";
       $req =$this->db->query($sql);
       return $req;
    }    
}