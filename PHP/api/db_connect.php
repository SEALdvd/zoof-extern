<?php

class DB_Connect {

    // constructor
    function __construct() {

    }

    // destructor
    function __destruct() {
        // $this->close();
    }

    // Connecting to database
    public function connect() {
        require_once 'config.php';
        // connecting to mysqli
        $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD);
        // selecting database
        mysqli_select_db($con, DB_DATABASE);

        // return database handler
        return $con;
    }

    // Closing database connection
    public function close() {
        $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD);
        mysqli_close($con);
    }

}

?>