# Challenge Prex 🚀

Este repositorio contiene la solución para el Challenge Prex PHP que integra la API de Giphy y desarrolla una API REST utilizando Laravel.

## 🏗 Requisitos del proyecto

1. **Integración con la API de Giphy** para buscar y obtener información sobre GIFs.
2. **API REST con autenticación OAuth2.0**:
    - Login para generar un token con expiración de 30 minutos.
    - Buscar GIFs mediante una frase o término.
    - Obtener información de un GIF por ID.
    - Guardar GIFs favoritos para un usuario.
3. **Persistencia de logs de las interacciones con los servicios**.
4. **Pruebas unitarias y de características**.

## 🛠 Tecnologías utilizadas

-   **PHP 8.2+**
-   **Laravel 10**
-   **MySQL o MariaDB**
-   **Docker** para contenedores
-   **UML** para diagramas

---

## 🚀 Despliegue del proyecto

### Prerrequisitos

1. **Docker** instalado en el sistema.
2. Clonar este repositorio:
```bash
git clone https://github.com/KuramaBiju/challenge-prex
cd https://github.com/KuramaBiju/challenge-prex
```

### Comandos principales

1. Construir y levantar los contenedores:

```bash
docker-compose up -d
```

2. Abrir otra terminal y ejecutar el siguiente comando para las queues:

```bash
docker exec -it Serve php artisan schedule:work
```

### Pruebas

1. Ejecutar **pruebas unitarias**:

```bash
docker exec -it Serve php artisan test --testsuite=Unit
```

2. Ejecutar **pruebas features**:

```bash
docker exec -it Serve php artisan test --testsuite=Feature
```

## 🌟 Recursos adicionales

-   Documentación oficial de la API de Giphy: [developers.giphy.com](https://developers.giphy.com/docs/api/#quick-start-guide)
