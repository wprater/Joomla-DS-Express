<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class TableAccount extends JTable
{
	var $id = null;
	var $email = null;
	var $userId = null;
	var $password = null;
	var $accountId = null;
	var $accountName = null;
	var $endpoint = null;
	var $mode = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableAccount(& $db) {
		parent::__construct('#__dsexpress_accounts', 'id', $db);
	}
}