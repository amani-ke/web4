<?php

class Message {
    public $id;
    public $msg;
    public $sender;

    public function __construct($id, $msg, $sender) {
        $this->id = $id;
        $this->msg = $msg;
        $this->sender = $sender;
    }
}

?>
