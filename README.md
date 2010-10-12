# Kohana database log writer

## Status

### alpha

## Requirements

-	[Database module](http://github.com/kohana/database)
-	[ORM module](http://github.com/kohana/orm)
-	[Pagination module](http://github.com/kohana/pagination)

## Installation

Register the module in bootstrap.php:

	Kohana::modules(array(
		[...]
		'dblog'      => MODPATH.'dblog',
	));

Create a database table, based on default.sql. Additional fields can be added.

If you want to store all Kohana::$log messages in the database too:

1.	In bootstrap.php change

		Kohana::$log->attach(new DBlog_Writer());

	to

		Kohana::$log->attach(new Kohana_Log_Db());

	**Make sure this line appears after the call of Kohana::modules().**

2.	In the same file add

		Kohana_Log::$timestamp = 'U';

## Configuration

TODO

## Using additional fields

### Setting a default value (e.g. in bootstrap.php)

TODO

### Setting values on a per entry basis

	DBlog::add('category', 'title', 'details', array(), array(
		'myVarDump' => $myVar,
	));

## View

Storing the rendered view of all log entries in *$log_table*:

	$log_table = Request::factory('dblog/index')->execute()->response;

## Unit tests

TODO

## License

[ISC License](http://opensource.org/licenses/isc-license.txt)
