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
9. Funcionalidad del carrito completada al 50%.
10. Vista del carrito completada al 50% (provisional para identificar datos).

## 3.- ¿Cómo se ha hecho?
He ido avanzando poco a poco, terminando elementos funcionales o casi funcionales pequeños que han hecho crecer la página. 

Una vez tenía una visión mas o menos global del problema, anoté los aspectos que creía mas problemáticos y pensé una manera de resolverlos. Por ejemplo, modificar el carrito suponía un problema, ya que si añado un producto al carrito y quiero recuperar esa información en una navegación posterior, la página debe usar sessions o cookies, pero para ello hay que recargar la página.

Con la visión global del problema y los puntos problemáticos y cómo afrontarlos anotados, empecé a desarrollar lo que fuera mas necesario, no por urgencia sino porque otras cosas dependieran de ello. Teniendo en cuenta siempre que fueran cosas no muy grandes y que se pudieran terminar como máximo en una hora o una hora y media de trabajo.


## 4.- ¿Qué queda por terminar?
En este momento, queda por terminar:

1. Registro de nuevos usuarios. (He modificado los elementos necesarios para darse de alta en el sitio, pero no he actualizado esos elementos en la creación de la nueva fila en la BBDD y da error. Es algo muy sencillo de solucionar, pero no es prioritario).
2. Mejorar vista del carrito.
3. Añadir selector de cantidades a cada producto del carrito
4. Añadir motor de plantillas para la vista de la administración de los productos.
5. Añadir vista de la administración de productos.
6. Añadir sección de confirmar pago que realice las comprobaciones pertinentes sobre productos, precio y stock.
7. Cambiar almacenamiento del carrito de sesiones a cookies
8. Añadir pasarela de pago. 

