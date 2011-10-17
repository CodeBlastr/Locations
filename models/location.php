<?php
class Location extends AppModel {
	var $name = 'Location';
	
	var $response;
	var $ip;
		
	/* 
	 * function add() saves the data in locations table
	 * parameters $foreign_key, $data of model, restricted and available ip's
	 * data for available and restricted fields should be a value or a empty string
	 * it should not be null value 
	 */ 

	function add($foreign_key = null, $model = null, $data = null) {
		if (!empty($data['Location']['available']) || !empty($data['Location']['restricted'])) : 
			$data['Location']['foreign_key']= $foreign_key;
			$data['Location']['model'] = $model;
			$ret = false;
			if ($existing_id = $this->field('id', array( 
					'foreign_key'=>$foreign_key, 'model'=>$model))) {
						$data['Location']['id'] = $existing_id;
					}
			if ($this->save($data)) {
				$ret = true;
			}
			return $ret;
		endif;
	}
	
	/*
	 * function get_ip() of client from where client requests data
	 */
	function get_ip() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  //check ip from share internet
			$this->ip=$_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
			$this->ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$this->ip=$_SERVER['REMOTE_ADDR'];
		}
		return $this->ip;
	}
	
	/*
	 * function get_location ()  used to get location of client ip address
	 */
	function get_location () {
		App::import('Model', 'CakeSession');
		$this->Session = new CakeSession(); 
		if ($this->Session->read('Auth.User.zip')) {
			# put zip return here.
			$this->response['zipCode'] = $this->Session->read('Auth.User.zip');
		} else {
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_TIMEOUT, 5);
	        curl_setopt($ch, CURLOPT_URL, "http://api.ipinfodb.com/v3/ip-city/?key=989f5aa44ad0d14ee67b3aae454fd284816b94202fa52d52d9fe3b33037dad87&ip={$this->get_ip()}&format=json");
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	    curl_setopt($ch, CURLOPT_HEADER, 0);
	        curl_setopt($ch, CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	        $this->response = json_decode(curl_exec($ch), true);
	        //$this->response = curl_exec($ch);
	        curl_close($ch);
		}
	}
	function get_city () {
		$this->get_location();
		return $this->response['cityName'];
	}
	
	function get_country () {
		$this->get_location();
		return $this->response['countryName'];
	}
	
	/*
	 * function get_zip () used to get zip code of client from location
	 */
	function get_zip () {
		$this->get_location();
		return $this->response["zipCode"];
	}
	
	/*
	 *  function get_foreign_keys() used to get foreign key on basis of ModelName, user's ip address
	 *  parameter $model=  ModelName
	 *  
	 *  to be used for complex algos
						'OR' => array( 
							array('OR' => array('Location.available LIKE' => "%{$this->get_zip()}%",
											'Location.restricted NOT LIKE' => "%{$this->get_zip()}%")),
							array('AND' =>array('Location.available' => "",
												'Location.restricted' => "")
						),
						))
	 */
	function get_restricted_keys($model = null) {
		if ($this->get_zip()) {
			$fkeys = $this->find('list', array(
				'fields' => array( 'id' , 'foreign_key'),
				'conditions' => array(
					'Location.model' => $model,
					'Location.restricted LIKE' => "{$this->get_zip()}",
					)
				));
		} else {
			$fkeys = $this->find('list', array(
				'fields' => array( 'id' , 'foreign_key'),
				'conditions' => array(
					'Location.model' => $model,
					'Location.restricted >' => 0,
					)
				));
		}
		$restricted_list = implode(',', ($fkeys));
		return $restricted_list;
	}
	
	/*
	 * gives back available items if current zip code is present in it. also returns the zip codes which has no data.
	 */
	function get_available_keys($model = null) {
		if ($this->get_zip()) {
			$fkeys = $this->find('list', array(
				'fields' => array('id', 'foreign_key'),
				'conditions' => array('Location.model' => $model,
					'OR' => array(
						'Location.available LIKE' => "%{$this->get_zip()}%",
						'Location.available = "" AND Location.restricted = ""'
						)
					)
				));
		} else {
			$fkeys = $this->find('list', array(
				'fields' => array( 'id' , 'foreign_key'),
				'conditions' => array(
					'Location.model' => $model,
					'Location.available' => '',
					)
				));
		}
		$available_list = implode(',', ($fkeys));
		return $available_list;
	}
}
?>