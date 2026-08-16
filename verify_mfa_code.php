<?php
session_start();

$enteredCode = $_POST['mfa_code']; // Kullanıcının girdiği MFA kodu
$expectedCode = $_SESSION['mfa_code']; // Beklenen MFA kodu

if ($enteredCode == $expectedCode) {
    // MFA kodu doğrulandı, card_details.php sayfasına yönlendir
    header("Location: card_details.php");
    exit();
} else {
    // MFA kodu doğrulanmadı, bir hata mesajı göster
    echo "Invalid MFA code.";
}
?>
