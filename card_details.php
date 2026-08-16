<?php
session_start();

// İstifadəçi giriş etmişdirmi yoxlayırıq
if (!isset($_SESSION['user_id'])) {
    // Giriş etməmiş istifadəçini login səhifəsinə yönləndiririk
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Card Details</title>
    <link rel="stylesheet" href="csscodes.css">
</head>
<body>
    <main>
        <div class="container">
            <div class="left-section">
                <div class="cards">
                    <div class="front-card">
                        <img src="images/bg-card-front.png" alt="front-card">
                        <div class="card-container">
                            <img class="card-logo" src="images/card-logo.svg" alt="logo">
                            <h1 class="number">0000 0000 0000 0000</h1>
                            <div class="card-info">
                                <span class="name">Jane Appleseed</span>
                                <span class="date">
                                    <span class="month">00</span>
                                    <span class="year">00</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="back-card">
                        <img src="images/bg-card-back.png" alt="back-card">
                        <span class="cvc">000</span>
                    </div>
                </div>
            </div>
            <div class="right-section">
                <form>
                    <div class="grid-1">
                        <label for="card-name">Cardholder Name </label>
                        <input type="text" id="card-name" placeholder=" e.g.Jane Appleseed" required />
                    </div>
                    <div class="grid-2">
                        <label for="card-number">Card Number </label> 
                        <input type="number"
                               oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                               minlength="16"
                               maxlength="16"
                               placeholder="e.g. 1234 5678 9123 0000"
                               id="card-number"
                               required>
                    </div>
                    <div class="card-information">
                        <div class="card-date">
                            <label for="card-date"> Exp. Date (MM/YY)</label>
                            <div class="two-input">
                                <div>
                                    <input type="number"
                                           oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                           minlength="2"
                                           maxlength="2" placeholder="MM"
                                           id="card-month"
                                           required>
                                </div>
                                <div>
                                    <input oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                           type="number"
                                           minlength="2"
                                           maxlength="2"
                                           placeholder="YY"
                                           id="card-year"
                                           required>
                                </div>
                            </div>
                        </div>
                        <div class="grid-4">
                            <label for="card-cvc">CVC</label>
                            <input type="number"
                                   oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                   minlength="3"
                                   maxlength="3"
                                   placeholder="e.g. 123"
                                   id="card-cvc"
                                   required />
                        </div>
                    </div>
                    <button class="submit-button" type="submit">Confirm</button>
                </form>
                <div class="thanks hidden">
                    <img src="images/icon-complete.svg" alt="iconcomplete">
                    <h1>Thank you!</h1>
                    <p>We've added your card details </p>
                    <button>Continue</button>
                </div>
                <!-- Password Manager Link -->
                <div class="password-manager-link">
                    <a href="password_manager.php">Go to Password Manager</a>
                </div>
            </div>
        </div>
    </main>
    <script src="jscodes.js"></script>
</body>
</html>
