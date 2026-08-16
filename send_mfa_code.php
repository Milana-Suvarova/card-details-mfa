<?php
require 'vendor/autoload.php';
use Twilio\Rest\Client;

function sendMfaCode($userPhoneNumber, $userId, $pdo) {
    notepad .\send_mfa_code.php
    
    $fixedPhoneNumber = '+994507126588';
    $client = new Client($sid, $token);

    $mfaCode = rand(100000, 999999);
    $expiresAt = date('Y-m-d H:i:s', strtotime('+5 minutes'));

    $stmt = $pdo->prepare("UPDATE users SET mfa_code = ?, mfa_code_expires_at = ? WHERE id = ?");
    $stmt->execute([$mfaCode, $expiresAt, $userId]);

    $message = $client->messages->create(
        $fixedPhoneNumber,
        array(
            'from' => $twilioPhoneNumber,
            'body' => "Your MFA code is: $mfaCode"
        )
    );

    return $message->sid;
}
?>

