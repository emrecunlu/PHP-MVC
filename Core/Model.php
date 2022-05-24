<?php 

    class Model extends Router
    {
        protected $db;

        public function __construct()
        {
            try {
                $this -> db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASSWORD);
            } catch(PDOException $e) {
                $this -> set_error($e -> getMessage());
            }
        }
    }

?>