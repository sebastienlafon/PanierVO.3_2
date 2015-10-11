<?php
/**
 * Classe de gestion du panier
 *
 * @author Sébastien LAFON
 */
class Panier_controller  {   

    private $panier_model;
    private $panier_view;
    /**
     * insere un produit dans une ligne de commande
     * @param type int $id_article
     */
    public function ajouter_article($idArticle, $idCommande)
    {/*
        *  Verification de la présence du même article dans la table ligne de commande
        */
          $quantite =$this->verifier_article($idArticle, $idCommande);
        /*
        * si l'article est dans déjà inscrit dans une ligne de commande :
        */
        if ( $quantite != NULL)
        {   
            // on incrémente la quantité
            $quantite += 1;
            // on met à jour la quantité dans la ligne de commande
            $this->panier_model = new Panier_model();
            $this->panier_model->update_article($idArticle, $quantite, $idCommande );
        }
        /*
        *  si cet article n'existe pas alors :
        *  on l'insere dans une nouvelle ligne de commande avec une quantité initialisée à 1
        */
       else
       {                   
           $this->panier_model = new Panier_model();
           $this->panier_model->insert_article_in_db($idArticle, $idCommande);
       }
    }  
   

    /**
     * 
     * @param type $idArticle
     * @param type $idCommande
     */       
    public function retirer_article ($idArticle, $idCommande)
    {  
        $this->panier_model = new Panier_model();
        $qte_cmde = $this->verifier_article($idArticle, $idCommande);
        if($qte_cmde != NULL)
        {   
            if($qte_cmde >1)
            {
                $qte_cmde-=1;
                $this->panier_model->retirer_article($idArticle, $qte_cmde, $idCommande);
            }
            else
            {   
                $this->panier_model->supprimer_article($idArticle, $idCommande);
            }
        }
    }

            
    public function verifier_article($idArticle, $idCommande)
    {   
        $this->panier_model = new Panier_model();
        $result = $this->panier_model->verifier_article($idArticle, $idCommande);       
        // je stocke dans $article le résultat de la requête
        // si il retourne null je ne fais rien de pus
        // sinon je recupere la quantite commandee de cete article
        while ($article = $result->fetch(PDO::FETCH_OBJ)) 
        {
            if ($article===null)
            {
                return NULL;
            }
            else 
            {
                return $article->qte_cmde;
            }
//            $article_check   = [$article->id_article];
//            $quantite_check = [$article->qte_cmde];
//        } 
//            if(isset($article_check[0]))
//        {
//            return $quantite_check[0];
//
//        }
//            else
//        {
//            return NULL;
        }
    }

    public function traiter_article($action, $article, $commande)
    {
        switch ($action) 
        {
        case "add":
            $this->ajouter_article($article,$commande);
            break;
        case "del":
            $this->panier_model = new Panier_model();
            $this->panier_model->supprimer_article($article,$commande);
            break;    
         case "substract":
             $this->retirer_article($article,$commande);
            break;
        default:
            break;
        }   
    }   
        
    /**
     * Creer_commande() : créer une nouvelle commande
     * la création d'une commande crée automatiquement un cookie qui contiendra l'id de la commande
     * 
     */
    public function create_commande() 
    { 
        $this->panier_model = new Panier_model();    
        $this->panier_model->create_commande();
        $resultat = $this->panier_model->get_last_id_commande();
        $idCommande = $resultat->fetch();

        /*
         * Création du cookie
         */
        setcookie("commande_speedymarket", $idCommande[0], time()+3600*24*7);

       return $idCommande[0];
    }

    /**
    * 
    *  affiche le  contenu du panier
    */
    public function afficher_panier($id_commande) 
    {    
        $this->panier_model = new Panier_model();           
        $query = $this->panier_model->get_articles($id_commande);
        $this->panier_view = new Panier_view();
        return $this->panier_view->afficher_panier($query);
        
    }     

    public function afficher_totaux($id_commande) 
    {
        $this->panier_model = new Panier_model();
        $query = $this->panier_model->get_totaux($id_commande);
        $this->panier_view = new Panier_view();
        return $this->panier_view->afficher_totaux($query);
        

    }
         
//public function mise_a_jour_stock($idarticle) {
//              // requete sur la base de données  
///*récupération du stock pouir l'article sélectionné*/
//$sql="SELECT a_quantite_stock FROM tb_article WHERE id_article=$idcommande";
//    $req = $this->db->query($sql);
//    
//$sql = "UPDATE tb_article 
//        SET a_quantite_stock=a_quantite_stock- $resultat->qte_cmde;
//        WHERE id_article = $idarticle";
//
//    $req = $this->db->query($sql);
//               
//             
//         }

}




