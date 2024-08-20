document.addEventListener('DOMContentLoaded', () => {
    const addProductForm = document.getElementById('addProductForm');

    addProductForm.addEventListener('submit', (event) => {
        event.preventDefault();

        // Obtener los datos del formulario
        const nombre = document.getElementById('nombre').value;
        const categoria = document.getElementById('categoria').value;
        const subcategoria = document.getElementById('subcategoria').value;
        const url = document.getElementById('url').value;
        const precioActual = document.getElementById('precioActual').value;
        const precioIdeal = document.getElementById('precioIdeal').value;

        // Crear objeto de datos
        const producto = {
            nombre,
            categoria,
            subcategoria,
            url,
            precioActual,
            precioIdeal
        };

        // Enviar los datos al servidor
        fetch('add_product.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(producto)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Producto agregado exitosamente');
                addProductForm.reset();
            } else {
                alert('Error al agregar el producto: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error al agregar el producto:', error);
        });
    });
});
