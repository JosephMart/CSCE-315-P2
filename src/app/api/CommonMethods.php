<?php

class Common
{
    var $conn;
    var $debug;

    var $db = "database.cs.tamu.edu";
    var $dbname = "josephmart";
    var $user = "josephmart";
    var $pass = "martinsen";

    function Common($debug)
    {
        $this->debug = $debug;
        if (getenv('DEV')) {
            $this->user = "root";
            $this->pass = "root";
            $this->db = getenv('MYSQL_IP');
        }
        $rs = $this->connect($this->user); // db name really here
        return $rs;
    }

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */

    function connect($db)// connect to MySQL DB Server
    {
        try {
            $this->conn = new PDO('mysql:host=' . $this->db . ';dbname=' . $this->dbname, $this->user, $this->pass);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */

    function executeQuery($sql, $filename) // execute query
    {
        if ($this->debug == true) {
            echo("$sql <br>\n");
        }
        $rs = $this->conn->query($sql) or die("Could not execute query '$sql' in $filename");
        return $rs;
    }

} // ends class, NEEDED!!
