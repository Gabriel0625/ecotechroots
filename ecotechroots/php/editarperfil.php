<?php
include_once 'conexao.php';
include_once 'auth.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Garante que o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../telalogin.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Recebe dados do formulário
$nome = trim($_POST['nome'] ?? '');
$bio = trim($_POST['bio'] ?? '');
$senha_atual = $_POST['senha_atual'] ?? '';
$nova_senha = $_POST['nova_senha'] ?? '';
$confirmar_senha = $_POST['confirmar_senha'] ?? '';

// ===== Validação de senha =====
if (!empty($nova_senha)) {
    if ($nova_senha !== $confirmar_senha) {
        $_SESSION['erro'] = "As senhas não coincidem!";
        header("Location: ../telaperfileditar.php");
        exit;
    }

    function senha_forte($senha) {
        $erros = [];
    
        if (strlen($senha) < 8) {
            $erros[] = "mínimo 8 caracteres";
        }
        if (!preg_match('/[A-Z]/', $senha)) {
            $erros[] = "pelo menos uma letra maiúscula";
        }
        if (!preg_match('/[a-z]/', $senha)) {
            $erros[] = "pelo menos uma letra minúscula";
        }
        if (!preg_match('/[0-9]/', $senha)) {
            $erros[] = "pelo menos um número";
        }
        if (!preg_match('/[\W_]/', $senha)) {
            $erros[] = "pelo menos um caractere especial";
        }
    
        return $erros; // retorna array vazio se estiver ok
    }
    

    // Verificar se a senha atual está correta
    $stmt = $mysqli->prepare("SELECT senha FROM tb_usuarios WHERE id_usuarios = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($senha_hash);
    $stmt->fetch();
    $stmt->close();

    if (!empty($nova_senha)) {
        if ($nova_senha !== $confirmar_senha) {
            $_SESSION['erro'] = "As senhas não coincidem!";
            header("Location: ../telaperfileditar.php");
            exit;
        }
    
        // Validação de senha forte
        $erros_senha = senha_forte($nova_senha);
        if (!empty($erros_senha)) {
            $_SESSION['erro'] = 'Senha fraca! Ela precisa ter: ' . implode(', ', $erros_senha) . '.';
            header("Location: ../telaperfileditar.php");
            exit;
        }
    
        // Verificar se a senha atual está correta
        $stmt = $mysqli->prepare("SELECT senha FROM tb_usuarios WHERE id_usuarios = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($senha_hash);
        $stmt->fetch();
        $stmt->close();
    
        if (!password_verify($senha_atual, $senha_hash)) {
            $_SESSION['erro'] = "Senha atual incorreta!";
            header("Location: ../telaperfileditar.php");
            exit;
        }
    
        $senha_final = password_hash($nova_senha, PASSWORD_DEFAULT);
    }
    
    

    if (!password_verify($senha_atual, $senha_hash)) {
        $_SESSION['erro'] = "Senha atual incorreta!";
        header("Location: ../telaperfileditar.php");
        exit;
    }
    $senha_final = password_hash($nova_senha, PASSWORD_DEFAULT);
} else {
    // Se não alterar, manter senha antiga
    $stmt = $mysqli->prepare("SELECT senha FROM tb_usuarios WHERE id_usuarios = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($senha_final);
    $stmt->fetch();
    $stmt->close();
}

// ===== Upload de foto =====
$foto_nome = null;
if (!empty($_FILES['foto']['name']) && $_FILES['foto']['error'] === 0) {
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $foto_nome = "perfil_{$user_id}." . $ext;
    $destino = "../uploads/perfis/" . $foto_nome;
    move_uploaded_file($_FILES['foto']['tmp_name'], $destino);
}

// ===== Atualizar tb_usuarios =====
$stmt = $mysqli->prepare("UPDATE tb_usuarios SET nm_usuario = ?, senha = ? WHERE id_usuarios = ?");
$stmt->bind_param("ssi", $nome, $senha_final, $user_id);
$stmt->execute();
$stmt->close();

// ===== Atualizar tb_perfil =====
// Primeiro verificar se já existe
$stmt = $mysqli->prepare("SELECT id_perfil FROM tb_perfil WHERE tb_usuarios_id_usuarios = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($perfil_id);
$existe = $stmt->fetch();
$stmt->close();

if ($existe) {
    // Atualiza
    if ($foto_nome) {
        $stmt = $mysqli->prepare("UPDATE tb_perfil SET nm_usuario = ?, biografia = ?, img_perfil = ? WHERE tb_usuarios_id_usuarios = ?");
        $stmt->bind_param("sssi", $nome, $bio, $foto_nome, $user_id);
    } else {
        $stmt = $mysqli->prepare("UPDATE tb_perfil SET nm_usuario = ?, biografia = ? WHERE tb_usuarios_id_usuarios = ?");
        $stmt->bind_param("ssi", $nome, $bio, $user_id);
    }
    $stmt->execute();
    $stmt->close();
} else {
    // Inserir novo registro
    $stmt = $mysqli->prepare("INSERT INTO tb_perfil (nm_usuario, biografia, img_perfil, tb_usuarios_id_usuarios) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nome, $bio, $foto_nome, $user_id);
    $stmt->execute();
    $stmt->close();
}

// Redirecionar de volta para perfil
$_SESSION['msg'] = "Perfil atualizado com sucesso!";
header("Location: ../perfil.php");
exit;
