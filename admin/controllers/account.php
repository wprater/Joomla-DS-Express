<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once('Docusign'.DS.'Client.php');

class DsExpressControllerAccount extends DsExpressController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();
		
		JRequest::setVar( 'view', 'account' );
		JRequest::setVar( 'layout', 'form' );
		JRequest::setVar('hidemainmenu', 1);

		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
	}
    
    function getAccounts()
    {
		$postData = JRequest::get( 'post' );
		
		$endpointMode = strtoupper($postData['mode']);
        $authClient = new Docusign_Client(constant("DsExpressHelper::DS_{$endpointMode}_CREDENTIALS_ENDPOINT"));
		
		$response = $authClient->__soapCall('login', array('parameters' => 
														array('Email' => $postData['email'],
															  'Password' => $postData['password'])));
        if ($response->LoginResult->Success) {
            $out = array();
            foreach($response->LoginResult->Accounts->Account as $account) {
                $out[] = "<option value=\"{$account->AccountID}|{$account->UserID}|{$account->AccountName}\">{$account->AccountName}</option>";
            }
            echo join($out);
            return;
        } else {
            echo $response->LoginResult->AuthenticationMessage;
            return;
        }
    }
    
    function chooseaccount()
    {
		parent::display();        
    }
    
	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
	    if (JRequest::getVar('task') == 'add') {
	        
	    }
		parent::display();
	}

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		$model = $this->getModel('account');

		if ($model->store($post)) {
			$msg = JText::_( 'DS Account Saved!' );
		} else {
			$msg = JText::_( 'Error Saving DS Account' );
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
			$msg = JText::_( 'Error: Your DS Account could not be Deleted' );
		} else {
			$msg = JText::_( 'DS Account Deleted' );
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