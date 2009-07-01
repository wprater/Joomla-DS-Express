<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class DsExpressViewDocument extends JView
{

	function display($tpl = null)
	{
		$document =& $this->get('Data');
		$isNew = ($document->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Document' ).': <small><small>[ ' . $text.' ]</small></small>' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->assignRef('document', $document);

		parent::display($tpl);
	}
}