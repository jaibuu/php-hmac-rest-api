<?php

namespace Models;

class Entry extends \Phalcon\Mvc\Model {

	public $name;

	public $date;

	public function save($data = null, $whiteList = null) {

        $fp = fopen("entries.csv", "a");

        fputcsv($fp,array($this->name,$this->date));

        fclose($fp);

        echo 'Entry saved';
	}
}
