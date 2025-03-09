# 🚀 Gestión de Tareas con Laravel

[![Licencia MIT](https://img.shields.io/badge/Licencia-MIT-brightgreen.svg)](https://opensource.org/licenses/MIT)
[![Laravel](https://img.shields.io/badge/Laravel-10.x-orange.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://php.net)

Sistema de gestión de tareas desarrollado con Laravel para administrar proyectos y actividades.

## 🌟 Características

- 🔐 Autenticación de usuarios
- ✅ CRUD completo de tareas
- 📅 Gestión de fechas y prioridades
- 🐳 Entorno Docker integrado con Sail
- 📱 Diseño responsive
- 📧 Notificaciones por correo electrónico

## 📋 Requisitos

- Docker y Docker Compose
- PHP 8.1+ 
- Composer
- Node.js y NPM

## 🛠️ Instalación

1. Clonar repositorio:
```bash
git clone https://github.com/YukiiCode/gestion-tareas.git
cd gestion-tareas
```

2. Copiar archivo de entorno:
```bash
cp .env.example .env
```

3. Instalar dependencias:
```bash
composer install
npm install
```

4. Iniciar contenedores Docker:
```bash
./vendor/bin/sail up -d
```

5. Ejecutar migraciones:
```bash
./vendor/bin/sail artisan migrate --seed
```

6. Acceder en:
http://localhost

## 📸 Capturas

![Listado de tareas](![image](https://github.com/user-attachments/assets/bb77a808-93af-4d8b-b6bf-e68df8a66cf4)
)
*Captura del listado principal de tareas*

## 🤝 Contribución

1. Hacer fork del proyecto
2. Crear rama (`git checkout -b feature/nueva-funcionalidad`)
3. Hacer commit de los cambios
4. Hacer push a la rama
5. Abrir Pull Request

## 📜 Licencia

Este proyecto está bajo la licencia [MIT](https://opensource.org/licenses/MIT).

---

Desarrollado con ❤️ por [Yuki](https://github.com/YukiiCode)
