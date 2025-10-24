<?php
include_once 'php/conexao.php';
include_once 'php/auth.php';

if (!is_logged()) {
    header("Location: telalogin.php");
    exit;
}

// Pega os dados do usuário logado
$user = get_logged_user($mysqli);
if (!$user) {
    header("Location: telalogin.php");
    exit;
}

$erro = '';
$sucesso = '';

// --- Processar envio do formulário ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmar = $_POST['confirmar_senha'] ?? '';

    if ($senha && $senha !== $confirmar) {
        $erro = 'As senhas não coincidem!';
    } else {
        // Upload da foto
        $diretorio = __DIR__ . "/uploads/perfis/"; 
        if (!is_dir($diretorio)) mkdir($diretorio, 0777, true);

        $fotoNome = $user['img_perfil'];
        if (!empty($_FILES['foto']['name'])) {
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $fotoNome = 'perfil_' . $user['id_usuarios'] . '.' . $ext;
            $destino = $diretorio . $fotoNome;
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                $erro = 'Falha ao enviar a foto!';
            }
        }

        if (!$erro) {
            if ($senha) {
                $hashSenha = password_hash($senha, PASSWORD_DEFAULT);
                $stmt = $mysqli->prepare("UPDATE tb_usuarios SET nm_usuario = ?, senha = ? WHERE id_usuarios = ?");
                $stmt->bind_param("ssi", $nome, $hashSenha, $user['id_usuarios']);
                $stmt->execute();
                $stmt->close();
            } else {
                $stmt = $mysqli->prepare("UPDATE tb_usuarios SET nm_usuario = ? WHERE id_usuarios = ?");
                $stmt->bind_param("si", $nome, $user['id_usuarios']);
                $stmt->execute();
                $stmt->close();
            }

            // Atualizar perfil
            $stmt2 = $mysqli->prepare("INSERT INTO tb_perfil (img_perfil, biografia, tb_usuarios_id_usuarios) VALUES (?, ?, ?) 
                                        ON DUPLICATE KEY UPDATE img_perfil = VALUES(img_perfil), biografia = VALUES(biografia)");
            $stmt2->bind_param("ssi", $fotoNome, $bio, $user['id_usuarios']);
            $stmt2->execute();
            $stmt2->close();

            $sucesso = 'Perfil atualizado com sucesso!';
            $user = get_logged_user($mysqli);
        }
    }
}

// Caminho da foto
$fotoPerfil = !empty($user['img_perfil']) && file_exists('uploads/perfis/' . $user['img_perfil'])
              ? 'uploads/perfis/' . $user['img_perfil']
              : 'image/imguser.png';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Editar Perfil - EcotechRoots</title>
