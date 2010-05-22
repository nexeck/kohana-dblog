# Status

## pre-alpha

# Requirements

-	Database module
-	Pagination module, if default view is used

# Installation

1.	In bootstrap.php change

		Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));

	to

		Kohana::$log->attach(new Kohana_Log_Db());

2.	In the same file add

		Kohana_Log::$timestamp = 'U';

# Configuration (?)

# Using additional fields

## Setting a default value (e.g. in bootstrap.php)

	DBlog::setAdditionalField('ip', getenv('REMOTE_ADDR'));

## Setting values on a per entry basis

	DBlog::add('category', 'title', 'details', array(
		'myVarDump' => $myVar,
	));