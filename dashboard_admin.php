<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

if (!isset($_SESSION['usuario_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit();
}

include 'backend/config.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Administrador - Hasbi On Tour</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid bg-primary px-5 d-none d-lg-block">
        <div class="row gx-0">
            <div class="col-lg-8 text-center text-lg-start mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center" style="height: 45px;">
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href=""><i class="fab fa-twitter fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href=""><i class="fab fa-facebook-f fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href=""><i class="fab fa-linkedin-in fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href=""><i class="fab fa-instagram fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square" href=""><i class="fab fa-youtube fw-normal"></i></a>
                </div>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <div class="d-inline-flex align-items-center" style="height: 45px;">
                    <a href="backend/logout.php" class="btn btn-sm btn-outline-light">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3">
                    <div class="list-group list-group-flush bg-light rounded">
                        <a href="#" class="list-group-item list-group-item-action active" id="usuarios-tab">Usuarios</a>
                        <a href="#" class="list-group-item list-group-item-action" id="depositos-tab">Depósitos</a>
                        <a href="#" class="list-group-item list-group-item-action" id="polizas-tab">Pólizas</a>
                        <a href="#" class="list-group-item list-group-item-action" id="contratos-tab">Contratos</a>
                        <a href="#" class="list-group-item list-group-item-action" id="mensajes-tab">Mensajes</a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <h3>Bienvenido, Administrador</h3>
                    <div id="usuarios" class="tab-content">
                        <h3>Usuarios</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Apellido</th>
                                    <th scope="col">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $usuarios_query = $conn->query("SELECT id, nombre, apellido, email FROM usuarios");
                                while ($usuario = $usuarios_query->fetch_assoc()) {
                                    echo "<tr>
                                        <td>{$usuario['id']}</td>
                                        <td>{$usuario['nombre']}</td>
                                        <td>{$usuario['apellido']}</td>
                                        <td>{$usuario['email']}</td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="depositos" class="tab-content" style="display: none;">
                        <h3>Depósitos</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $depositos_query = $conn->query("SELECT abonos.id, usuarios.nombre, usuarios.apellido, abonos.fecha, abonos.monto FROM abonos JOIN usuarios ON abonos.usuario_id = usuarios.id");
                                while ($deposito = $depositos_query->fetch_assoc()) {
                                    echo "<tr>
                                        <td>{$deposito['id']}</td>
                                        <td>{$deposito['nombre']} {$deposito['apellido']}</td>
                                        <td>{$deposito['fecha']}</td>
                                        <td>\${$deposito['monto']}</td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="polizas" class="tab-content" style="display: none;">
                        <h3>Pólizas Generadas</h3>
                        <p>Implementar lógica para mostrar pólizas generadas</p>
                    </div>
                    <div id="contratos" class="tab-content" style="display: none;">
                        <h3>Contratos Generados</h3>
                        <p>Implementar lógica para mostrar contratos generados</p>
                    </div>
                    <div id="mensajes" class="tab-content" style="display: none;">
                        <h3>Buzón de Mensajes</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Mensaje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $mensajes_query = $conn->query("SELECT mensajes.id, usuarios.nombre, usuarios.apellido, mensajes.fecha, mensajes.mensaje FROM mensajes JOIN usuarios ON mensajes.usuario_id = usuarios.id");
                                while ($mensaje = $mensajes_query->fetch_assoc()) {
                                    echo "<tr>
                                        <td>{$mensaje['id']}</td>
                                        <td>{$mensaje['nombre']} {$mensaje['apellido']}</td>
                                        <td>{$mensaje['fecha']}</td>
                                        <td>{$mensaje['mensaje']}</td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.list-group-item-action').click(function () {
                $('.list-group-item-action').removeClass('active');
                $(this).addClass('active');
                $('.tab-content').hide();
                $('#' + $(this).attr('id').replace('-tab', '')).show();
            });
        });
    </script>
</body>

</html>
