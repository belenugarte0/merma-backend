<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a LOGISTIC - Sistema de Gestión</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        #container {
            max-width: 600px;
            margin: 0 auto;
        }

        header {
            background: #00a6f3 !important;
            background: -webkit-linear-gradient(to right, #00ceff, #00a6f3) !important;
            background: linear-gradient(to right, #00ceff, #00a6f3) !important;
            text-align: center;
            color: #fff;
            border-radius: 20px 20px 0 0;
        }

        main {
            padding: 20px;
        }

        footer {
            background-color: #f1f1f1;
            padding: 5px;
            text-align: center;
            border-radius: 0 0 20px 20px;
        }

        a {
            color: #4285f4;
            text-decoration: none;
            font-weight: bold;
        }

        .logo {
            padding-top: 10px;
            left: 10px;
            width: 60px;
            height: auto;
        }
        .title {
            margin-top: 15px !important;
            padding-bottom: 5px;
            padding-top: -15px !important;
        }
    </style>
</head>

<body>
    <div id="container">
        <header>
            <div class="logo-container">
                <img src="https://lapapelera.com/wp-content/uploads/2020/11/grupo350-300x228.png" class="logo" alt="Logo de LOGISTIC">
            </div>
            <h1 class="title">BIENVENIDO A LOGISTIC</h1>
        </header>
        <main>
            <p>Hola {{ $userName }},</p>
            <p>Te damos la bienvenida a LOGISTIC, el Sistema de Gestión que te ayudará a administrar tus tareas de manera eficiente.</p>
            <p>A continuación, encontrarás tus credenciales para iniciar sesión:</p>
            <ul>
                <li><strong>Usuario:</strong> {{ $userEmail }}</li>
                <li><strong>Contraseña:</strong> {{ $generatedPassword }}</li>
            </ul>
            <p>Por favor, guarda esta información en un lugar seguro. Haz clic en el siguiente enlace para iniciar sesión:</p>
            <a href="http://localhost:5173/auth/login">Iniciar Sesión</a>
        </main>
        <footer>
            <p>&copy; 2024 LOGISTIC. Todos los derechos reservados.</p>
        </footer>
    </div>
</body>

</html>
