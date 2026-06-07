<?php
session_start();
include 'includes/db.php';

/* login obrigatório */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

/* validar */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: resultados.php");
    exit;
}

$alojamento_id = (int) $_POST['alojamento_id'];

/* buscar alojamento */
$sql = "SELECT * FROM alojamentos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $alojamento_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Alojamento inválido.");
}

$alojamento = $result->fetch_assoc();

/* criar Favoritos */
if (!isset($_SESSION['Favoritos'])) {
    $_SESSION['Favoritos'] = [];
}

/* evitar duplicados */
foreach ($_SESSION['Favoritos'] as $item) {
    if ($item['alojamento_id'] == $alojamento_id) {
        header("Location: Favoritos.php");
        exit;
    }
}

/* adicionar ao Favoritos */
$_SESSION['Favoritos'][] = [

    'alojamento_id' => $alojamento['id'],
    'nome' => $alojamento['nome'],
    'localizacao' => $alojamento['localizacao'],

    /* ESTA LINHA FALTAVA */
    'imagem' => $alojamento['imagem'],

    'data_inicio' => date('Y-m-d'),
    'data_fim' => date('Y-m-d', strtotime('+1 day')),

    'adultos' => 1,
    'criancas' => 0,

    'preco_total' => $alojamento['preco_noite'],
    'preco_noite' => $alojamento['preco_noite'],
    'pontos' => $alojamento['pontos_por_estadia']
];

/* ir para Favoritos */
header("Location: Favoritos.php");
exit;
?>