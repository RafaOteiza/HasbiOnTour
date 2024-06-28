<?php
session_start();
if (!isset($_SESSION['usuario_id']) || !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid bg-primary px-5 d-none d-lg-block">
        <div class="row gx-0">
            <div class="col-lg-8 text-center text-lg-start mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center" style="height: 45px;">
</div>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <div class="d-inline-flex align-items-center" style="height: 45px;">
                    <?php if(isset($_SESSION['usuario_id'])): ?>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle text-light" data-bs-toggle="dropdown"><small><i class="fa fa-user me-2"></i> Mi Panel</small></a>
                            <div class="dropdown-menu rounded">
                                <a href="backend/logout.php" class="dropdown-item"><i class="fas fa-power-off me-2"></i> Cerrar sesión</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal"><small class="me-3 text-light"><i class="fa fa-user me-2"></i>Registrar</small></a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal"><small class="me-3 text-light"><i class="fa fa-sign-in-alt me-2"></i>Iniciar sesión</small></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-3">
                <div class="bg-light rounded h-100 p-4">
                    <div class="list-group">
                        <a href="#usuarios" class="list-group-item list-group-item-action active" data-bs-toggle="list">Usuarios</a>
                        <a href="#reportes" class="list-group-item list-group-item-action" data-bs-toggle="list">Reportes</a>
                        <a href="#contratos" class="list-group-item list-group-item-action" data-bs-toggle="list">Contratos</a>
                        <a href="#abonos" class="list-group-item list-group-item-action" data-bs-toggle="list">Abonos</a>
                        <a href="#mensajes" class="list-group-item list-group-item-action" data-bs-toggle="list">Mensajes</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-9">
                <div class="bg-light rounded h-100 p-4">
                    <div class="tab-content">
                        <!-- Usuarios -->
                        <div id="usuarios" class="tab-pane fade show active">
                            <h3>Usuarios</h3>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody id="usuariosTableBody">
                                    <!-- Los usuarios se llenarán aquí con AJAX -->
                                </tbody>
                            </table>
                        </div>
                        <!-- Reportes -->
                        <div id="reportes" class="tab-pane fade">
                            <h3>Reportes</h3>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Tipo</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody id="reportesTableBody">
                                    <!-- Los reportes se llenarán aquí con AJAX -->
                                </tbody>
                            </table>
                        </div>
                        <!-- Contratos -->
                        <div id="contratos" class="tab-pane fade">
                            <h3>Contratos</h3>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Tipo</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody id="contratosTableBody">
                                    <!-- Los contratos se llenarán aquí con AJAX -->
                                </tbody>
                            </table>
                        </div>
                        <!-- Abonos -->
                        <div id="abonos" class="tab-pane fade">
                            <h3>Abonos</h3>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Fecha</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody id="abonosTableBody">
                                    <!-- Los abonos se llenarán aquí con AJAX -->
                                </tbody>
                            </table>
                        </div>
                        <!-- Mensajes -->
                        <div id="mensajes" class="tab-pane fade">
                            <h3>Mensajes</h3>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Mensaje</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody id="mensajesTableBody">
                                    <!-- Los mensajes se llenarán aquí con AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Cargar usuarios
            $.getJSON('backend/get_usuarios.php', function (data) {
                var usuariosTableBody = $('#usuariosTableBody');
                data.forEach(function (usuario) {
                    usuariosTableBody.append('<tr><td>' + usuario.id + '</td><td>' + usuario.nombre + '</td><td>' + usuario.apellido + '</td><td>' + usuario.email + '</td></tr>');
                });
            });

            // Cargar reportes
            $.getJSON('backend/get_reportes.php', function (data) {
                var reportesTableBody = $('#reportesTableBody');
                data.forEach(function (reporte) {
                    reportesTableBody.append('<tr><td>' + reporte.id + '</td><td>' + reporte.nombre + '</td><td>' + reporte.apellido + '</td><td>' + reporte.tipo + '</td><td>' + reporte.fecha + '</td></tr>');
                });
            });

            // Cargar contratos
            $.getJSON('backend/get_contratos.php', function (data) {
                var contratosTableBody = $('#contratosTableBody');
                data.forEach(function (contrato) {
                    contratosTableBody.append('<tr><td>' + contrato.id + '</td><td>' + contrato.nombre + '</td><td>' + contrato.apellido + '</td><td>' + contrato.tipo + '</td><td>' + contrato.fecha + '</td></tr>');
                });
            });

            // Cargar abonos
            $.getJSON('backend/get_abonos.php', function (data) {
                var abonosTableBody = $('#abonosTableBody');
                data.forEach(function (abono) {
                    abonosTableBody.append('<tr><td>' + abono.id + '</td><td>' + abono.nombre + '</td><td>' + abono.apellido + '</td><td>' + abono.fecha + '</td><td>' + abono.monto + '</td></tr>');
                });
            });

            // Cargar mensajes
            $.getJSON('backend/get_mensajes.php', function (data) {
                var mensajesTableBody = $('#mensajesTableBody');
                data.forEach(function (mensaje) {
                    mensajesTableBody.append('<tr><td>' + mensaje.id + '</td><td>' + mensaje.nombre + '</td><td>' + mensaje.apellido + '</td><td>' + mensaje.mensaje + '</td><td>' + mensaje.fecha + '</td></tr>');
                });
            });
        });
    </script>
</body>
</html>
