<?php
include_once './config/conn.php';
include_once './config/head.php';

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

/* Validar ID se existe */
if (empty($id)) {
    echo "<script>  alert('ID não informado!'); </script> ";    
    echo "<script>  window.location.href = 'index.php';  </script>";
}