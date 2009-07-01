<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

set_include_path(get_include_path() 
				. PATH_SEPARATOR
				. JPATH_ADMINISTRATOR.DS.'components'.DS.'com_dsexpress'.DS.'lib');

// Require the base controller
require_once(JPATH_COMPONENT.DS.'controller.php');
require_once(JPATH_COMPONENT.DS.'helper.php');

// Require specific controller if requested
if($controller = JRequest::getWord('controller', 'documents')) {
    // Go to account setup if there are no accounts
    $accountData = DsExpressHelper::getDsAccountData();
    if (0 == $accountData->id) {
        JRequest::getVar('task', 'add');
        $controller = 'account';
    }
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}

// Add the sub menu
JSubMenuHelper::addEntry(JText::_('Documents'), 'index.php?option=com_dsexpress&controller=documents');
JSubMenuHelper::addEntry(JText::_('DS Account Settings'), 'index.php?option=com_dsexpress&controller=account');

// Create the controller
$classname	= 'DsExpressController'.$controller;
$controller	= new $classname( );

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );

// Redirect if set by the controller
$controller->redirect();