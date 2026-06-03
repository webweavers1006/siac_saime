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

### 4. Crear base de datos y ejecutar migraciones

```bash
# Crear la base de datos
sudo -u postgres psql -c "CREATE DATABASE siac_migraciones_test OWNER postgres;"
```

Luego ejecutar migraciones y seeders:

```bash
# Crear todas las tablas + foreign keys (38 migraciones)
php spark migrate

# Poblar datos de catálogo + usuario admin (20 seeders en orden)
php spark db:seed MainSeeder
```

> Esto crea 37 tablas, 22 foreign keys y carga: roles, países (216), estados (26), municipios (336), parroquias (1135), y un usuario administrador.

#### Credenciales por defecto

| Campo | Valor |
|-------|-------|
| Email | `admin@sala-situacional.test` |
| Password | `admin123` |
| Rol | Administrador |

### 5. Comandos Spark útiles

| Comando | Descripción |
|---------|-------------|
| `php spark migrate` | Ejecutar migraciones nuevas |
| `php spark migrate:status` | Ver estado de migraciones |
| `php spark migrate:refresh` | Rollback + migrate |
| `php spark migrate:rollback` | Revertir último batch |
| `php spark db:seed MainSeeder` | Ejecutar todos los seeders en orden |
| `php spark db:seed RolesSeeder` | Ejecutar un seeder específico |
| `php spark routes` | Ver rutas registradas |
| `php spark list` | Ver todos los comandos |

### 6. Cambios en base de datos (producción)

Para modificar tablas sin perder datos, **nunca edites migraciones ya ejecutadas**.
Crea una nueva con `spark migrate:create` y usa los métodos de Forge para alterar la estructura:

```bash
# Crear nueva migración con el cambio
php spark migrate:create agregar_campo_x
```

Luego edita `up()` y `down()` según el cambio:

| Cambio | Método en `up()` |
|--------|-----------------|
| Agregar columna | `$this->forge->addColumn('tabla', ['col' => ['type' => 'VARCHAR', ...]])` |
| Modificar columna | `$this->forge->modifyColumn('tabla', ['col' => ['type' => 'TEXT', ...]])` |
| Eliminar columna | `$this->forge->dropColumn('tabla', 'columna')` |
| Agregar FK | `$this->db->query('ALTER TABLE t ADD CONSTRAINT ... FOREIGN KEY ...')` |
| Agregar índice | `$this->db->query('CREATE INDEX ... ON tabla (col)')` |

```bash
# Ejecutar solo la nueva migración
php spark migrate
```

> Spark compara la tabla `migrations` y solo ejecuta las que no están registradas. Las tablas y datos existentes no se tocan.

### 7. Configurar Nginx

```bash
sudo cp deploy/nginx.conf /etc/nginx/sites-available/siac_saime
sudo ln -s /etc/nginx/sites-available/siac_saime /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
```

### 8. Agregar dominio local

```bash
echo "127.0.0.1  salasituacional.test" | sudo tee -a /etc/hosts
```

### 9. Crear carpetas necesarias y permisos

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

### 10. Configurar whitelist de acceso

La lista principal de dominios/IPs autorizados está en `app/Config/Whitelist.php`:

```php
public $hosts = ['siac_v2.com', 'siac.sapi.gob.ve', ...];
public $ips   = ['172.16.0.39', ...];
```

Para agregar entradas solo para desarrollo/local, usar el `.env`:

```ini
whitelist.extra_hosts = salasituacional.test,localhost
whitelist.extra_ips = 127.0.0.1
```

> Así la whitelist base se versiona y cada entorno agrega lo suyo sin tocar código.

### 11. Verificar rutas

```bash
php spark routes
```

### 12. Acceder

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
