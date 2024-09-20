<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

const ORIGIN = '*';
const GMAILUSERNAME = 'noleeethan@gmail.com';
const GMAILPASSWORD = 'vpsn jzox ocux hfht';
const RECIPIENTMAIL = 'martinezmontoyajoe@gmail.com';

header("Access-Control-Allow-Origin: ". ORIGIN );
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $website = $_POST['website'] ?? '';
    $message = $_POST['message'] ?? '';

    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(['success' => false, 'error' => 'Veuillez remplir tous les champs requis.']);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = GMAILUSERNAME;
        $mail->Password = GMAILPASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom(GMAILUSERNAME, 'MailBot');
        $mail->addAddress(RECIPIENTMAIL);

        $mail->isHTML(true);
        $mail->Subject = 'Nouveau message';
        $mail->Body    = "Nom: $name\nEmail: $email\nSite Web: $website\n\nMessage:\n$message";

        $mail->send();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => "Erreur lors de l'envoi du message: {$mail->ErrorInfo}"]);
    }
}
?>
