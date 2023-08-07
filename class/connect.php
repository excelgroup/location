<?php
class Category {
  // (A) CONSTRUCTOR - CONNECT TO DATABASE
  public $pdo = null;
  private $stmt = null;
  public $error = null;
  function __construct () {
    try {
      $this->pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET,
        DB_USER, DB_PASSWORD, [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } catch (Exception $ex) { exit($ex->getMessage()); }
  }

  // (B) DESTRUCTOR - CLOSE DATABASE CONNECTION
  function __destruct () {
    if ($this->stmt !== null) { $this->stmt = null; }
    if ($this->pdo !== null) { $this->pdo = null; }
  }

  /**
   * get date for feild selection options
   * 
   * @param int $pid 
   * @param string $feild1
   * @param string $table
   * @param int $feild2
   * @return array $result
   */
  
  function getoption ($pid,$feild1,$table,$feild2) {
    $this->stmt = $this->pdo->prepare("SELECT rowid, $feild1 FROM `$table` WHERE `$feild2`=?");
    $this->stmt->execute([$pid]);
    $results = [];
    while ($row = $this->stmt->fetch()) { $results[$row["rowid"]] = $row["$feild1"]; }
    return $results;
  }
}

// (D) DATABASE SETTINGS - CHANGE TO YOUR OWN!
define("DB_HOST", "192.168.1.2");
define("DB_NAME", "dolibarr");
define("DB_CHARSET", "utf8");
define("DB_USER", "abdessamad");
define("DB_PASSWORD", "s112233");

// (E) NEW CATEGORY OBJECT
$_CAT = new Category();
