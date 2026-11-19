# Sistema de Gestión de Soporte Técnico y Reparación de Laptops

Proyecto académico desarrollado para la unidad didáctica **DSI406 · Tecnología Backend** (IES Túpac Amaru).

## Requisitos
- PHP 8.3+ con extensiones `pdo_pgsql` y `pgsql`
- Composer 2.x
- PostgreSQL 16+

## Instalación local

```bash
git clone [https://github.com/yeny1139/soporte-laptops.git](https://github.com/yeny1139/soporte-laptops.git)
cd soporte-laptops
composer install
cp .env.example .env
php artisan key:generate
```

Configurar en `.env` las credenciales de PostgreSQL (`DB_DATABASE=soporte_laptops`) y ejecutar:

```bash
php artisan migrate
php artisan serve
```

Abrir `http://127.0.0.1:8000` en el navegador.