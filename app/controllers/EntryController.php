<?php

namespace Controllers;

class EntryController extends \Phalcon\Mvc\Controller {


	public function createAction() {

        $entry = new \Models\Entry();
        $entry->date = date('Y-m-d H:i:s');
        $entry->name = $this->request->getPost("name",'string');
        $entry->save();
	}
}
