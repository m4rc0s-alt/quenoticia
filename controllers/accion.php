<?php
require_once("../includes/db.php");
$op = $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";


$usuario = "1";
$titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : "Sin Titulo";
$descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "Sin Descripcion";
$categoria = isset($_POST["categorias"]) ? $_POST["categorias"] : "Sin Categoria";
$carpetaASubir = "../img/upload/";
$extension = pathinfo($_FILES["upload"]["name"], PATHINFO_EXTENSION);
$nuevoNombre = date('Ymd_His') . '_' . uniqid() . '.' . $extension;
$rutaFinal = $carpetaASubir . $nuevoNombre;


if (move_uploaded_file($_FILES["upload"]["tmp_name"], $rutaFinal)){
    $sql = "INSERT INTO noticias (titulo, imagen, descripcion, id_categoria, fecha_publicado, id_usuario) VALUES (?, ?, ?, ?, now(), ?)";
    $stmt = $conx->prepare($sql);
    $stmt->bind_param("sssis", $titulo, $rutaFinal, $descripcion, $categoria, $usuario);
    $stmt->execute();
    $stmt->close();

    header("Location: /noti/views/noticias/index.php");
}else {
    echo "Error al subir el archivo";
}