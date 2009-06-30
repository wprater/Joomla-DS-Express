<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class JElementSigningdocument extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Signingdocument';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT a.id, a.name'
		. ' FROM #__dsexpress_documents AS a'
		. ' ORDER BY a.name'
		;
		$db->setQuery( $query );
		$options = $db->loadObjectList();

		array_unshift($options, JHTML::_('select.option', '0', '- '.JText::_('Select Document').' -', 'id', 'name'));

		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', 'class="inputbox"', 'id', 'name', $value, $control_name.$name );
	}
}
