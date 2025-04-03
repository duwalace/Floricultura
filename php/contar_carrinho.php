<?php
session_start();

if (!isset($_SESSION["carrinho"])) {
  $_SESSION["carrinho"] = [];
}

echo json_encode([
  'sucesso' => true,
  'quantidade' => array_sum($_SESSION["carrinho"])
]);
?>