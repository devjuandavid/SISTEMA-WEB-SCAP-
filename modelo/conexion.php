<?php

Class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=scap_db",
						"root",
						"");

		$link->exec("set names utf8mb4");

		return $link;

	}

}
