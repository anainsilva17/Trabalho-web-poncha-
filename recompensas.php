<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$pontos = $_SESSION['user_pontos'] ?? 0;

$recompensas = [

[
"nome"=>"Poncha Tradicional",
"descricao"=>"Saboreie a bebida mais famosa da Madeira.",
"imagem"=>"recompensas1.jpg",
"pontos"=>50
],

[
"nome"=>"Visita à Cascata",
"descricao"=>"Descubra uma das paisagens mais bonitas da ilha.",
"imagem"=>"recompensas2.jpg",
"pontos"=>150
],

[
"nome"=>"Pico do Areeiro",
"descricao"=>"Uma experiência acima das nuvens.",
"imagem"=>"recompensas3.jpg",
"pontos"=>300
],

[
 "nome"=>"Carros de Cesto",
"descricao"=>"Uma experiência tradicional madeirense.",
"imagem"=>"recompensas5.jpg",
"pontos"=>500
],

[
"nome"=>"Road Trip pela Madeira",
"descricao"=>"Explore a natureza da ilha.",
"imagem"=>"recompensas4.jpg",
"pontos"=>750
],

[
"nome"=>"Cruzeiro no Funchal",
"descricao"=>"Uma experiência premium inesquecível.",
"imagem"=>"recompensas6.jpg",
"pontos"=>1200
]

];
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Recompensas | Poncha-te Aqui</title>

<link rel="stylesheet" href="style.css?v=100">

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

body{
    background:#f5f6f8;
}

.topo-recompensas{
    margin-top:40px;
    margin-bottom:50px;
}

.titulo h1{
    font-size:55px;
    font-weight:700;
    color:#1d243f;
}

.titulo p{
    color:#777;
    font-size:18px;
}

.caixa-pontos{
    background:white;
    padding:20px 35px;
    border-radius:25px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
    text-align:center;
}

.numero-pontos{
    font-size:38px;
    font-weight:700;
    color:#d4a017;
}

.card-recompensa{
    background:white;
    border:none;
    border-radius:30px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
    transition:.3s;
}

.card-recompensa:hover{
    transform:translateY(-8px);
}

.card-recompensa img{
    width:100%;
    height:220px;
    object-fit:cover;
}

.info{
    padding:25px;
}

.nome{
    font-size:20px;
    font-weight:700;
    color:#1d243f;
}

.descricao{
    margin-top:10px;
    color:#777;
}

.preco{
    margin-top:20px;
    font-size:20px;
    font-weight:700;
    color:#d4a017;
}

.botao{
    width:100%;
    margin-top:20px;
    border:none;
    background:#ffc107;
    padding:14px;
    border-radius:50px;
    font-weight:700;
}

.bloqueado{
    width:100%;
    margin-top:20px;
    border:none;
    background:#e9ecef;
    color:#666;
    padding:14px;
    border-radius:50px;
    font-weight:700;
}

</style>

</head>
<body>

<?php include 'includes/header.php'; ?>
<div style="height:120px;"></div>


<div class="container">

<div class="topo-recompensas d-flex justify-content-between align-items-center">

<div class="titulo">

<h1>Recompensas</h1>

<p>
Descubra experiências únicas na Madeira e troque os seus pontos.
</p>

</div>

<div class="caixa-pontos">

<small>Os seus pontos</small>

<div class="numero-pontos">
<?= $pontos ?>
</div>

</div>

</div>


<div class="row g-4">

<?php foreach($recompensas as $r): ?>

<div class="col-lg-4 col-md-6">

<div class="card-recompensa">

<img src="img/<?= $r['imagem']; ?>">

<div class="info">

<div class="nome">
<?= $r['nome']; ?>
</div>

<div class="descricao">
<?= $r['descricao']; ?>
</div>

<div class="preco">
<?= $r['pontos']; ?> pontos
</div>

<?php if($pontos >= $r['pontos']): ?>

<button class="botao">
Desbloquear recompensa
</button>

<?php else: ?>

<button class="bloqueado">
Faltam <?= $r['pontos'] - $pontos ?> pontos
</button>

<?php endif; ?>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>