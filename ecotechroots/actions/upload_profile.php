<?php
include __DIR__ . '/../php/conexao.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user_id'])) { header('Location: ../telalogin.html'); exit; }
$user_id = $_SESSION['user_id'];
if (!isset($_FILES['img_perfil']) || $_FILES['img_perfil']['error'] !== UPLOAD_ERR_OK) { $_SESSION['flash_error'] = 'Erro no upload.'; header('Location: ../perfil.php'); exit; }
$ext = pathinfo($_FILES['img_perfil']['name'], PATHINFO_EXTENSION);
$allowed = ['jpg','jpeg','png','webp','gif'];
if (!in_array(strtolower($ext), $allowed)) { $_SESSION['flash_error']='Formato não suportado.'; header('Location: ../perfil.php'); exit; }
$uploads_dir = __DIR__ . '/../uploads/perfis/';
if (!is_dir($uploads_dir)) mkdir($uploads_dir, 0755, true);
$filename = 'user_'.$user_id.'_'.time().'.'.$ext;
$target = $uploads_dir . $filename;
if (!move_uploaded_file($_FILES['img_perfil']['tmp_name'], $target)) { $_SESSION['flash_error']='Falha ao mover arquivo.'; header('Location: ../perfil.php'); exit; }
$sql = 'UPDATE tb_perfil SET img_perfil = ? WHERE tb_usuarios_id_usuarios = ?';
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param('si', $filename, $user_id);
    $stmt->execute();
    $stmt->close();
    $_SESSION['flash_success'] = 'Foto atualizada.';
} else { $_SESSION['flash_error'] = 'Erro ao salvar imagem no banco.'; }
header('Location: ../perfil.php'); exit;
?>