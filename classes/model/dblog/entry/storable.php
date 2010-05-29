<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Kohana/dblog
 * @author     Bastian Bräu
 */
interface Model_DBlog_Entry_Storable {

	public function setType($type);
	public function setMessage($message);
	public function setDetails($details);
	public function setSubstitutionValues(array $substitutionValues);
	public function setAdditionalData(array $additionalData);
	public function save();

}