<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EcotechRoots</title>
  <link rel="shortcut icon" href="favicon.com/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>

<!-- Header -->
<header class="d-flex align-items-center px-4 py-2">
  <!-- Logo -->
  <a href="telainicial.html" class="d-flex align-items-center gap-2 me-auto">
    <img src="image/logo ecotech.png" alt="Logo EcotechRoots" width="80" height="80">
  </a>

  <!-- Texto central -->
  <span class="fw-bold text-white mx-auto">
    EcotechRoots
  </span>

  <!-- Link simples -->
 <?php if (isset($_SESSION['usuario_id'])): ?>
  <!-- Se o usuário estiver logado -->
  <a href="perfil.php" class="user-profile ms-auto">
    <img id="userAvatar" 
         src="<?php echo $_SESSION['usuario_foto'] ?? 'image/imguser.png'; ?>" 
         alt="Foto do Usuário"
         style="width:45px; height:45px; border-radius:50%; object-fit:cover; border:2px solid #fff;">
  </a>
<?php else: ?>
  <!-- Se não estiver logado -->
  <a href="telalogin.html" class="fw-bold text-white text-decoration-none ms-auto">
    Entrar
  </a>
<?php endif; ?>

</header>



  <!-- Layout principal -->
  <div class="d-flex min-vh-100">

    <!-- SIDEBAR (desktop) -->
    <aside class="sidebar d-none d-md-flex flex-column p-4 text-white">
      <nav class="nav flex-column gap-2">
        <a class="nav-link" href="telalogin.html">Início</a>
        <a class="nav-link" href="telalogin.html">Projeto</a>
        <a class="nav-link" href="telalogin.html">Conscientização</a>
        <a class="nav-link" href="telalogin.html">Mapa Pin</a>
        <a class="nav-link" href="telalogin.html">Publicação</a>
        <a class="nav-link" href="sobre.html">Sobre nós</a>
      </nav>
      
      <div class="mt-auto">
        <div class="small mt-2">© 2025 Ecotech</div>
      </div>
    </aside>

    <!-- CONTEÚDO -->
    <main class="flex-grow-1 d-flex flex-column">

      <!-- Topbar (mobile) -->
      <div class="d-md-none d-flex justify-content-between align-items-center p-3 bg-hero">
        <button class="btn btn-menu-mobile" data-bs-toggle="collapse" data-bs-target="#menuMobile">Menu</button>
   
      </div>

      <!-- Menu Mobile -->
      <div id="menuMobile" class="collapse d-md-none mb-3 px-3">
        <div class="card card-body">
          <a class="text-decoration-none mb-2" href="telalogin.html">Início</a>
          <a class="text-decoration-none mb-2" href="telalogin.html">Projeto</a>
          <a class="text-decoration-none mb-2" href="telalogin.html">Conscientização</a>
          <hr>
          <a class="text-decoration-none mb-2" href="telalogin.html">Login</a>
          <a class="text-decoration-none mb-2" href="sobre.html">Sobre nós</a>
        </div>
      </div>

      <!-- Hero Section -->
      <section class="hero text-center text-md-start d-flex align-items-center px-4 py-5">
        <div class="container">
          <div class="row align-items-center g-4">
            <div class="col-md-4">
              <img src="image/logo mao.png" alt="EcotechRoots" class="img-fluid rounded">
            </div>
            <div class="col-md-8">
              <h1 class="emblema">EcotechRoots: Esperança que inspira, inovação que transforma
              </h1><hr>
      
              
              <h3 class="sub">Veja como você pode fazer a diferença!</h3>
            </div>
          </div>
        </div>
      </section>

      <!-- Painel de Cards -->
  <section class="panel container-fluid px-4 py-5">
  <div class="row g-4">
    <div class="col-md-4">
      <a href="telalogin.html" class="card feature-card h-100 shadow-sm text-decoration-none text-dark">
        <div class="feature-thumb ratio ratio-16x9 rounded-top">
          <img src="image/img pinheiro.jpg" alt="Nosso Projeto" class="img-fluid rounded-top">
        </div>
        <div class="card-body">
          <h5 class="card-title">Nosso Projeto</h5>
          <p class="card-text">Conheça nossa missão e os resultados alcançados.</p>
        </div>
      </a>
    </div>

    <div class="col-md-4">
      <a href="telalogin.html" class="card feature-card h-100 shadow-sm text-decoration-none text-dark">
        <div class="feature-thumb ratio ratio-16x9 rounded-top">
          <img src="image/img desmatamento.jpg" alt="Impacto do Desmatamento" class="img-fluid rounded-top">
        </div>
        <div class="card-body">
          <h5 class="card-title">Impacto do Desmatamento</h5>
          <p class="card-text">Dados e visualizações para entender o problema.</p>
        </div>
      </a>
    </div>

    <div class="col-md-4">
      <a href="telalogin.html" class="card feature-card h-100 shadow-sm text-decoration-none text-dark">
        <div class="feature-thumb ratio ratio-16x9 rounded-top">
          <img src="image/card plantação.jpg" alt="Como Você Pode Ajudar" class="img-fluid rounded-top">
        </div>
        <div class="card-body">
          <h5 class="card-title">Como Você Pode Ajudar</h5>
          <p class="card-text">Ações simples que geram impacto real.</p>
        </div>
      </a>
    </div>
  </div>
</section>


    </main>
  </div>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
