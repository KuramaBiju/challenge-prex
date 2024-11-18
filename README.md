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
-   **MySQL**
-   **Docker** 
-   **UML**

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

2. Abrir otra terminal y ejecutar para las queues:

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

### 📚 Documentación

Toda la documentación relacionada con este proyecto se encuentra en la carpeta `/docs`. Dentro de esta carpeta, podrás encontrar los siguientes archivos y recursos:

- **Colección de Postman**: Una colección de Postman con los endpoints de la API para probar los endpoints.
- **Diagrama DER**: Un diagrama entidad-relación que muestra la estructura de la base de datos utilizada por la aplicación.
- **Diagrama de Casos de Uso**: Representación gráfica de los casos de uso de la aplicación, detallando las interacciones entre los usuarios y el sistema.
- **Diagrama de Secuencia**: Diagrama que muestra las interacciones secuenciales entre los componentes del sistema durante el flujo de una operación.




## 🌟 Recursos adicionales

-   Documentación oficial de la API de Giphy: [developers.giphy.com](https://developers.giphy.com/docs/api/#quick-start-guide)
