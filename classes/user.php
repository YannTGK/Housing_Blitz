<?php
require_once __DIR__ . "/database.php";

class User {
    protected $db;

    public function __construct() {
        $this->db = new Db();
    }

  
function canLogin($Pusername, $Ppassword){
    $conn = Db::getConnection();
    $Pusername = $conn->real_escape_string($Pusername);
    $sql = "SELECT password, username, role, id FROM account WHERE Username = '$Pusername'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    if ($user !== null && password_verify($Ppassword, $user['password'])) {
        return $user; 
    } else {
        return false;
    }
}

   
}
?>
