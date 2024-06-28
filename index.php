<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Hasbi On Tour</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <?php session_start(); ?>
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
                    <?php if(isset($_SESSION['usuario_id'])): ?>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle text-light" data-bs-toggle="dropdown"><small><i class="fa fa-user me-2"></i> Mi Panel</small></a>
                            <div class="dropdown-menu rounded">
                                <a href="dashboard.php#miPerfil" class="dropdown-item"><i class="fas fa-user-alt me-2"></i> Mi Perfil</a>
                                <a href="dashboard.php#bandejaEntrada" class="dropdown-item"><i class="fas fa-comment-alt me-2"></i> Bandeja de entrada</a>
                                <a href="dashboard.php#notificaciones" class="dropdown-item"><i class="fas fa-bell me-2"></i> Notificaciones</a>
                                <a href="dashboard.php#configuracionCuenta" class="dropdown-item"><i class="fas fa-cog me-2"></i> Configuración de la cuenta</a>
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
    <div id="home" class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
            <a href="#home" class="navbar-brand p-0">
                <h1 class="m-0"><i class="fa fa-map-marker-alt me-3"></i>Hasbi On Tour</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="#home" class="nav-item nav-link active">Inicio</a>
                    <a href="#about" class="nav-item nav-link">Sobre nosotros</a>
                    <a href="#services" class="nav-item nav-link">Servicios</a>
                    <a href="#packages" class="nav-item nav-link">Paquetes</a>
                    <a href="#contact" class="nav-item nav-link">Contacto</a>
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar & Hero End -->

    <!-- Carousel Start -->
    <div class="carousel-header">
        <div id="carouselId" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active"></li>
                <li data-bs-target="#carouselId" data-bs-slide-to="1"></li>
                <li data-bs-target="#carouselId" data-bs-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <img src="img/carousel-2.jpg" class="img-fluid" alt="Imagen">
                    <div class="carousel-caption">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">Explora el mundo</h4>
                            <h1 class="display-2 text-capitalize text-white mb-4">¡Vamos a explorar el mundo juntos!</h1>
                            <p class="mb-5 fs-5">En Hasbi On Tour, nos especializamos en hacer de cada viaje de estudio una experiencia inolvidable y enriquecedora. Nuestra agencia se dedica a mejorar la eficiencia y la transparencia en la contratación y gestión de servicios turísticos destinados a giras de estudio. Entendemos la importancia de crear viajes que no solo sean educativos, sino también seguros y confiables para estudiantes, colegios y apoderados.
                            </p>
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="btn-hover-bg btn btn-primary rounded-pill text-white py-3 px-5" href="#">Descubre ahora</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/carousel-1.jpg" class="img-fluid" alt="Imagen">
                    <div class="carousel-caption">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">Explora el mundo</h4>
                            <h1 class="display-2 text-capitalize text-white mb-4">Encuentra tu tour perfecto en Travel</h1>
                            <p class="mb-5 fs-5">En Hasbi On Tour, nos especializamos en hacer de cada viaje de estudio una experiencia inolvidable y enriquecedora. Nuestra agencia se dedica a mejorar la eficiencia y la transparencia en la contratación y gestión de servicios turísticos destinados a giras de estudio. Entendemos la importancia de crear viajes que no solo sean educativos, sino también seguros y confiables para estudiantes, colegios y apoderados.
                            </p>
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="btn-hover-bg btn btn-primary rounded-pill text-white py-3 px-5" href="#">Descubre ahora</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/carousel-3.jpg" class="img-fluid" alt="Imagen">
                    <div class="carousel-caption">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">Explora el mundo</h4>
                            <h1 class="display-2 text-capitalize text-white mb-4">¿Te gustaría ir?</h1>
                            <p class="mb-5 fs-5">En Hasbi On Tour, nos especializamos en hacer de cada viaje de estudio una experiencia inolvidable y enriquecedora. Nuestra agencia se dedica a mejorar la eficiencia y la transparencia en la contratación y gestión de servicios turísticos destinados a giras de estudio. Entendemos la importancia de crear viajes que no solo sean educativos, sino también seguros y confiables para estudiantes, colegios y apoderados.
                            </p>
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="btn-hover-bg btn btn-primary rounded-pill text-white py-3 px-5" href="#">Descubre ahora</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                <span class="carousel-control-prev-icon btn bg-primary" aria-hidden="false"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                <span class="carousel-control-next-icon btn bg-primary" aria-hidden="false"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </div>
    <!-- Carousel End -->
