<?php
/**
 * Hellos Model for Hello World Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license		GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

/**
 * Hello Model
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class DocumentsModelDocuments extends JModel
{
	/**
	 * Hellos data array
	 *
	 * @var array
	 */
	var $_data;


	/**
	 * Retrieves the hello data
	 * @return array Array of objects containing the data from the database
	 */
	function getData()
	{
		// Lets load the data if it doesn't already exist
		if (empty( $this->_data ))
		{
			$query = "SELECT * FROM #__dsexpress_documents";
			$this->_data = $this->_getList( $query );


			$query = "SELECT * FROM #__dsexpress_account";
			$accountData = $this->_getList($query, 0, 1);
		}

		return $this->_data;
	}
}