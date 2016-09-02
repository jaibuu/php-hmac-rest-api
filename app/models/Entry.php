<?php

namespace Models;

class Entry extends \Phalcon\Mvc\Model {
	public $encrypted_data;

	public $date;

	private $name;

	private function getKey(){
		$app = new \Application\Micro();
		$clientId = $app->request->getHeader('API_ID');

		return $app->config->data->clients[$clientId]->crypt_key;

	}

	private function decrypt(){

		$decoded = base64_decode($this->encrypted_data);


	    $iv = mb_substr($decoded, 0, 16, '8bit');
	    $ciphered = mb_substr($decoded, 16, null, '8bit');
	      
	    $decrypted = rtrim(
	        mcrypt_decrypt(
	            MCRYPT_RIJNDAEL_128,
	            $this->getKey(),
	            $ciphered,
	            'ctr',
	            $iv
	        ),
	        "\0"
	    );        

		
		$data = json_decode($decrypted, true);

		//assigning decrypted values as properties of Entry
		foreach ($data as $key => $value) {
		 $this->{$key} = $value;
		}

	}

	public function save($data = null, $whiteList = null) {
		$this->decrypt();

        $fp = fopen("entries-" . date('Y-m-d') . ".csv", "a");

        fputcsv($fp,array(
        	$this->name,
        	$this->date
        ));

        fclose($fp);
	}
}
