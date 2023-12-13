<?php

/*
    Class implementing Singleton pattern to get a cursor to the current database.
*/
class MysqlDatabase {

    /* cursor to DB connection */
    private $cursor = null;

    /* Singleton instance - not needed in class methods */
    private static $instance = null;

    /*
        Use this method to get access to the database connection.
    */
    public static function get_instance(){
        if(self::$instance == null){
            self::$instance = new MysqlDatabase();
        }
        return self::$instance;
    }

    /*
        Private constructor to implement Singleton. Do not use this method for instatiation!
    */
	private function __construct(){
		$host = '127.0.0.1';
		$db = 'realdb';
		$user = 'wt1_prakt';
		$pw = 'abcd';
		
		$dsn = "mysql:host=$host;port=3306;dbname=$db";
		
		$options = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_CASE => PDO::CASE_NATURAL
		];

		try{
            $this->cursor = new PDO($dsn, $user, $pw, $options);
		} 
		catch(PDOException $e){
			echo "Verbindungsaufbau gescheitert: " . $e->getMessage();
		}
    }
    
    /*
        Do not call this method directly.
    */
	public function __destruct(){
		$this->cursor = NULL;	
    }
    public function read_messages() {
        $query = "SELECT id, msg, sender FROM Message";
        $statement = $this->cursor->prepare($query);
        $statement->execute();

        $messages = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $message = new Message($row['id'], $row['msg'], $row['sender']);
            $messages[] = $message;
        }

        return $messages;
    }

    public function insert_message($msg, $sender) {
        $query = "INSERT INTO Message (msg, sender) VALUES (:msg, :sender)";
        $statement = $this->cursor->prepare($query);
        $statement->bindParam(':msg', $msg);
        $statement->bindParam(':sender', $sender);
        $statement->execute();
    }

    
		
}



?>