</div>
<!-- Navbar & Hero End -->

<!-- About Start -->
<div id="about" class="container-fluid about py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5">
                <div class="h-100" style="border: 50px solid; border-color: transparent #13357B transparent #13357B;">
                    <img src="img/Light-Blue.png" class="img-fluid w-100 h-100" alt="">
                </div>
            </div>
            <div class="col-lg-7" style="background: linear-gradient(rgba(255, 255, 255, .8), rgba(255, 255, 255, .8)), url(img/about-img-1.png);">
                <h5 class="section-about-title pe-3">Sobre nosotros</h5>
                <h1 class="mb-4">Bienvenido a <span class="text-primary">Hasbi On Tour</span></h1>
                <p class="mb-4">En Hasbi On Tour, nos especializamos en hacer de cada viaje de estudio una experiencia inolvidable y enriquecedora. Nuestra agencia se dedica a mejorar la eficiencia y 
                    la transparencia en la contratación y gestión de servicios turísticos destinados a giras de estudio. Entendemos la importancia de crear viajes que no solo sean educativos, 
                    sino también seguros y confiables para estudiantes, colegios y apoderados.</p>
                <div class="row gy-2 gx-4 mb-4">
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Vuelos de primera</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Hoteles seleccionados</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Alojamientos de 5 estrellas</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Guias Especializados</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>10 Tours premium por la ciudad</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Servicio 24/7</p>
                    </div>
                </div>
                <a class="btn btn-primary rounded-pill py-3 px-5 mt-2" href="">Leer más</a>
            </div>
        </div>
    </div>
</div>
<!-- About End -->

<!-- Services Start -->
<div id="services" class="container-fluid bg-light service py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h5 class="section-title px-3">Servicios</h5>
            <h1 class="mb-0">Nuestros servicios</h1>
        </div>
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="d-flex border-top border-5 border-primary shadow-sm rounded p-4">
                        <i class="flaticon-route display-1 text-primary me-4"></i>
                        <div class="ps-3">
                            <h4>Tours alrededor del mundo</h4>
                            <p class="mb-0">En Hasbi On Tour, nos especializamos en crear experiencias únicas y memorables en cada rincón del planeta. Desde recorridos culturales hasta aventuras extremas, ofrecemos una amplia gama de tours que se adaptan a todas las preferencias y presupuestos.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="d-flex border-top border-5 border-primary shadow-sm rounded p-4">
                        <i class="flaticon-guide display-1 text-primary me-4"></i>
                        <div class="ps-3">
                            <h4>Reservación de hoteles</h4>
                            <p class="mb-0">Trabajamos con una selección de los mejores hoteles para garantizar que tu estancia sea cómoda y placentera. Nos aseguramos de ofrecer opciones que cumplan con los más altos estándares de calidad y servicio.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="d-flex border-top border-5 border-primary shadow-sm rounded p-4">
                        <i class="flaticon-guide display-1 text-primary me-4"></i>
                        <div class="ps-3">
                            <h4>Guías de viaje</h4>
                            <p class="mb-0">Nuestros guías especializados te acompañarán en cada paso del viaje, proporcionando información valiosa y asegurándose de que aproveches al máximo tu experiencia. Su conocimiento y pasión por los destinos harán que cada recorrido sea inolvidable.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="d-flex border-top border-5 border-primary shadow-sm rounded p-4">
                        <i class="flaticon-gear display-1 text-primary me-4"></i>
                        <div class="ps-3">
                            <h4>Gestión de eventos</h4>
                            <p class="mb-0">Organizamos y gestionamos eventos a medida para grupos escolares, empresas y particulares. Desde conferencias y seminarios hasta celebraciones y excursiones educativas, nos encargamos de todos los detalles para que tu evento sea un éxito rotundo.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Services End -->

