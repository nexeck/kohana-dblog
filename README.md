# Kohana database log writer

## Status

### Beta

## Requirements

-	[Database module](http://github.com/kohana/database)
-	[ORM module](http://github.com/kohana/orm)
-	[Pagination module](http://github.com/kohana/pagination)

## Installation

Register the module in bootstrap.php:

	Kohana::modules(array(
		[...]
		'dblog' => MODPATH.'dblog',
	));

Create a database table, based on default.sql. Additional fields can be added.

If you want to store all Kohana::$log messages in the database too:

1.	In bootstrap.php change
		
		Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));

	to

		Kohana::$log->attach(new DBlog_Writer());

	**Make sure this line appears after the call of Kohana::modules().**

2.	In the same file add

		Kohana_Log::$timestamp = 'U';

## Basic usage

	DBlog::add('NOTICE', 'Log demo title', 'Log demo details: :params', array(':params' => chr(10).print_r($_GET, TRUE)));

## Using additional fields

	DBlog::add('category', 'title', 'details', array(), array(
		'client_ip' => getenv('REMOTE_ADDR'),
		'url' => getenv('REQUEST_URI'),
	));

## View

Storing the rendered view of all log entries in `$log_table`:

	$log_table = Request::factory('dblog/index')->execute()->response;

## License

[ISC License](http://opensource.org/licenses/isc-license.txt)
