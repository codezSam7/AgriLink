<?php
echo "<h2>Pxxl MySQL Connection Test</h2>";

$host = 'db.pxxl.pro';
$port = 39722;
$dbname = 'pxxldb_mni7zt9f241518a';
$user = 'pxxluser_mni7zt9f837af9e';
$pass = '80f31af3415b93919ad35b107382eff16464aebbd052b69148b4b2c2af007988'; // your long password

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<p style='color:green; font-weight:bold;'>✅ Connected successfully to the Pxxl database!</p>";

    // Check tables (to see if your import would work)
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "<p>Number of tables: " . count($tables) . "</p>";
    if (!empty($tables)) {
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>" . htmlspecialchars($table) . "</li>";
        }
        echo "</ul>";
    }
} catch (PDOException $e) {
    echo "<p style='color:red; font-weight:bold;'>❌ Connection failed:<br>" . htmlspecialchars($e->getMessage()) . "</p>";
}
