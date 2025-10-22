<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EcotechRoots</title>
  <link rel="shortcut icon" href="favicon.com/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/telacadastro.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
  <!-- Header -->
  <header class="d-flex align-items-center gap-2 p-3" style="background-color:#234d37;">
    <a href="telainicial.php" class="d-flex align-items-center gap-2">
      <img src="image/logo ecotech.png" alt="Logo EcotechRoots" width="80" height="80">
    </a>
    <a href="telainicial.php"><span class="fw-bold text-white fs-4">EcotechRoots</span></a>
  </header>

  <!-- Main Content -->
  <main class="d-flex justify-content-center align-items-center" style="min-height:80vh;">
    <div class="form-container p-4 shadow rounded-4" style="background:#f3fbe9; max-width:400px; width:100%;">
      <h2 class="text-center mb-3">Bem-vindo(a) de volta!</h2>
      <p class="text-center mb-4">Faça login para continuar.</p>

      <form id="formLogin" action="php/login.php" method="post">

<!-- Email -->
<div class="mb-3 input-group">
  <span class="input-group-text"><i class="bi bi-envelope"></i></span>
  <input type="email" class="form-control" name="email" placeholder="Email" required>
</div>

<!-- Senha -->
<div class="mb-2 input-group">
  <span class="input-group-text"><i class="bi bi-lock"></i></span>
  <input type="password" class="form-control" name="senha" placeholder="Senha" required>
</div>

<!-- Botão de login -->
<button type="submit" class="btn btn-success w-100 rounded-3 mb-3">Autenticar-se</button>

</form>


        <!-- Cadastro -->
        <div class="text-center mb-2"> 
          <span>Não possui uma conta? <a href="telacadastro.php">Cadastre-se</a></span>
        </div> 

   <br>
          <div class="text-center mb-1"> 
       <a href="esqueci.html">Esqueci minha senha </a></span>
        </div>

  
<hr>

        <!-- Voltar ao início -->
        <div class="text-center">
          <span><a href="telainicial.php">Voltar ao Início</a></span>
        </div>
      </form>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
