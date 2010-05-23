<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Database log writer.
 *
 * @package    Kohana/dblog
 * @category   Logging
 * @author     Bastian Bräu
 * @copyright  (c) 2010 Bastian Bräu
 * @license    ISC http://opensource.org/licenses/isc-license.txt
 */
class Kohana_Log_Db extends Kohana_Log_Writer {

	/**
	 * @param   array messages
	 * @return  void
	 */
	public function write(array $messages) {
		foreach ($messages as $message) {
			DBlog::addKohanaMessage($message['type'], $message['body'], $message['time']);
		}
	}

}