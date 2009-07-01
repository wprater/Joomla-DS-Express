<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class DsExpressViewDocuments extends JView
{
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'DS Express Manager' ), 'generic.png' );
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

		// Get data from the model
		$items = & $this->get('Data');

		$this->assignRef('items', $items);

		parent::display($tpl);
	}
}