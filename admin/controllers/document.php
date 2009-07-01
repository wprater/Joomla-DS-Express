<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class DsExpressControllerDocument extends DsExpressController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
	}

	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
		JRequest::setVar( 'view', 'document' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		$model = $this->getModel('document');

		if ($model->store($post)) {
			$msg = JText::_( 'Template Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Signing Document' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_dsexpress';
		$this->setRedirect($link, $msg);
	}

	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('document');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Templates Could not be Deleted' );
		} else {
			$msg = JText::_( 'Template(s) Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_dsexpress', $msg );
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_dsexpress', $msg );
	}
}