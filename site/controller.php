<?php

jimport('joomla.application.component.controller');


require_once('Docusign'.DS.'Envelope.php');
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_dsexpress'.DS.'helper.php');

class DocumentController extends JController
{
	var $_envelope; 
	
	function sign()
	{
	    // Exit if user is not signed in
        if (DsExpressHelper::isGuestUser()) {
            return;
        }        
		$userData =& JFactory::getUser();

		// Get DS account data
		$accountData = DsExpressHelper::getDsAccountData();

		$this->_envelope = new Docusign_Envelope(
	        $accountData->endpoint, 
			array('userId' => $accountData->userId, 
				'password' => $accountData->password)
		);
        
        // Get the document that is being signed
		$documentId = (int) JRequest::getVar('id');
		$signingData = DsExpressHelper::getSigningDocument($documentId);
        $templateResult = $this->_envelope->RequestTemplate(array('TemplateID' => $signingData->dsTemplateId, 
																  'IncludeDocumentBytes' => true))
															->RequestTemplateResult;
		// Get the envelope data from the stored template
		$templateEvelope = $templateResult->Envelope;
		$firstDocument = $templateEvelope->Documents->Document;

		// Setup the template params to the envelope
		$this->_envelope->setTemplateEnvelope($templateEvelope);

		// Set the required Envelope parameters		
        // $this->_envelope->AccountId = $accountData->accountId;
        $this->_envelope->Subject = $signingData->subject;
        $this->_envelope->EmailBlurb = $signingData->emailBlurp;

		// Authentication assertions
        $this->_envelope->AssertionID = $userData->username;
        $this->_envelope->AuthenticationInstant = date('Y-m-d\Th:m:s', strtotime($userData->lastvisitDate)) . 'Z';
        $this->_envelope->AuthenticationMethod = 'Password';
        $this->_envelope->SecurityDomain = 'Joomla Built-in Auth';

        // Remove everything leading up to // for the base URI
        $this->_envelope->setupDefaultCallbackUrls(array_pop(explode('//', JURI::base())), 
                                                    '?option=com_dsexpress&view=callback', '&type=');
		
		// Add logged in Joomla user as the recipient
		$captiveUserId = (string) uniqid();
        $captiveInfo = array('ClientUserId' => $captiveUserId);
        $this->_envelope->addRecipient($userData->name, $userData->email, null, $captiveInfo);

        // Create the Envelope
        $envelopeId = $this->_envelope->CreateAndSendEnvelope(
                                        $this->_envelope->getTemplateEnvelopeParams())
                                            ->CreateAndSendEnvelopeResult->EnvelopeID;
        $this->_envelope->setEnvelopeId($envelopeId);

        // Fetch the embedded URL
        $signingEmbeddedUrl = $this->_envelope
                                ->RequestRecipientToken($this->_envelope->getRequestRecipientTokenParams())
                                ->RequestRecipientTokenResult;
        
        echo $signingEmbeddedUrl;
	}
	
	/**
	 * Method to display the view
	 *
	 * @access	public
	 */
	function display()
	{
		parent::display();
	}

}
