<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.html");
    exit();
}

include 'backend/config.php';


// Funcionalidades adicionales
$usuarioId = $_SESSION['usuario_id'];
$user = [];
$messages = [];
$notifications = [];

// Obtener datos del usuario
$sql = "SELECT nombre, apellido, email FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$stmt->bind_result($nombre, $apellido, $email);
if ($stmt->fetch()) {
    $user = [
        'nombre' => $nombre,
        'apellido' => $apellido,
        'email' => $email
    ];
}
$stmt->close();

// Obtener mensajes del administrador
$sql = "SELECT mensaje FROM mensajes WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$stmt->bind_result($mensaje);
while ($stmt->fetch()) {
    $messages[] = ['mensaje' => $mensaje];
}
$stmt->close();

// Obtener notificaciones
$sql = "SELECT notificacion FROM notificaciones WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$stmt->bind_result($notificacion);
while ($stmt->fetch()) {
    $notifications[] = ['notificacion' => $notificacion];
}
$stmt->close();

$abonoMensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['abonoMonto'])) {
    $usuarioId = $_SESSION['usuario_id'];
    $monto = $_POST['abonoMonto'];

    // Obtener el monto total de los abonos del usuario
    $sql = "SELECT SUM(monto) as total_abonos FROM abonos WHERE usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuarioId);
    $stmt->execute();
    $stmt->bind_result($total_abonos);
    $stmt->fetch();
    $stmt->close();

    if ($total_abonos + $monto > 1500000) {
        $abonoMensaje = "No puede abonar más de $1,500,000.";
    } else {
        $sql = "INSERT INTO abonos (usuario_id, monto) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("id", $usuarioId, $monto);

        if ($stmt->execute()) {
            $abonoMensaje = "Abono realizado correctamente";
        } else {
            $abonoMensaje = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$sql = "SELECT id, fecha, monto FROM abonos WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$stmt->bind_result($id, $fecha, $monto);

$abonos = [];
$totalMonto = 0;
while ($stmt->fetch()) {
    $abonos[] = ["id" => $id, "fecha" => $fecha, "monto" => $monto];
    $totalMonto += $monto;
}

$stmt->close();
$conn->close();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'download':
            if (isset($_GET['id'])) {
                generateReport($_GET['id']);
            }
            break;
        case 'download_all':
            generateAllReports($_SESSION['usuario_id']);
            break;
        case 'generate_policy':
            generatePolicy($_SESSION['usuario_id']);
            break;
        case 'generate_contract':
            generateContract($_SESSION['usuario_id']);
            break;
    }
}

function generateReport($report_id) {
    require('fpdf/fpdf.php');
    include 'backend/config.php';

    $query = $conn->prepare("SELECT * FROM abonos WHERE id = ?");
    $query->bind_param("i", $report_id);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $user_query = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
        $user_query->bind_param("i", $row['usuario_id']);
        $user_query->execute();
        $user_result = $user_query->get_result();
        $user_row = $user_result->fetch_assoc();

        $pdf = new FPDF();
        $pdf->AddPage();

        // Agregar título
        $pdf->SetFont('Helvetica','B',16);
        $pdf->Cell(40,10,'Reporte de Abonos');
        $pdf->Ln(20);

        // Agregar datos del usuario
        $pdf->SetFont('Helvetica','',12);
        $pdf->Cell(40,10,'Nombre: ' . $user_row['nombre']);
        $pdf->Ln(10);
        $pdf->Cell(40,10,'Apellido: ' . $user_row['apellido']);
        $pdf->Ln(10);
        $pdf->Cell(40,10,'Correo: ' . $user_row['email']);
        $pdf->Ln(20);

        // Agregar datos del reporte
        $pdf->Cell(40,10,'Fecha: ' . $row['fecha']);
        $pdf->Ln(10);
        $pdf->Cell(40,10,'Monto: ' . $row['monto']);
        $pdf->Ln(10);

        // Output PDF
        $pdf->Output('D', 'reporte_abono.pdf'); // D para forzar la descarga
    } else {
        echo 'Reporte no encontrado';
    }

    $query->close();
    $conn->close();
    exit();
}

