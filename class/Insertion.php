<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Insertion
 *
 * @author jdpaoli
 */
class Insertion extends Database {
    //put your code here
    
    public function inserer_des_produits($produits) {
                  
          $sql = 'INSERT INTO tb_produit (nom_produit, qte_produit) VALUE (:nom_produit, :qte_produit)';
          $req = $this->db->prepare($sql);
          
          foreach ($produits as $value) {
              $req->execute($value);
          }         
        echo'produits enregistrés en base de donnée !!';
    }
}
