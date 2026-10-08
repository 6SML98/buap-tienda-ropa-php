document.addEventListener('DOMContentLoaded', () => {
  // Manejar clic en "Agregar al carrito"
  document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', async (e) => {
      e.preventDefault();
      
      const product = e.target.closest('.product');
      const productId = product.dataset.id;
      const productName = product.dataset.name;
      const productPrice = product.dataset.price;
      
      // Obtener talla seleccionada
      const selectedSize = product.querySelector('.size-option.selected')?.dataset.size || 'Única';
      
      try {
        const response = await fetch(ADD_TO_CART_URL, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            product_id: productId,
            product_name: productName,
            price: productPrice,
            size: selectedSize
          })
        });
        
        const result = await response.json();
        
        if (result.success) {
          alert('Producto agregado al carrito');
          updateCartCount();
        } else {
          alert('Error: ' + result.message);
        }
      } catch (error) {
        console.error('Error:', error);
        alert('No se pudo conectar al servidor');
      }
    });
  });

  // Manejar selección de tallas
  document.querySelectorAll('.size-option').forEach(button => {
    button.addEventListener('click', (e) => {
      e.preventDefault();
      const product = e.target.closest('.product');
      product.querySelectorAll('.size-option').forEach(btn => btn.classList.remove('selected'));
      e.target.classList.add('selected');
    });
  });

  // Actualizar contador del carrito
  async function updateCartCount() {
    try {
      const response = await fetch(CART_COUNT_URL);
      const data = await response.json();
      
      const cartCountElement = document.querySelector('.cart-count');
      if (cartCountElement) {
        cartCountElement.textContent = data.count || '0';
      }
    } catch (error) {
      console.error('Error al actualizar contador:', error);
    }
  }

  updateCartCount();
});

// Variables definidas desde el HTML para rutas relativas correctas
const ADD_TO_CART_URL = typeof BASE_PATH !== 'undefined' ? `${BASE_PATH}add_to_cart.php` : 'includes/cart/add_to_cart.php';
const CART_COUNT_URL = typeof BASE_PATH !== 'undefined' ? `${BASE_PATH}get_cart_count.php` : 'includes/cart/get_cart_count.php';
