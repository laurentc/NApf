<?php
namespace napf\sql;

interface IConnection {
	/**
	 * Exectute une requête
	 * @param string $query (select * from table where champ=:field)
	 * @param array $bind (':field'=>$var)
	 */
	public function doQuery($query, array $bind = null);
	/**
	 * Ferme la connexion en cours
	 */
	public function close();
	/**
	 * Retourne la liste des tables d'une base de données
	 * @return array
	 */
	public function getTables();
	/**
	 * Retourne la liste des champs d'une table
	 * @param string $table
	 * @param string $fields - champ retour
	 * @param string $primary - champ retour
	 * @return array
	 */
	public function getFields($table, &$fields, &$primary);
}