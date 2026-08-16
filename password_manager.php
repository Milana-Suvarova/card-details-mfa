<?php
session_start();

// Kullanıcının giriş yapıp yapmadığını ve MFA doğrulamasını geçip geçmediğini kontrol et
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Veritabanına bağlanma
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı hatası kontrolü
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM passwords WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<h1>Your Stored Passwords</h1>";
echo "<table border='1'>";
echo "<tr><th>Site Name</th><th>Site URL</th><th>Site Username</th><th>Site Password</th></tr>";
$encryption_key = 'your-encryption-key';  // Same key used for encryption
$iv = 'your-iv';  // Same IV used for encryption

while ($row = $result->fetch_assoc()) {
    $decrypted_password = openssl_decrypt($row['site_password'], 'aes-128-cbc', $encryption_key, 0, $iv);
    echo "<tr><td>" . htmlspecialchars($row['site_name']) . "</td><td>" . htmlspecialchars($row['site_url']) . "</td><td>" . htmlspecialchars($row['site_username']) . "</td><td>" . htmlspecialchars($decrypted_password) . "</td></tr>";
}
echo "</table>";

$stmt->close();
$conn->close();
?>

<a href="add_password.php">Add a new password</a>
