<?php
namespace napf\sql;

interface IConnection
{
    /**
     * Exectute une requête
     * @param string $query (select * from table where champ=:field)
     * @param array $bind (':field'=>$var)
     */
    function doQuery($query, array $bind = null);

    /**
     * Ferme la connexion en cours
     */
    function close();

    /**
     * Retourne la liste des tables d'une base de données
     * @return array
     */
    function getTables();

    /**
     * Retourne la liste des champs d'une table
     * @param string $table
     * @param string $fields - champ retour
     * @param string $primary - champ retour
     * @return array
     */
    function getFields($table, &$fields, &$primary);
}