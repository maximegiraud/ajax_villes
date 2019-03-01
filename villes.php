<?php
include('config/config.php');
try
{
    /*Connection au serveur*/

    $dbh = new PDO(DB_SGBD.':host='.DB_SGBD_URL.';dbname='.DB_DATABASE.';charset='.DB_CHARSET, DB_USER, DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    /*Récupérer code postal dans la chaine de requete*/
    
    if(array_key_exists('id',$_GET) && $_GET['id'] !='')
    {
        $code_postal = $_GET['id'];
        

        /*Préparation de ma requete SQL*/

        $sth = $dbh->prepare('SELECT * FROM villes WHERE ville_code_postal LIKE :code_postal');

        /*Execution de la requete SQL avec bindage du code postal reçu dans la requete*/

        $sth->bindValue(':code_postal', $code_postal.'%', PDO::PARAM_STR);       
        $sth->execute();

        /*Recuperation du jeu d'enregistrement*/

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        /*Affichage du jeu d'enregistrement*/

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    
    
    //include('tpl/villes.phtml');
}
catch(PDOException $e)
{
    echo 'Une erreur s\'est produite : '.$e->getMessage();
}

/*Tester tout ça
1.connexion
2.requete simple avec un code postal en dur
3.execute et on affiche */
