document.addEventListener('DOMContentLoaded', async () => {
  const BASE = typeof CART_BASE_PATH !== 'undefined' ? CART_BASE_PATH : 'includes/cart/';

  try {
    const response = await fetch(`${BASE}get_cart.php`);
    const cartItems = await response.json();

    const cartItemsContainer = document.getElementById('cart-items');
    const totalAmountElement = document.getElementById('total-amount');
    let total = 0;

    cartItemsContainer.innerHTML = '';

    cartItems.forEach(item => {
      total += parseFloat(item.precio);

      const itemElement = document.createElement('div');
      itemElement.className = 'cart-item';
      itemElement.innerHTML = `
        <img src="assets/img/${item.producto.replace(/\s+/g, '')}.jpg" alt="${item.producto}">
        <div class="cart-details">
            <p class="product-name">${item.producto}</p>
            <p class="product-size">Talla: ${item.talla}</p>
            <p class="product-price">$${item.precio}</p>
        </div>
        <button class="remove-item" data-id="${item.id_seleccion}">Eliminar</button>
      `;

      cartItemsContainer.appendChild(itemElement);
    });

    totalAmountElement.textContent = `$${total.toFixed(2)}`;

    // Eliminar items
    document.querySelectorAll('.remove-item').forEach(button => {
      button.addEventListener('click', async () => {
        const itemId = button.getAttribute('data-id');
        try {
          const res = await fetch(`${BASE}remove_from_cart.php`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: itemId })
          });
          const result = await res.json();
          if (result.success) location.reload();
        } catch (error) {
          console.error('Error:', error);
        }
      });
    });

    // Finalizar compra
    const checkoutBtn = document.querySelector('.checkout-button');
    if (checkoutBtn) {
      checkoutBtn.addEventListener('click', async () => {
        try {
          const res = await fetch(`${BASE}checkout.php`, {
            method: 'POST'
          });
          const result = await res.json();
          if (result.success) {
            alert('Compra finalizada con éxito');
            location.reload();
          }
        } catch (error) {
          console.error('Error:', error);
        }
      });
    }
  } catch (error) {
    console.error('Error al cargar el carrito:', error);
  }
});
