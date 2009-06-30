<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

set_include_path(get_include_path() 
				. PATH_SEPARATOR
				. JPATH_ADMINISTRATOR.DS.'components'.DS.'com_hello'.DS.'lib');

// Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');

// Require specific controller if requested
if($controller = JRequest::getVar('controller')) {
	require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
}

// Create the controller
$classname	= 'HelloController'.$controller;
$controller = new $classname();

// Perform the Request task
$controller->execute( JRequest::getVar('task'));

// Redirect if set by the controller
$controller->redirect();
