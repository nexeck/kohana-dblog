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

In `bootstrap.php` change

	Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));

to

	Kohana::$log->attach(new DBlog_Writer());

**Make sure this line appears after the call of Kohana::modules().**

## Basic usage

	DBlog::add('NOTICE', 'Log demo title', 'Log demo details: :params', array(':params' => chr(10).print_r($_GET, TRUE)));

## Using additional fields

	DBlog::add('category', 'title', 'details', array(), array(
		'client_ip' => getenv('REMOTE_ADDR'),
		'url' => getenv('REQUEST_URI'),
	));

## Configuration (optional)

-	Copy `modules/dblog/config/dblog.php` to `application/config/`
-	You can change the log table name and pagination settings

## Controller / rendering the log table

The controller should not be accessed directly. You can embed it in your controller with an internal request.

Example with [`Controller_Demo`](http://kerkness.ca/wiki/doku.php?id=template-site:extending_the_template_controller):

	$this->template->content = Request::factory('dblog/index')->execute()->response;

## Ignoring certain log types

You can omit log entries of certain types (e.g. in production environments) by setting the static `$omit_types` property.

Example in `bootstrap.php`:

	if (Kohana::$environment === Kohana::PRODUCTION)
	{
		DBlog::$omit_types = array('NOTICE');
	}

## License

[ISC License](http://opensource.org/licenses/isc-license.txt)
