<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * @package    dblog
 * @author     Bastian Bräu
 */
abstract class DBlog_Core
{

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
		try {
			$type = strtoupper($type);
			$log = ORM::factory('log');
			$log->type = $type;
			$log->message = strtr($message, $subst);
			$log->details = strtr($details, $subst);
 			$log->set_additional_data($additional_data);
			$log->save();
		} catch (Exception $e) {
			self::instance()->handle_exception(new DBlog_Exception('Log entry could not be saved: '.$e->getMessage()));
		}
	}

	public static function add_kohana_message($type, $message)
	{
		// TODO check time format (unix time stamp)
		// TODO (?) split message on first : and use remainder as details
		self::add($type, $message);
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