<?php
/**
 * Hello World table class
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license		GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Hello Table class
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class TableDocument extends JTable
{
	var $id = null;
	var $name = null;
	var $subject = null;
	var $emailBlurp = null;
	var $documentName = null;
	var $dsTemplateId = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableDocument(& $db) {
		parent::__construct('#__dsexpress_documents', 'id', $db);
	}
}