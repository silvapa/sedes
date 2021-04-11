<?php
phpinfo();
  try {
    $hostname = "localhost";
    $port = 5432;
    $dbname = "cbc_guarani";
    $username = "mbaleani";
    $pw = "MarianaC3C!";
    $dbh = new PDO ("pgsql:host=$hostname:$port;dbname=$dbname","$username","$pw");
  } catch (PDOException $e) {
    echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    exit;
  }
  $stmt = $dbh->prepare("SELECT * from usuarios;");
  $stmt->execute();
  while ($row = $stmt->fetch()) {
    print_r($row);
  }
  unset($dbh); unset($stmt);
?>
