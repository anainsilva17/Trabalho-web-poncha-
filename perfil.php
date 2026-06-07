<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>O Meu Perfil</title>

    <link rel="stylesheet"
          href="style.css?v=20">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="perfil-page">

<?php include 'includes/header.php'; ?>

<main class="container py-5"
      style="
      margin-top:120px;
      min-height:80vh;
      background:#e3ebf5;
      border-radius:40px;
      ">

    <!-- TÍTULO -->
    <div class="text-center mb-5">

        <h1 class="fw-bold">
            O Meu Perfil
        </h1>

        <p class="text-muted">
            Gerir conta e preferências
        </p>

    </div>


    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-5">

                    <!-- DADOS -->
                    <div class="text-center mb-5">

                        <div style="font-size:90px;">
                            👤
                        </div>

                        <h2 class="fw-bold mt-3">

                            <?= $_SESSION['user_nome']; ?>

                        </h2>

                        <p class="text-muted">

                            <?= $_SESSION['user_email']; ?>

                        </p>

                        <h4 class="text-warning fw-bold">

                            ⭐ <?= $_SESSION['user_pontos']; ?>
                            pontos

                        </h4>
                        <div class="programa-pontos mt-4">
    <h5 class="fw-bold mb-3">
    Programa de Pontos
</h5>

<p class="text-muted mb-4">
    Acumule pontos em cada reserva e desfrute de futuras vantagens exclusivas.
</p>

<div class="pontos-item">
    Cada alojamento possui uma quantidade de pontos diferente.
</div>

<div class="pontos-item">
    Quanto mais noites permanecer, mais pontos ganha.
</div>

<div class="pontos-item">
    Quanto mais hóspedes incluídos na reserva, mais pontos acumula.
</div>

<div class="pontos-item">
    Os pontos poderão ser utilizados para obter recompensas e descontos especiais.
</div>

</div>

                    </div>


                    <!-- BOTÕES -->
<div class="d-grid gap-3">

    <a href="minhas_reservas.php"
       class="btn btn-lg rounded-4 border-0 shadow-sm"
       style="background:#10264f; color:white;">

        🏠 As Minhas Reservas

    </a>

    <a href="favoritos.php"
       class="btn btn-lg rounded-4 border-0 shadow-sm"
       style="background:#10264f; color:white;">

        ❤️ Os Meus Favoritos

    </a>
<a href="recompensas.php"
   class="btn btn-lg rounded-4 border-0 shadow-sm"
       style="background:#10264f; color:white;">

    🎁 Ver Recompensas

</a>
    <a href="editar_perfil.php"
       class="btn btn-lg rounded-4 border-0 shadow-sm"
       style="background:#10264f; color:white;">

        ✏️ Editar Dados

    </a>

    <a href="logout.php"
       class="btn btn-lg rounded-4 border-0 shadow-sm"
       style="background:#10264f; color:white;">

        🚪 Sair da Conta

    </a>

</div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>