<!-- Explore Tour Start -->
<div id="packages" class="container-fluid ExploreTour py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h5 class="section-title px-3">Explorar Tour</h5>
            <h1 class="mb-4">El mundo</h1>
            <p class="mb-0">En Hasbi On Tour, nos especializamos en hacer de cada viaje de estudio una experiencia inolvidable y enriquecedora. Nuestra agencia se dedica a mejorar la eficiencia y la transparencia en la contratación y gestión de servicios turísticos destinados a giras de estudio. Entendemos la importancia de crear viajes que no solo sean educativos, sino también seguros y confiables para estudiantes, colegios y apoderados.
            </p>
        </div>
        <div class="tab-class text-center">
            <ul class="nav nav-pills d-inline-flex justify-content-center mb-5">
                <li class="nav-item">
                    <a class="d-flex py-2 mx-3 border border-primary bg-light rounded-pill" data-bs-toggle="pill" href="#InternationalTab-2">
                        <span class="text-dark" style="width: 250px;">Ver tours internacionales</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="InternationalTab-2" class="tab-pane fade show p-0">
                    <div class="row g-4">
                        <div class="col-md-6 col-lg-4">
                            <div class="international-item">
                                <img src="img/explore-tour-1.jpg" class="img-fluid w-100 rounded" alt="Imagen">
                                <div class="international-content">
                                    <div class="international-info">
                                        <h5 class="text-white text-uppercase mb-2">Aventura Andida</h5>
                                        <p class="text-white mb-2">Destino: Cusco, Perú</p>
                                        <p class="text-white mb-2">Duracion: 7 noches</p>
                                        <a href="#" class="btn-hover text-white">Ver todos los lugares <i class="fa fa-arrow-right ms-2"></i></a>
                                    </div>
                                </div>
                                <div class="international-plus-icon">
                                    <a href="#" class="my-auto"><i class="fas fa-link fa-2x text-white"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="international-item">
                                <img src="img/explore-tour-2.jpg" class="img-fluid w-100 rounded" alt="Imagen">
                                <div class="international-content">
                                    <div class="international-info">
                                        <h5 class="text-white text-uppercase mb-2">Exploración del Caribe</h5>
                                        <p class="text-white mb-2">Destino: Cartagena, Colombia</p>
                                        <p class="text-white mb-2">Duración: 5 noches</p>
                                        <a href="#" class="btn-hover text-white">Ver todos los lugares <i class="fa fa-arrow-right ms-2"></i></a>
                                    </div>
                                </div>
                                <div class="international-plus-icon">
                                    <a href="#" class="my-auto"><i class="fas fa-link fa-2x text-white"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="international-item">
                                <img src="img/explore-tour-3.jpg" class="img-fluid w-100 rounded" alt="Imagen">
                                <div class="international-content">
                                    <div class="international-info">
                                        <h5 class="text-white text-uppercase mb-2">Aventura Patagónica</h5>
                                        <p class="text-white mb-2">Destino: Torres del Paine, Chile</p>
                                        <p class="text-white mb-2">Duración: 5 días</p>
                                        <a href="#" class="btn-hover text-white">Ver todos los lugares <i class="fa fa-arrow-right ms-2"></i></a>
                                    </div>
                                </div>
                                <div class="international-plus-icon">
                                    <a href="#" class="my-auto"><i class="fas fa-link fa-2x text-white"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="international-item">
                                <img src="img/explore-tour-4.jpg" class="img-fluid w-100 rounded" alt="Imagen">
                                <div class="international-content">
                                    <div class="international-info">
                                        <h5 class="text-white text-uppercase mb-2">Sol y Playa en Búzios</h5>
                                        <p class="text-white mb-2">Destino: Búzios, Brasil</p>
                                        <p class="text-white mb-2">Duración: 7 días</p>
                                        <a href="#" class="btn-hover text-white">Ver todos los lugares <i class="fa fa-arrow-right ms-2"></i></a>
                                    </div>
                                </div>
                                <div class="international-plus-icon">
                                    <a href="#" class="my-auto"><i class="fas fa-link fa-2x text-white"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="international-item">
                                <img src="img/explore-tour-5.jpg" class="img-fluid w-100 rounded" alt="Imagen">
                                <div class="international-content">
                                    <div class="international-info">
                                        <h5 class="text-white text-uppercase mb-2">Encantos de Buenos Aires</h5>
                                        <p class="text-white mb-2">Destino: Buenos Aires, Argentina</p>
                                        <p class="text-white mb-2">Duración: 4 días</p>
                                        <a href="#" class="btn-hover text-white">Ver todos los lugares <i class="fa fa-arrow-right ms-2"></i></a>
                                    </div>
                                </div>
                                <div class="international-plus-icon">
                                    <a href="#" class="my-auto"><i class="fas fa-link fa-2x text-white"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="international-item">
                                <img src="img/explore-tour-6.jpg" class="img-fluid w-100 rounded" alt="Imagen">
                                <div class="international-content">
                                    <div class="international-info">
                                        <h5 class="text-white text-uppercase mb-2">Escapada Tropical a Cancún</h5>
                                        <p class="text-white mb-2">Destino: Cancún, México</p>
                                        <p class="text-white mb-2">Duración: 6 días</p>
                                        <a href="#" class="btn-hover text-white">Ver todos los lugares <i class="fa fa-arrow-right ms-2"></i></a>
                                    </div>
                                </div>
                                <div class="international-plus-icon">
                                    <a href="#" class="my-auto"><i class="fas fa-link fa-2x text-white"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Explore Tour End -->
