# Sistema de Ventas Laravel

Sistema de ventas y gestión desarrollado en **Laravel 12** con soporte para desarrollo local mediante entorno tradicional (PHP/Composer) o contenedorizado con **Docker (Laravel Sail)**.

---

## 📋 Requisitos Previos

Dependiendo del método que prefieras para ejecutar la aplicación, asegúrate de contar con:

### Opción 1: Entorno Local (Directo)
- **PHP** >= 8.2 (con extensiones `pdo`, `sqlite3` o `pdo_mysql`, `mbstring`, `openssl`, `curl`)
- **Composer** >= 2.x
- **Node.js** >= 18.x y **npm**
- Servidor de base de datos (**MariaDB / MySQL** o **SQLite**)

### Opción 2: Docker / Laravel Sail (Recomendado si no tienes PHP instalado)
- **Docker** y **Docker Compose**

---

## 🚀 Instalación y Puesta en Marcha

### 1. Clonar el repositorio

```bash
git clone git@github.com:Eliexxer/sistema-de-ventas-laravel.git
cd sistema-de-ventas-laravel
```
*(O usando HTTPS: `https://github.com/Eliexxer/sistema-de-ventas-laravel.git`)*

---

### 2. Configuración del Entorno

Copia el archivo de configuración base:

```bash
cp .env.example .env
```

Configura tus credenciales de base de datos en el archivo `.env` si vas a utilizar MariaDB/MySQL. Si vas a usar SQLite, asegúrate de crear el archivo correspondiente:

```bash
touch database/database.sqlite
```

---

### 3. Instalación de Dependencias y Base de Datos

#### 👉 Método A: Usando Entorno Local (PHP + Composer)

1. **Instalar dependencias de PHP:**
   ```bash
   composer install
   ```

2. **Generar la clave de la aplicación:**
   ```bash
   php artisan key:generate
   ```

3. **Ejecutar migraciones (y seeders si aplica):**
   ```bash
   php artisan migrate
   ```

4. **Instalar dependencias de Frontend y compilar assets:**
   ```bash
   npm install
   npm run dev
   ```

5. **Iniciar el servidor de desarrollo de Laravel:**
   ```bash
   php artisan serve
   ```
   *Accede desde el navegador en:* [http://localhost:8000](http://localhost:8000)

---

#### 👉 Método B: Usando Docker (Laravel Sail)

1. **Iniciar los contenedores en segundo plano:**
   ```bash
   ./vendor/bin/sail up -d
   ```

2. **Generar la clave de la aplicación:**
   ```bash
   ./vendor/bin/sail artisan key:generate
   ```

3. **Ejecutar las migraciones:**
   ```bash
   ./vendor/bin/sail artisan migrate
   ```

4. **Instalar dependencias de Frontend y compilar:**
   ```bash
   ./vendor/bin/sail npm install
   ./vendor/bin/sail npm run dev
   ```
   *Accede desde el navegador en:* [http://localhost](http://localhost)

---

## 🛠️ Comandos Útiles

- **Ejecutar tests:**
  ```bash
  php artisan test
  # O con Sail:
  ./vendor/bin/sail test
  ```
- **Compilar assets para producción:**
  ```bash
  npm run build
  # O con Sail:
  ./vendor/bin/sail npm run build
  ```

---

## 📄 Licencia

Este proyecto está distribuido bajo la licencia [MIT](LICENSE).
