<?php
require "DataBaseConfig.php";

class DataBase
{
    public $connect;
    public $data;
    private $sql;
    protected $servername;
    protected $username;
    protected $password;
    protected $databasename;

    public function __construct()
    {
        $this->connect = null;
        $this->data = null;
        $this->sql = null;
        $dbc = new DataBaseConfig();
        $this->servername = $dbc->servername;
        $this->username = $dbc->username;
        $this->password = $dbc->password;
        $this->databasename = $dbc->databasename;
    }

    function dbConnect()
    {
        $this->connect = mysqli_connect($this->servername, $this->username, $this->password, $this->databasename);
        return $this->connect;
    }

    function prepareData($data)
    {
        return mysqli_real_escape_string($this->connect, stripslashes(htmlspecialchars($data)));
    }

    function logIn($table, $email, $password)
    {
        $email = $this->prepareData($email);
        $password = $this->prepareData($password);
        $this->sql = "select * from " . $table . " where email = '" . $email . "'";
        $result = mysqli_query($this->connect, $this->sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) != 0) {
            $dbemail = $row['email'];
            $dbpassword = $row['password'];
            if ($dbemail == $email && password_verify($password, $dbpassword)) {
                $login = true;
                
            } else $login = false;
        } else $login = false;

        return $login;
    }

    function signUp($table,$email,$password)
    {
        $email = $this->prepareData($email);
        $password = $this->prepareData($password);
        
        $password = password_hash($password, PASSWORD_DEFAULT);
        
        $this->sqli = "select * from " . $table . " where email = '" . $email . "'";
        $result = mysqli_query($this->connect, $this->sqli);
        $row = mysqli_fetch_assoc($result);
        
            
                
            
        $this->sql =
            "INSERT INTO " . $table . " (email, password) VALUES ('" .  $email . "','" .$password . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else return false;
    
        }
    
        
        
        
        function checksignUp($table,$email)
    {
        $email = $this->prepareData($email);
        
        
        $this->sql = "select * from " . $table . " where email = '" . $email . "'";
        $result = mysqli_query($this->connect, $this->sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) == 0) {
            
                
                 return true;
        
    }else return false;
        }
        
        
        
        
        

}


?>
