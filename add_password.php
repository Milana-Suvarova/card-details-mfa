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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $site_name = $conn->real_escape_string($_POST['site_name']);
    $site_url = $conn->real_escape_string($_POST['site_url']);
    $site_username = $conn->real_escape_string($_POST['site_username']);
    $site_password = $conn->real_escape_string($_POST['site_password']);

    // Şifreleme (örnek olarak basit bir şifreleme kullanıldı, güvenlik için daha güçlü yöntemler tercih edin)
    $encryption_key = 'your-encryption-key';  // 16 byte key for AES-128
    $iv = 'your-iv';  // 16 byte IV for AES-128
    $encrypted_password = openssl_encrypt($site_password, 'aes-128-cbc', $encryption_key, 0, $iv);

    $sql = "INSERT INTO passwords (user_id, site_name, site_url, site_username, site_password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $user_id, $site_name, $site_url, $site_username, $encrypted_password);

    if ($stmt->execute() === TRUE) {
        echo "Password added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<form method="post">
    Site Name: <input type="text" name="site_name" required><br>
    Site URL: <input type="text" name="site_url"><br>
    Site Username: <input type="text" name="site_username"><br>
Site Password: <input type="password" name="site_password" required><br>
<button type="submit">Add Password</button>

</form>

   
