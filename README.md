# Agenda de Contactos

## Integrantes del equipo
- Fernandez Borrayes Bryan David

## Nombre de la materia
Programación Web

## Descripción del proyecto
Sistema web de agenda de contactos desarrollado con PHP y MySQL que permite gestionar contactos mediante operaciones CRUD completas. El sistema permite crear, leer, actualizar y eliminar contactos con foto incluida.

## Tecnologías utilizadas
- PHP 8.3
- MySQL / MariaDB
- PDO (PHP Data Objects)
- HTML5
- CSS3

## Funcionalidades implementadas
- ✅ CREATE — Agregar nuevos contactos con foto
- ✅ READ — Listar todos los contactos
- ✅ READ — Ver detalle individual de un contacto
- ✅ UPDATE — Editar contactos existentes
- ✅ DELETE — Eliminar contactos con confirmación previa
- ✅ Búsqueda de contactos por nombre, apellido o teléfono
- ✅ Validación en cliente (HTML5) y servidor (PHP)
- ✅ Sentencias preparadas PDO (prevención de SQL Injection)
- ✅ Sanitización de salida con htmlspecialchars()
- ✅ Subida de fotos

## Estructura del proyecto
```
agenda_contactos/
├── index.php
├── crear.php
├── guardar.php
├── editar.php
├── actualizar.php
├── ver.php
├── eliminar.php
├── config/
│   └── db.php
├── includes/
│   ├── header.php
│   ├── menu.php
│   └── footer.php
├── css/
│   └── styles.css
└── uploads/
```