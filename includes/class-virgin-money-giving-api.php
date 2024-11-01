<?php

/**
* 
*/
class Virgin_Money_Giving_Fundraisers {

	/**
	* The API base URL
	*/
	const API_Fundraisers_URL = 'https://api.virginmoneygiving.com/fundraisers/v1/account/';

	/**
	* The API base search URL
	*/
	const API_Fundraisers_Search_URL = 'https://api.virginmoneygiving.com/fundraisers/v1/search';
	
	/**
	* The Virgin Money Giving users resourceId
	* 
	* @var string
	*/
	//private $_resource_id;
	
	/**
	* The Virgin Money Giving pageId
	* 
	* @var string
	*/
	//private $_pageId;
	
	/**
	* The Virgin Money Giving Fundraiser developer key
	* 
	* @var string
	*/
	private $_fundDevelopersKey;
	
	/**
	* Default constructor
	*
	* @param array $config          Virgin Fundraisers configuration data
	* @return void
	*/
	public function __construct($config) {
		//$this->setResourceID($config['resourceId']);
		//$this->setPageID($config['pageId']);
		$this->setDevelopersKey($config['fundDevelopersKey']);
	}

	/**
	* $fundDevelopersKey Setter
	* 
	* @param string $fundDevelopersKey
	* @return void
	*/
	public function setDevelopersKey($fundDevelopersKey) {
		$this->_fundDevelopersKey = $fundDevelopersKey;
	}
	
	/**
	* get the fundraisers page
	* 
	* @param string $resource
	* @param string $pageID
	* @return _makeCall
	*/
	public function get_fundraisers_page_details($resource, $pageID) {
		return $this->_makeCall_fundraisers_page_details($resource, $pageID);
	}
	
	/**
	* get the fundraisers details
	* 
	* @param string $resource
	* @return _makeCall
	*/
	public function get_fundraisers_details($resource){
		return $this->_makeCall_fundraisers_details($resource);
	}
	
	/**
	* get the fundraisers details
	* 
	* @param string $resource
	* @param string $lastname
	* @param string $firstname
	* @return _makeCall
	*/
	public function return_fundraisers_search($resource, $lastname, $firstname){
		return $this->_makeCall_fundraisers_search($resource, $lastname, $firstname);
	}
	
	protected function _makeCall_fundraisers_details($resource) {

		$key = '?api_key='.$this->getDevelopersKey();
		
		$apiCall = self::API_Fundraisers_URL . $resource . $key;
		
		var_dump($apiCall);
		
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $apiCall,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		));
		
		$response = curl_exec($curl);
		
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
			
			//var_dump($response);
			
			$feed = json_decode(json_encode((array) simplexml_load_string($response)),1);
			
			//$feed = new SimpleXMLElement($response);
			
			return $feed;
		}
		
	}

	protected function _makeCall_fundraisers_page_details($resource, $pageID) {

		$key = '?api_key='.$this->getDevelopersKey();
		
		$pageID = '/pages/'.$pageID.'.json';
		$apiCall = self::API_Fundraisers_URL . $resource . $pageID . $key;

		$curl = curl_init();
		
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $apiCall,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		));
		
		$response = curl_exec($curl);
		
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
			
			//$feed = json_decode(json_encode((array) simplexml_load_string($response)),1);

			$feed = json_decode($response);
			
			return $feed;
		}
		
	}

	protected function _makeCall_fundraisers_search($resource, $lastname, $firstname) {

		if ($lastname) {
			$search = '?surname='.$lastname;
			if ($firstname) {
				$search .= '&forename='.$firstname;
			}
			$key = '&api_key='.$this->getDevelopersKey();
			
			$apiCall = self::API_Fundraisers_Search_URL . $search . $key;
			
		}
		
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $apiCall,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		));
		
		$response = curl_exec($curl);
		
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
			
			$feed = new SimpleXMLElement($response);
			
			return $feed;
		}
		
	}
	
	public function getDevelopersKey() {
		return $this->_fundDevelopersKey;
	}
}

