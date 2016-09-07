<?php

/**
 * Simplified version of the Restful Storage API
 * No request authentication
 * No encryption
 */

if ($_SERVER['REQUEST_METHOD'] !== 'POST')  die('Wrong Request'); 


class Entry {    
    public $base64encoded_data;
    
    public $date;
    
    private $form_data;

    private function decrypt(){
        $decoded = base64_decode($this->base64encoded_data);

        $data = json_decode($decoded, true);
    
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

date_default_timezone_set('America/New_York');

$entry = new Entry();
$entry->date = date('Y-m-d H:i:s');
$entry->base64encoded_data = $_POST['payload'];
$entry->save();
