# Juegos UCSI 2024

Este proyecto es un sistema web para gestionar y visualizar los fixtures, categorías y eventos de los Juegos UCSI 2024, incluyendo la noche inaugural. Está desarrollado en PHP y utiliza MySQL como base de datos.

## Características

- **Gestión de fixtures**: Los administradores pueden agregar, editar y eliminar partidos en diferentes categorías y fixtures.
- **Visualización de fixtures**: Los usuarios pueden ver los fixtures según la categoría seleccionada.
- **Eventos de la noche inaugural**: Un apartado especial para la noche inaugural que se muestra de forma destacada en el apartado de fixtures.
- **Filtros**: Los usuarios pueden filtrar los fixtures por categoría y fixture específico.
- **Seguridad**: El sistema requiere inicio de sesión para administrar los fixtures.


## Instalación

1. Clonar el repositorio:


git clone https://github.com/tu-usuario/juegos_ucsi_2024.git

    Configurar la base de datos:

    Crear una base de datos MySQL llamada juegos_ucsi_2024.
    Importar el archivo juegos_ucsi_2024.sql para crear las tablas necesarias.

    Configurar la conexión a la base de datos:

    Editar el archivo /db/db_connection.php con las credenciales de tu base de datos.

php

<?php
$servername = "localhost";
$username = "tu_usuario";
$password = "tu_contraseña";
$dbname = "juegos_ucsi_2024";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

    Ejecutar el servidor:

    Colocar los archivos en el directorio de tu servidor web (e.g., htdocs para XAMPP).
    Iniciar el servidor web (e.g., Apache).

Uso

    Inicio de sesión: Acceder a index.html para iniciar sesión.
    Agregar fixtures: Los administradores pueden agregar fixtures y eventos de la noche inaugural desde los respectivos formularios.
    Visualizar fixtures y eventos: Los usuarios pueden filtrar y ver los fixtures y eventos según la categoría seleccionada.

Base de datos
Esquema de la base de datos


Contribución

Las contribuciones son bienvenidas. Por favor, realiza un fork del repositorio y crea una nueva rama para tus cambios. Luego, envía una solicitud de pull con una descripción detallada de tus modificaciones.
Licencia

Este proyecto está licenciado bajo la Licencia MIT. Consulta el archivo LICENSE para más detalles.
Contacto

Para cualquier consulta, puedes contactarme en [tu-email@example.com].
