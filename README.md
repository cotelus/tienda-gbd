# Tienda - Bases de datos -
## 1.- Introducción
El objetivo es crear una tienda completamente funcional. ¿Pero a qué me refiero con funcional?. 

En primer lugar, habrá un control de usuarios, es decir, se va a poder iniciar sesión para las compras de modo que estas queden guardadas. Además, la página no dejará comprar hasta que el usuario haya iniciado sesión. Habrá otro grupo de usuarios, el grupo administrador, que podrá editar datos de los usuarios y de los productos que se venden.

Respecto al funcionamiento de los productos, es también muy sencillo, se pueden añadir a la cesta de la compra desde el propio catálogo y una vez en la cesta de la compra se podrá elegir qué cantidad se desea. Si se añade de nuevo a la cesta un producto ya existente en esta, se añadirá uno a la cantidad.

Una vez el usuario esté decidido a comprar, podrá ir a la pantalla de pago y se comprobará en la parte del servidor que los datos de la compra son correctos y se procederá a la pasarela de pago para este. 

El carrito quedará guardado para usos posteriores usando sesiones de php. 

Por otra parte, al no hacer uso de tecnologías de comunicación asíncrona, la página debe estar continuamente actualiándose en primer plano, molestando al usuario en cierta medida, así que se intentará dentro de lo posible actualizarse lo menos posible. 


## 2.- ¿Qué se ha hecho en esta parte?
1. Se ha completado la vista de la página principal.
2. Se ha completado la funcionalidad de la página principal. 
3. Se han creado las tablas de la BBDD.
4. Se ha creado la clase "Producto" para manejar los productos de forma mas eficaz.
5. Se ha creado la clase "Usuario" para manejar los usuarios de forma mas eficaz.
6. Se ha creado una clase para la conexión con la BBDD.
7. Se ha creado una clase para la gestión de los datos de tipo Producto recibidos de la BBDD.
8. Se ha creado una clase para la gestión de los datos de tipo Usuario recibidos de la BBDD.
----------
9. Funcionalidad del carrito completada al 100%.
10. Vista del carrito completada al 100%.
11. Creada sección del usuario para que modifique sus datos.
12. Añadir selector de cantidades a cada producto del carrito.
13. Añadir funcionalidad de eliminar en el carrito.
14. Mejorar vista del carrito.
15. Añadir vista de la administración de productos.
16. Añadir opción de insertar productos desde la web al admin.
17. Añadir opción de eliminar productos desde la web al admin.
18. Añadir vista en el perfil de usuario del historial de compras.
19. Añadir conexión con la BBDD para mostrar las facturas.
20. Filtrar facturas para aumentar seguridad.
21. Vista en detalle da cada factura.
22. Añadir entrada en la BBDD de una factura al realizar la compra.
23. Arreglado el registro de nuevos usuarios.
24. La dirección asociada a cada usuario se muestra correctamente y cambia.
25. Se añadió la biblioteca FPDF
26. Añadida funcionalidad para imprimir PDF


## 3.- ¿Cómo se ha hecho?
He ido avanzando poco a poco, terminando elementos funcionales o casi funcionales pequeños que han hecho crecer la página. 

Una vez tenía una visión mas o menos global del problema, anoté los aspectos que creía mas problemáticos y pensé una manera de resolverlos. Por ejemplo, modificar el carrito suponía un problema, ya que si añado un producto al carrito y quiero recuperar esa información en una navegación posterior, la página debe usar sessions o cookies, pero para ello hay que recargar la página.

Con la visión global del problema y los puntos problemáticos y cómo afrontarlos anotados, empecé a desarrollar lo que fuera mas necesario, no por urgencia sino porque otras cosas dependieran de ello. Teniendo en cuenta siempre que fueran cosas no muy grandes y que se pudieran terminar como máximo en una hora o una hora y media de trabajo.


## 4.- ¿Qué queda por terminar?
En este momento, se han finalizado todos los puntos obligatorios. A excepción de validación HTTPS y pagar con PayPal


## 5.- Explicación breve de la página

1. En el index se muestra una barra de navegación y los productos en catálogo. Pueden añadirse al carrito pero hasta que no se inicia sesión no se puede completar la compra.
2. El usuario administrador tiene una opción especial que es un engranaje visible en cada producto que al pinchar sobre el lleva a la página de administración de ese producto.
3. El usuario administrador además, tiene una sección accesible desde la barra de navegación desde la que puede acceder a las opciones de administración, que sirven para añadir productos nuevos o listar los ya existentes para modificarlos o eliminarlos
4. El usuario admin y el no admin tienen la posibilidad de hacer compras
5. Cada compra se almacenará en la BBDD cuando se complete.
6. En la zona de usuarios (user_panel.php) se muestran todas las compras realizadas por el usuario. Si se desea, puede verse con mas detalle cada compra e incluso imprimir un pdf a modo de factura.
7. Todos los sitios de la página que no deben de ser accesibles están restringidos. Hay redirecciones para que si se llega de una forma "fraudulenta" se devuelva al usuario a una página concreta


