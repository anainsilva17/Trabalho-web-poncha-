<?php
session_start();
include 'includes/db.php';

/* 🔐 Proteção */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

/* iniciar Favoritos */
if (!isset($_SESSION['Favoritos'])) {
    $_SESSION['Favoritos'] = [];
}

/* remover item */
if (isset($_GET['remover'])) {

    $index = (int) $_GET['remover'];

    if (isset($_SESSION['Favoritos'][$index])) {

        unset($_SESSION['Favoritos'][$index]);

        $_SESSION['Favoritos'] =
            array_values($_SESSION['Favoritos']);
    }

    header("Location: Favoritos.php");
    exit;
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Favoritos | Poncha-te Aqui</title>

    <link rel="stylesheet" href="style.css?v=30">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<?php include 'includes/header.php'; ?>

<main class="container py-5"
      style="margin-top:120px; min-height:80vh;">

    <div class="text-center mb-5">

        <h1 class="fw-bold">
            ❤️‍🔥 Favoritos
        </h1>

        <p class="text-muted">
            Reveja e edite as suas reservas antes de confirmar.
        </p>

    </div>

    <?php if (!empty($_SESSION['Favoritos'])): ?>

        <div class="row g-4">

            <?php foreach ($_SESSION['Favoritos'] as $index => $item): ?>

                <?php
                $preco = $item['preco_total'] ?? 0;
                $total += $preco;
                
                /* imagem fallback */
                $imagem = !empty($item['imagem'])
                    ? $item['imagem']
                    : 'sem-imagem.jpg';

                /* datas válidas */
             $data_inicio = $_SESSION['data_inicio']
            ?? $item['data_inicio']
            ?? date('Y-m-d');

            $data_fim = $_SESSION['data_fim']
            ?? $item['data_fim']
            ?? date('Y-m-d', strtotime('+1 day'));
            
        ?>

     <div class="col-12">

    <div class="card shadow-sm rounded-4 overflow-hidden">

        <div class="row g-0 align-items-center">

            <!-- IMAGEM -->
            <div class="col-md-3 d-flex align-items-center justify-content-center">

                <img
                    src="img/<?= htmlspecialchars($imagem); ?>"
                    alt="<?= htmlspecialchars($item['nome'] ?? 'Alojamento'); ?>"
                    class="img-fluid rounded-start p-3"
                    style="
                        width:100%;
                        max-height:380px;
                        object-fit:contain;
                    "
                >

            </div>

            <!-- INFORMAÇÕES -->
            <div class="col-md-9">

                <div class="card-body p-4">
                            <h3 class="fw-bold">
                                <?= htmlspecialchars($item['nome'] ?? 'Alojamento'); ?>
                            </h3>

                            <p class="text-muted mb-3">
                                📍 <?= htmlspecialchars($item['localizacao'] ?? 'Madeira'); ?>
                            </p>

                            <hr>

                            <!-- FORM EDITAR -->
                            <form method="POST"
                                  action="atualizar_Favoritos.php">

                                <input type="hidden"
                                       name="index"
                                       value="<?= $index; ?>">

                                <div class="row">

                                    <div class="col-6 mb-3">

                                        <label class="fw-bold">
                                            📅 Check-in
                                        </label>

<input
    type="date"
    class="checkin form-control"
    name="data_inicio"
    value="<?= $data_inicio; ?>"
    min="<?= date('Y-m-d'); ?>"
    required
>
                                    </div>

                                    <div class="col-6 mb-3">

                                        <label class="fw-bold">
                                            📅 Check-out
                                        </label>

<input
    type="date"
    class="checkout form-control"
    name="data_fim"
    value="<?= $data_fim; ?>"
    min="<?= date('Y-m-d', strtotime('+1 day')); ?>"
    required
>
                                    </div>

                                    <div class="col-6 mb-3">

                                        <label class="fw-bold">
                                            👨 Adultos
                                        </label>

                                        <input
                                            type="number"
                                            name="adultos"
                                            class="form-control"
                                            value="<?= $item['adultos'] ?? 1; ?>"
                                            min="1"
                                            required
                                        >
                                    </div>

                                    <div class="col-6 mb-3">

                                        <label class="fw-bold">
                                            🧒 Crianças
                                        </label>

                                        <input
                                            type="number"
                                            name="criancas"
                                            class="form-control"
                                            value="<?= $item['criancas'] ?? 0; ?>"
                                            min="0"
                                        >
                                    </div>

                                </div>

                               <div class="d-flex gap-3 mb-3">

    <button
        type="submit"
        class="btn btn-primary rounded-pill fw-bold px-4">

        Atualizar Reserva 🔄

    </button>

    <a
        href="confirmar_Favoritos.php?index=<?= $index; ?>"
        class="btn btn-warning rounded-pill fw-bold px-4">

        Reservar Agora

    </a>

</div>

</form>

<hr>

<div class="d-flex justify-content-between align-items-center">

    <div>

        <h3 class="fw-bold text-success mb-1">
            €<?= number_format($preco, 2, ',', '.'); ?>
        </h3>

        <?php

        $inicio = new DateTime($data_inicio);
        $fim = new DateTime($data_fim);

        $noites = $inicio->diff($fim)->days;

        if ($noites < 1) {
            $noites = 1;
        }

        $total_pessoas =
            $item['adultos']
            + $item['criancas'];

        $pontos_totais =
            $item['pontos']
            * $noites
            * $total_pessoas;

        ?>

        <p class="text-warning fw-bold mb-0">
            ⭐ <?= $pontos_totais; ?> pontos
        </p>

    </div>

    <a
        href="Favoritos.php?remover=<?= $index; ?>"
        class="btn btn-outline-danger rounded-pill px-4 fw-bold">

        Remover

    </a>

</div>
    
</div>

</div>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

<?php else: ?>

<div class="text-center bg-light rounded-4 shadow-sm p-5">

    <h2>
        Ainda não tem favoritos 🥲
    </h2>

    <p class="text-muted mt-3">
        Adicione alojamentos aos Favoritos.
    </p>

    <a href="resultados.php"
       class="btn btn-warning rounded-4 px-4 fw-bold">

        Ver Alojamentos

    </a>

</div>

<?php endif; ?>

</main>

<?php include 'includes/footer.php'; ?>

<script>

document.querySelectorAll('.checkin').forEach(function(checkin){

    const form = checkin.closest('form');
    const checkout = form.querySelector('.checkout');

    /* definir mínimo ao abrir a página */
    let data = new Date(checkin.value);
    data.setDate(data.getDate() + 1);

    let ano = data.getFullYear();
    let mes = String(data.getMonth() + 1).padStart(2,'0');
    let dia = String(data.getDate()).padStart(2,'0');

    let minimo = `${ano}-${mes}-${dia}`;

    checkout.min = minimo;

    /* se o check-out for inválido, corrige */
    if (!checkout.value || checkout.value <= checkin.value) {
        checkout.value = minimo;
    }

    /* quando mudar o check-in */
    checkin.addEventListener('change', function(){

        let data = new Date(this.value);
        data.setDate(data.getDate() + 1);

        let ano = data.getFullYear();
        let mes = String(data.getMonth() + 1).padStart(2,'0');
        let dia = String(data.getDate()).padStart(2,'0');

        let minimo = `${ano}-${mes}-${dia}`;

        checkout.min = minimo;

        if (checkout.value <= this.value) {
            checkout.value = minimo;
        }

    });

});

</script>
</body>
</html>