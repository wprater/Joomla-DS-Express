<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

require_once('Docusign'.DS.'Envelope.php');


class DsExpressModelDocument extends JModel
{
	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		parent::__construct();

		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}

	function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}

	function &getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$this->_db->setQuery(<<<SQL
			    SELECT * FROM `#__dsexpress_documents`
				WHERE id = {$this->_id}
SQL
            );
			$this->_data = $this->_db->loadObject();
		}
		if (!$this->_data) {
			$this->_data =& $this->getTable();
            // $this->_data->id = 0;
            // $this->_data->name = null;
            // $this->_data->subject = null;
		}
		return $this->_data;
	}

	/**
	 * Method to store a record
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function store()
	{	
		$row =& $this->getTable();
		$postData = JRequest::get( 'post' );
        
		// Get account data
		$accountData = DsExpressHelper::getDsAccountData();
		$dsApiHelper = new Docusign_Envelope(
	        $accountData->endpoint, 
			array('userId' => $accountData->userId, 
				'password' => $accountData->password)
		);
		// Save template to DS Account
        try {
            // $postData['documentName'] = $_FILES['document_upload']['name'];
            $doc = simplexml_load_file($_FILES['document_upload']['tmp_name']);
            $dpdTempalteXml = $doc->asXML();

            $uploadTemplateResult = $dsApiHelper->UploadTemplate(
                                            array('Shared' => false,
                                                'TemplateXML' => $dpdTempalteXml, 
                                                'AccountID' => $accountData->accountId))
                                                ->UploadTemplateResult;
        } catch(Exception $e) {
            $this->setError($e);
            return false;
        }
        // die(var_dump($uploadTemplateResult));
        if (!$uploadTemplateResult->Success) {
            $this->setError('There was an error uploading the DPD.');
			return false;
        } else {
    		$postData['documentName'] = $uploadTemplateResult->Name;
    		$postData['dsTemplateId'] = $uploadTemplateResult->TemplateID;
        }

		
		// Bind the form fields to the table
		if (!$row->bind($postData, array('document_upload'))) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the record is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the web link table to the database
		if (!$row->store()) {
			$this->setError( $row->getErrorMsg() );
			return false;
		}

		return true;
	}

	/**
	 * Method to delete record(s)
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function delete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$row =& $this->getTable();

		if (count( $cids )) {
			foreach($cids as $cid) {
				if (!$row->delete( $cid )) {
					$this->setError( $row->getErrorMsg() );
					return false;
				}
			}
		}
		return true;
	}

}