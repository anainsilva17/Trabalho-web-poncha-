
<?php
session_start();
include 'includes/db.php';

/* dados da pesquisa */
$localizacao =
    $_GET['localizacao'] ?? 'tudo';

$data_inicio =
    $_GET['data_inicio'] ?? '';

$data_fim =
    $_GET['data_fim'] ?? '';

$adultos =
    (int) ($_GET['adultos'] ?? 1);

$criancas =
    (int) ($_GET['criancas'] ?? 0);
    /* guardar pesquisa na sessão */
$_SESSION['data_inicio'] = $data_inicio;
$_SESSION['data_fim'] = $data_fim;
$_SESSION['adultos'] = $adultos;
$_SESSION['criancas'] = $criancas;

$total_pessoas =
    $adultos + $criancas;

/* pesquisa */
$sql =
    "SELECT * FROM alojamentos
     WHERE capacidade >= ?";

$params = [$total_pessoas];
$types = "i";

/* filtrar localização */
/* "tudo" mostra todos */
if (
    !empty($localizacao)
    && $localizacao !== 'tudo'
) {

    $sql .=
        " AND localizacao LIKE ?";

    $localizacao_search =
        "%" . $localizacao . "%";

    $params[] =
        $localizacao_search;

    $types .= "s";
}

/* ordenar */
$sql .=
    " ORDER BY preco_noite ASC";

$stmt =
    $conn->prepare($sql);

$stmt->bind_param(
    $types,
    ...$params
);

$stmt->execute();

$result =
    $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Resultados | Poncha-te Aqui
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="style.css?v=17">

    <link rel="shortcut icon"
          href="img/logos.png">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<?php include 'includes/header.php'; ?>

<main class="container py-5"
      style="margin-top:120px; min-height:80vh;">

    <div class="text-center mb-5">

        <h1 class="fw-bold">
            🏠 Resultados da Pesquisa
        </h1>

        <p class="text-muted">

            <?php if (
                !empty($localizacao)
                && $localizacao !== 'tudo'
            ): ?>

                Alojamentos em
                <strong>
                    <?= htmlspecialchars($localizacao); ?>
                </strong>

            <?php else: ?>

                Explore todos os alojamentos disponíveis na Madeira.

            <?php endif; ?>

        </p>

    </div>

    <?php if ($result->num_rows > 0): ?>

        <div class="row g-4">

            <?php while ($row = $result->fetch_assoc()): ?>

                <div class="col-lg-6">

                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">

                        <!-- IMAGEM -->
                        <img
                            src="img/<?= htmlspecialchars($row['imagem']); ?>"
                            alt="<?= htmlspecialchars($row['nome']); ?>"
                            style="height:260px; object-fit:cover;"
                        >

                        <div class="card-body p-4">

                            <h3 class="fw-bold mb-2">
                                <?= htmlspecialchars($row['nome']); ?>
                            </h3>

                            <p class="text-muted mb-3">
                                📍 <?= htmlspecialchars($row['localizacao']); ?>
                            </p>

                            <p class="small text-muted">
                                <?= htmlspecialchars($row['descricao']); ?>
                            </p>

                            <hr>

                            <p class="mb-2">
                                <strong>
                                    Capacidade:
                                </strong>

                                <?= $row['capacidade']; ?>
                                pessoas
                            </p>

                            <h5 class="fw-bold text-success">

                                €<?= number_format(
                                    $row['preco_noite'],
                                    2,
                                    ',',
                                    '.'
                                ); ?>

                                <span class="fs-6 text-muted">
                                    / noite
                                </span>

                            </h5>

                            <p class="text-warning fw-bold mb-3">

                                ⭐
                                <?= $row['pontos_por_estadia']; ?>
                                pontos por estadia

                            </p>

                            <!-- BOTÕES -->
                            <div class="d-flex gap-2 mt-4">

                                <!-- RESERVAR -->
                                <a
    href="alojamentos.php?id=<?= $row['id']; ?>&data_inicio=<?= urlencode($data_inicio); ?>&data_fim=<?= urlencode($data_fim); ?>&adultos=<?= $adultos; ?>&criancas=<?= $criancas; ?>"
    class="btn btn-primary flex-fill fw-bold rounded-3">

    Reservar 

</a>

                                <!-- Favoritos -->
                                <form method="POST"
                                      action="adicionar_Favoritos.php"
                                      class="flex-fill">

                                    <input
                                        type="hidden"
                                        name="alojamento_id"
                                        value="<?= $row['id']; ?>">

                                    <button
                                        type="submit"
                                        class="btn btn-warning w-100 fw-bold rounded-3">

                                        Favoritos 

                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

        </div>

    <?php else: ?>

        <div class="text-center bg-light p-5 rounded-4 shadow-sm">

            <h3 class="mb-3">
                Nenhum alojamento encontrado 😢
            </h3>

            <p class="text-muted">
                Experimente outra localização
                ou menos pessoas.
            </p>

            <a href="index.php"
               class="btn btn-warning rounded-4 px-4">

                Nova Pesquisa

            </a>

        </div>

    <?php endif; ?>

</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>