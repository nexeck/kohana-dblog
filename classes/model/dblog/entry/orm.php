<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Kohana/dblog
 * @author     Bastian Bräu
 * @todo       Move all the logic which is not ORM related to a seperate class
 *             so that other implementation can use it.
 */
class Model_DBlog_Entry_ORM extends ORM implements Model_DBlog_Entry_Storable
{

	public function __construct($id = NULL)
	{
		$this->_table_name = DBlog::getTableName();
		$this->_primary_val = 'message';
		parent::__construct($id);
		$this->_load();
	}

	public function get_fields()
	{
		return $this->_object;
	}

	public function get_field($key)
	{
		return $this->$key;
	}

	public function get_formatted_field($key)
	{
		switch ($key)
		{
			case 'tstamp': return date('Y-m-d H:i:s', $this->$key);
			default: return $this->$key;
		}
	}

	public function field_name_to_localized_header($field_name)
	{
		try
		{
			switch ($field_name)
			{
				case 'tstamp': return 'Date/time';
				default: return __(Inflector::humanize(ucfirst($field_name)));
			}
		}
		catch (Exception $e)
		{
			throw new DBlog_Exception('Could not transform the field name :name', array(':name' => $field_name));
		}
	}

	public function limit($items_per_page)
	{
		return parent::limit($items_per_page);
	}

	public function offset($offset)
	{
		return parent::offset($offset);
	}

	public function set_type($type)
	{
		$this->type = strtoupper($type);
		return $this;
	}

	public function set_message($message)
	{
		$this->message = $message;
		return $this;
	}

	public function set_details($details)
	{
		$this->details = $details;
		return $this;
	}

	public function save()
	{
		$this->tstamp = time();
		parent::save();
	}

	public function set_substitution_values(array $substitution_values)
	{
		$this->message = strtr($this->message, $substitution_values);
		$this->details = strtr($this->details, $substitution_values);
		return $this;
	}

	public function set_additional_data(array $additional_data)
	{
		foreach ($additional_data as $key => &$value)
		{
			$this->$key = $value;
		}
		return $this;
	}

}