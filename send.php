<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Verifica reCAPTCHA
    $secretKey = "YOUR_SECRET_KEY"; // <-- qui la Secret Key
    $response = $_POST["g-recaptcha-response"];
    $remoteip = $_SERVER["REMOTE_ADDR"];

    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$response}&remoteip={$remoteip}");
    $captchaSuccess = json_decode($verify);

    if ($captchaSuccess->success == false) {
        die("reCAPTCHA non valido. Riprova.");
    }

    // 2. Recupero dati form
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $inquiry = htmlspecialchars($_POST["inquiry"]);

    // 3. Prepara email
    $to = "giorgia98.gp@gmail.com"; // <-- la tua mail
    $subject = "Nuovo messaggio dal sito";
    $message = "Nome: $name\nEmail: $email\nMessaggio:\n$inquiry";
    $headers = "From: $email";

    // 4. Invia mail
    if (mail($to, $subject, $message, $headers)) {
        echo "Messaggio inviato con successo!";
    } else {
        echo "Errore nell'invio. Riprova più tardi.";
    }
}
?>
