# Juegos UCSI 2024

Este proyecto es un sistema web para gestionar la inscripción y seguimiento de deportistas en los Juegos UCSI 2024. Los administradores pueden registrar usuarios, delegados, y deportistas, mientras que los delegados pueden registrar deportistas en diferentes categorías deportivas.

## Tecnologías Utilizadas

- PHP
- MySQL
- HTML/CSS
- JavaScript

## Funcionalidades

- Sistema de autenticación (login/logout)
- Registro de usuarios (administradores y delegados)
- Registro de deportistas
- Listado de deportistas con filtros por universidad y categoría
- Panel de control para administradores
- Verificación de duplicados en la inscripción de deportistas

## Instalación

### Prerrequisitos

- Servidor web (Apache, Nginx, etc.)
- PHP >= 7.4
- MySQL
- phpMyAdmin (opcional, pero recomendado)

### Instrucciones

1. Clona este repositorio en tu servidor local:
    ```bash
    git clone https://github.com/tu_usuario/juegos-ucsi-2024.git
    ```

2. Navega a la carpeta del proyecto:
    ```bash
    cd juegos-ucsi-2024
    ```

3. Configura tu base de datos:
    - Crea una base de datos en MySQL llamada `juegos_ucsi_2024`.
    - Importa el archivo `juegos_ucsi_2024.sql` en tu base de datos. Puedes hacerlo mediante phpMyAdmin o la línea de comandos:
        ```bash
        mysql -u tu_usuario -p juegos_ucsi_2024 < juegos_ucsi_2024.sql
        ```

4. Configura la conexión a la base de datos en el archivo `php/db_connection.php`:
    ```php
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "juegos_ucsi_2024";

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    ?>
    ```

5. Asegúrate de que tu servidor web esté configurado para servir el proyecto. Si estás utilizando Apache, asegúrate de tener un archivo `.htaccess` para la redirección de URL si es necesario.

## Uso

1. Accede a la página de inicio del proyecto mediante tu navegador web:
    ```
    http://localhost/juegos-ucsi-2024/
    ```

2. Registra un administrador inicial mediante la interfaz de usuario.

3. Usa el panel de control para registrar delegados y deportistas.

4. Filtra y visualiza los deportistas registrados mediante los filtros de universidad y categoría.

## Contribuciones

¡Las contribuciones son bienvenidas! Si deseas contribuir, sigue estos pasos:

1. Haz un fork de este repositorio.
2. Crea una nueva rama para tu función (`git checkout -b feature/nueva-funcion`).
3. Realiza tus cambios y haz commit (`git commit -am 'Agrega nueva función'`).
4. Haz push a la rama (`git push origin feature/nueva-funcion`).
5. Crea un nuevo Pull Request.

## Licencia

Este proyecto está bajo la licencia MIT. Consulta el archivo [LICENSE](LICENSE) para obtener más información.

## Contacto

Si tienes preguntas o sugerencias, no dudes en abrir un issue o contactarme a través de [tu_email@example.com](mailto:tu_email@example.com).