<!-- Contact Start -->
<div id="contact" class="container-fluid contact bg-light py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h5 class="section-title px-3">Contáctanos</h5>
            <h1 class="mb-0">Contacta para cualquier consulta</h1>
        </div>
        <div class="row g-5 align-items-center">
            <div class="col-lg-4">
                <div class="bg-white rounded p-4">
                    <div class="text-center mb-4">
                        <i class="fa fa-map-marker-alt fa-3x text-primary"></i>
                        <h4 class="text-primary">Dirección</h4>
                        <p class="mb-0">Av. Vicuña Mackenna 4917,<br> San Joaquin, Santiago, Chile.</p>
                    </div>
                    <div class="text-center mb-4">
                        <i class="fa fa-phone-alt fa-3x text-primary mb-3"></i>
                        <h4 class="text-primary">Teléfono</h4>
                        <p class="mb-0">+56984494726</p>
                    </div>
                    <div class="text-center">
                        <i class="fa fa-envelope-open fa-3x text-primary mb-3"></i>
                        <h4 class="text-primary">Correo Electrónico</h4>
                        <p class="mb-0">contacto@hasbiontour.cl</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <h3 class="mb-2">Envíanos un mensaje</h3>
                <div id="contact-response" class="mb-4"></div>
                <form id="contact-form">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control border-0" id="name" name="name" placeholder="Tu Nombre" required>
                                <label for="name">Tu Nombre</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control border-0" id="email" name="email" placeholder="Tu Correo Electrónico" required>
                                <label for="email">Tu Correo Electrónico</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control border-0" id="subject" name="subject" placeholder="Asunto" required>
                                <label for="subject">Asunto</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control border-0" placeholder="Deja un mensaje aquí" id="message" name="message" style="height: 160px" required></textarea>
                                <label for="message">Mensaje</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100 py-3" type="submit">Enviar Mensaje</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <div class="rounded">
                    <iframe class="rounded w-100" 
                    style="height: 450px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3327.0496563678644!2d-70.61886772444221!3d-33.50008517336982!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662d00be4a5fa81%3A0xcd8eaf5b1d547f64!2sDuoc%20UC%3A%20Sede%20San%20Joaqu%C3%ADn!5e0!3m2!1ses-419!2scl!4v1719513210899!5m2!1ses-419!2scl" 
                    loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>     
