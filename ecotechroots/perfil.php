<?php
include_once 'php/conexao.php';
include_once 'php/auth.php';

if (!is_logged()) {
    header("Location: telalogin.php");
    exit;
}

// Pega o usuário logado usando a função do auth.php
$user = get_logged_user($mysqli);
if (!$user) {
    header("Location: telalogin.php");
    exit;
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
<title>EcotechRoots - Perfil</title>

<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="shortcut icon" href="favicon.com/favicon.png" type="image/x-icon" />
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;800&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">

<style>
/* --- Sua estilização original --- */
:root {
  --bege: rgba(200, 241, 153, 0.15);
  --verde-800: #234d37;
  --verde-700: #2d6a4f;
  --verde-500: #52b788;
  --verde-300: #95d5b2;
  --branco: #FEFFF1;
}
body, html { margin: 0; padding: 0; font-family: Roboto, sans-serif; background: var(--bege); color: var(--verde-700); height:100%; overflow:hidden; }
header { background-color: var(--verde-800); color: var(--branco); position: fixed; top: 0; width: 100%; height: 60px; display:flex; align-items:center; padding:0 1rem; box-shadow:0 2px 8px rgba(0,0,0,0.15); z-index:1000; }
.sidebar { position: fixed; top:60px; left:0; width:220px; height:calc(100vh - 60px); background: var(--verde-800); padding:2rem 1rem; overflow-y:auto; }
.sidebar .nav-link { color: var(--branco); font-weight:500; margin-bottom:0.5rem; transition:0.3s; }
.sidebar .nav-link:hover { color: #ffffff; transform: translateX(4px); }
main.container { margin-left: 220px; padding:80px 2% 40px; min-height: calc(100vh - 60px); display:flex; justify-content:center; }
h2.text-success { font-family: Montserrat, sans-serif; font-weight: 700; }
.perfil-container { background: var(--branco); border-radius:16px; padding:2rem; box-shadow:0 6px 18px rgba(0,0,0,0.12); width:100%; max-width:900px; margin:0 auto; position:relative; transition: all .3s ease; }
.perfil-container:hover { transform: scale(1.01); }
.perfil-foto img { width:130px; height:130px; border-radius:50%; object-fit:cover; border:4px solid var(--verde-500); display:block; margin:0 auto; transition: .3s; }
.perfil-foto img:hover { border-color: var(--verde-300); transform: scale(1.05); }
.btn-editar-perfil { position:absolute; top:15px; right:20px; background: var(--verde-500); color:#fff; border:none; padding:6px 14px; border-radius:8px; font-size:0.9rem; cursor:pointer; transition:0.2s; }
.btn-editar-perfil:hover { background: var(--verde-700); }
h1#nomeUsuario { font-family: Montserrat, sans-serif; font-weight:700; color: var(--verde-700); }
.bio { color: #555; font-style: italic; margin-bottom: 1rem; }
section.publicacoes { margin-top: 2rem; }
.card-publicacao { border-radius: 14px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: .3s; }
.card-publicacao:hover { transform: translateY(-6px); }
.card-publicacao img { height: 200px; object-fit: cover; }
.btn-excluir { background:#e63946; border:none; }
.btn-excluir:hover { background:#c1121f; }
.btn-adicionar { background: var(--verde-500); color:#fff; border:none; padding:6px 12px; font-size:1.4rem; border-radius:8px; text-decoration:none; display:flex; align-items:center; justify-content:center; transition:.2s; }
.btn-adicionar:hover { background: var(--verde-700); }
@media(max-width:767.98px){ .sidebar{ display:none; } main{ margin-left:0; padding:100px 1rem 2rem; } }
</style>
</head>
<body>

<header>
  <a href="telainicial.php" class="d-flex align-items-center gap-2">
    <img src="image/logo ecotech.png" alt="Logo EcotechRoots" width="80" height="80">
  </a>
  <div class="flex-grow-1 d-flex justify-content-center ms-3">
    <span class="fw-bold text-white">EcotechRoots</span>
  </div>
</header>

<aside class="sidebar d-none d-md-flex flex-column p-4 text-white">
  <nav class="nav flex-column gap-2">
    <a class="nav-link" href="telainicial.php">Início</a>
    <a class="nav-link" href="telaprojeto.html">Projeto</a>
    <a class="nav-link" href="telaconcientizacao.html">Conscientização</a>
    <a class="nav-link" href="telapin.html">Mapa Pin</a>
    <a class="nav-link" href="publicacoes.php">Publicação</a>
    <a class="nav-link" href="sobre.html">Sobre nós</a>
  </nav>
  <div class="mt-auto">
    <a class="nav-link" href="logout.php">Sair</a>
    <div class="small mt-2">© 2025 Ecotech</div>
  </div>
</aside>

<main class="container">
  <div class="perfil-container">
    <a href="telaperfileditar.php" class="btn-editar-perfil">✎ Editar Perfil</a>
    <div class="perfil-foto mb-3">
      <img id="fotoPerfil" src="<?php echo $fotoPerfil; ?>" alt="Foto do usuário">
    </div>

    <h1 id="nomeUsuario" class="h3 text-center">
      <?php echo htmlspecialchars($user['nm_usuario']); ?>
    </h1>

    <p class="bio text-center">
      <?php echo htmlspecialchars($user['email'] ?? ''); ?>
    </p>

    <p class="bio text-center" id="bioUsuario">
      <?php echo htmlspecialchars($user['biografia'] ?? 'Este é meu perfil, seja bem-vindo!'); ?>
    </p>

    <hr>
    <section class="publicacoes mt-4">
      <div class="d-flex justify-content-center align-items-center gap-2 mb-3 flex-wrap">
        <h2 class="text-success m-2">Minhas publicações</h2>
        <a href="criapubli.php" class="btn-adicionar">+</a>
      </div>

      <div id="publicacoesLista" class="row g-3"></div>
    </section>
  </div>
</main>

<script>
// ===== Publicações (localStorage, mantém seu JS) =====
const LS_PUBLICACOES = "publicacoes_ecotech";
const lista = document.getElementById("publicacoesLista");

function excluirPublicacao(id){
  if(!confirm("Deseja realmente excluir esta publicação?")) return;
  let arr = JSON.parse(localStorage.getItem(LS_PUBLICACOES) || "[]");
  arr = arr.filter(pub => pub.id !== id);
  localStorage.setItem(LS_PUBLICACOES, JSON.stringify(arr));
  carregarPublicacoes();
}

function carregarPublicacoes(){
  const arr = JSON.parse(localStorage.getItem(LS_PUBLICACOES) || "[]");
  lista.innerHTML = "";
  if(arr.length === 0){
    lista.innerHTML = '<p class="text-muted">Nenhuma publicação ainda.</p>';
    return;
  }
  arr.forEach(pub=>{
    const col = document.createElement("div");
    col.className="col-sm-6 col-lg-4 d-flex";
    col.innerHTML=`
      <div class="card card-publicacao w-100">
        <img src="${pub.imagemBase64}" class="card-img-top" alt="Publicação">
        <div class="card-body">
          <h5 class="card-title">${pub.legenda}</h5>
          <p class="card-text"><small class="text-muted">Lat: ${Number(pub.lat).toFixed(4)}, Lng: ${Number(pub.lng).toFixed(4)}</small></p>
          <button class="btn-excluir btn btn-sm btn-danger" onclick="excluirPublicacao(${pub.id})">Excluir</button>
        </div>
      </div>`;
    lista.appendChild(col);
  });
}
carregarPublicacoes();
</script>

</body>
</html>
