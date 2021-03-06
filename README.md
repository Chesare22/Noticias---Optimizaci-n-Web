# Noticias con RSS
Este proyecto es para la materia optativa "Optimización de aplicaciones web" tiene como propósito leer noticias de internet y mostrarlas al usuario. Está hecho para ser usado en un servidor xampp, dentro de la carpeta "htdocs".

## Cómo minimizar el proyecto
### Prerrequisitos
+ Tener [node](https://nodejs.org/en/) instalado en el sistema.
+ Tener UglifyJS instalado de manera global `sudo npm install uglify-js -g`
+ Tener las dependencias del proyecto instaladas. `npm install`
### Pasos
1. Correr Babel para pasar de ES6 (o posterior) a ES5. `npm run build`
2. Minimizar JS con Uglify-js. `uglifyjs ./js/index.js -m --toplevel -o ./js/index.js`
3. Minimizar HTML usando a la página [HTML minifier](https://kangax.github.io/html-minifier/).
4. Minimizar CSS con el siguiente comando:
  ```
  find css/ -type f \
    -name "*.css" ! -name "*.min.*" \
    -exec echo {} \; \
    -exec uglifycss --output {}.min {} \; \
    -exec rm {} \; \
    -exec mv {}.min {} \;
  ```
5. Eliminar archivos sobrantes. Los únicos que se quedan son:
  + /assets/*
  + /css/*
  + /js/*
  + /php-functions/*
  + index.html

## Tecnologías
+ **php**.- Hace consultas a internet y a la base de datos. La mayoría de los archivos .php (excluyendo librerías) contienen funciones que se pueden llamar con Ajax y devuelven información en formato JSON. Estos archivos no van a generar html, sólo son para hacer consultas.
+ **html** y **css**.- Muestran la información de manera agradable para el usuario. Contiene todos los elementos con los cuales el usuario va a interactuar.
+ **javascript**.- Hace que las páginas sean dinámicas y "tengan comportamiento". Su principal función será conectar los archivos html y php.
+ **EsLint**.- Define los patrones de codificación presentes en el código JavaScript. Sus reglas están definidas en el archivo _package.json_.

## Características del proyecto
### Implementadas
+ Consultar noticias en internet usando rss.

### Por implementar
+ Configurar qué ruta se va a usar para obtener las noticias.
+ Tener más de una ruta para obtener noticias.
+ Almacenar las noticias en una base de datos.
+ Consultar las noticias desde la base de datos.
+ Buscar noticias en la base de datos usando palabras clave.
