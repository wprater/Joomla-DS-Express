<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

class DsExpressModelDocuments extends JModel
{
	var $_data;


	function getData()
	{
		// Lets load the data if it doesn't already exist
		if (empty( $this->_data ))
		{
			$query = "SELECT * FROM `#__dsexpress_documents`";
			$this->_data = $this->_getList( $query );


			$query = "SELECT * FROM `#__dsexpress_accounts`";
			$accountData = $this->_getList($query, 0, 1);
		}

		return $this->_data;
	}
}