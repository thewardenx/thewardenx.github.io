let cart = [];
let total = 0;

// Función para actualizar el carrito en la interfaz
function updateCart() {
    const cartItems = document.getElementById('cart-items');
    const totalElement = document.getElementById('total');
    cartItems.innerHTML = '';
    total = 0;

    cart.forEach((item, index) => {
        const cartItem = document.createElement('div');
        cartItem.innerHTML = `
            <p>${item.product} - $${item.price.toFixed(2)}</p>
            <button class="remove-from-cart" data-index="${index}">Quitar</button>
        `;
        cartItems.appendChild(cartItem);
        total += item.price;
    });

    totalElement.textContent = `Total: $${total.toFixed(2)}`;

    // Actualizamos el campo oculto con el total de la compra
    document.getElementById('total-input').value = total.toFixed(2);

    // Añadimos funcionalidad para los botones de eliminar
    document.querySelectorAll('.remove-from-cart').forEach(button => {
        button.addEventListener('click', function () {
            const index = this.getAttribute('data-index');
            removeFromCart(index);
        });
    });
}

// Función para agregar un producto al carrito
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function () {
        const product = this.getAttribute('data-product');
        const price = parseFloat(this.getAttribute('data-price'));

        cart.push({ product, price });
        updateCart();
    });
});

// Función para quitar un producto del carrito
function removeFromCart(index) {
    cart.splice(index, 1); // Elimina el elemento en el índice indicado
    updateCart(); // Vuelve a renderizar el carrito
}

document.getElementById('checkout-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Evitar el envío normal del formulario

    // Recoger los datos del formulario
    const formData = new FormData(this);

    // Realizar la solicitud AJAX
    fetch('process.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text()) // Esperar
