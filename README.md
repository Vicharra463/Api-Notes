# API de Notas

Este proyecto es una API RESTful construida con Laravel para gestionar notas personales. Permite a los usuarios registrarse, iniciar sesión y realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) en sus notas de forma segura.

## ✨ Características

- Autenticación de usuarios basada en tokens (Laravel Sanctum).
- Registro, inicio de sesión y cierre de sesión de usuarios.
- Operaciones CRUD completas para las notas.
- Validación de solicitudes para garantizar la integridad de los datos.
- Respuestas de API estandarizadas usando Recursos de Laravel.

## 🛠️ Tecnologías Utilizadas

- **Backend:** PHP 8+, Laravel 10+
- **Base de Datos:** MySQL (o cualquier otra soportada por Laravel)
- **Autenticación:** Laravel Sanctum
- **Dependencias PHP:** `composer`
- **Dependencias Frontend:** `npm` (para herramientas de desarrollo como Vite)

## 🏗️ Arquitectura del Proyecto

La API sigue una arquitectura limpia y organizada, aprovechando las características de Laravel para separar responsabilidades.

- **`app/Http/Controllers`**: Contienen la lógica para manejar las solicitudes HTTP. Delegan la lógica de negocio a los servicios y utilizan `Requests` para la validación y `Resources` para formatear las respuestas.
    - `AutController`: Gestiona el registro, inicio de sesión y cierre de sesión.
    - `UserController`: Gestiona la obtención de datos del usuario autenticado.
    - `NoteController`: Gestiona las operaciones CRUD para las notas.

- **`app/Http/Requests`**: Clases de solicitud de formulario que contienen las reglas de validación para los datos de entrada. Esto mantiene los controladores limpios.
    - `UserRequest`: Reglas para el registro de usuarios.
    - `NoteRequest`: Reglas para la creación y actualización de notas.

- **`app/Http/Resources`**: Transforman los modelos de Eloquent en respuestas JSON estandarizadas, permitiendo controlar qué datos se exponen en la API.
    - `UserResource`: Formatea los datos del usuario.
    - `NoteResource`: Formatea los datos de las notas.

- **`app/Services`**: Capa de servicio que encapsula la lógica de negocio principal. Esto desacopla la lógica de los controladores, haciendo el código más reutilizable y fácil de mantener.
    - `AuthServices`: Lógica para la autenticación.
    - `UserService`: Lógica de negocio relacionada con los usuarios.
    - `NoteServices`: Lógica de negocio para las operaciones con notas.

- **`app/Models`**: Modelos de Eloquent que definen las relaciones y la interacción con la base de datos.
    - `User`: Modelo para la tabla `users`.
    - `Note`: Modelo para la tabla `notes`.

- **`routes/api.php`**: Archivo donde se definen todos los endpoints de la API. Las rutas están protegidas con el middleware `auth:sanctum` cuando es necesario.

- **`database/migrations`**: Contienen las definiciones del esquema de la base de datos, permitiendo crear y modificar las tablas de forma versionada.

## 🚀 Guía de Instalación

Sigue estos pasos para configurar el proyecto en tu entorno local.

1.  **Clonar el repositorio:**
    ```bash
    git clone https://github.com/tu-usuario/Api-Notes.git
    cd Api-Notes
    ```

2.  **Instalar dependencias:**
    ```bash
    composer install
    npm install
    ```

3.  **Configurar el entorno:**
    Copia el archivo de ejemplo `.env.example` y renómbralo a `.env`.
    ```bash
    copy .env.example .env
    ```
    Configura las variables de entorno en el archivo `.env`, especialmente la conexión a la base de datos (`DB_*`).

4.  **Generar la clave de la aplicación:**
    ```bash
    php artisan key:generate
    ```

5.  **Ejecutar las migraciones:**
    Esto creará las tablas necesarias en tu base de datos.
    ```bash
    php artisan migrate
    ```

6.  **Iniciar el servidor:**
    ```bash
    php artisan serve
    ```
    La API estará disponible en `http://127.0.0.1:8000`.

## 📚 Documentación de Endpoints

Todas las rutas de la API están prefijadas con `/api`. Las rutas que requieren autenticación deben incluir el token Bearer en la cabecera `Authorization`.

`Authorization: Bearer <token>`

---

### Autenticación

#### `POST /register`
Registra un nuevo usuario.

- **Body:**
    ```json
    {
        "name": "John Doe",
        "email": "john.doe@example.com",
        "password": "password123",
        "password_confirmation": "password123"
    }
    ```
- **Respuesta Exitosa (201 Created):**
    ```json
    {
        "data": {
            "id": 1,
            "name": "John Doe",
            "email": "john.doe@example.com"
        },
        "token": "1|aBcDeFgHiJkLmNoPqRsTuVwXyZ..."
    }
    ```

#### `POST /login`
Inicia sesión y obtiene un token de autenticación.

- **Body:**
    ```json
    {
        "email": "john.doe@example.com",
        "password": "password123"
    }
    ```
- **Respuesta Exitosa (200 OK):**
    ```json
    {
        "data": {
            "id": 1,
            "name": "John Doe",
            "email": "john.doe@example.com"
        },
        "token": "2|aBcDeFgHiJkLmNoPqRsTuVwXyZ..."
    }
    ```

#### `POST /logout`
Cierra la sesión del usuario (invalida el token actual).
- **Autenticación:** Requerida.
- **Respuesta Exitosa (200 OK):**
    ```json
    {
        "message": "Sesión cerrada exitosamente"
    }
    ```

---

### Notas (`/notes`)

#### `GET /notes`
Obtiene todas las notas del usuario autenticado.
- **Autenticación:** Requerida.
- **Respuesta Exitosa (200 OK):**
    ```json
    {
        "data": [
            {
                "id": 1,
                "title": "Mi primera nota",
                "content": "Este es el contenido de la nota.",
                "created_at": "2025-10-02T10:00:00.000000Z"
            }
        ]
    }
    ```

#### `POST /notes`
Crea una nueva nota.
- **Autenticación:** Requerida.
- **Body:**
    ```json
    {
        "title": "Nueva Nota",
        "content": "Contenido de la nueva nota."
    }
    ```
- **Respuesta Exitosa (201 Created):**
    ```json
    {
        "data": {
            "id": 2,
            "title": "Nueva Nota",
            "content": "Contenido de la nueva nota.",
            "created_at": "2025-10-02T11:00:00.000000Z"
        }
    }
    ```

#### `GET /notes/{id}`
Obtiene una nota específica por su ID.
- **Autenticación:** Requerida.
- **Respuesta Exitosa (200 OK):**
    ```json
    {
        "data": {
            "id": 1,
            "title": "Mi primera nota",
            "content": "Este es el contenido de la nota.",
            "created_at": "2025-10-02T10:00:00.000000Z"
        }
    }
    ```

#### `PUT /notes/{id}`
Actualiza una nota existente.
- **Autenticación:** Requerida.
- **Body:**
    ```json
    {
        "title": "Nota Actualizada",
        "content": "Contenido actualizado."
    }
    ```
- **Respuesta Exitosa (200 OK):**
    ```json
    {
        "data": {
            "id": 1,
            "title": "Nota Actualizada",
            "content": "Contenido actualizado.",
            "created_at": "2025-10-02T10:00:00.000000Z"
        }
    }
    ```

#### `DELETE /notes/{id}`
Elimina una nota.
- **Autenticación:** Requerida.
- **Respuesta Exitosa (204 No Content):** (Sin contenido en la respuesta)