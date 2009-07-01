<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

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