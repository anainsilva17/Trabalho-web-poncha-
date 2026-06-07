<?php
session_start();

if (!isset($_SESSION['ultima_reserva'])) {
    header("Location: index.php");
    exit;
}

$reserva = $_SESSION['ultima_reserva'];

/* valores compatíveis */
$total_reservas = $reserva['total_reservas'] ?? 1;

$total_pontos =
    $reserva['total_pontos']
    ?? $reserva['pontos']
    ?? 0;

$total_preco =
    $reserva['total_preco']
    ?? $reserva['preco_total']
    ?? 0;
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Reserva Confirmada</title>

    <link rel="stylesheet"
          href="style.css?v=30">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<?php include 'includes/header.php'; ?>

<main class="container py-5"
      style="margin-top:120px; min-height:80vh;">

    <div class="card border-0 shadow-lg rounded-5 p-5 text-center mx-auto"
         style="max-width:900px;">

        <div style="font-size:80px;">
            🎉
        </div>

        <h1 class="fw-bold mb-3">
            Reserva Confirmada!
        </h1>

        <p class="fs-4 text-muted">
            Obrigado pela sua reserva,
            <strong>
                <?= htmlspecialchars($_SESSION['user_nome']); ?>
            </strong>
        </p>

        <div class="bg-light rounded-5 p-5 mt-4">

            <h3 class="fw-bold mb-4">
                Resumo da Reserva
            </h3>

            <div class="row text-start">

                <div class="col-md-4 mb-3">

                    <strong>🏠 Reservas</strong><br>

                    <?= $total_reservas; ?>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>⭐ Pontos ganhos</strong><br>

                    <?= $total_pontos; ?>

                </div>

                <div class="col-md-4 mb-3">

                    <strong>💰 Total pago</strong><br>

                    €<?= number_format(
                        $total_preco,
                        2,
                        ',',
                        '.'
                    ); ?>

                </div>

            </div>

        </div>

        <div class="d-flex justify-content-center gap-3 mt-5">

            <a href="minhas_reservas.php"
               class="btn btn-warning btn-lg rounded-4 px-4">

                Ver Minhas Reservas

            </a>

            <a href="index.php"
               class="btn btn-dark btn-lg rounded-4 px-4">

                Voltar ao Início

            </a>

        </div>

    </div>

</main>

<?php unset($_SESSION['ultima_reserva']); ?>

<?php include 'includes/footer.php'; ?>

</body>
</html>