<link rel="stylesheet" href="css/bootstrap.css" />
<link rel="shortcut icon" href="favicon.com/favicon.png" type="image/x-icon" />
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;800&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
<style>
:root {
  --bege: rgba(200, 241, 153, 0.15);
  --verde-800: #234d37;
  --verde-700: #2d6a4f;
  --verde-500: #52b788;
  --branco: #FEFFF1;
  --vermelho: #e74c3c;
  --vermelho-escuro: #c0392b;
}
body { background: var(--bege); font-family: "Roboto", sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
.card { padding: 2.5rem; border-radius: 22px; background: var(--branco); max-width: 520px; width: 90%; text-align: center; position: relative; box-shadow: 0 6px 20px rgba(0,0,0,0.12); border: 1px solid rgba(82,183,136,0.25); }
.card h3 { font-family: "Montserrat", sans-serif; font-weight: 700; color: var(--verde-800); margin-bottom: 1.5rem; }
.card img { width: 150px; height: 150px; border-radius: 50%; object-fit: cover; margin: 1rem 0; border: 4px solid var(--verde-500); box-shadow: 0 4px 12px rgba(0,0,0,0.15); transition: transform 0.3s ease; }
.card img:hover { transform: scale(1.05); }
.form-control { border-radius: 10px; border: 1px solid #cfd8cf; padding: 0.8rem; font-size: 0.95rem; transition: all 0.2s ease; }
.form-control:focus { border-color: var(--verde-500); box-shadow: 0 0 6px rgba(82,183,136,0.5); }
.btn-alterar-foto, .btn-remover-foto { padding: 10px; font-size: 0.95rem; border-radius: 10px; width: 100%; font-weight: 600; margin-bottom: 0.6rem; transition: all 0.3s ease; letter-spacing: 0.3px; }
.btn-alterar-foto { background: var(--verde-500); color: #fff; border: none; box-shadow: 0 3px 8px rgba(0,0,0,0.15); }
.btn-alterar-foto:hover { background: var(--verde-700); transform: translateY(-2px); }
.btn-remover-foto { background: var(--vermelho); color: #fff; border: none; box-shadow: 0 3px 8px rgba(0,0,0,0.15); }
.btn-remover-foto:hover { background: var(--vermelho-escuro); transform: translateY(-2px); }
h5 { font-family: "Montserrat", sans-serif; color: var(--verde-800); margin: 1.5rem 0 1rem; }
.btn-success { background: linear-gradient(135deg, var(--verde-700), var(--verde-500)); border: none; border-radius: 12px; font-weight: 600; padding: 0.9rem; font-size: 1rem; box-shadow: 0 5px 14px rgba(0,0,0,0.18); transition: all 0.3s ease; }
.btn-success:hover { background: linear-gradient(135deg, var(--verde-500), var(--verde-700)); transform: translateY(-2px); }
.alert { margin-bottom: 1rem; }
#senhaAviso { font-size: 0.9rem; color: var(--vermelho); margin-bottom: 1rem; display:none; }
</style>
</head>
<body>

<div class="card">
  <h3>Editar Perfil</h3>

  <?php if($erro): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
  <?php endif; ?>
  <?php if($sucesso): ?>
      <div class="alert alert-success"><?= htmlspecialchars($sucesso) ?></div>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data" id="formPerfil">
      <input type="text" name="nome" class="form-control mb-3" placeholder="Nome completo" value="<?= htmlspecialchars($user['nm_usuario']) ?>">
      <textarea name="bio" class="form-control mb-3" rows="4" placeholder="Biografia"><?= htmlspecialchars($user['biografia']) ?></textarea>

      <button type="button" id="btnAlterarFoto" class="btn-alterar-foto">Alterar Foto</button>
      <input type="file" name="foto" id="inputFoto" style="display:none" accept="image/*">

      <img id="previewFoto" src="<?= $fotoPerfil ?>" alt="Foto Perfil">

      <button type="button" id="btnRemoverFoto" class="btn-remover-foto">Remover Foto</button>

      <h5 class="mt-3">Alterar Senha</h5>
      <input type="password" name="senha" id="senha" class="form-control mb-2" placeholder="Nova Senha">
      <input type="password" name="confirmar_senha" id="confirmar_senha" class="form-control mb-2" placeholder="Confirmar Senha">
      <div id="senhaAviso">A senha deve ter ao menos 6 caracteres, incluindo letra maiúscula, minúscula e número.</div>

      <button type="submit" class="btn btn-success mt-2">Salvar Alterações</button>
  </form>
</div>

<script>
// Preview da foto
document.getElementById('btnAlterarFoto').onclick = () => document.getElementById('inputFoto').click();
document.getElementById('inputFoto').onchange = (e) => {
    const reader = new FileReader();
    reader.onload = () => document.getElementById('previewFoto').src = reader.result;
    reader.readAsDataURL(e.target.files[0]);
};
document.getElementById('btnRemoverFoto').onclick = () => document.getElementById('previewFoto').src = 'image/imguser.png';

// Validação de senha
document.getElementById('formPerfil').onsubmit = function(e) {
    const senha = document.getElementById('senha').value;
    const confirmar = document.getElementById('confirmar_senha').value;
    const aviso = document.getElementById('senhaAviso');
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/;

    if (senha && !regex.test(senha)) {
        aviso.style.display = 'block';
        e.preventDefault();
        return false;
    } else {
        aviso.style.display = 'none';
    }

    if (senha && senha !== confirmar) {
        alert('As senhas não coincidem!');
        e.preventDefault();
        return false;
    }
};
</script>

</body>
</html>
