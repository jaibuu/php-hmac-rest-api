<?php

/**
 * Settings to be stored in dependency injector
 */

$settings = array(
	'database' => array(
		'adapter' => 'Sqlite',	/* Possible Values: Mysql, Postgres, Sqlite */
		'host' => '',
		'username' => '',
		'password' => '',
		'name' => 'saveit',
		'port' => 3306
	),
	'data' => array(
		'clients' => array(
			'1' => array (
				'private_key' => '8c484c8c89547cncy4mc8nzxbcvi4eba66e10fba74dbf9e99c22f'
			)

		)
	)
);

date_default_timezone_set('America/New_York');

return $settings;
