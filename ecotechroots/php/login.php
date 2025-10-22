<?php
include_once __DIR__ . '/conexao.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if (!$email || !$senha) {
    $_SESSION['login_error'] = 'Preencha email e senha.';
    header('Location: ../telalogin.php'); exit;
}

if ($stmt = $mysqli->prepare('SELECT id_usuarios, senha, nm_usuario FROM tb_usuarios WHERE email = ? LIMIT 1')) {
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($user = $res->fetch_assoc()) {
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['user_id'] = (int)$user['id_usuarios'];
            $_SESSION['user_name'] = $user['nm_usuario'];
            header('Location: ../telainicial.php'); exit;
        } else {
            $_SESSION['login_error'] = 'Senha incorreta.';
        }
    } else {
        $_SESSION['login_error'] = 'Usuário não encontrado.';
    }
    $stmt->close();
} else {
    $_SESSION['login_error'] = 'Erro no sistema.';
}
header('Location: ../telalogin.php'); exit;
?>
