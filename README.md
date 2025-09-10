
# srn-empanadas-ffronend - aplicación de gestión de empanadas chilenas

## **1. Programas necesarios para empezar**

Para poder utilizar el sistema se debe tener instalado.

- Docker
- Git


## **2. Abrir consola CMD**

Después de instalar los programas necesita abrir el CMD y posicionarse a una carpeta donde vas a clonar el proyecto.


## **3. Clonar el repositorio**

Ingrese el siguiente comando.

git clone https://github.com/BENISXELLI/srn-empanadas-ffronend.git


## **4. Acceder a proyecto**

Una ves ya clonado debes ingresar a la carpeta con el siguiente comando.

cd srn-empanadas-ffronend


## **5. Habilitar los contenedores de docker**

cuando ya se encuentre posicionado en la carpeta del proyecto debe ejecutar el siguiente comando.

docker compose up -d --build


## **6. Installer npm**

Después de finalizar el proceso de los contenedores se debe instala en npm en el Backend ejecutando el siguiente comando.

docker compose run backend npm install


## **7. Migrar base de datos**

migrar la base de datos con el comando siguiente.

docker compose run backend npm run migrate


## **8. crear directorio necesario**

Se necesita crear una carpeta necesaria para guardar la cache del sitio del frontend

docker exec -it srn-empanadas-ffronend-frontend-1 mkdir -p /var/www/html/writable/cache


## **9. Instalar Composer**

Instala el composer en el frontend con el comando.

docker exec -it srn-empanadas-ffronend-frontend-1 composer install


## **10. Dar permiso de Directorios**

Se necesita dar ciertos permisos y privilegios de los sitios.

docker exec -it srn-empanadas-ffronend-frontend-1 chown -R www-data:www-data /var/www/html


## **11. Ingresar al sistema**

Después de finalizar con la instalación y configuración del sitio, se debe ingresar navegador web para acceder al sistema con el siguiente enlace. 

http://localhost:8080


## **12. Pruebas Unitarios**

para realizar las pruebas de funcionamiento del sitio se debe ejecuta el siguiente comando.

docker compose run backend npm test
