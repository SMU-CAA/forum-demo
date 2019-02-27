<?php
require_once __DIR__ . "/../controller/Controller.class.php";
require_once __DIR__ . "/../model/Messages.class.php";

class Send extends Controller
{
    public function __construct($connection)
    {
        parent::__construct($connection);
        $this->model = new Messages($connection);
    }

    public function send()
    {
        if (isset($_POST["to"]) && isset($_POST["content"])) {
            $message_content = pg_escape_string(trim($_POST["content"]));
            $message_time = date("Y-m-d h:i:s");
            $message = array("message_from" => (int)$_SESSION["user_id"], "message_to" => (int)$_POST["to"], "message_content" => $message_content, "message_time" => $message_time);
            return $this->model->send($message);
        } else
            return NULL;
    }

    public function json()
    {
        if (isset($_POST["to"]) && isset($_POST["content"]) && isset($_SESSION["user_id"]))
            if ($this->send())
                echo '1';
            else
                echo '0';
        else
            parent::json();
    }

    public function format()
    {
        return;
    }

}