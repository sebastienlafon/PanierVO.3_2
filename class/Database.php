<?php
/**
 * Description of Database
 * * @author LAFON Sébastien
 */
class Database 
{
    //attributs
    protected $db;   
    // paramètre de connexion       
    private $host = 'localhost';
    private $dbname = 'db_speedymarket';
    private $user = 'root';
    private $password='';
    
    public function __construct() 
    {
        $this->connexion();
    }
    // methodes
    public function connexion() 
    {   
        // connexion à la base de donnée
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
    

