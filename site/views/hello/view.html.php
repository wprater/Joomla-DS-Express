<?php
/**
 * Hello View for Hello World Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:components/
 * @license		GNU/GPL
 */

jimport( 'joomla.application.component.view');

class HelloViewHello extends JView
{
	function display($tpl = null)
	{
		$greeting = $this->get( 'Greeting' );
		$this->assignRef( 'name',	$greeting );

		parent::display($tpl);
	}
}
?>
