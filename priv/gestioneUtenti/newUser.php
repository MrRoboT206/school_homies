<?php

include "../include/connessione.inc";

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;

$email = $_POST['email'];
$password = $_POST['password'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$user_type = $_POST['user_type'];

// Controlla se l'email è già presente nel database
$stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Email già presente, mostra un messaggio di errore e reindirizza alla pagina di login
    echo "<script>alert('L\'email è già registrata. Per favore, usa un\'altra email o accedi.');</script>";
    echo "<script>window.location.href = '../login.php';</script>";
} else {
    // Cripta la password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Email non presente, inserisci il nuovo utente
    $stmt = $conn->prepare("INSERT INTO users (email, password, name, surname, user_type) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $email, $hashed_password, $name, $surname, $user_type);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        // Registrazione avvenuta con successo, mostra un messaggio di successo e reindirizza alla pagina di login
        echo "<script>alert('Registrazione avvenuta con successo!');</script>";
        // Invia un'email di conferma (opzionale)
        // Crea token
        $id_user = $conn->insert_id;
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 day'));

        $stmt = $conn->prepare("INSERT INTO email_verifications (id_user, token, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$id_user, $token, $expires]);

        // Invia email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'papaverifanclub@gmail.com';
            $mail->Password = 'ktto vehd jpzr ngio';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('papaverifanclub@gmail.com', 'Tuo Sito');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Verifica la tua email';
            $mail->Body = "Clicca sul link per verificare: <a href='http://82.51.168.10:8080/school_homies/priv/gestioneUtenti/email-verifica/verify.php?token=$token'>Verifica ora</a>";

            $mail->send();
            echo "Controlla la tua email per confermare.";
        } catch (Exception $e) {
            echo "Errore nell'invio dell'email: {$mail->ErrorInfo}";
        }

        //echo "<script>window.location.href = '../login.php';</script>";
    } else {
        // Errore durante la registrazione, mostra un messaggio di errore
        echo "<script>alert('Si è verificato un errore durante la registrazione. Riprova.');</script>";
    }
    $stmt->close();

    header("location:../../pub/index.php");
    exit();
}

include "../priv/include/connessione.inc";
