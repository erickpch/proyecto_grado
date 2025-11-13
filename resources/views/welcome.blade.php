<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bienvenido - Sistema de Gestión</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <header>
    <div class="logo">
      <img src="{{ asset('storage/general/logo.png') }}" alt="Logo del sistema" />
    </div>
    <nav>
      <ul>
        <li><a href="#">Inicio</a></li>
        <li><a href="#">Servicios</a></li>
        <li><a href="#">Acerca</a></li>
        <li><a href="#">Contacto</a></li>
      </ul>
    </nav>
    <div class="login-btn">
      <a href="{{ route('login') }}" class="btn">Login</a>
    </div>
  </header>
    <div class="hero-image"></div>
  <footer>
    <p>© 2025 Sistema de Gestión | Todos los derechos reservados.</p>
  </footer>

  <style>

    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}

body {
  background-color: #f2f2f2;
  color: #333;
}

/* ----- HEADER ----- */
header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background-color: #fff;
  padding: 15px 50px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}
.hero-image {
  width: 100%;
  height: 400px; /* puedes ajustar la altura */
  background-image: url("{{ asset('storage/general/hotel.jpg') }}");
  background-size: cover;     /* se estira manteniendo proporción */
  background-position: center; /* centra la imagen */
  background-repeat: no-repeat;
}


.logo img {
  height: 60px;
}

nav ul {
  display: flex;
  list-style: none;
  gap: 25px;
}

nav ul li a {
  text-decoration: none;
  color: #222;
  font-weight: 500;
  transition: 0.3s;
}

nav ul li a:hover {
  color: #007bff;
}

.login-btn .btn {
  background-color: #007bff;
  color: white;
  padding: 10px 20px;
  border-radius: 6px;
  text-decoration: none;
  font-weight: 500;
  transition: 0.3s;
}

.login-btn .btn:hover {
  background-color: #0056b3;
}

/* ----- HERO SECTION ----- */
.hero {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 80vh;
  background: linear-gradient(to right, #333, #666);
  color: #fff;
  text-align: center;
}

.hero-content {
  max-width: 700px;
  background-color: rgba(0, 0, 0, 0.5);
  padding: 50px;
  border-radius: 20px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.hero-content h1 {
  font-size: 2.5rem;
  margin-bottom: 20px;
}

.hero-content p {
  font-size: 1.1rem;
  margin-bottom: 30px;
}

.btn.primary {
  background-color: #007bff;
  padding: 12px 25px;
  border-radius: 8px;
  text-decoration: none;
  color: white;
  font-weight: bold;
  transition: 0.3s;
}

.btn.primary:hover {
  background-color: #0056b3;
}

/* ----- FOOTER ----- */
footer {
  text-align: center;
  padding: 20px 0;
  background-color: #222;
  color: #ccc;
  font-size: 0.9rem;
}

  </style>
</body>
</html>
