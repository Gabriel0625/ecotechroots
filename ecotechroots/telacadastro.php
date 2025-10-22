<?php
include_once __DIR__ . '/conexao.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';
$confirmar = $_POST['confirmar_senha'] ?? '';

if (!$nome || !$email || !$senha || !$confirmar) {
    $_SESSION['cad_error'] = 'Preencha todos os campos.';
    header('Location: ../telacadastro.php');
    exit;
}

if ($senha !== $confirmar) {
    $_SESSION['cad_error'] = 'As senhas não coincidem.';
    header('Location: ../telacadastro.php');
    exit;
}

// Verifica se o email já existe
if ($stmt = $mysqli->prepare('SELECT id_usuarios FROM tb_usuarios WHERE email = ? LIMIT 1')) {
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        $_SESSION['cad_error'] = 'Este email já está cadastrado.';
        header('Location: ../telacadastro.php');
        exit;
    }
    $stmt->close();
}

// Cria o hash da senha
$hash = password_hash($senha, PASSWORD_DEFAULT);

// Insere na tabela de usuários
if ($stmt = $mysqli->prepare('INSERT INTO tb_usuarios (nm_usuario, email, senha, telefone) VALUES (?, ?, ?, ?)')) {
    $telefone = ''; // vazio no cadastro inicial
    $stmt->bind_param('ssss', $nome, $email, $hash, $telefone);

    if ($stmt->execute()) {
        //  pega o ID do usuário recém-criado
        $user_id = $stmt->insert_id;
        $stmt->close();

        //  cria automaticamente o perfil vinculado
        if ($stmt2 = $mysqli->prepare('INSERT INTO tb_perfil (img_perfil, tb_usuarios_id_usuarios, nm_usuario, biografia) VALUES (?, ?, ?, ?)')) {
            $img = NULL;
            $bio = 'Este é meu perfil, seja bem-vindo!';
            $stmt2->bind_param('siss', $img, $user_id, $nome, $bio);
            $stmt2->execute();
            $stmt2->close();
        }

        //  salva sessão do usuário logado
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $nome;

        // redireciona para a tela inicial
        header('Location: ../telainicial.php');
        exit;
    } else {
        $stmt->close();
        $_SESSION['cad_error'] = 'Erro ao cadastrar usuário.';
        header('Location: ../telacadastro.php');
        exit;
    }
} else {
    $_SESSION['cad_error'] = 'Erro interno ao preparar o cadastro.';
    header('Location: ../telacadastro.php');
    exit;
}
?>
