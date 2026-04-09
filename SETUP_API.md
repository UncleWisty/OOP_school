# OOP_school - API REST con Doctrine ORM

Este proyecto implementa una API REST con persistencia en base de datos usando Doctrine ORM, siguiendo la arquitectura DDD (Domain-Driven Design).

## Instalación

### 1. Instalar dependencias
```bash
composer install
```

### 2. Configurar la base de datos
Edita el archivo `.env` con tus credenciales:
```env
DB_DRIVER=pdo_mysql
DB_HOST=localhost
DB_PORT=3306
DB_USER=root
DB_PASSWORD=tu_contraseña
DB_NAME=school
```

### 3. Crear la base de datos
```bash
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS school;"
```

### 4. Crear las tablas con Doctrine
```bash
php bin/doctrine orm:schema-tool:create
```

O si ya existen las tablas y necesitas actualizarlas:
```bash
php bin/doctrine orm:schema-tool:update --force
```

## Estructura del Proyecto

```
OOP_school/
├── config/
│   ├── doctrine.php          # Configuración de Doctrine
│   └── routes.php            # Definición de rutas API
├── public/
│   ├── index.php             # Punto de entrada de la API
│   └── bootstrap.php         # Bootstrap del router y Entity Manager
├── src/
│   ├── Domain/               # Lógica de negocio (Entidades)
│   │   ├── Course/
│   │   ├── Enrollment/
│   │   ├── Shared/
│   │   ├── Student/
│   │   ├── Subject/
│   │   └── Teacher/
│   ├── Http/                 # Capa HTTP
│   │   ├── Controllers/      # Controladores API
│   │   ├── Request.php       # Manejo de requests
│   │   ├── ResponseJson.php  # Respuestas JSON
│   │   └── Routing/          # Router y RouteCollection
│   └── Infrastructure/       # Implementaciones concretas
│       └── Persistence/
│           └── Doctrine/     # Repositories de Doctrine
├── .env                      # Variables de entorno
└── composer.json
```

## Endpoints de la API

### Students
- `GET /api/students` - Obtener todos los estudiantes
- `GET /api/students/{id}` - Obtener estudiante por ID
- `POST /api/students` - Crear nuevo estudiante
- `PUT /api/students/{id}` - Actualizar estudiante
- `DELETE /api/students/{id}` - Eliminar estudiante

### Courses
- `GET /api/courses` - Obtener todos los cursos
- `GET /api/courses/{id}` - Obtener curso por ID
- `POST /api/courses` - Crear nuevo curso
- `PUT /api/courses/{id}` - Actualizar curso
- `DELETE /api/courses/{id}` - Eliminar curso

### Teachers
- `GET /api/teachers` - Obtener todos los profesores
- `GET /api/teachers/{id}` - Obtener profesor por ID
- `POST /api/teachers` - Crear nuevo profesor
- `PUT /api/teachers/{id}` - Actualizar profesor
- `DELETE /api/teachers/{id}` - Eliminar profesor

### Subjects
- `GET /api/subjects` - Obtener todas las asignaturas
- `GET /api/subjects/{id}` - Obtener asignatura por ID
- `POST /api/subjects` - Crear nueva asignatura
- `PUT /api/subjects/{id}` - Actualizar asignatura
- `DELETE /api/subjects/{id}` - Eliminar asignatura

### Enrollments
- `GET /api/enrollments` - Obtener todas las matriculaciones
- `GET /api/enrollments/{id}` - Obtener matriculación por ID
- `POST /api/enrollments` - Crear nueva matriculación
- `PUT /api/enrollments/{id}` - Actualizar matriculación
- `DELETE /api/enrollments/{id}` - Eliminar matriculación

## Ejemplos de uso con cURL

### Crear un estudiante
```bash
curl -X POST http://localhost:8000/api/students \
  -H "Content-Type: application/json" \
  -d '{
    "id": "student-001",
    "email": "john@example.com"
  }'
```

### Crear un curso
```bash
curl -X POST http://localhost:8000/api/courses \
  -H "Content-Type: application/json" \
  -d '{
    "id": "course-001",
    "name": "Matemáticas"
  }'
```

### Crear una asignatura
```bash
curl -X POST http://localhost:8000/api/subjects \
  -H "Content-Type: application/json" \
  -d '{
    "id": "subject-001",
    "name": "Álgebra",
    "courseId": "course-001"
  }'
```

### Crear una matriculación (curso completo)
```bash
curl -X POST http://localhost:8000/api/enrollments \
  -H "Content-Type: application/json" \
  -d '{
    "id": "enrollment-001",
    "academicYear": 2024,
    "academicYearEnd": 2025,
    "courseId": "course-001"
  }'
```

### Crear una matriculación (asignaturas parciales)
```bash
curl -X POST http://localhost:8000/api/enrollments \
  -H "Content-Type: application/json" \
  -d '{
    "id": "enrollment-002",
    "academicYear": 2024,
    "academicYearEnd": 2025,
    "subjectIds": ["subject-001", "subject-002"]
  }'
```

### Obtener un estudiante
```bash
curl -X GET http://localhost:8000/api/students/student-001 \
  -H "Content-Type: application/json"
```

### Actualizar un estudiante
```bash
curl -X PUT http://localhost:8000/api/students/student-001 \
  -H "Content-Type: application/json" \
  -d '{
    "email": "newemail@example.com"
  }'
```

### Eliminar un estudiante
```bash
curl -X DELETE http://localhost:8000/api/students/student-001
```

## Iniciar el servidor local

Usando PHP 8.2+:
```bash
php -S localhost:8000 -t public/
```

Luego acceder a: `http://localhost:8000/api/students`

## Características

✅ **Doctrine ORM** - Persistencia con modelado relacional
✅ **API REST** - Endpoints siguiendo convenciones REST
✅ **DDD** - Domain-Driven Design con Value Objects
✅ **Routing** - Sistema de routing flexible y potente
✅ **Response JSON** - Respuestas automáticas en JSON
✅ **Error Handling** - Manejo completo de excepciones
✅ **Environment Config** - Configuración con variables de entorno

## Notas Importantes

- Los IDs se generan como strings UUID (36 caracteres)
- Los Value Objects (StudentId, Email, CourseId, etc.) validan automáticamente
- Las respuestas siguen estándares REST (201 para creación, 204 para eliminación, 404 para no encontrado)
- Doctrine maneja automáticamente la persistencia y las relaciones
- Las matriculaciones pueden ser de curso completo o de asignaturas parciales
