## Oswa - inv

![OSWA-INV v2 image](https://scontent-iad3-1.xx.fbcdn.net/v/t31.0-8/12045296_896994067005023_5505146103193104549_o.jpg?oh=4afd029c1486604d29f672d76becb8bc&oe=5921F70A " Sistema de Inventario de Almacén ")

# Sistema de Inventario de Almacén

---

La aplicación fue creada inicialmente por **Siamon Hasan**, utilizando [php](http:php.net), [mysql](https://www.mysql.com) y [bootstrap](http://getbootstrap.com).

OSWA-INV es un sistema de inventario basado en la web que le permitirá realizar un seguimiento de la cantidad y el precio de compra y venta de los productos existentes en su almacén o negocio. Al crear nuevos productos, puede establecer la cantidad, el precio de compra y el precio de venta.

---

Si encuentra algún error y una solución para ese error, deje un comentario en la página de GitHub de este proyecto y aplicaré el cambio a la rama principal.

---

## Actualizaciones de Seguridad y Refactorización (Reciente)

Se han realizado mejoras significativas en la arquitectura y seguridad del sistema:

### 1. Migración a PDO y Consultas Preparadas

Se ha refactorizado la capa de base de datos para utilizar **PDO (PHP Data Objects)** en lugar de la extensión obsoleta `mysqli`.

- **Seguridad**: Implementación de **sentencias preparadas** en todas las consultas para eliminar el riesgo de ataques de **Inyección SQL**.
- **Compatibilidad**: Mayor facilidad para cambiar de motor de base de datos en el futuro.

### 2. Mejora en el Hashing de Contraseñas

Se ha actualizado el mecanismo de almacenamiento de contraseñas, migrando de `SHA1` (inseguro) a algoritmos modernos.

- **Función**: Ahora el sistema utiliza `password_hash()` y `password_verify()` con el algoritmo `BCRYPT` por defecto.
- **Migración Progresiva**: El sistema mantiene compatibilidad con las contraseñas antiguas, actualizándolas automáticamente al nuevo formato cuando el usuario inicia sesión.

### 3. Implementación de Protección CSRF (Cross-Site Request Forgery)

Se ha implementado una capa de protección contra ataques de falsificación de solicitudes en sitios cruzados.

- **Tokens por Sesión**: Generación y validación de tokens únicos para cada sesión de usuario.
- **Protección Global**: Verificación automática en todas las peticiones `POST` del sistema.
- **Soporte AJAX**: Integración mediante etiquetas meta y configuración automática para peticiones jQuery AJAX.
- **Formularios Protegidos**: Actualización de todos los formularios del sistema (login, productos, ventas, usuarios, etc.) para incluir el campo de seguridad.

---

### Instalar esta aplicación es bastante sencillo, solo siga estos pasos:

---

1. Descargue la última versión con git (`git clone https://github.com/siamon123/warehouse-inventory-system.git`)

2. Importe/cargue `oswa_inv.sql` en su base de datos MySQL. Esto debería configurar la estructura básica del sistema de base de datos.

3. Modifique `includes/config.php` y cambie las variables para que coincidan con su servidor, base de datos, nombre de usuario y contraseñas.

4. Cambie todos los permisos de las carpetas dentro de la carpeta `uploads`, ya sea agregándolas al grupo llamado `www` si está disponible o configurándolas en `777`.

5. Luego inicie sesión escribiendo el **nombre de usuario** (username) y la **contraseña** (password):

   | Administrador         | Usuario Especial        | Usuario por Defecto  |
   | --------------------- | ----------------------- | -------------------- |
   | **Usuario**: admin    | **Usuario**: special    | **Usuario**: user    |
   | **Contraseña**: admin | **Contraseña**: special | **Contraseña**: user |

6. ¡Buena suerte!

---

## NO OLVIDE DARNOS SU OPINIÓN

---

Siga a [@OSWA](https://www.facebook.com/oswapp) en Facebook para más proyectos.

No olvide visitar [oswapp.com](http://oswapp.com "OSWA")
