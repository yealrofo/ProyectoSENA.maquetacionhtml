document.addEventListener('DOMContentLoaded', () => {
    // Obtener el contenedor donde se mostrarán los productos
    const productosContainer = document.getElementById('productosContainer');

    // Función para cargar productos desde la base de datos
    function cargarProductos() {
        fetch('get_productos.php')
            .then(response => response.json())
            .then(data => {
                // Limpiar el contenedor antes de agregar nuevos productos
                productosContainer.innerHTML = '';

                // Recorrer las categorías y productos
                data.forEach(categoria => {
                    // Crear elemento de categoría
                    const categoriaDiv = document.createElement('div');
                    categoriaDiv.classList.add('categoria');
                    categoriaDiv.innerHTML = `<h3>Categoría: ${categoria.nombre}</h3>`;
                    
                    categoria.subcategorias.forEach(subcategoria => {
                        // Crear elemento de subcategoría
                        const subcategoriaDiv = document.createElement('div');
                        subcategoriaDiv.classList.add('subcategoria');
                        subcategoriaDiv.innerHTML = `<h4>Subcategoría: ${subcategoria.nombre}</h4>`;
                        
                        subcategoria.productos.forEach(producto => {
                            // Crear elemento de producto
                            const productoDiv = document.createElement('div');
                            productoDiv.classList.add('producto');
                            productoDiv.innerHTML = `
                                <img src="${producto.imagen}" alt="${producto.nombre}" class="producto-img">
                                <div>
                                    <p>Producto: ${producto.nombre}</p>
                                    <p>Precio Actual: ${producto.precio_actual} USD</p>
                                    <p>${producto.porcentaje_diferencia}% respecto al precio ideal</p>
                                    <p>Precio Más Bajo: ${producto.precio_bajo} USD</p>
                                    <p>Precio Más Alto: ${producto.precio_alto} USD</p>
                                    <a href="editar.html?id=${producto.id}">
                                        <button>Editar Producto</button>
                                    </a>
                                </div>
                            `;
                            subcategoriaDiv.appendChild(productoDiv);
                        });

                        categoriaDiv.appendChild(subcategoriaDiv);
                    });

                    productosContainer.appendChild(categoriaDiv);
                });
            })
            .catch(error => {
                console.error('Error al cargar los productos:', error);
            });
    }

    // Cargar productos al cargar la página
    cargarProductos();
});
