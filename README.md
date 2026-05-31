# SIAC-SAIME - Sistema de Atención al Ciudadano

Proyecto CodeIgniter 4.0.3 con PostgreSQL.

---

## Requisitos del sistema

| Componente | Versión |
|-----------|---------|
| PHP       | **7.4** (no compatible con PHP 8.x) |
| PostgreSQL | 12+ |
| Nginx     | 1.18+ (o Apache) |
| Composer  | 2.x |

### Extensiones PHP requeridas

```bash
sudo apt install -y php7.4-fpm php7.4-pgsql php7.4-intl php7.4-mbstring php7.4-curl php7.4-xml php7.4-json
```

---

## Instalación

### 1. Clonar el proyecto

```bash
git clone <repo-url> /var/www/siac_saime
cd /var/www/siac_saime
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Configurar entorno

Copiar el archivo de entorno y editarlo:

```bash
cp env .env
```

Editar `.env` con los datos de la base de datos:

```ini
CI_ENVIRONMENT = development
app.baseURL = 'http://salasituacional.test/'

database.default.DBDriver = Postgre
database.default.hostname = 127.0.0.1
database.default.database = siac_v2_saime
database.default.username = postgres
database.default.password = <tu-password>
database.default.port = 5432
database.default.DSN = pgsql:host=127.0.0.1;port=5432;dbname=siac_v2_saime;user=postgres;password=<tu-password>
```

### 4. Crear base de datos

```bash
sudo -u postgres psql -c "CREATE DATABASE siac_v2_saime;"
# Importar el dump si existe:
# sudo -u postgres psql siac_v2_saime < dump.sql
```

### 5. Configurar Nginx

```bash
sudo cp deploy/nginx.conf /etc/nginx/sites-available/siac_saime
sudo ln -s /etc/nginx/sites-available/siac_saime /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
```

### 6. Agregar dominio local

```bash
echo "127.0.0.1  salasituacional.test" | sudo tee -a /etc/hosts
```

### 7. Crear carpetas necesarias y permisos

```bash
# Carpetas requeridas
sudo mkdir -p /var/www/siac_saime/writable/session
sudo mkdir -p /var/www/siac_saime/writable/debugbar
sudo mkdir -p /var/www/siac_saime/public/documentos_casos
sudo mkdir -p /var/www/siac_saime/public/documentos_punto_cuenta

# Permisos
sudo chown -R www-data:www-data /var/www/siac_saime/writable
sudo chown -R www-data:www-data /var/www/siac_saime/public/documentos_casos
sudo chown -R www-data:www-data /var/www/siac_saime/public/documentos_punto_cuenta
sudo chmod -R 775 /var/www/siac_saime/writable
sudo chmod -R 775 /var/www/siac_saime/public/documentos_casos
sudo chmod -R 775 /var/www/siac_saime/public/documentos_punto_cuenta

# Agregar tu usuario al grupo www-data (para desarrollo)
sudo usermod -a -G www-data $USER
```

### 8. Configurar whitelist de acceso

Editar `app/Controllers/BaseController.php` y agregar tu dominio/IP al array `$whitelist`:

```php
protected $whitelist = [
    // ... existentes ...
    'salasituacional.test',
    '127.0.0.1',
    'localhost',
];
```

### 9. Verificar rutas

```bash
php spark routes
```

### 10. Acceder

Abrir en el navegador: `http://salasituacional.test`

---

## Configuraciones importantes

### `app/Config/Paths.php`

El directorio `$writableDirectory` debe apuntar a `writable/`:

```php
public $writableDirectory = __DIR__ . '/../../writable';
```

### `app/Config/App.php`

- `$baseURL` — Debe coincidir con el dominio configurado en Nginx
- `$indexPage` — Dejar como `'index.php'` (Nginx maneja el rewrite)
- `$sessionSavePath` — Por defecto `WRITEPATH . 'session'`

---

## Solución de problemas comunes

| Error | Causa | Solución |
|-------|-------|----------|
| `mkdir(): Permission denied` | `writable/` sin permisos para `www-data` | Paso 7 |
| `Acceso no autorizado` | Dominio no está en la whitelist | Paso 8 |
| `FILTER_SANITIZE_STRING is deprecated` | Usando PHP 8.x en vez de 7.4 | Instalar PHP 7.4 |
| `Controller method is not found` | `Paths.php` con `$writableDirectory` incorrecto | Verificar `Paths.php` |
| `404 - File Not Found` | Ruta no registrada o nginx mal configurado | Verificar `php spark routes` |

---

## Estructura del proyecto

```
siac_saime/
├── app/                    # Código de la aplicación
│   ├── Config/             # Configuraciones (App, Database, Routes, Paths, etc.)
│   ├── Controllers/        # Controladores
│   ├── Models/             # Modelos
│   └── Views/              # Vistas
├── deploy/                 # Archivos de despliegue
│   └── nginx.conf          # Plantilla de configuración Nginx
├── public/                 # Document root
│   ├── index.php           # Entry point
│   ├── documentos_casos/   # Uploads de documentos (requiere permisos)
│   └── documentos_punto_cuenta/
├── system/                 # Core de CodeIgniter 4
├── vendor/                 # Dependencias de Composer
├── writable/               # Archivos generados (requiere permisos de escritura)
│   ├── session/            # Sesiones PHP
│   ├── debugbar/           # Debug toolbar
│   └── uploads/            # Uploads
├── .env                    # Configuración de entorno (no versionar)
├── env                     # Plantilla de .env
├── composer.json
└── spark                   # CLI de CodeIgniter
```
