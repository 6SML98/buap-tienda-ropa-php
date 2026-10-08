document.addEventListener('DOMContentLoaded', () => {
  const addToCartButtons = document.querySelectorAll('.add-to-cart');

  // Selección de tallas por producto
  document.querySelectorAll('.product').forEach(product => {
    const sizeButtons = product.querySelectorAll('.size-option');
    
    sizeButtons.forEach(button => {
      button.addEventListener('click', e => {
        e.preventDefault();
        sizeButtons.forEach(btn => btn.classList.remove('selected'));
        button.classList.add('selected');
      });
    });
  });

  // Agregar al carrito
  addToCartButtons.forEach(button => {
    button.addEventListener('click', async (e) => {
      e.preventDefault();

      const product = button.closest('.product');
      const productName = product.dataset.name || product.querySelector('img')?.alt;
      const productPrice = product.dataset.price;
      const selectedSize = product.querySelector('.size-option.selected')?.dataset.size || 'Única';

      try {
        const response = await fetch(`${BASE_PATH}add_to_cart.php`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
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
          alert('Error al agregar al carrito: ' + result.message);
        }
      } catch (error) {
        console.error('Error:', error);
        alert('Error al conectar con el servidor');
      }
    });
  });

  // Actualizar contador del carrito
  function updateCartCount() {
    fetch(`${BASE_PATH}get_cart_count.php`)
      .then(response => response.json())
      .then(data => {
        const cartCountElement = document.querySelector('.cart-count');
        if (cartCountElement) {
          cartCountElement.textContent = data.count || '0';
        }
      })
      .catch(error => {
        console.error('Error actualizando contador:', error);
      });
  }

  // Inicializar contador
  updateCartCount();
});
