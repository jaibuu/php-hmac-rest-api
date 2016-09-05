<?php

namespace Models;

class Entry extends \Phalcon\Mvc\Model {    
    public $encrypted_data;
    
    public $date;
    
    private $form_data;
    
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
    
        $this->form_data = $data;  
    }
    
    public function save($data = null, $whiteList = null) { 
        $this->decrypt();

        $file_name = "entries-" . date('Y-m-d') . ".csv";
        $this->form_data['ServerDate'] = $this->date;

        $file_exists = file_exists($file_name);

        $fp = fopen($file_name, "a");

        if(!$file_exists){
            fputcsv($fp,array_keys($this->form_data));
        }

        fputcsv($fp,$this->form_data);

        fclose($fp);    
    }
}
