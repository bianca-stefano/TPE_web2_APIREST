# API REST de Biblioteca - TPE Web 2

Esta API permite gestionar una biblioteca (libros y autores). La autenticación se realiza mediante **JSON Web Tokens (JWT)**.

> **ACLARACIÓN:** El código se encuentra sobrecomentado con fines pedagógicos para facilitar el aprendizaje y la revisión. Entendemos que esta no es una práctica estándar en el ámbito profesional, donde se busca código autodocumentado.

---

### Usuario y contraseña

-matias
-matias

---

## Tecnologías utilizadas
- **Backend:** PHP nativo con arquitectura MVC.
- **Base de datos:** MySQL.
- **Seguridad:** JSON Web Tokens (JWT).
- **Ruteo:** Router propio (lib/router).

---

## Autenticación
Para acceder a los métodos protegidos (`POST`, `PUT`, `DELETE`), es necesario enviar un token JWT en el header de la petición:
- **Header:** `X-Authorization`
- **Valor:** `Bearer <TU_TOKEN_JWT>`

---

## Resumen de Endpoints

| Método | Endpoint | Descripción | Requiere Token |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/auth/login` | Obtiene el token JWT mediante Basic Auth | No |
| `GET` | `/api/libros` | Lista todos los libros (admite paginación) | No |
| `GET` | `/api/libros/:id` | Devuelve el detalle de un libro | No |
| `POST` | `/api/libros` | Agrega un nuevo libro | Sí (ADMIN) |
| `PUT` | `/api/libros/:id` | Actualiza un libro existente | Sí (ADMIN) |

---

## Documentación Detallada

### 1. Autenticación (Login)
* **URL:** `POST /api/auth/login`
* **Descripción:** Recibe credenciales y devuelve un token JWT.
* **Uso:** En Postman, usar la pestaña **Authorization** -> **Basic Auth** con el usuario y contraseña. El servidor devolverá el token necesario para las rutas protegidas.

### 2. Obtener todos los libros
* **URL:** `GET /api/libros`
* **Descripción:** Devuelve una lista de libros.
* **Parámetros (Opcionales):** * `page`: Número de página.
    * `limit`: Cantidad de resultados por página.
* **Ejemplo:** `GET /api/libros?page=1&limit=4`

### 3. Obtener un libro por ID
* **URL:** `GET /api/libros/:id`
* **Descripción:** Devuelve la información completa de un único libro.
* **Ejemplo:** `GET /api/libros/8`

### 4. Crear un nuevo libro
* **URL:** `POST /api/libros`
* **Descripción:** Inserta un nuevo libro (Requiere permisos de Admin).
* **Cuerpo (JSON):**
  
```json
{
    "id_autor": 1,
    "titulo": "El gran libro de Matías",
    "descripcion": "Descripción detallada",
    "imagen": "imagen.jpg",
    "fecha_publicacion": "2026-06-21"
}

### 5. Actualizar un nuevo libro
* **URL:** `PUT /api/libros/:id`
* **Descripción:** Actualiza un nuevo libro (Requiere permisos de Admin).
* **Cuerpo (JSON):**
```json
{
    "id_autor": 1,
    "titulo": "Título actualizado",
    "descripcion": "Nueva descripción",
    "imagen": "nueva_imagen.jpg",
    "fecha_publicacion": "2026-06-21"
}


