<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');


set_include_path(get_include_path() 
				. PATH_SEPARATOR
				. JPATH_ADMINISTRATOR.DS.'components'.DS.'com_dsexpress'.DS.'lib');

// require_once (dirname(dirname(__FILE__)).DS.'helper.php');
require_once('Docusign'.DS.'Envelope.php');


class DsExpressModelAccount extends JModel
{
	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		parent::__construct();

        // $array = JRequest::getVar('cid',  1, '', 'array');
        // $this->setId((int)$array[0]);
	}

    // function setId($id)
    // {
    //  // Set id and wipe data
    //  $this->_id      = $id;
    //  $this->_data    = null;
    // }

	function &getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$this->_db->setQuery(<<<SQL
			SELECT * FROM `#__dsexpress_accounts`
			LIMIT 1
SQL
);
			$this->_data = $this->_db->loadObject();
		}
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->email = '';
			$this->_data->password = '';
		}
		return $this->_data;
	}

	/**
	 * Method to store a record
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function store()
	{	
		$row =& $this->getTable();
		$postData = JRequest::get( 'post' );
        
        $parts = explode('|', $postData['accountId']);
        $postData['accountId'] = $parts[0];
        $postData['userId'] = $parts[1];
        $postData['accountName'] = $parts[2];        
        $stringEncrypt = new StringEncrypt();
        $postData['password'] = $stringEncrypt->encrypt($postData['password']);
        $endpointMode = strtoupper($postData['mode']);
        $postData['endpoint'] = constant("DsExpressHelper::DS_{$endpointMode}_API_ENDPOINT");
        $postData['mode'] = $postData['mode'];
		
		// Bind the form fields to the table
		if (!$row->bind($postData)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the record is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the web link table to the database
		if (!$row->store()) {
			$this->setError( $row->getErrorMsg() );
			return false;
		}

		return true;
	}

	/**
	 * Method to delete record(s)
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function delete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$row =& $this->getTable();

		if (count( $cids )) {
			foreach($cids as $cid) {
				if (!$row->delete( $cid )) {
					$this->setError( $row->getErrorMsg() );
					return false;
				}
			}
		}
		return true;
	}

}