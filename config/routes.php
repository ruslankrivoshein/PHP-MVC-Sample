<?php
return array(
	'login' 		=> 'user/login',
	'logout'		=> 'user/logout',
	'edittask'		=> 'task/editTask',
	'posttask' 		=> 'task/postTask',
	'page-([0-9]+)' => 'task/getTasks/$1',
	'' 				=> 'task/index',
);
