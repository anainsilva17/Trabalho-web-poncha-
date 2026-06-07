<?php
session_start();
include 'includes/db.php';

/* 🔐 Proteção */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

/* validar POST */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

/* 📥 Dados */
$alojamento_id = (int) $_POST['alojamento_id'];
$adultos = (int) $_POST['adultos'];
$criancas = (int) $_POST['criancas'];
$data_inicio = $_POST['data_inicio'];
$data_fim = $_POST['data_fim'];

/* 🏠 Buscar alojamento */
$sql = "SELECT * FROM alojamentos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $alojamento_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Alojamento inválido.");
}

$alojamento = $result->fetch_assoc();

/* 💰 Calcular preço */
$inicio = new DateTime($data_inicio);
$fim = new DateTime($data_fim);

$noites = $inicio->diff($fim)->days;

if ($noites < 1) {
    $noites = 1;
}

$preco_total =
    $noites * $alojamento['preco_noite'];

$total_pessoas =
    $adultos + $criancas;

$pontos =
    $alojamento['pontos_por_estadia']
    * $noites
    * $total_pessoas;

/* ==================================
   CONFIRMAR RESERVA DIRETA
================================== */

if (isset($_POST['confirmar'])) {

    $user_id = $_SESSION['user_id'];
    $email = $_SESSION['user_email'];

    /* guardar reserva */
    $sql = "INSERT INTO reservas
    (
        alojamento_id,
        email,
        user_id,
        data_inicio,
        data_fim,
        pontos,
        adultos,
        criancas
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "isissiii",
        $alojamento_id,
        $email,
        $user_id,
        $data_inicio,
        $data_fim,
        $pontos,
        $adultos,
        $criancas
    );

    $stmt->execute();

    /* atualizar pontos */
    $sql = "UPDATE utilizadores
            SET pontos = pontos + ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ii",
        $pontos,
        $user_id
    );

    $stmt->execute();

    /* atualizar sessão */
    $_SESSION['user_pontos'] += $pontos;

    /* resumo temporário */
    $_SESSION['ultima_reserva'] = [
        'nome' => $alojamento['nome'],
        'localizacao' => $alojamento['localizacao'],
        'data_inicio' => $data_inicio,
        'data_fim' => $data_fim,
        'adultos' => $adultos,
        'criancas' => $criancas,
        'preco_total' => $preco_total,
        'pontos' => $pontos
    ];

    header("Location: sucesso_Favoritos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">

    <title>
        Confirmar Reserva
    </title>

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="style.css?v=30">
</head>

<body>

<?php include 'includes/header.php'; ?>

<main class="container py-5"
      style="margin-top:140px; min-height:80vh;">

    <!-- TÍTULO -->
    <div class="text-center mb-5">

        <h1 class="fw-bold">
            Confirmar Reserva
        </h1>

        <p class="text-muted">
            Reveja os detalhes antes de confirmar.
        </p>

    </div>

    <!-- CARD -->
    <div class="card border-0 shadow-sm rounded-4 mx-auto"
         style="max-width:750px;">

        <div class="card-body p-5">

            <h2 class="fw-bold mb-2">
                <?= htmlspecialchars($alojamento['nome']); ?>
            </h2>

            <p class="text-muted fs-5">
                📍 <?= htmlspecialchars($alojamento['localizacao']); ?>
            </p>

            <hr class="my-4">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <strong>
                        📅 Check-in:
                    </strong><br>

                    <?= htmlspecialchars($data_inicio); ?>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>
                        📅 Check-out:
                    </strong><br>

                    <?= htmlspecialchars($data_fim); ?>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>
                        👨 Adultos:
                    </strong><br>

                    <?= $adultos; ?>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>
                        🧒 Crianças:
                    </strong><br>

                    <?= $criancas; ?>

                </div>

            </div>

            <hr class="my-4">

            <h2 class="text-success fw-bold">

                Total:
                €<?= number_format(
                    $preco_total,
                    2,
                    ',',
                    '.'
                ); ?>

            </h2>

            <p class="text-warning fw-bold fs-5">

    ⭐ <?= $pontos; ?>
    pontos ganhos nesta reserva

</p>



            <form method="POST"
                  action="reservas.php"
                  class="mt-4">

                <input type="hidden"
                       name="alojamento_id"
                       value="<?= $alojamento_id; ?>">

                <input type="hidden"
                       name="adultos"
                       value="<?= $adultos; ?>">

                <input type="hidden"
                       name="criancas"
                       value="<?= $criancas; ?>">

                <input type="hidden"
                       name="data_inicio"
                       value="<?= $data_inicio; ?>">

                <input type="hidden"
                       name="data_fim"
                       value="<?= $data_fim; ?>">

                <button
                    type="submit"
                    name="confirmar"
                    class="btn btn-primary btn-lg w-100 rounded-4 fw-bold">

                    Confirmar Reserva!

                </button>

            </form>

        </div>

    </div>

</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>