<?php
require_once ('autoloader.php');
/**
 * Description of Article_controller
 *
 * @author Sébastien LAFON
 */
class Article_controller {
    /**
     *
     * @var objet Article_model
     */
    private $article_model;
    /**
     *
     * @var objet Article_view
     */
    private $article_view;

    /**
     * Crée et affiche une liste d'articles 
     * @return string tableau html
     */
    public function creer_liste_articles() 
    {
        $this->article_model = new Article_model();
        $liste_articles = $this->article_model->get_articles_from_db();
        $this->article_view = new Article_view();
        $liste_html = $this->article_view->afficher_articles($liste_articles);
        return $liste_html;
    }
    
}
