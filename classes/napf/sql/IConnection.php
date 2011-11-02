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
}