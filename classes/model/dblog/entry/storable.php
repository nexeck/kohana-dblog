<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Kohana/dblog
 * @author     Bastian Bräu
 */
interface Model_DBlog_Entry_Storable {

	public function getFormattedField($fieldName);
	public function fieldNameToLocalizedHeader($fieldName);
	public function setType($type);
	public function setMessage($message);
	public function setDetails($details);
	public function setSubstitutionValues(array $substitutionValues);
	public function setAdditionalData(array $additionalData);

	// ORM provides these by default:
	public function count_all();
	public function find_all();
	public function limit($itemsPerPage);
	public function offset($offset);
	public function pk();
	public function save();

}