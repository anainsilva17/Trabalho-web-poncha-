<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['Favoritos']) || empty($_SESSION['Favoritos'])) {
    header("Location: Favoritos.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$email = $_SESSION['user_email'];

$index = $_GET['index'] ?? 0;

if (!isset($_SESSION['Favoritos'][$index])) {
    header("Location: Favoritos.php");
    exit;
}

$item = $_SESSION['Favoritos'][$index];

/* Dados da reserva */
$alojamento_id = $item['alojamento_id'] ?? 0;

$nome = $item['nome'] ?? 'Alojamento';
$localizacao = $item['localizacao'] ?? 'Madeira';

$data_inicio = $item['data_inicio'] ?? date('Y-m-d');
$data_fim = $item['data_fim'] ?? date('Y-m-d', strtotime('+1 day'));

$adultos = $item['adultos'] ?? 1;
$criancas = $item['criancas'] ?? 0;

$preco = $item['preco_total'] ?? 0;
$pontos_base = $item['pontos'] ?? 0;

/* calcular pontos */
$inicio = new DateTime($data_inicio);
$fim = new DateTime($data_fim);

$noites = $inicio->diff($fim)->days;

if ($noites < 1) {
    $noites = 1;
}

$total_pessoas = $adultos + $criancas;

$pontos = $pontos_base * $noites * $total_pessoas;

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

/* atualizar pontos do utilizador */
$sql = "UPDATE utilizadores
        SET pontos = pontos + ?
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $pontos, $user_id);
$stmt->execute();

$_SESSION['user_pontos'] += $pontos;

/* guardar dados para reserva_confirmada.php */
$_SESSION['ultima_reserva'] = [

    'nome' => $nome,
    'localizacao' => $localizacao,

    'data_inicio' => $data_inicio,
    'data_fim' => $data_fim,

    'adultos' => $adultos,
    'criancas' => $criancas,

    'preco_total' => $preco,

    'pontos' => $pontos,

    'total_reservas' => 1,
    'total_pontos' => $pontos,
    'total_preco' => $preco
];

/* remover dos favoritos */
unset($_SESSION['Favoritos'][$index]);
$_SESSION['Favoritos'] = array_values($_SESSION['Favoritos']);

header("Location: reserva_confirmada.php");
exit;
?>