<?php
/**
 * Description of Panier_model
 *
 * @author Sébastien LAFON
 */
class Panier_model extends Database{
    /**
     * Insertion d'une ligne de commande dans la BD
     * @param integer $idArticle identifiant d'un article
     * @param integer  $idCommande identifiant de commande
     */
    public function insert_article_in_db($idArticle, $idCommande) 
    {
        $sql = "INSERT INTO  tb_ligne_commande  (id_article, id_commande, qte_cmde)            
                VALUES  (:id_article, :id_commande, 1) ";
        $req = $this->db->prepare($sql);
        $req->bindValue('id_article',$idArticle, PDO::PARAM_INT);
        $req->bindValue('id_commande',$idCommande, PDO::PARAM_INT);
        $req->execute();     

    }  
    
    public function supprimer_article($idArticle, $idCommande)
    {
        $sql = "DELETE  FROM tb_ligne_commande 
                WHERE id_article = :id_article AND id_commande = :id_commande";
        $req = $this->db->prepare($sql);
        $req->bindValue('id_article', $idArticle, PDO::PARAM_INT);
        $req->bindValue('id_commande', $idCommande, PDO::PARAM_INT);
        $req->execute();

    }
    public function retirer_article($idArticle, $qte_cmde, $idCommande)
    {
        $sql="UPDATE tb_ligne_commande 
                 SET qte_cmde = :qte_cmde
                 WHERE id_article = :id_article
                 AND id_commande = :id_commande ";
        $req = $this->db->prepare($sql);
        $req->bindValue('id_article',$idArticle, PDO::PARAM_INT);
        $req->bindValue('qte_cmde',$qte_cmde, PDO::PARAM_INT);
        $req->bindValue('id_commande',$idCommande, PDO::PARAM_INT);
        $req->execute();    

    }
    public function verifier_article ($idArticle,$idCommande) 
    {
        // requete pour afficher le contenu de l'article  à partir l'id_article et l'id_commande
        $sql = "SELECT  * FROM tb_ligne_commande 
                WHERE id_article = $idArticle 
                AND id_commande = $idCommande";
        // lance la requete en query car ne necessite pas de modification sur la bd
        // et pas de risque de sécurité
        return $this->db->query($sql);              
    }

    public function update_article($id_article, $qte_cmde, $idCommande)
    {       
        $sql="UPDATE tb_ligne_commande SET qte_cmde = :qte_cmde WHERE id_article = :id_article  AND id_commande = :id_commande ";
        $req = $this->db->prepare($sql);
        $req->bindValue('id_article',$id_article, PDO::PARAM_INT);
        $req->bindValue('qte_cmde',$qte_cmde, PDO::PARAM_INT);
        $req->bindValue('id_commande',$idCommande, PDO::PARAM_INT);
        $req->execute();  
    }   

    public function create_commande() {
        //j'ajoute une nouvelle entrée dans la table commande avec le statut 1 ( commande en cours de validation)
        $sql = "INSERT INTO tb_commande (id_statut) VALUES (1)";
        $req = $this->db->prepare($sql);
        $req->execute();
            
    }
    public function get_last_id_commande() {
        // j'affiche la dernier entrée de la table commande             
        $sql="SELECT id_commande FROM tb_commande ORDER  BY id_commande DESC LIMIT 1";
        return $this->db->query($sql);
        
    }
    public function get_articles($id_commande) {
        // requete sur la base de donnée
         $sql = "SELECT tb_article.id_article,a_designation,a_pht,qte_cmde,url_image,t_taux, tb_ligne_commande.id_commande, a_pht*(1+tb_tva.t_taux) AS PRIX
                    FROM tb_article,tb_commande,tb_ligne_commande, tb_tva 
                    WHERE tb_article.id_article = tb_ligne_commande.id_article 
                    AND tb_ligne_commande.id_commande = tb_commande.id_commande 
                    AND tb_article.id_tva = tb_tva.id_tva 
                    AND tb_commande.id_commande =$id_commande";
         return $this->db->query($sql);
    }
    public function get_totaux($id_commande) 
    {
            // requete sur la base de donnée
          $sql = "SELECT  SUM(TOTAL_PRIX_ttc) as total_ttc,
          SUM(PRIX_ht) as total_ht, 
          SUM(qte_cmde) as total_quantite
          FROM totaux
          WHERE id_commande=$id_commande";
          return $this->db->query($sql); 
    }
    public function get_quantite_commandee($id_commande,$id_article)
    {
        $sql = "
            SELECT qte_cmde 
            FROM tb_ligne_commande 
            WHERE id_commande= $id_commande
            AND id_article= $id_article
            ";
        return $this->db->query($sql); 
    }

    public function update_quantite_en_stock($query, $id_article) 
    {
        $requete = $query->fetchall();
        var_dump($requete);
        $sql = "UPDATE tb_article 
                SET a_quantite_stock=a_quantite_stock - $query->qte_cmde;
                WHERE id_article = $id_article";

        $this->db->query($sql);    
    }
}
