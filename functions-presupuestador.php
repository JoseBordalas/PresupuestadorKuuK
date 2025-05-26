
<?php
add_action('wp_ajax_enviar_resumen_presupuesto', 'enviar_resumen_presupuesto');
add_action('wp_ajax_nopriv_enviar_resumen_presupuesto', 'enviar_resumen_presupuesto');

function enviar_resumen_presupuesto() {
    $nombre = sanitize_text_field($_POST['nombre']);
    $telefono = sanitize_text_field($_POST['telefono']);
    $email = sanitize_email($_POST['email']);
    $comentario = sanitize_textarea_field($_POST['comentario']);
    $resumen = wp_kses_post($_POST['resumen']);

    $to = 'bbddgrupocaballero@gmail.com'; // Cambia esto por tu correo
    $subject = 'Nuevo presupuesto desde el formulario';
    $message = "
    <strong>Nombre:</strong> {$nombre}<br>
    <strong>Teléfono:</strong> {$telefono}<br>
    <strong>Email:</strong> {$email}<br>
    <strong>Comentario:</strong> {$comentario}<br><br>
    <strong>Resumen del presupuesto:</strong><br>{$resumen}
    ";
    $headers = ['Content-Type: text/html; charset=UTF-8'];

    if (wp_mail($to, $subject, $message, $headers)) {
        echo json_encode(['status' => 'ok']);
    } else {
        echo json_encode(['status' => 'error']);
    }

    wp_die();
}
?>
