<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si la solicitud es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger y sanitizar los datos de entrada
    $cedula = filter_input(INPUT_POST, 'cedula', FILTER_SANITIZE_STRING);
    $password = $_POST["password"];
    $nueva_password = $_POST["nueva_password"];
    $confirmar_password = $_POST["confirmpassword"];

    // Validar que los campos requeridos no estén vacíos
    if (empty($cedula) || empty($password) || empty($nueva_password) || empty($confirmar_password)) {
        echo "Todos los campos son requeridos.";
        exit();
    }

    // Verificar si las nuevas contraseñas coinciden
    if ($nueva_password !== $confirmar_password) {
        echo "Las nuevas contraseñas no coinciden.";
        exit();
    }

    // Verificar si la contraseña actual es correcta
    $sql = "SELECT password FROM usuario WHERE cedula = :cedula";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':cedula', $cedula);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si la contraseña actual no es correcta
    if (!$resultado || $resultado['password'] !== $password) {
        echo "La contraseña actual es incorrecta.";
        exit();
    }

    // Actualizar la contraseña
    $sql = "UPDATE usuario SET password = :nueva_password WHERE cedula = :cedula";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':nueva_password', $nueva_password);
    $stmt->bindParam(':cedula', $cedula);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Mostrar alerta de éxito
        echo '<script>
                alert("Contraseña cambiada con éxito.");
                window.location.href = "index_sesion.html"; // Reemplaza con la URL de tu página de destino
              </script>';
    } else {
        echo "Error al cambiar la contraseña.";
    }
}
?>