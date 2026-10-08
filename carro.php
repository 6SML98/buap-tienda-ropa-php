<?php
require 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT rs.*, p.imagen FROM RopaSeleccionada rs JOIN Productos p ON rs.id_producto = p.id_producto WHERE rs.id_usuario = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al cargar el carrito: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carro de Compras - Tienda de Ropa</title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<header class="page-header">
  <?php if (isset($_SESSION['nombre'])): ?>
    <div class="user-info" style="position:absolute; top:10px; right:10px; background: #fff; padding: 10px 20px; border-radius: 10px; font-weight: bold; color: #4b2e15; box-shadow: 2px 2px 5px rgba(0,0,0,0.2); font-family: 'Poppins', sans-serif;">
      👋 Hola, <?= htmlspecialchars($_SESSION['nombre']) ?> |
      <a href="includes/auth/logout.php" style="color: brown; text-decoration: underline; font-weight: bold;">Cerrar sesión</a>
    </div>
  <?php endif; ?>
</header>

<section>
<div class="container">
  <nav>
    <img src="assets/img/Logo.png" alt="Perfil">
    <ul>
      <li><a href="products/playeras.php">Playeras</a></li>
      <li><a href="products/pantalones.php">Pantalones</a></li>
      <li><a href="products/accesorios.php">Accesorios</a></li>
      <li><a href="carro.php"><strong>Carro de compras</strong></a></li>
    </ul>
  </nav>

  <div class="cart-container">
    <h2>Tu carrito</h2>
    <div id="cart-items">
      <?php if (count($productos) > 0): ?>
        <?php $total = 0; ?>
        <?php foreach ($productos as $item): ?>
          <?php $total += $item['precio']; ?>
          <div class="cart-item">
            <img src="assets/img/<?= htmlspecialchars($item['imagen']) ?>" 
                 alt="<?= htmlspecialchars($item['producto']) ?>" 
                 onerror="this.src='assets/img/Fondo.png'; console.warn('Imagen no encontrada:', this.src)">
            <div class="cart-details">
              <p class="product-name"><?= htmlspecialchars($item['producto']) ?></p>
              <p class="product-size">Talla: <?= htmlspecialchars($item['talla']) ?></p>
              <p class="product-price">$<?= htmlspecialchars($item['precio']) ?></p>
            </div>
            <button class="remove-item" data-id="<?= $item['id_seleccion'] ?>">Eliminar</button>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="empty-cart-message">
          <p>Tu carrito está vacío</p>
          <a href="products/playeras.php" class="continue-shopping">Seguir comprando</a>
        </div>
      <?php endif; ?>
    </div>

    <div class="cart-summary">
      <p>Total: <span id="total-amount">$<?= number_format($total ?? 0, 2) ?></span></p>
      <?php if (count($productos) > 0): ?>
        <button class="checkout-button" id="checkout-btn">Finalizar compra</button>
      <?php endif; ?>
    </div>
  </div>
</div>
</section>

<footer>
  <p>&copy; 2025 Tienda de Ropa. Todos los derechos reservados.</p>
</footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.remove-item').forEach(button => {
    button.addEventListener('click', async () => {
      const itemId = button.getAttribute('data-id');
      const response = await fetch('includes/cart/remove_from_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: itemId })
      });
      const result = await response.json();
      if (result.success) location.reload();
    });
  });

  const checkoutBtn = document.getElementById('checkout-btn');
  if (checkoutBtn) {
    checkoutBtn.addEventListener('click', async () => {
      const response = await fetch('includes/cart/checkout.php', { method: 'POST' });
      const result = await response.json();
      if (result.success) {
        alert('Compra finalizada con éxito');
        location.reload();
      } else {
        alert('Error al finalizar la compra: ' + (result.message || ''));
      }
    });
  }
});
</script>

</body>
</html>
