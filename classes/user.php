<?php
require_once __DIR__ . "/database.php";

class User {
    protected $db;

    public function __construct() {
        $this->db = new Db();
    }

    public function login($gebruiker, $password) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE gebruiker = ? AND password = ? ");
        $stmt->execute([$gebruiker, $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
}
?>
