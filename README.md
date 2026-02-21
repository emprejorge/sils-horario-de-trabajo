# 📅 Sistema de Gestión de Horarios

Sistema web desarrollado en **CodeIgniter 4** para la gestión
institucional de horarios con autenticación tradicional y login con
Google.

---

## 🚀 Funcionalidades

### 👤 Usuario

- Inicio de sesión con email/contraseña
- Inicio de sesión con Google (OAuth 2.0)
- Carga y edición de horario semanal
- Cálculo automático de horas trabajadas (formato HH:MM)
- Visualización de estado:
  - 🟡 Pendiente
  - 🟢 Aprobado
- Bloqueo automático del horario una vez aprobado por administración

### 🛠 Administrador

- Listado completo de usuarios
- Visualización y edición de horarios
- Aprobación / desaprobación de horarios
- Registro automático de fecha y hora de aprobación
- Indicadores visuales (badges) de estado

---

## 🏗 Tecnologías utilizadas

- PHP 8+
- CodeIgniter 4
- MySQL / MariaDB
- Bootstrap 5
- Bootstrap Icons
- Google OAuth 2.0

---

## ⚙️ Instalación

### 1️⃣ Clonar el repositorio

```bash
git clone https://github.com/emprejorge/sils-horario-de-trabajo.git
cd sils-horario-de-trabajo
```

---

### 2️⃣ Instalar dependencias

```bash
composer install
```

---

### 3️⃣ Configurar entorno

Copiar archivo base de entorno:

#### En macOS / Linux:

```bash
cp env .env
```

#### En Windows:

```bash
copy env .env
```

---

Editar el archivo `.env` y configurar:

### 🔹 Base URL

    app.baseURL = 'http://localhost:8080/'

---

### 🔹 Base de datos

    database.default.hostname = localhost
    database.default.database = nombre_base_datos
    database.default.username = root
    database.default.password = password
    database.default.DBDriver = MySQLi

---

### 🔹 Zona horaria

Ejemplo:

    app.appTimezone = America/Santiago

---

### 🔹 Configuración Google OAuth (OBLIGATORIO)

Agregar en `.env`:

    GOOGLE_CLIENT_ID= ''
    GOOGLE_CLIENT_SECRET= ''
    GOOGLE_REDIRECT_URI= ''

Ejemplo:

    GOOGLE_CLIENT_ID= 1234567890-xxxxxxxxxxxxxxxxxxxxxxxx.apps.googleusercontent.com
    GOOGLE_CLIENT_SECRET= GOCSPX-xxxxxxxxxxxxxxxx
    GOOGLE_REDIRECT_URI= http://localhost:8080/auth/googleCallback

⚠ Importante: - El `GOOGLE_REDIRECT_URI` debe coincidir exactamente con
el configurado en Google Cloud Console. - Nunca subir estos valores
reales al repositorio.

---

## 🔐 Configurar Google Cloud Console

1.  Ir a https://console.cloud.google.com/
2.  Crear un nuevo proyecto
3.  Habilitar "Google Identity Services"
4.  Crear credenciales → OAuth Client ID
5.  Tipo: Aplicación Web
6.  Agregar:
    - Orígenes autorizados:\
      `http://localhost:8080`
    - URIs de redirección autorizados:\
      `http://localhost:8080/auth/googleCallback`
7.  Copiar Client ID y Client Secret al `.env`

---

## 🗄 Crear base de datos

Crear la base de datos en MySQL y luego ejecutar:

```bash
php spark migrate
```

---

## ▶ Ejecutar el proyecto

```bash
php spark serve
```

Abrir en navegador:

    http://localhost:8080

---

## 📁 Estructura principal

    app/
     ├── Controllers/
     ├── Models/
     ├── Views/
     ├── Database/Migrations/

    public/

---

## 🔒 Seguridad

- Validación de sesión por roles
- Protección de edición cuando el horario está aprobado
- Manejo seguro de checkbox booleanos
- Exclusión de archivos sensibles en `.gitignore`:
  - `/vendor`
  - `/writable`
  - `.env`

---

## 📌 Mejoras futuras

- Registro de qué administrador aprobó
- Historial de cambios
- Notificaciones por email
- Dashboard con métricas
- Exportación a PDF
- Filtro avanzado en panel administrador

---

## 👨‍💻 Autor

Sistema desarrollado como solución institucional para gestión interna de
horarios.

---

## 📄 Licencia

Uso interno / académico.
