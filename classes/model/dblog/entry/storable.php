<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Kohana/dblog
 * @author     Bastian Bräu
 */
interface Model_DBlog_Entry_Storable
{

	public function get_formatted_field($field_name);
	public function field_name_to_localized_header($field_name);
	public function set_type($type);
	public function set_message($message);
	public function set_details($details);
	public function set_substitution_values(array $substitution_values);
	public function set_additional_data(array $additional_data);

	// ORM provides these by default:
	public function count_all();
	public function find_all();
	public function limit($items_per_page);
	public function offset($offset);
	public function pk();
	public function save();

}