<?php
require '../includes/db.php';
session_start();

try {
    // Consulta para obtener productos de tipo 0 (Playeras)
    $stmt = $pdo->prepare("SELECT * FROM Productos WHERE tipo = 0");
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener productos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playeras</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
<header class="page-header">
  <?php if (isset($_SESSION['nombre'])): ?>
    <div class="user-info" style="position:absolute; top:10px; right:10px; background: #fff; padding: 10px 20px; border-radius: 10px; font-weight: bold; color: #4b2e15; box-shadow: 2px 2px 5px rgba(0,0,0,0.2); font-family: 'Poppins', sans-serif;">
      👋 Hola, <?= htmlspecialchars($_SESSION['nombre']) ?> |
      <a href="../includes/auth/logout.php" style="color: brown; text-decoration: underline; font-weight: bold;">Cerrar sesión</a>
    </div>
  <?php endif; ?>
</header>

<div class="container">
  <nav>
    <img src="../assets/img/Logo.png" alt="Logo">
    <ul>
      <li><a href="playeras.php"><strong>Playeras</strong></a></li>
      <li><a href="pantalones.php">Pantalones</a></li>
      <li><a href="accesorios.php">Accesorios</a></li>
      <li><a href="../carro.php">Carro de compras</a></li>
    </ul>
  </nav>

  <main class="main-content">
    <section class="products product-grid">
      <?php foreach ($productos as $producto): ?>
        <article class='product' data-id='<?= $producto['id_producto'] ?>' data-name='<?= htmlspecialchars($producto['nombre']) ?>' data-price='<?= $producto['precio'] ?>'>
          <img src='../assets/img/<?= htmlspecialchars($producto['imagen']) ?>' alt='<?= htmlspecialchars($producto['nombre']) ?>'>

          <h2 class='product-name'><?= htmlspecialchars($producto['nombre']) ?></h2>
          <p class='product-price'>Precio: <?= htmlspecialchars($producto['precio']) ?> MX</p>
          <p class='product-sizes'>Tallas: <?= htmlspecialchars($producto['tallas']) ?></p>
          <div class='sizes'>
            <?php foreach (explode(',', $producto['tallas']) as $talla): ?>
              <button class='size-option' data-size='<?= htmlspecialchars($talla) ?>'><?= htmlspecialchars($talla) ?></button>
            <?php endforeach; ?>
          </div>
          <button class="add-to-cart">Agregar al carrito</button>
        </article>
      <?php endforeach; ?>
    </section>
  </main>
</div>

<footer>
  <p>&copy; 2025 Tienda de Ropa. Todos los derechos reservados.</p>
</footer>

<script>
$(document).ready(function() {
  $('.size-option').click(function() {
    $(this).siblings().removeClass('selected');
    $(this).addClass('selected');
  });

  $('.add-to-cart').click(function() {
    const product = $(this).closest('.product');
    const productId = product.data('id');
    const productName = product.data('name');
    const productPrice = product.data('price');
    const selectedSize = product.find('.size-option.selected').data('size');

    if (!selectedSize) {
      alert('Por favor selecciona una talla antes de continuar');
      return;
    }

    $.ajax({
      url: '../includes/cart/add_to_cart.php',
      method: 'POST',
      dataType: 'json',
      contentType: 'application/json',
      data: JSON.stringify({
        product_id: productId,
        product_name: productName,
        price: productPrice,
        size: selectedSize
      }),
      success: function(response) {
        if (response.success) {
          alert('Producto agregado al carrito');
        } else {
          alert('Error: ' + response.message);
        }
      },
      error: function() {
        alert('Error al conectar con el servidor');
      }
    });
  });

  function updateCartCount() {
    $.ajax({
      url: '../includes/cart/get_cart_count.php',
      method: 'GET',
      success: function(data) {
        $('#cart-count').text(data.count);
      }
    });
  }

  updateCartCount();
});
</script>

</body>
</html>
