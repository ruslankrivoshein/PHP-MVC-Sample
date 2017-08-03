<?php

class Database
{
		public static function getConnection()
		{
			$paramsPath = ROOT . '/config/connection.php';
			$params = include($paramsPath);
			$db = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']);
			return $db;
		}
}