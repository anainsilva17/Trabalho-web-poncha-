<?php
session_start();

if (!isset($_SESSION['ultima_reserva'])) {
    header("Location: index.php");
    exit;
}

$reserva = $_SESSION['ultima_reserva'];
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <title>Reserva Confirmada | Poncha-te Aqui</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="style.css?v=6">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include 'includes/header.php'; ?>

<main class="container py-5" style="margin-top:120px; min-height:80vh;">

    <div class="card shadow-lg border-0 mx-auto text-center p-5"
         style="max-width:850px; border-radius:35px;">

        <div style="font-size:80px;">
            🎉
        </div>

        <h1 class="fw-bold mb-3">
            Reserva Confirmada!
        </h1>

        <p class="text-muted fs-5 mb-4">
            Obrigado pela sua reserva,
            <strong><?= htmlspecialchars($_SESSION['user_nome']); ?></strong>.
        </p>

        <div class="card bg-light border-0 p-4 text-start">

            <h3 class="fw-bold mb-3">
                <?= htmlspecialchars($reserva['nome']); ?>
            </h3>

            <p class="text-muted mb-4">
                <?= htmlspecialchars($reserva['localizacao']); ?>
            </p>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <strong>📅 Check-in</strong><br>
                    <?= htmlspecialchars($reserva['data_inicio']); ?>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>📅 Check-out</strong><br>
                    <?= htmlspecialchars($reserva['data_fim']); ?>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>👨 Adultos</strong><br>
                    <?= $reserva['adultos']; ?>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>🧒 Crianças</strong><br>
                    <?= $reserva['criancas']; ?>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>💰 Total</strong><br>
                    €<?= number_format($reserva['preco_total'], 2, ',', '.'); ?>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>⭐ Pontos ganhos</strong><br>
                    <?= $reserva['pontos']; ?> pontos
                </div>

            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center gap-3 flex-wrap">

            <a href="minhas_reservas.php"
               class="btn btn-warning btn-lg px-4">
                Ver Minhas Reservas
            </a>

            <a href="index.php"
               class="btn btn-dark btn-lg px-4">
                Voltar ao Início
            </a>

        </div>

    </div>

</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>