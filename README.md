# Descripción

Reto de programación backend para Docfav

## Herramientas y tecnologías utilizadas

- Laravel 9
- PHP 8
- MariaDB 10.9
- Docker y docker-compose
- Github
- Postman

## Requerimientos

- Docker y docker-compose instalados
- Git instalado
- Postman instalado

## APIs

> /api/users/list

Obtiene la lista de usuarios registrados en la Base de Datos, se utiliza paginación de 15 en 15, se puede enviar el parámetro `page` que representa el número de página. 
> /api/users/{id}

Obtiene los datos completos de un usuario mediante el segmento `id`
> /api/users/store

Crea un nuevo usuario, al cual se debe enviar los campos (name, last_name, email, password, birth_date y gender) como bodyform-data
> /api/users/update/{id}

Actualiza los datos de un usuario `id`, al cual se debe enviar los campos (name, last_name, email, birth_date y gender) como body x-www-form-urlencoded
> /api/users/delete/{id}

Elimina lógicamente a un usuario (Softdelete) mediante el segmento `id`

## Instalación

1. Abrir la terminal o línea de comandos de su preferencia y clonar el proyecto desde Github
```
git clone https://github.com/rogertcd/docfav.git
```
2. Ingrese al directorio que se acaba de crear llamado `docfav`
```
cd docfav
```
3. Crear un archivo llamado `.env` y copiar el contenido del archivo `.env.example` a `.env`


4. Ingrese al directorio `www`
```
cd www
```
5. Crear un archivo llamado `.env` y copiar el contenido del archivo `.env.example` a `.env`


6. Vuelva al directorio raíz `docfav`
```
cd ..
```
7. Ejecute el siguiente comando de docker-compose
```
docker-compose up -d
```

8. (Opcional) Si desea datos aleatorios de prueba puede ejecutar el siguiente comando
```
docker-compose exec www php artisan migrate:fresh --seed
```
## Pruebas mediante Postman

Para realizar pruebas de los endpoints, importe la colección del archivo `Docfav.postman_collection.json` desde Postman 

## Ejecución de test unitarios
Para realizar la ejecución de test unitarios ejecute el siguiente comando
```
docker-compose exec www php artisan test --filter user
```

## Tiempo de desarrollo

24 horas aproximadamente