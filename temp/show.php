<?php
include '../config/setup.php';

echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Id</th><th>username</th><th>email</th><th>confirmed</th></tr>";

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
  //! SHOW CONFIRMED USER ACCOUNTS
  $stmt = $conn->prepare("SELECT id, username, email, confirmed FROM users WHERE confirmed=1");
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
