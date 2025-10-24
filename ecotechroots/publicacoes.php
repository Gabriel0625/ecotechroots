<?php
include_once __DIR__ . '/php/conexao.php';
include_once __DIR__ . '/php/auth.php';
$publicacoes = [];
$sql = "SELECT id_publicacao, tb_usuarios_id_usuarios, nm_publicacao, descricao FROM tb_publicacao ORDER BY id_publicacao DESC";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) $publicacoes[] = $row;
    $stmt->close();
}
?>
<!doctype html><html lang="pt-br"><head><meta charset="utf-8"><title>Publicações</title></head><body>
<div class="container-publicacoes">
<?php if (empty($publicacoes)): ?><p>Nenhuma publicação encontrada.</p>
<?php else: foreach ($publicacoes as $p): ?>
<article class="post-card">
  <h3 class="post-title"><?php echo htmlspecialchars($p['nm_publicacao']); ?></h3>
  <div class="post-content"><?php echo nl2br(htmlspecialchars($p['descricao'])); ?></div>
</article>
<?php endforeach; endif; ?>
</div></body></html>


<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>EcotechRoots</title>
  <link rel="shortcut icon" href="favicon.com/favicon.png" type="image/x-icon" />
  
  <link rel="shortcut icon" href="favicon.com/favicon.png" type="image/x-icon" />
  <link rel="stylesheet" href="css/bootstrap.min.css" />

  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --bege: rgba(200, 241, 153, 0.15);
      --verde-900: #27b87bcb;
      --verde-800: #234d37;
      --verde-700: #2d6a4f;
      --verde-500: #52b788;
      --verde-400: #32855b;
      --verde-50: #FEFFF1;
      --texto: #243c3b;
      --branco: #FEFFF1;
    }

    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: "Roboto", sans-serif;
      background: var(--bege);
      color: var(--verde-700);
      overflow: hidden;
    }

    /* HEADER FIXO */
    header {
      background-color: var(--verde-800);
      color: var(--branco);
      position: fixed;
      top: 0;
      width: 100%;
      height: 60px;
      z-index: 1000;
      padding: 0 1rem;
      display: flex;
      align-items: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
.user-profile img {
  width: 45px;
  height: 45px;
  border-radius: 50%; 
  object-fit: cover;
  border: 2px solid #fff;
  cursor: pointer;
  transition: transform 0.2s ease;
}
.header-text {
  margin-left: 10px; /* ou px, %, o que preferir */
}

.user-profile img:hover {
  transform: scale(1.05);
}

    .d-flex.min-vh-100 {
      margin-top: 60px;
      display: flex;
      min-height: calc(100vh - 60px);
    }

    /* SIDEBAR FIXA */
    .sidebar {
      position: fixed;
      top: 60px;
      left: 0;
      width: 220px;
      height: calc(100vh - 60px);
      background: var(--verde-800);
      padding: 2rem 1rem;
      overflow-y: auto;
    }
    .sidebar .nav-link {
      color: var(--verde-50);
      font-weight: 500;
      margin-bottom: 0.5rem;
      transition: all 0.3s ease;
    }
    .sidebar .nav-link:hover {
      color: #fff;
      transform: translateX(4px);
    }

    main {
      margin-left: 130px;
      display: flex;
      flex-direction: column;
      flex: 1;
      overflow: hidden;
    }

    /* PAINEL */
    .panel {
      width: auto;
      max-width: 980px;
      background: rgb(234, 241, 221);
      border-radius: 18px;
      padding: 28px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06);
      margin: 100px auto;
    }
    .panel h2 {
      text-align: center;
      font-size: 30px;
      margin-bottom: 6px;
      color: #21412f; 
      font-weight: 700;
    }
    .panel p.lead {
      text-align:center;
      font-size:14px;
      color:#2f4f3f;
      margin-bottom: 18px;
      line-height:1.25;
    }

    /* CARROSSEL */
    .carousel { 
      display: flex; 
      align-items: center; 
      justify-content: center; 
      gap: 12px; 
      padding: 16px; 
    }
    .carousel .btn {
      width:50px; height:50px;
      border-radius:50%;
      background:#21412f;
      color:#fff;
      display:flex; align-items:center; justify-content:center;
      font-size:24px;
      cursor:pointer;
      box-shadow:0 4px 12px rgba(0,0,0,0.25);
      transition: all 0.3s ease;
      flex:0 0 auto;
    }
    .carousel .btn:hover {
      background: #2d6a4f;
      transform: scale(1.1);
    }

    .viewport {
      overflow:hidden; flex:1 1 auto;
      border-radius:12px; padding:14px;
      background:linear-gradient(180deg, rgba(255,255,255,0.6), rgba(255,255,255,0.35));
    }
    .track {
      display:flex;
      gap:18px;
      transition: transform 450ms cubic-bezier(.22,.9,.3,1);
      align-items:stretch;
      justify-content: center; 
    }

    /* CARDS MODERNOS */
    .card {
      background:#fff;
      min-width:300px;
      max-width:45%;
      border-radius:20px;
      box-shadow:0 4px 15px rgba(0,0,0,0.1);
      overflow:hidden;
      display:flex; 
      flex-direction:column;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor:pointer;
      position: relative;
    }
    .card:hover {
      transform: translateY(-8px) scale(1.03);
      box-shadow:0 15px 30px rgba(0,0,0,0.18);
    }

    .card img {
      width:100%;
      height:180px;
      object-fit:cover;
      border-radius:20px 20px 0 0;
      transition: transform 0.3s ease;
    }
    .card:hover img {
      transform: scale(1.05);
    }

    .card-body {
      padding:16px;
      background: linear-gradient(180deg, #f8fff5 0%, #eaf0df 100%);
    }
    .card-body .meta {
      font-size:13px;
      color:#4b6b58;
      margin-bottom:8px;
    }
    .card-body p {
      font-size:14px;
      line-height:1.4;
      color:#2f4f3f;
    }
    .leiamais {
      color:#1f6b4f;
      text-decoration:none;
      font-weight:600;
      transition: color 0.3s ease;
    }
    .leiamais:hover {
      color:#21412f;
    }

    .dots { display:flex; justify-content:center; gap:8px; margin-top:14px; }
    .dot { width:10px; height:10px; border-radius:50%; background:#bfc9b8; cursor:pointer; transition: all 0.3s ease; }
    .dot.active { background:#21412f; transform: scale(1.2); }

    .cta { text-align:center; margin-top:18px; }
    .btn-primary {
      margin-top:10px; background:transparent; border:2px solid #21412f; color:#21412f;
      padding:10px 18px; border-radius:12px; font-weight:700; cursor:pointer;
      transition: background 0.3s ease, color 0.3s ease;
    }
    .btn-primary:hover { background:#21412f; color:#fff; }

    /* RESPONSIVO */
    @media (max-width: 720px) {
      .sidebar { width: 180px; }
      main { margin-left: 180px; }
      .card { min-width:80%; max-width:90%; }
      .card img { height:200px; }
    }
  </style>
</head>
<body>

  <!-- Header -->
<header class="d-flex align-items-center px-4 py-2">
  <!-- Logo -->
  <a href="telainicial2.html" class="d-flex align-items-center gap-2">
    <img src="image/logo ecotech.png" alt="Logo EcotechRoots" width="80" height="80">
  </a>

  <!-- Texto central -->
<div class="flex-grow-1 d-flex justify-content-center ms-3">
  <span class="fw-bold text-white">EcotechRoots</span>
</div>
  <!-- Foto do usuário -->
  <a href="perfil.html" class="user-profile ms-auto">
    <img id="userAvatar" src="image/imguser.png" alt="Foto do Usuário">
  </a>
</header>

<script>
  // Caminho da imagem do usuário
  const fotoDoUsuario = ""; // use o caminho exato da sua imagem

  const avatar = document.getElementById("userAvatar");
  if(fotoDoUsuario){
    avatar.src = fotoDoUsuario; // substitui o avatar padrão
  }
</script>


  <!-- SIDEBAR -->
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
      <a class="nav-link" href="logout.html">Sair</a>
      <div class="small mt-2">© 2025 Ecotech</div>
    </div>
  </aside>

  <!-- CONTEÚDO -->
  <main>
    <section class="panel" aria-label="Publicações da Comunidade">
      <h2>Publicações da Comunidade</h2>
      <p class="lead">Veja onde nossas mudas estão ganhando vida!<br>Os usuários compartilham fotos e histórias das plantações realizadas.</p>

      <div class="carousel">
        <button class="btn" id="prevBtn" aria-label="Anterior">&lt;</button>
        <div class="viewport" id="viewport">
          <div class="track" id="track">
            <article class="card">
              <img src="https://picsum.photos/id/1018/800/600" alt="Plantação em andamento">
              <div class="card-body">
                <div class="meta d-flex justify-content-between"><span><strong>User</strong></span><span>14-04-2025</span></div>
                <p>Só um comentariozinho... <a href="#" class="leiamais">Leia Mais</a></p>
              </div>
            </article>
            <article class="card">
              <img src="https://picsum.photos/id/1025/800/600" alt="Relato da plantação">
              <div class="card-body">
                <div class="meta d-flex justify-content-between"><span><strong>User</strong></span><span>12-04-2025</span></div>
                <p>Relato da plantação... <a href="#" class="leiamais">Leia Mais</a></p>
              </div>
            </article>
            <article class="card">
              <img src="https://picsum.photos/id/1036/800/600" alt="Horta escolar em crescimento">
              <div class="card-body">
                <div class="meta d-flex justify-content-between"><span><strong>User</strong></span><span>10-04-2025</span></div>
                <p>Horta escolar crescendo... <a href="#" class="leiamais">Leia Mais</a></p>
              </div>
            </article>
          </div>
        </div>
        <button class="btn" id="nextBtn" aria-label="Próximo">&gt;</button>
      </div>

      <div class="dots" id="dots"></div>
      <div class="cta">
        <p>Já fez sua parte? Faça sua publicação também!</p>
        <a href="criapubli.html" class="btn btn-primary">+ Nova Publicação</a>

      </div>
    </section>
  </main>

  <!-- JS CARROSSEL -->
  <script>
    (function(){
      const track = document.getElementById('track');
      const prevBtn = document.getElementById('prevBtn');
      const nextBtn = document.getElementById('nextBtn');
      const dotsContainer = document.getElementById('dots');
      const viewport = document.getElementById('viewport');
      const items = Array.from(track.children);
      let index = 0;

      function itemsPerView(){ return window.matchMedia("(max-width:720px)").matches ? 1 : 2; }
      function pageCount(){ return Math.ceil(items.length / itemsPerView()); }

      function update(){
        const cardWidth = viewport.clientWidth / itemsPerView();
        track.style.transform = `translateX(${-(index * cardWidth)}px)`;
        updateDots();
      }
      function createDots(){
        dotsContainer.innerHTML = '';
        for(let i=0;i<pageCount();i++){
          const d=document.createElement('div');
          d.className='dot'+(i===0?' active':'');
          d.addEventListener('click',()=>{index=i;update();});
          dotsContainer.appendChild(d);
        }
      }
      function updateDots(){
        Array.from(dotsContainer.children).forEach((d,i)=>d.classList.toggle('active', i===index));
      }

      prevBtn.onclick=()=>{index=(index-1+pageCount())%pageCount();update();}
      nextBtn.onclick=()=>{index=(index+1)%pageCount();update();}
      window.onresize=()=>{createDots();update();}
      createDots();update();
    })();
  </script>

</body>
</html>