<?php
namespace demo\servlets;

class HelloAction extends \napf\core\Servlet
{
    public function doGet(\napf\core\ServletRequest &$request, \napf\core\ServletResponse &$response)
    {
        // passage de variable
        //$request->setAttribute("var", "Bonjour");

        // récupération de la connection par défaut du context
        //$connection = \napf\core\HttpSession::getServletContext()->getConnection();

        // execution d'une requete
        //var_dump($connection->doQuery("select * from annonce"));

        // utilisation d'une dao
        //$dao = new \napf\dao\SqlDAO('annonce', $connection);
        //var_dump($dao->getAll());


        // utilisation du bean créé par le dao
        //$annonce = new \beans\AnnonceBean($connection, 1);
        //var_dump($annonce->getAnn_texte());

        // utilisation de l'authentification
        //$login = \napf\auth\LoginContextFactory::get("demo");
        //$login->login('admin','login');
        
        $request->getRequestDispatcher("/hello.php")->forward($request, $response);
    }
}