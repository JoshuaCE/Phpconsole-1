<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Users
	|--------------------------------------------------------------------------
	|
	| Add users in an array as show in the example below. You can add as many
	| users as you like. The nickname will identify a user when sending data to
	| a user's Phpconsole and must be unique.
	|
	*/

	'users' => array(

		'nickname' => array(
			'user_key'    => '',
			'project_key' => '',
		),

	),

	/*
	|--------------------------------------------------------------------------
	| Default user
	|--------------------------------------------------------------------------
	|
	| You can set a default user by specifying a user nickname set in the users
	| users array. This is especially usefull for different configuration 
	| environments. You can set yourself as default user in your own
	| development environment and the package will automatically set a user
	| cookie for you. Data send to Phpconsole will be automatically send to
	| your own Phpconsole project.
	|
	*/

	'default' => '',

);