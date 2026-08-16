<?php
session_start();
require 'vendor/autoload.php';
use Twilio\Rest\Client;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Bağlantı hatası: " . $e->getMessage());
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Kullanıcının bilgilerini veritabanından al
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// Sabit telefon numarasını belirleyin
 // Tüm kullanıcılara gönderilecek sabit telefon numarasını buraya yazın
$fixedPhoneNumber = '+994507126588';

// Twilio hesap SID ve Auth Token bilgilerini buraya ekleyin
$sid = getenv('TWILIO_ACCOUNT_SID');
$token = getenv('TWILIO_AUTH_TOKEN');
$twilioPhoneNumber = getenv('TWILIO_PHONE_NUMBER');
$client = new Client($sid, $token);

$mfaCode = rand(100000, 999999);
$expiresAt = date('Y-m-d H:i:s', strtotime('+5 minutes'));

$stmt = $pdo->prepare("UPDATE users SET mfa_code = ?, mfa_code_expires_at = ? WHERE id = ?");
$stmt->execute([$mfaCode, $expiresAt, $_SESSION['user_id']]);

$message = $client->messages->create(
    $fixedPhoneNumber,
    array(
        'from' => $twilioPhoneNumber,
        'body' => "Your MFA code is: $mfaCode"
    )
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MFA</title>
</head>
<body>
    <h2>Enter MFA Code</h2>
    <form method="post" action="card_details.php">
        <label for="mfa_code">MFA Code:</label>
        <input type="text" id="mfa_code" name="mfa_code" required>
        <br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>

