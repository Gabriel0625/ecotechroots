<?php
include __DIR__ . '/conexao.php';
if (session_status() === PHP_SESSION_NONE) session_start();
$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';
$confirmar = $_POST['confirmar_senha'] ?? '';
if (!$nome || !$email || !$senha || !$confirmar) {
    $_SESSION['cad_error'] = 'Preencha todos os campos.';
    header('Location: ../telacadastro.html'); exit;
}
if ($senha !== $confirmar) {
    $_SESSION['cad_error'] = 'As senhas não coincidem.';
    header('Location: ../telacadastro.html'); exit;
}
if ($stmt = $mysqli->prepare('SELECT id_usuarios FROM tb_usuarios WHERE email = ? LIMIT 1')) {
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->close();
        $_SESSION['cad_error'] = 'Email já cadastrado.';
        header('Location: ../telacadastro.html'); exit;
    }
    $stmt->close();
}
$hash = password_hash($senha, PASSWORD_DEFAULT);
if ($stmt = $mysqli->prepare('INSERT INTO tb_usuarios (nm_usuario, email, senha, telefone) VALUES (?, ?, ?, ?)')) {
    $telefone = NULL;
    $stmt->bind_param('ssss', $nome, $email, $hash, $telefone);
    if (!$stmt->execute()) {
        $stmt->close();
        $_SESSION['cad_error'] = 'Erro ao cadastrar.';
        header('Location: ../telacadastro.html'); exit;
    }
    $user_id = $stmt->insert_id;
    $stmt->close();
    $img = NULL; $bio = '';
    if ($stmt2 = $mysqli->prepare('INSERT INTO tb_perfil (img_perfil, tb_usuarios_id_usuarios, nm_usuario, biografia) VALUES (?, ?, ?, ?)')) {
        $stmt2->bind_param('siss', $img, $user_id, $nome, $bio);
        $stmt2->execute();
        $stmt2->close();
    }
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_name'] = $nome;
    header('Location: ../index.php'); exit;
} else {
    $_SESSION['cad_error'] = 'Erro ao preparar consulta.';
    header('Location: ../telacadastro.html'); exit;
}
?>