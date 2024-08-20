document.addEventListener('DOMContentLoaded', () => {
    // Obtener el contenedor donde se mostrarán los productos en promoción
    const promocionesContainer = document.getElementById('promocionesContainer');

    // Función para cargar productos en promoción desde la base de datos
    function cargarPromociones() {
        fetch('get_promociones.php')
            .then(response => response.json())
            .then(data => {
                // Limpiar el contenedor antes de agregar nuevos productos
                promocionesContainer.innerHTML = '';

                // Recorrer las categorías y productos en promoción
                data.forEach(categoria => {
                    // Crear elemento de categoría
                    const categoriaDiv = document.createElement('div');
                    categoriaDiv.classList.add('categoria');
                    categoriaDiv.innerHTML = `<h3>Categoría: ${categoria.nombre}</h3>`;
                    
                    categoria.productos.forEach(producto => {
                        // Crear elemento de producto
                        const productoDiv = document.createElement('div');
                        productoDiv.classList.add('producto');
                        productoDiv.innerHTML = `
                            <img src="${producto.imagen}" alt="${producto.nombre}" class="producto-img">
                            <div>
                                <p>Producto: ${producto.nombre}</p>
                                <p>Precio Actual: ${producto.precio_actual} USD</p>
                                <p>${producto.porcentaje_diferencia}% respecto al precio ideal</p>
                                <a href="editar.html?id=${producto.id}">
                                    <button>Editar Producto</button>
                                </a>
                            </div>
                        `;
                        categoriaDiv.appendChild(productoDiv);
                    });

                    promocionesContainer.appendChild(categoriaDiv);
                });
            })
            .catch(error => {
                console.error('Error al cargar los productos en promoción:', error);
            });
    }

    // Cargar productos en promoción al cargar la página
    cargarPromociones();
});
