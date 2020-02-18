# Noticias con RSS
Este proyecto es para la materia optativa "Optimización de aplicaciones web" tiene como propósito leer noticias de internet y mostrarlas al usuario. Está hecho para ser usado en un servidor xampp, dentro de la carpeta "htdocs".

## Tecnologías
+ **php**.- Hace consultas a internet y a la base de datos. La mayoría de los archivos .php (excluyendo librerías) contienen funciones que se pueden llamar con Ajax y devuelven información en formato JSON. Estos archivos no van a generar html, sólo son para hacer consultas.
+ **html** y **css**.- Muestran la información de manera agradable para el usuario. Contiene todos los elementos con los cuales el usuario va a interactuar.
+ **javascript**.- Hace que las páginas sean dinámicas y "tengan comportamiento". Su principal función será conectar los archivos html y php.

## Características del proyecto
### Implementadas
+ Consultar noticias en internet usando rss.

### Por implementar
+ Configurar qué ruta se va a usar para obtener las noticias.
+ Tener más de una ruta para obtener noticias.
+ Almacenar las noticias en una base de datos.
+ Consultar las noticias desde la base de datos.
+ Buscar noticias en la base de datos usando palabras clave.
