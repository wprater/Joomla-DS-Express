<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class DsExpressHelper
{
    const DS_DEMO_CREDENTIALS_ENDPOINT  = 'https://demo.docusign.net/api/3.0/credential.asmx?wsdl';
    const DS_DEMO_API_ENDPOINT          = 'https://demo.docusign.net/api/3.0/api.asmx?wsdl';
    const DS_PROD_CREDENTIALS_ENDPOINT  = 'https://www.docusign.net/api/3.0/credential.asmx?wsdl';
    const DS_PROD_API_ENDPOINT          = 'https://www.docusign.net/api/3.0/api.asmx?wsdl';
        
    function isGuestUser()
    {
        $userData =& JFactory::getUser();
        return (1 == $userData->guest);
    }
    
	function getDocument($id)
	{
		$db	=& JFactory::getDBO();
		$result	= null;

		$db->setQuery(<<<SQL
		SELECT id, name FROM `#__dsexpress_documents`
		WHERE id = {$id}
SQL
);
		$result = $db->loadObject();

		if ($db->getErrorNum()) {
			JError::raiseWarning( 500, $db->stderr() );
		}

		return $result;
	}
    
    function getDsAccountData()
    {
        $db =& JFactory::getDBO();
		// Get DS account data
		$query = "SELECT * FROM `#__dsexpress_accounts` LIMIT 1";
		$db->setQuery($query);
		$data = $db->loadObject();
		if (!$data) {
			$data = new stdClass();
			$data->id = 0;
		}

		return $data;
    }
    
    function getSigningDocument($id)
    {
        $db =& JFactory::getDBO();
		$db->setQuery(<<<SQL
    		SELECT * FROM `#__dsexpress_documents`
    		WHERE id = {$id}
SQL
);
		return $db->loadObject();
    }

    function connectToApi()
    {
        $accountData = $this->getDsAccountData();
        $stringEncrypt = new StringEncrypt();
        $docusignClient = new Docusign_Client();
        $docusignClient->setCredentials($accountData->userId, $stringEncrypt->decrypt($accountData->password));

        return $docusignClient;
    }
}