<!-- Contact End -->

<!-- Footer Start -->
<div class="container-fluid footer py-5">
<div class="container py-5">
    <div class="row g-5">
        <div class="col-md-4">
            <div class="footer-item d-flex flex-column">
                <h4 class="mb-4 text-white">Contacto</h4>
                <p><i class="fas fa-home me-2"></i> Av. Vicuña Mackenna 4917, San Joaquin, Santiago, Chile</p>
                <p><i class="fas fa-envelope me-2"></i> contacto@hasbiontour.cl</p>
                <p><i class="fas fa-phone me-2"></i> +56984494726</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="footer-item d-flex flex-column">
                <h4 class="mb-4 text-white">Links</h4>
                <a href="#home" class="nav-item nav-link active">Inicio</a>
                <a href="#about" class="nav-item nav-link">Sobre nosotros</a>
                <a href="#services" class="nav-item nav-link">Servicios</a>
                <a href="#packages" class="nav-item nav-link">Paquetes</a>
                <a href="#contact" class="nav-item nav-link">Contacto</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="footer-item">
                <h4 class="mb-4 text-white">Redes Sociales</h4>
                <p><i class="fab fa-facebook-f me-2"></i> <a href="https://facebook.com/hasbiontour" class="text-white">facebook.com/hasbiontour</a></p>
                <p><i class="fab fa-twitter me-2"></i> <a href="https://twitter.com/hasbiontour" class="text-white">twitter.com/hasbiontour</a></p>
                <p><i class="fab fa-instagram me-2"></i> <a href="https://instagram.com/hasbiontour" class="text-white">instagram.com/hasbiontour</a></p>
                <p><i class="fab fa-linkedin-in me-2"></i> <a href="https://linkedin.com/hasbiontour" class="text-white">linkedin.com/hasbiontour</a></p>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Footer End -->

<!-- Back to Top -->
<a href="#" class="btn btn-primary py-3 fs-4 back-to-top"><i class="fa fa-arrow-up"></i></a>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Iniciar sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="loginForm" method="POST" action="backend/login.php">
                    <div class="mb-3">
                        <label for="loginEmail" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="loginEmail" name="email" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="loginPassword" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="loginPassword" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Registrar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="registerForm" method="POST" action="backend/register.php">
                    <div class="mb-3">
                        <label for="registerFirstName" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="registerFirstName" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="registerLastName" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="registerLastName" name="apellido" required>
                    </div>
                    <div class="mb-3">
                        <label for="registerEmail" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="registerEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="registerPassword" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="registerPassword" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>
<script src="js/main.js"></script>

<script>
    function showLoginModal() {
        $('#registerModal').modal('hide');
        $('#loginModal').modal('show');
    }

    $(document).ready(function () {
        $('#registerForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'backend/register.php',
                data: $(this).serialize(),
                success: function(response) {
                    console.log("Response received:");
                    console.log(response);
                    var res = JSON.parse(response);
                    $('#registerMessage').html(res.message).removeClass().addClass('alert alert-' + (res.status === 'success' ? 'success' : 'danger'));
                    if (res.status === 'success') {
                        $('#registerForm')[0].reset();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error occurred:");
                    console.error(xhr.responseText);
                }
            });
        });

        $('#loginForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'backend/login.php',
                data: $(this).serialize(),
                success: function(response) {
                    try {
                        var res = JSON.parse(response);
                        if (res.status === 'success') {
                            alert('Inicio de sesión exitoso');
                            window.location.href = res.redirect;
                        } else {
                            alert(res.message);
                        }
                    } catch (e) {
                        console.error('Error al parsear JSON:', e);
                        console.error('Respuesta del servidor:', response);
                        alert('Error en la respuesta del servidor');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error);
                    console.error('Estado:', status);
                    console.error('Respuesta:', xhr.responseText);
                    alert('Error en la solicitud de inicio de sesión');
                }
            });
        });
    });
</script>

</body>

</html>