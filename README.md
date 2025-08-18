---
marp: true
---

# Integrantes
#### Andrea Horna
#### Ricardo Cabrera

---
# GITHUB del proyecto
https://github.com/Rick7u7/Ultima-Clase.git

---
# Después de Clonar el repo

Instalar las dependencias de composer

```bash
composer install
```

Copiar el entorno

```bash
cp .env.example .env
```

Generar la llave

```bash
php artisan key:generate
```

---

Reemplazar la URL del entorno por la que nos entrega Firebase

https://9000-firebase-dwi-25-2-clases-1752585818839.cluster-qhrn7lb3szcfcud6uanedbkjnm.cloudworkstations.dev

Migrar la base de datos

```bash
php artisan migrate
```
Preguntará si queremos crear la base de datos sqlite, respondemos YES

---

# Cambios realizados al modal

Integracion de la variable select en case(2) para variedad en las opciones.

# Integracion de scripts
 
Se integraron scripts en los index para permitir la edicion de modelos.