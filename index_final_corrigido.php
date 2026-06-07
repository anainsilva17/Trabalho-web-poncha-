<?php
session_start();
?>

<?php
include 'includes/db.php';

$sql = "SELECT * FROM alojamentos ORDER BY RAND() LIMIT 4";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <title>Poncha-te Aqui</title>

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="style.css?v=30">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="shortcut icon"
          href="img/logos.png">
    <link rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
</head>

<body>

<?php include 'includes/header.php'; ?>

<!-- HERO -->
<section class="hero">

    <div class="hero-content">

        <h1>
            Descubra alojamentos locais na Ilha da Madeira
        </h1>

        <!-- PESQUISA -->
        <form action="resultados.php"
              method="GET"
              class="search-box">

            <!-- LOCALIZAÇÃO -->
            <div class="field full">

                <span class="label">
                    Localização
                </span>

                <select
                    name="localizacao"
                    class="form-control"
                    required>

                    <option value="tudo">
                        Ver tudo
                    </option>

                    <option value="Funchal">
                        Funchal
                    </option>

                    <option value="Calheta">
                        Calheta
                    </option>

                    <option value="Machico">
                        Machico
                    </option>

                    <option value="Santana">
                        Santana
                    </option>

                    <option value="Porto Moniz">
                        Porto Moniz
                    </option>

                </select>

            </div>

            <!-- CHECK-IN -->
            <div class="field">

                <span class="label">
                    Check-in
                </span>

                <input
                    type="date"
                    name="data_inicio"
                    id="checkin"
                    min="<?= date('Y-m-d', strtotime('+1 day')); ?>"
                >

            </div>

            <!-- CHECK-OUT -->
            <div class="field">

                <span class="label">
                    Check-out
                </span>

                <input
                    type="date"
                    name="data_fim"
                    id="checkout"
                    min="<?= date('Y-m-d', strtotime('+2 day')); ?>"
                >

            </div>

            <!-- ADULTOS -->
            <div class="field">

                <span class="label">
                    Adultos
                </span>

                <input
                    type="number"
                    name="adultos"
                    min="1"
                    value="1"
                    required
                >

            </div>

            <!-- CRIANÇAS -->
            <div class="field">

                <span class="label">
                    Crianças
                </span>

                <input
                    type="number"
                    name="criancas"
                    min="0"
                    value="0"
                >

            </div>

            <!-- BOTÃO -->
            <button
                type="submit"
                class="btn btn-search">

                PESQUISAR

            </button>

        </form>

    </div>

</section>

<!-- BENEFÍCIOS -->
<section class="benefits py-5">

    <div class="container">

        <div class="row g-4">

            <div class="col-md-4">

                <div class="benefit-card text-center">

                    <div class="benefit-header">

                        <i class="fa-solid fa-star benefit-icon"></i>

                        <h5>
                            Leia Avaliações Autênticas
                        </h5>

                    </div>

                    <p>
                        Encontre alojamentos que vai adorar
                        com base nas experiências
                        de outros viajantes.
                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="benefit-card text-center">

                    <div class="benefit-header">

                        <i class="fa-solid fa-compass benefit-icon"></i>

                        <h5>
                            Escolha experiências únicas
                        </h5>

                    </div>

                    <p>
                        Tours, mergulho ou aventura
                        nas Piscinas Naturais.
                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="benefit-card text-center">

                    <div class="benefit-header">

                        <i class="fa-solid fa-shield-heart benefit-icon"></i>

                        <h5>
                            Mantenha a Flexibilidade
                        </h5>

                    </div>

                    <p>
                        Casas com políticas flexíveis
                        para mudar os seus planos.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- TESTEMUNHOS -->
