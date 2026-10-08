<?php
$dir = 'assets/img/';
$archivos = scandir($dir);

echo "<h2>Archivos en assets/img/</h2><ul>";
foreach ($archivos as $archivo) {
  if (!in_array($archivo, ['.', '..'])) {
    echo "<li>$archivo</li>";
  }
}
echo "</ul>";
?>
