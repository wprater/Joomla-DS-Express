<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class DsExpressControllerDocuments extends DsExpressController
{
    function __construct()
	{
		parent::__construct();

		JRequest::setVar( 'view', 'documents' );
        // JRequest::setVar( 'layout', 'form'  );
        // JRequest::setVar('hidemainmenu', 1);
        
        // Go to account setup if there are no accounts
        $accountData = DsExpressHelper::getDsAccountData();
        // var_dump($accountData);die;
            //         if ($accountData->id == 0) {
            //             $link = 'index.php?option=com_dsexpress&controller=account&task=new';
            // $this->setRedirect($link, $msg);
            //         }
		
	}
	
	function display()
	{
		parent::display();
	}

}