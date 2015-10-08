<?php

/*Coucou c moi*/
/**
 * Description of Panier
 *
 * @author jdpaoli
 */
class Panier extends Article {
    
          /**
 * insere un produit dans une ligne de commande
 * @param type int $id_article
 */
          public function Ajouter_Article($idArticle, $idCommande)
          {

/*
 *  Verification de la présence du même article dans la table ligne de commande
 */
            $quantite =$this->Verifier_Article($idArticle, $idCommande);

        /*
         * si l'article est dans déjà inscrit dans une ligne de commande :
         */
                    if ( $quantite != NULL)
                    {   

                        //$quantite = $check['quantite'];
                        echo 'cet article est dans la ligne de commande  ';
                        // on incrémente la quantité
                        $quantite += 1;
                        echo "la quantité est de $quantite";
                        // on met à jour la quantité dans la ligne de commande
                        $this->Update_Article($idArticle, $quantite, $idCommande );
                    }
        /*
         *  si cet article n'existe pas alors :
         *  on l'insere dans une nouvelle ligne de commande avec une quantité initialisée à 1
         */
                   else
                   {                   
                        echo 'c\'est un nouvel article ajouté dans la commande' ;
                        $sql = "INSERT INTO  tb_ligne_commande  (id_article, id_commande, qte_cmde) VALUES  (:id_article, :id_commande, 1) ";           
                        $req = $this->db->prepare($sql);
                        $req->bindValue('id_article',$idArticle, PDO::PARAM_INT);
                        $req->bindValue('id_commande',$idCommande, PDO::PARAM_INT);
                        $req->execute();          
                   }
           }  
           
           public function Supprimer_Article($idArticle, $idCommande){
               $sql = "DELETE  FROM tb_ligne_commande WHERE id_article = :id_article AND id_commande = :id_commande  ";
               $req = $this->db->prepare($sql);
               $req->bindValue('id_article', $idArticle, PDO::PARAM_INT);
               $req->bindValue('id_commande', $idCommande, PDO::PARAM_INT);
               $req->execute();
                   
           }
           
            public function Retirer_Article ($idArticle, $idCommande){

                $qte_cmde = $this->Verifier_Article($idArticle, $idCommande);
                
                    if($qte_cmde != NULL){
                        if($qte_cmde >1){
                            $qte_cmde-=1;
                            echo $qte_cmde;
                                $sql="UPDATE tb_ligne_commande SET qte_cmde = :qte_cmde WHERE id_article = :id_article  AND id_commande = :id_commande ";

                                $req = $this->db->prepare($sql);
                                $req->bindValue('id_article',$idArticle, PDO::PARAM_INT);
                                $req->bindValue('qte_cmde',$qte_cmde, PDO::PARAM_INT);
                                $req->bindValue('id_commande',$idCommande, PDO::PARAM_INT);
                                $req->execute();    
                        }
                        else{                    
                                $this->Supprimer_Article($idArticle, $idCommande);
                        }
                    }
                
            }

            
            public function Verifier_Article($idArticle, $idCommande){
                    // requete pour afficher le contenu de l'article  à partir l'id_article et l'id_commande
                    $sql = "SELECT  * FROM tb_ligne_commande WHERE id_article = $idArticle AND id_commande = $idCommande";
                    // lance la requete
                    $result = $this->db->query($sql);                     
                    // extrait le resultat dans un tableau  associatif d'objet
                    while ($article = $result->fetch(PDO::FETCH_OBJ)) 
                    {
                              $article_check   = [$article->id_article];
                              $quantite_check = [$article->qte_cmde];
                    } 
                    
                    
                    if(isset($article_check[0])){
                        
                        return $quantite_check[0];

                    }
                    else{
                        return NULL;
                    }

            }

           public function Update_Article($id_article, $qte_cmde, $idCommande){       
                    $sql="UPDATE tb_ligne_commande SET qte_cmde = :qte_cmde WHERE id_article = :id_article  AND id_commande = :id_commande ";

                    $req = $this->db->prepare($sql);
                    $req->bindValue('id_article',$id_article, PDO::PARAM_INT);
                    $req->bindValue('qte_cmde',$qte_cmde, PDO::PARAM_INT);
                    $req->bindValue('id_commande',$idCommande, PDO::PARAM_INT);
                    $req->execute();  
           }   

/**
 * TRAITEMENT ARTICLE
 * 
 */    
            public function Traiter_article($action, $article, $commande){

                switch ($action) {
                    case "add":
                        $this->Ajouter_Article($article,$commande);
                        break;
                    case "del":
                        $this->Supprimer_Article($article,$commande);
                        break;    
                     case "substract":
                         $this->Retirer_Article($article,$commande);
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
        public function Creer_commande() { 
             //j'ajoute une nouvelle entrée dans la table commande avec le statut 1 ( commande en cours de validation)
             $sql = "INSERT INTO tb_commande (id_statut) VALUES (1)";
             $req = $this->db->prepare($sql);
             $req->execute();
             
             // j'affiche la dernier entrée de la table commande             
             $sql2="SELECT id_commande FROM tb_commande ORDER  BY id_commande DESC LIMIT 1";
             $resultat=  $this->db->query($sql2);            
             while ($commandes =$resultat->fetch(PDO::FETCH_OBJ)) 
             {
                 $idCommande = [$commandes->id_commande];
             }
             /*
              * Création du cookie
              */
             setcookie("commande", $idCommande[0], time()+3600*24*7);
             
            return $idCommande[0];
         }

         /**
 * 
 *  affiche le  contenu du panier
 */
            public function Afficher_Panier($id_commande) {
                
                // requete sur la base de donnée
                 $sql = "SELECT tb_article.id_article,a_designation,a_pht,qte_cmde,url_image,t_taux, tb_ligne_commande.id_commande, a_pht*(1+tb_tva.t_taux) AS PRIX
                            FROM tb_article,tb_commande,tb_ligne_commande, tb_tva 
                            WHERE tb_article.id_article = tb_ligne_commande.id_article 
                            AND tb_ligne_commande.id_commande = tb_commande.id_commande 
                            AND tb_article.id_tva = tb_tva.id_tva 
                            AND tb_commande.id_commande =$id_commande";
                 
                 $req = $this->db->query($sql);

                $enteteTableau =  '<table class="tableauPanier">
                                                <caption>Contenu du panier</caption>
                                               <tr>
                                                    <th>image</th>
                                                    <th>Désignation</th>
                                                    <th>Prix</th>
                                                    <th>Quantité</th>
                                                    <th></th>
                                                    <th>modification</th>
                                                    <th></th>
                                                </tr>';
                $contenuTableau ="";  
                while ($resultat =$req->fetch(PDO::FETCH_OBJ)) {

                $contenuTableau .= "

                                        <tr>
                                            <td><img src= \"$resultat->url_image\"/> </td>
                                            <td>$resultat->a_designation</td>
                                            <td>$resultat->PRIX €</td>
                                            <td>$resultat->qte_cmde</td>
                                            <td><a href=\"?id_article=$resultat->id_article&action=add\"> Ajouter</a></td>
//                                         <td><a href=\"?id_article=$resultat->id_article&action=substract\">RETIRER</a> </td>
                                            <td><a href=\"?id_article=$resultat->id_article&action=del\"> Supprimer</a></td>
                                        </tr>
                       ";
                }
                $finTableau = '</table>';
                
                $tableau = $enteteTableau
                                 .$contenuTableau
                                 .$finTableau;
                
                return $tableau;
                
         }     

         public function Afficher_($param) {
             
         }        

}




