<?php

/**
 * Description of Panier_view
 *
 * @author Sébastien LAFON
 */
class Panier_view {

    public function afficher_panier($query)
    {
        $tableau = "";
        while ($resultat = $query->fetch(PDO::FETCH_OBJ)) 
        {      
            $tableau .= //concaténation de contenu
                "<table class='tableauPanier'>
                    <caption>Contenu du panier</caption>
                    <tr>
                        <th>image</th>
                        <th>Désignation</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>modification</th>
                    </tr>
                    <tr>
                        <td><img src= \"$resultat->url_image\"/> </td>
                        <td>$resultat->a_designation</td>
                        <td>$resultat->PRIX €</td>
                        <td>$resultat->qte_cmde</td>
                        <td><a href=\"?id_article=$resultat->id_article&action=add\"> Ajouter</a></td>
                        <td><a href=\"?id_article=$resultat->id_article&action=substract\">RETIRER</a> </td>
                        <td><a href=\"?id_article=$resultat->id_article&action=del\"> Supprimer</a></td>
                    </tr>
                </table>";
        }
    return $tableau;
    }
    
    public function afficher_totaux($query) 
    {
        while ($resultat = $query->fetch(PDO::FETCH_OBJ)) 
        {
            $tableau = "<table class=''>
            <caption>TOTAUX</caption>
            <tr><th>total ht</th>
            <th>total ttc</th>
            <th>total quatité</th></tr>
            <tr><td>$resultat->total_ht</td>
            <td>$resultat->total_ttc</td>
            <td>$resultat->total_quantite</td></tr>
            </table>";
        }
        return $tableau;       
    }
}