function generateAllReports($usuario_id) {
    require('fpdf/fpdf.php');
    include 'backend/config.php';

    $query = $conn->prepare("SELECT fecha, monto FROM abonos WHERE usuario_id = ?");
    $query->bind_param("i", $usuario_id);
    $query->execute();
    $result = $query->get_result();

    $user_query = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
    $user_query->bind_param("i", $usuario_id);
    $user_query->execute();
    $user_result = $user_query->get_result();
    $user_row = $user_result->fetch_assoc();

    $pdf = new FPDF();
    $pdf->AddPage();

    // Agregar título
    $pdf->SetFont('Helvetica','B',16);
    $pdf->Cell(40,10,'Reporte Completo de Abonos');
    $pdf->Ln(20);

    // Agregar datos del usuario
    $pdf->SetFont('Helvetica','',12);
    $pdf->Cell(40,10,'Nombre: ' . $user_row['nombre']);
    $pdf->Ln(10);
    $pdf->Cell(40,10,'Apellido: ' . $user_row['apellido']);
    $pdf->Ln(10);
    $pdf->Cell(40,10,'Correo: ' . $user_row['email']);
    $pdf->Ln(20);

    // Agregar datos del reporte
    $totalMonto = 0;
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(40,10,'Fecha: ' . $row['fecha']);
        $pdf->Ln(10);
        $pdf->Cell(40,10,'Monto: ' . $row['monto']);
        $pdf->Ln(10);
        $pdf->Ln(10);
        $totalMonto += $row['monto'];
    }

    // Agregar monto total
    $pdf->SetFont('Helvetica','B',12);
    $pdf->Cell(40,10,'Monto Total: $' . $totalMonto);
    $pdf->Ln(10);

    // Output PDF
    $pdf->Output('D', 'reporte_completo_abonos.pdf'); // D para forzar la descarga

    $query->close();
    $conn->close();
    exit();
}

function generatePolicy($usuario_id) {
    require('fpdf/fpdf.php');
    include 'backend/config.php';

    $user_query = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
    $user_query->bind_param("i", $usuario_id);
    $user_query->execute();
    $user_result = $user_query->get_result();
    $user_row = $user_result->fetch_assoc();

    $pdf = new FPDF();
    $pdf->AddPage();

    // Agregar título
    $pdf->SetFont('Helvetica','B',16);
    $pdf->Cell(0,10,utf8_decode('Póliza de Seguro'),0,1,'C');
    $pdf->Ln(10);

    // Agregar datos del usuario
    $pdf->SetFont('Helvetica','',12);
    $pdf->Cell(0,10,utf8_decode('Aseguradora: Hasbi On Tour Insurance'),0,1);
    $pdf->Cell(0,10,utf8_decode('Número de Póliza: 123456789'),0,1);
    $pdf->Cell(0,10,utf8_decode('Titular de la Póliza: ') . utf8_decode($user_row['nombre']) . ' ' . utf8_decode($user_row['apellido']),0,1);
    $pdf->Cell(0,10,utf8_decode('Fecha de Emisión: ') . date('Y-m-d'),0,1);
    $pdf->Ln(10);

    // Agregar coberturas
    $pdf->Cell(0,10,utf8_decode('Cobertura:'),0,1);
    $pdf->Cell(0,10,utf8_decode('- Accidentes Personales: Cobertura hasta $50,000'),0,1);
    $pdf->Cell(0,10,utf8_decode('- Gastos Médicos: Cobertura hasta $100,000'),0,1);
    $pdf->Cell(0,10,utf8_decode('- Cancelación/Interrupción del Viaje: Cobertura hasta $10,000'),0,1);
    $pdf->Cell(0,10,utf8_decode('- Pérdida de Equipaje: Cobertura hasta $5,000'),0,1);
    $pdf->Cell(0,10,utf8_decode('- Retraso de Vuelo: Cobertura hasta $1,000'),0,1);
    $pdf->Ln(10);

    // Agregar detalles del asegurado
    $pdf->Cell(0,10,utf8_decode('Detalles del Asegurado:'),0,1);
    $pdf->Cell(0,10,utf8_decode('- Nombre: ') . utf8_decode($user_row['nombre']),0,1);
    $pdf->Cell(0,10,utf8_decode('- Apellido: ') . utf8_decode($user_row['apellido']),0,1);
    $pdf->Cell(0,10,utf8_decode('- Correo Electrónico: ') . utf8_decode($user_row['email']),0,1);
    $pdf->Ln(10);

    // Agregar términos y condiciones
    $pdf->Cell(0,10,utf8_decode('Términos y Condiciones:'),0,1);
    $pdf->MultiCell(0,10,utf8_decode('1. Esta póliza de seguro es válida únicamente para el viaje contratado con Hasbi On Tour.'));
    $pdf->MultiCell(0,10,utf8_decode('2. La cobertura comienza desde la fecha de inicio del viaje y finaliza en la fecha de retorno.'));
    $pdf->MultiCell(0,10,utf8_decode('3. El asegurado debe notificar cualquier incidente dentro de las 24 horas posteriores a su ocurrencia.'));
    $pdf->MultiCell(0,10,utf8_decode('4. Para reclamaciones, se debe proporcionar la documentación requerida, incluyendo recibos y reportes médicos.'));
    $pdf->MultiCell(0,10,utf8_decode('5. Las exclusiones de esta póliza incluyen, pero no se limitan a, actividades extremas, enfermedades preexistentes, y actos de guerra.'));
    $pdf->Ln(10);

    // Agregar contacto para reclamaciones
    $pdf->Cell(0,10,utf8_decode('Contacto para Reclamaciones:'),0,1);
    $pdf->Cell(0,10,utf8_decode('- Teléfono: +56984494726'),0,1);
    $pdf->Cell(0,10,utf8_decode('- Correo Electrónico: contacto@hasbiontour.cl'),0,1);
    $pdf->Ln(20);

    // Firma
    $pdf->Cell(0,10,utf8_decode('Firma:'),0,1);
    $pdf->Ln(20);
    $pdf->Cell(0,10,'______________________',0,1);
    $pdf->Cell(0,10,utf8_decode('Representante de Hasbi On Tour Insurance'),0,1);

    // Output PDF
    $pdf->Output('D', 'poliza_seguro.pdf'); // D para forzar la descarga

    $user_query->close();
    $conn->close();
    exit();
}

