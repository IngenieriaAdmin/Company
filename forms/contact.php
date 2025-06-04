<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $to = "destinatario@example.com"; // Cambia por el correo que recibirá los mensajes
    $subject = htmlspecialchars($_POST['subject']);
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['message']);

    // Validar campos
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'Por favor, completa todos los campos.']);
        exit;
    }

    // Configurar mensaje
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $body = "Nombre: $name\nCorreo: $email\n\nMensaje:\n$message";

    // Enviar correo
    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(['status' => 'success', 'message' => 'Correo enviado con éxito.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se pudo enviar el correo.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
}
?>
