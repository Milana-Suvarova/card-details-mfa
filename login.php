<?php
session_start();

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
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Giriş başarılı olduğunda
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];

            // MFA kodunu gönderme işlemi
            // sendMfaCode fonksiyonunu buraya ekleyin

            // MFA kodu doğrulama sayfasına yönlendirme
            header("Location: mfa.php");
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "No user found with this email";
    }
}

$conn->close();
?>
