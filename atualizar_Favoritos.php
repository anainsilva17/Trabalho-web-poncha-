<?php
session_start();

include 'includes/db.php';

$data_inicio = $_POST['data_inicio'];
$data_fim = $_POST['data_fim'];

$hoje = date('Y-m-d');

/* impedir datas passadas */
if ($data_inicio < $hoje) {
    die("O check-in não pode ser anterior a hoje.");
}

/* impedir mesmo dia ou anterior */
if ($data_fim <= $data_inicio) {
    die("O check-out tem de ser pelo menos um dia depois do check-in.");
}

/* verificar login */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

/* validar POST */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: Favoritos.php");
    exit;
}

$index = (int) $_POST['index'];

if (!isset($_SESSION['Favoritos'][$index])) {
    header("Location: Favoritos.php");
    exit;
}

$item = &$_SESSION['Favoritos'][$index];

/* novos dados */
$data_inicio = $_POST['data_inicio'];
$data_fim = $_POST['data_fim'];

$adultos = (int) $_POST['adultos'];
$criancas = (int) $_POST['criancas'];

/* corrigir datas */
$inicio = new DateTime($data_inicio);
$fim = new DateTime($data_fim);

$noites = $inicio->diff($fim)->days;

if ($noites < 1) {
    $noites = 1;
}

/* recalcular preço */
$preco_noite = $item['preco_noite'];

$novo_total =
    $preco_noite * $noites;

/* atualizar Favoritos */
$item['data_inicio'] = $data_inicio;
$item['data_fim'] = $data_fim;

$item['adultos'] = $adultos;
$item['criancas'] = $criancas;

$item['preco_total'] = $novo_total;

header("Location: Favoritos.php");
exit;
?>