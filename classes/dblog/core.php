<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * @package    dblog
 * @author     Bastian Bräu
 */
abstract class DBlog_Core
{

	public static $omit_types = array();

	protected static $instance;

	/**
	 * @param   string  type of message
	 * @param   string  message
	 * @param   string  details
	 * @param   array   values to replace in the message and details
	 * @param   array   values for additional fields, which must exist in the db table
	 * @return  void
	 */
	public static function add($type,
	                           $message,
	                           $details = '',
	                     array $subst = array(),
	                     array $additional_data = array())
	{
		$type = strtoupper($type);
		try {
			if (FALSE === in_array($type, self::$omit_types))
			{
				$log = ORM::factory('log');
				$log->type = $type;
				$log->message = strtr($message, $subst);
				$log->details = strtr($details, $subst);
				$log->set_additional_data($additional_data);
				$log->save();
			}
		} catch (Exception $e) {
			self::instance()->handle_exception(new DBlog_Exception('Log entry could not be saved: '.$e->getMessage()));
		}
	}

	public static function add_kohana_message($type, $message)
	{    
		$details = '';
		if (Kohana::config('dblog.split') === TRUE)
		{
			$colon_pos = strpos($message, ':');
			if ( (int) $colon_pos > 0)
			{
				$details = trim(substr($message, $colon_pos + 1));
				$message = trim(substr($message, 0, $colon_pos));
			 }
		}
		self::add($type, $message, $details);
	}

	protected function handle_exception(DBlog_Exception $e)
	{
		throw $e;
	}

	protected static function instance()
	{
		if ( ! isset(self::$instance))
		{
			self::$instance = new DBlog;
		}
		return self::$instance;
	}

	protected function __construct() {}
	protected function __clone() {}

}