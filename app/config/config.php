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
				'private_key' => '593fe6ed77014f9507761028801aa376f141916bd26b1b3f0271b5ec3135b989'
			)

		)
	)
);

date_default_timezone_set('America/New_York');

return $settings;
