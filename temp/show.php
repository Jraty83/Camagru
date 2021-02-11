<?php
include '../config/setup.php';

echo "<table style='border: solid 1px black;'>";
echo "<tr><th>user_id</th><th>username</th><th>email</th><th>password</th><th>verified</th></tr>";

class TableRows extends RecursiveIteratorIterator {
  function __construct($it) {
    parent::__construct($it, self::LEAVES_ONLY);
  }

  function current() {
    return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
  }

  function beginChildren() {
    echo "<tr>";
  }

  function endChildren() {
    echo "</tr>" . "\n";
  }
}

try {
  //! SHOW VERIFIED USER ACCOUNTS ONLY
//  $stmt = $conn->prepare("SELECT `user_id`, username, email, `password`, verified FROM users WHERE verified=1");
  //! SHOW ALL USERS
  $stmt = $conn->prepare("SELECT `user_id`, username, email, `password`, verified FROM users");
  $stmt->execute();

  // set the resulting array to associative
  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
    echo $v;
  }
} catch(PDOException $e) {
    die("ERROR: " . $e->getMessage());
}

$conn = null;
echo "</table>";
?>
