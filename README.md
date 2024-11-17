# Challenge Prex 🚀

Este repositorio contiene la solución para el Challenge Prex PHP que integra la API de Giphy y desarrolla una API REST utilizando Laravel.

## 🏗 Requisitos del proyecto

1. **Integración con la API de Giphy** para buscar y obtener información sobre GIFs.
2. **API REST con autenticación OAuth2.0**:
   - Login para generar un token con expiración de 30 minutos.
   - Buscar GIFs mediante una frase o término.
   - Obtener información de un GIF por ID.
   - Guardar GIFs favoritos para un usuario.
3. Persistencia de logs de las interacciones con los servicios.
4. **Pruebas unitarias y de características**.

## 🛠 Tecnologías utilizadas

- **PHP 8.2+**
- **Laravel 10**
- **MySQL o MariaDB**
- **Docker** para contenedores
- **UML** para diagramas

---

## 🚀 Despliegue del proyecto

### Prerrequisitos

1. **Docker** instalado en el sistema.
2. Clonar este repositorio:
   ```bash
   git clone <URL_DEL_REPOSITORIO>
   cd <NOMBRE_DEL_REPOSITORIO>
   ```


- Comando para levantar el proyecto : docker-compose up
- Comando para ejecutar migraciones : docker exec -it Serve php artisan migrate
- Comando para configurar Passport : docker exec -it Serve php artisan passport:install
- Comandos para ejecutar los unit test : docker exec -it Serve php artisan test --testsuite=Unit
- Comandos para ejecutar los feature test : docker exec -it Serve php artisan test --testsuite=Feature

