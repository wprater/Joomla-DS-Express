<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once(dirname(__FILE__).DS.'helper.php');
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_dsexpress'.DS.'helper.php');

// Get the document id or default to the first one
$signingDocument = DsExpressHelper::getDocument($params->get('id', 0));

if ($signingDocument && $signingDocument->id ) {
    $layout = JModuleHelper::getLayoutPath('mod_dsexpress');
	$name = $signingDocument->name;
	
	require($layout);
}