<?php
session_start();
include 'includes/db.php';

/* 🔐 Proteção */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* cancelar reserva */
if (isset($_GET['cancelar'])) {

    $id_reserva = (int) $_GET['cancelar'];

    $sql = "DELETE FROM reservas
            WHERE id = ?
            AND user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ii",
        $id_reserva,
        $user_id
    );

    $stmt->execute();

    header("Location: minhas_reservas.php");
    exit;
}

/* Buscar reservas */
$sql = "SELECT
            reservas.*,
            alojamentos.nome,
            alojamentos.localizacao,
            alojamentos.imagem,
            alojamentos.preco_noite
        FROM reservas
        INNER JOIN alojamentos
        ON reservas.alojamento_id = alojamentos.id
        WHERE reservas.user_id = ?
        ORDER BY reservas.data_reserva DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>As Minhas Reservas</title>

    <link rel="stylesheet" href="style.css?v=30">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="shortcut icon"
          href="img/logos.png">
</head>

<body>

<?php include 'includes/header.php'; ?>

<main class="container py-5"
      style="margin-top:120px; min-height:80vh;">

    <div class="text-center mb-5">

        <h1 class="fw-bold">
            🏠 As Minhas Reservas
        </h1>

        <p class="text-muted">
            Veja todas as suas reservas realizadas.
        </p>

    </div>

    <?php if ($result->num_rows > 0): ?>

        <div class="row g-4">

            <?php while ($reserva = $result->fetch_assoc()): ?>

                <?php
                $inicio = new DateTime($reserva['data_inicio']);
                $fim = new DateTime($reserva['data_fim']);

                $noites =
                    $inicio->diff($fim)->days;

                if ($noites < 1) {
                    $noites = 1;
                }

                $total =
                    $noites *
                    $reserva['preco_noite'];
                ?>

                <div class="col-lg-11 mx-auto">

    <div class="card shadow-sm rounded-4 border-0 overflow-hidden">

        <div class="row g-0 align-items-center">

            <!-- IMAGEM -->
            <div class="col-md-3">

                <img
                    src="img/<?= htmlspecialchars($reserva['imagem']); ?>"
                    alt="<?= htmlspecialchars($reserva['nome']); ?>"
                    class="img-fluid w-100 h-100"
                    style="
                        height:250px;
                        object-fit:cover;
                    "
                >

            </div>

            <!-- INFORMAÇÕES -->
            <div class="col-md-9">

                <div class="card-body p-4">

                    <!-- Nome -->
                    <div class="d-flex justify-content-between">

                        <div>

                            <h2 class="fw-bold mb-1">
                                <?= htmlspecialchars($reserva['nome']); ?>
                            </h2>

                            <p class="text-muted mb-0">
                                📍 <?= htmlspecialchars($reserva['localizacao']); ?>
                            </p>

                        </div>

                        <span class="badge bg-success fs-6 h-100">
                            Confirmada
                        </span>

                    </div>

                    <hr>

                    <!-- Dados -->
                    <div class="row text-center">

                        <div class="col-md-3 mb-3">
                            <strong>📅 Check-in</strong><br>
                            <?= date('d/m/Y', strtotime($reserva['data_inicio'])); ?>
                        </div>

                        <div class="col-md-3 mb-3">
                            <strong>📅 Check-out</strong><br>
                            <?= date('d/m/Y', strtotime($reserva['data_fim'])); ?>
                        </div>

                        <div class="col-md-2 mb-3">
                            <strong>👨 Adultos</strong><br>
                            <?= $reserva['adultos']; ?>
                        </div>

                        <div class="col-md-2 mb-3">
                            <strong>🧒 Crianças</strong><br>
                            <?= $reserva['criancas']; ?>
                        </div>

                        <div class="col-md-1 mb-3">
                            <strong>🌙</strong><br>
                            <?= $noites; ?>
                        </div>

                        <div class="col-md-1 mb-3">
                            <strong>⭐</strong><br>
                            <?= $reserva['pontos']; ?>
                        </div>

                    </div>

                    <hr>

                    <!-- Rodapé -->
                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted">
                                Reservado em
                            </small>

                            <br>

                            <strong>
                                <?= date('d/m/Y', strtotime($reserva['data_reserva'])); ?>
                            </strong>

                        </div>

                        <div class="text-end">

                            <small class="text-muted">
                                Total Pago
                            </small>

                            <h2 class="fw-bold text-success mb-0">
                                €<?= number_format($total, 2, ',', '.'); ?>
                            </h2>

                        </div>

                    </div>

                    <a
<a
    href="#"
    class="btn btn-danger rounded-pill mt-4 px-5"
    data-bs-toggle="modal"
    data-bs-target="#cancelarModal<?= $reserva['id']; ?>">

    Cancelar Reserva

</a> 

                    </a>
<!-- Modal Cancelar -->
<div class="modal fade"
     id="cancelarModal<?= $reserva['id']; ?>"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content rounded-4 border-0 shadow">

            <div class="modal-header">

                <h5 class="modal-title">
                    Cancelar Reserva
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                Tem a certeza que deseja cancelar esta reserva?

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary rounded-pill"
                    data-bs-dismiss="modal">

                    Voltar

                </button>

                <a
                    href="minhas_reservas.php?cancelar=<?= $reserva['id']; ?>"
                    class="btn btn-danger rounded-pill">

                    Sim

                </a>

            </div>

        </div>

    </div>

</div>
                </div>

            </div>

        </div>

    </div>

            </div>

            <?php endwhile; ?>

        </div>

    <?php else: ?>

        <div class="text-center bg-light p-5 rounded-4 shadow-sm">

            <h3 class="mb-3">
                Ainda não tem reservas 😢
            </h3>

            <p class="text-muted mb-4">
                Explore os alojamentos e faça a sua primeira reserva.
            </p>

            <a href="resultados.php"
               class="btn btn-warning btn-lg rounded-4 px-4">

                Ver Alojamentos

            </a>

        </div>

    <?php endif; ?>

</main>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>