function generateContract($usuario_id) {
    require('fpdf/fpdf.php');
    include 'backend/config.php';

    $user_query = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
    $user_query->bind_param("i", $usuario_id);
    $user_query->execute();
    $user_result = $user_query->get_result();
    $user_row = $user_result->fetch_assoc();

    $pdf = new FPDF();
    $pdf->AddPage();

    // Agregar título
    $pdf->SetFont('Helvetica','B',16);
    $pdf->Cell(0,10,utf8_decode('Contrato de Servicios Turísticos'),0,1,'C');
    $pdf->Ln(10);

    // Agregar datos del usuario
    $pdf->SetFont('Helvetica','',12);
    $pdf->Cell(0,10,utf8_decode('Agencia de Viajes: Hasbi On Tour'),0,1);
    $pdf->Cell(0,10,utf8_decode('Número de Contrato: 987654321'),0,1);
    $pdf->Cell(0,10,utf8_decode('Titular del Contrato: ') . utf8_decode($user_row['nombre']) . ' ' . utf8_decode($user_row['apellido']),0,1);
    $pdf->Cell(0,10,utf8_decode('Fecha de Emisión: ') . date('Y-m-d'),0,1);
    $pdf->Ln(10);

    // Agregar detalles del viaje
    $pdf->Cell(0,10,utf8_decode('Detalles del Viaje:'),0,1);
    $pdf->Cell(0,10,utf8_decode('- Destino: [Especificar Destino]'),0,1);
    $pdf->Cell(0,10,utf8_decode('- Duración del Viaje: [Especificar Duración]'),0,1);
    $pdf->Cell(0,10,utf8_decode('- Fecha de Salida: [Especificar Fecha]'),0,1);
    $pdf->Cell(0,10,utf8_decode('- Fecha de Retorno: [Especificar Fecha]'),0,1);
    $pdf->Ln(10);

    // Agregar servicios incluidos
    $pdf->Cell(0,10,utf8_decode('Servicios Incluidos:'),0,1);
    $pdf->Cell(0,10,utf8_decode('1. Transporte: Incluye vuelos de ida y vuelta, traslados locales.'),0,1);
    $pdf->Cell(0,10,utf8_decode('2. Alojamiento: Estancia en hoteles de categoría [Especificar Categoría].'),0,1);
    $pdf->Cell(0,10,utf8_decode('3. Alimentación: Plan de comidas [Especificar Detalles].'),0,1);
    $pdf->Cell(0,10,utf8_decode('4. Actividades y Excursiones: Incluye [Especificar Actividades].'),0,1);
    $pdf->Cell(0,10,utf8_decode('5. Guía de Viaje: Servicios de un guía profesional durante todo el viaje.'),0,1);
    $pdf->Ln(10);

    // Agregar términos y condiciones
    $pdf->Cell(0,10,utf8_decode('Términos y Condiciones:'),0,1);
    $pdf->MultiCell(0,10,utf8_decode('1. El titular del contrato debe presentar identificación válida y comprobantes de pago al inicio del viaje.'));
    $pdf->MultiCell(0,10,utf8_decode('2. Las cancelaciones deben realizarse con al menos 30 días de anticipación para reembolsos completos.'));
    $pdf->MultiCell(0,10,utf8_decode('3. Hasbi On Tour no se hace responsable por pérdidas o daños de bienes personales durante el viaje.'));
    $pdf->MultiCell(0,10,utf8_decode('4. El titular del contrato debe cumplir con todas las normas y regulaciones locales del destino visitado.'));
    $pdf->MultiCell(0,10,utf8_decode('5. Cualquier cambio en el itinerario debe ser notificado con antelación y puede estar sujeto a cargos adicionales.'));
    $pdf->Ln(10);

    // Agregar contacto de emergencia
    $pdf->Cell(0,10,utf8_decode('Contacto de Emergencia:'),0,1);
    $pdf->Cell(0,10,utf8_decode('- Teléfono: +56984494726'),0,1);
    $pdf->Cell(0,10,utf8_decode('- Correo Electrónico: contacto@hasbiontour.cl'),0,1);
    $pdf->Ln(20);

    // Firma
    $pdf->Cell(0,10,utf8_decode('Firma:'),0,1);
    $pdf->Ln(20);
    $pdf->Cell(0,10,'______________________',0,1);
    $pdf->Cell(0,10,utf8_decode('Representante de Hasbi On Tour'),0,1);
    $pdf->Ln(10);
    $pdf->Cell(0,10,'______________________',0,1);
    $pdf->Cell(0,10,utf8_decode($user_row['nombre']) . ' ' . utf8_decode($user_row['apellido']),0,1);

    // Output PDF
    $pdf->Output('D', 'contrato_viaje.pdf'); // D para forzar la descarga


    $user_query->close();
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Panel de Usuario - Hasbi On Tour</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-light navbar-light sticky-top">
        <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h1 class="m-0 text-primary">Hasbi On Tour</h1>
        </a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.html" class="nav-item nav-link">Inicio</a>
                <a href="backend/logout.php" class="nav-item nav-link">Cerrar sesión</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Dashboard Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3">
                    <div class="list-group list-group-flush bg-light rounded">
                        <a href="#" class="list-group-item list-group-item-action active" id="finanzas-tab">Finanzas</a>
                        <a href="#" class="list-group-item list-group-item-action" id="reportes-tab">Reportes</a>
                        <a href="#" class="list-group-item list-group-item-action" id="seguros-tab">Seguros</a>
                        <a href="#" class="list-group-item list-group-item-action" id="contratos-tab">Contratos</a>
                        <a href="#" class="list-group-item list-group-item-action" id="contacto-tab">Contacto</a>
                        <a href="#" class="list-group-item list-group-item-action" id="miPerfil-tab">Mi Perfil</a>
                        <a href="#" class="list-group-item list-group-item-action" id="bandejaEntrada-tab">Bandeja de entrada</a>
                        <a href="#" class="list-group-item list-group-item-action" id="notificaciones-tab">Notificaciones</a>
                        <a href="#" class="list-group-item list-group-item-action" id="configuracionCuenta-tab">Configuración de la cuenta</a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <h3>Bienvenido, <?php echo $_SESSION['nombre']; ?> <?php echo $_SESSION['apellido']; ?></h3>
                    <!-- Finanzas -->
                    <div id="finanzas" class="tab-content">
                        <h3>Finanzas</h3>
                        <?php if (isset($abonoMensaje)) echo '<p>' . $abonoMensaje . '</p>'; ?>
                        <form method="POST" action="dashboard.php">
                            <div class="mb-3">
                                <label for="abonoMonto" class="form-label">Monto a Abonar</label>
                                <input type="number" class="form-control" id="abonoMonto" name="abonoMonto" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Abonar</button>
                        </form>
                    </div>
                    <!-- Reportes -->
                    <div id="reportes" class="tab-content" style="display: none;">
                        <h3>Reportes</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Descargar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($abonos as $abono): ?>
                                    <tr>
                                        <td><?php echo $abono['fecha']; ?></td>
                                        <td>$<?php echo $abono['monto']; ?></td>
                                        <td><a href="dashboard.php?action=download&id=<?php echo $abono['id']; ?>" class="btn btn-sm btn-primary">Descargar</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <a href="dashboard.php?action=download_all" class="btn btn-primary">Descargar Reporte Completo</a>
                        <?php if ($totalMonto >= 1500000): ?>
                            <a href="dashboard.php?action=generate_policy" class="btn btn-success">Generar Póliza de Seguro</a>
                            <a href="dashboard.php?action=generate_contract" class="btn btn-success">Generar Contrato de Viaje</a>
                        <?php endif; ?>
                    </div>
                    <!-- Seguros -->
                    <div id="seguros" class="tab-content" style="display: none;">
                        <h3>Seguros</h3>
                        <p>Aquí el usuario puede descargar la póliza una vez finalizado el pago.</p>
                        <?php if ($totalMonto >= 1500000): ?>
                            <button class="btn btn-primary" onclick="window.location.href='dashboard.php?action=generate_policy'">Descargar Póliza</button>
                        <?php else: ?>
                            <p>No ha alcanzado el monto necesario para generar la póliza.</p>
                        <?php endif; ?>
                    </div>
                    <!-- Contratos -->
                    <div id="contratos" class="tab-content" style="display: none;">
                        <h3>Contratos</h3>
                        <p>Aquí el usuario puede descargar los contratos por el servicio contratado.</p>
                        <?php if ($totalMonto >= 1500000): ?>
                            <button class="btn btn-primary" onclick="window.location.href='dashboard.php?action=generate_contract'">Descargar Contrato</button>
                        <?php else: ?>
                            <p>No ha alcanzado el monto necesario para generar el contrato.</p>
                        <?php endif; ?>
                    </div>
                    <!-- Contacto -->
                    <div id="contacto" class="tab-content" style="display: none;">
                        <h3>Contacto</h3>
                        <form>
                            <div class="mb-3">
                                <label for="contactoNombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="contactoNombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="contactoEmail" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="contactoEmail" required>
                            </div>
                            <div class="mb-3">
                                <label for="contactoMensaje" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="contactoMensaje" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                    </div>
                    <!-- Mi Perfil -->
                    <div id="miPerfil" class="tab-content" style="display: none;">
                        <h3>Mi Perfil</h3>
                        <p>Nombre: <?php echo $user['nombre']; ?></p>
                        <p>Apellido: <?php echo $user['apellido']; ?></p>
                        <p>Email: <?php echo $user['email']; ?></p>
                    </div>
                    <!-- Bandeja de Entrada -->
                    <div id="bandejaEntrada" class="tab-content" style="display:                        none;">
                        <h3>Bandeja de entrada</h3>
                        <?php if (!empty($messages)): ?>
                            <ul>
                                <?php foreach ($messages as $message): ?>
                                    <li><?php echo $message['mensaje']; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>No tienes mensajes nuevos.</p>
                        <?php endif; ?>
                    </div>
                    <!-- Notificaciones -->
                    <div id="notificaciones" class="tab-content" style="display: none;">
                        <h3>Notificaciones</h3>
                        <?php if (!empty($notifications)): ?>
                            <ul>
                                <?php foreach ($notifications as $notification): ?>
                                    <li><?php echo $notification['notificacion']; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>No tienes notificaciones nuevas.</p>
                        <?php endif; ?>
                    </div>
                    <!-- Configuración de la Cuenta -->
                    <div id="configuracionCuenta" class="tab-content" style="display: none;">
                        <h3>Configuración de la cuenta</h3>
                        <form method="POST" action="backend/change_password.php">
                            <div class="mb-3">
                                <label for="oldPassword" class="form-label">Contraseña Actual</label>
                                <input type="password" class="form-control" id="oldPassword" name="oldPassword" required>
                            </div>
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirmar Nueva Contraseña</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Dashboard End -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.list-group-item').click(function () {
                $('.list-group-item').removeClass('active');
                $(this).addClass('active');
                $('.tab-content').hide();
                const target = $(this).attr('id').split('-')[0];
                $('#' + target).show();
            });

            <?php if (isset($_GET['tab'])): ?>
            const activeTab = '<?php echo $_GET['tab']; ?>';
            $('.list-group-item').removeClass('active');
            $('#' + activeTab + '-tab').addClass('active');
            $('.tab-content').hide();
            $('#' + activeTab).show();
            <?php endif; ?>
        });
    </script>
</body>
</html>