<section class="testemunhos">

    <h2>
        O que os nossos hóspedes dizem.
    </h2>

    <div class="cards-container">

        <div class="card-testemunho">

            <p class="quote">

                "Nunca pensei que um alojamento local
                pudesse ser tão acolhedor.
                A vista para o Pico Ruivo era
                de tirar o fôlego."

            </p>

            <div class="cliente-info">

                <img
                    src="img/cliente1.jpg"
                    alt="Vitória"
                    class="foto-cliente"
                >

                <div class="detalhes-cliente">

                    <div class="nome-cliente">
                        Vitória V.
                    </div>

                    <div class="titulo-cliente">
                        Hóspede em 2024
                    </div>

                </div>

            </div>

        </div>

        <div class="card-testemunho">

            <p class="quote">

                "O processo de reserva foi
                incrivelmente fácil.
                Recomendo a todos os meus amigos!"

            </p>

            <div class="cliente-info">

                <img
                    src="img/cliente2.jpg"
                    alt="Ana Cristina"
                    class="foto-cliente"
                >

                <div class="detalhes-cliente">

                    <div class="nome-cliente">
                        Ana Cristina F.
                    </div>

                    <div class="titulo-cliente">
                        Hóspede de longa data
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- ALOJAMENTOS EM DESTAQUE -->
<section class="container py-5">

    <h2 class="text-center mb-5">
        🌴 Alojamentos em Destaque
    </h2>

    <div class="row g-4" id="alojamentos-destaque">

        <?php while ($row = $result->fetch_assoc()): ?>

            <div class="col-md-6 col-lg-3">

                <div class="card shadow h-100">

                    <img src="img/<?= $row['imagem']; ?>" class="card-img-top" style="height:220px; object-fit:cover;">

                    <div class="card-body">

                        <h5 class="card-title"><?= $row['nome']; ?></h5>

                        <p class="text-muted">📍 <?= $row['localizacao']; ?></p>

                        <p>€<?= number_format($row['preco_noite'], 2, ',', '.'); ?>/noite</p>

                        <a href="alojamentos.php?id=<?= $row['id']; ?>" class="btn btn-primary w-100">
                            Ver alojamento
                        </a>

                    </div>

                </div>

            </div>

        <?php endwhile; ?>

    </div>

</section>

<section class="container py-5">

    <h2 class="text-center mb-4">
        🗺️ Explore os nossos alojamentos na Madeira
    </h2>

    <div id="mapa-alojamentos"></div>

</section>

<!-- CTA -->

<section class="cta-proprietarios">

    <h2>
        JUNTE-SE À NOSSA COMUNIDADE DE ANFITRIÕES
    </h2>

    <p class="cta-descricao">
        Partilhe a magia da Madeira.
        Receba mais reservas.
    </p>

    <form class="form-cta">

        <div class="cta-linha">

            <input
                type="text"
                placeholder="Nome"
                class="input-cta metade"
            >

            <input
                type="tel"
                placeholder="Telefone"
                class="input-cta metade"
            >

        </div>

        <div class="cta-linha">

            <input
                type="email"
                placeholder="Email"
                class="input-cta total"
            >

        </div>

        <button class="btn-cta">
            QUERO PARTILHAR O MEU ALOJAMENTO!
        </button>

    </form>

</section>

<?php include 'includes/footer.php'; ?>

<!-- SCRIPT DATAS -->
<script>
document.getElementById('checkin').addEventListener('change', function () {

    if (!this.value) return;

    const data = new Date(this.value);
    data.setDate(data.getDate() + 1);

    const ano = data.getFullYear();
    const mes = String(data.getMonth() + 1).padStart(2, '0');
    const dia = String(data.getDate()).padStart(2, '0');

    document.getElementById('checkout').min = `${ano}-${mes}-${dia}`;

    if (
        document.getElementById('checkout').value &&
        document.getElementById('checkout').value <= this.value
    ) {
        document.getElementById('checkout').value = '';
    }

});
</script>

<script>

setInterval(function(){

    fetch("carregar_alojamentos.php")

    .then(response => response.text())

    .then(data => {

        document.getElementById(
            "alojamentos-destaque"
        ).innerHTML = data;

    });

},10000);

</script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>

var mapa = L.map('mapa-alojamentos').setView([32.7607,-16.9595],10);

L.tileLayer(
'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
{
maxZoom:18
}
).addTo(mapa);

// Funchal
L.marker([32.6669,-16.9241])
.addTo(mapa)
.bindPopup("<b>Casa Vista Mar</b><br>Funchal");

// Santana
L.marker([32.8056,-16.8790])
.addTo(mapa)
.bindPopup("<b>Villa Santana</b><br>Santana");

// Machico
L.marker([32.7167,-16.7667])
.addTo(mapa)
.bindPopup("<b>Apartamento Machico</b><br>Machico");

// São Vicente
L.marker([32.7968,-17.0432])
.addTo(mapa)
.bindPopup("<b>Alojamento São Vicente</b><br>São Vicente");

// Ribeira Brava
L.marker([32.6748,-17.0627])
.addTo(mapa)
.bindPopup("<b>Villa Ribeira Brava</b><br>Ribeira Brava");

// Calheta
L.marker([32.7175,-17.1740])
.addTo(mapa)
.bindPopup("<b>Casa Calheta</b><br>Calheta");

// Santo da Serra
L.marker([32.7162,-16.8247])
.addTo(mapa)
.bindPopup("<b>Quinta Santo da Serra</b><br>Santo da Serra");

// Porto Moniz
L.marker([32.8676,-17.1667])
.addTo(mapa)
.bindPopup("<b>Casa Porto Moniz</b><br>Porto Moniz");

// Ponta do Sol
L.marker([32.6798,-17.1018])
.addTo(mapa)
.bindPopup("<b>Alojamento Ponta do Sol</b><br>Ponta do Sol");

</script>
</body>
</html>