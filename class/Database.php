<?php
/**
 * Database se connecte à la DB speedymarket en PDO
 * * @author LAFON Sébastien
 */
class Database 
{
    /**
     *
     * @var objet de type PDO statement connexion à la DB visible seulement 
     * à l'intérieur de cette classe et des classes filles
     */
    protected $db;
    /**
     *
     * @var string nom d'hôte pour la DB  
     */
    private $host = 'localhost';
    /**
     *
     * @var string nom de la base de données 
     */
    private $dbname = 'db_speedymarket';
    /**
     *
     * @var string nom d'utilisateur de la DB 
     */
    private $user = 'root';
    /**
     *
     * @var string  mot de passe de l'utilisateur de la DB 
     */
    private $password='';
    

    public function __construct() 
    {
        $this->connexion();
    }
    /**
     * fonction de connexion à la base de données
     * utilise les variables de connexion PDO dans un objet db
     */
    public function connexion() 
    {   
        try
        {
            $this->db = new PDO('mysql:host='.$this->host.';
                dbname='.$this->dbname.';charset=utf8', $this->user, $this->password,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));	
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }      
     }    
}
    

