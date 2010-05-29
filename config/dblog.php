<?php defined('SYSPATH') or die('No direct script access.');

return array(

	'default' => array(
		'db_table_name' => 'log',
		'log_entry_class' => 'Model_DBlog_Entry_ORM',
	),

	'testing' => array(
		'db_table_name' => 'logtest',
	),

);
