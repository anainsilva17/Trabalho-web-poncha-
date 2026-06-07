<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>As nossas sugestões</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css?v=30">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="shortcut icon" href="img/logos.png">
</head>

<body>

<?php include 'includes/header.php'; ?>

<section class="sugestoes-page">

    <div class="container">

        <div class="titulo-sugestoes">
            <h1>As nossas sugestões</h1>

            <p>
                Descubra experiências únicas na Madeira,
                desde aventuras no mar até trilhos inesquecíveis
                pela natureza da ilha.
            </p>
        </div>

        <!-- CATAMARÃ -->
        <div class="sugestao-card">

            <img src="img/imagem2.jpg"
                 class="sugestao-img"
                 alt="Passeio de Catamarã">

            <div class="sugestao-content">

                <span class="tag">
                    Experiência no Mar
                </span>

                <h2>Passeios de Catamarã pela Costa</h2>

                <p>
                    Os passeios de catamarã, com partida do Funchal,
                    são uma das melhores formas de observar
                    golfinhos e baleias no Atlântico.
                </p>

                <p>
                    Estes cruzeiros oferecem vistas privilegiadas
                    da costa madeirense e do Cabo Girão,
                    incluindo frequentemente uma paragem
                    para mergulho em águas cristalinas.
                </p>

                <p class="highlight">
                    Perfeito para relaxar no mar ou viver
                    um romântico pôr do sol.
                </p>

            </div>

        </div>

        <!-- LEVADAS -->
        <div class="sugestao-card">

            <img src="img/imagem8.jpg"
                 class="sugestao-img"
                 alt="Levadas da Madeira">

            <div class="sugestao-content">

                <span class="tag">
                    Natureza
                </span>

                <h2>As nossas Levadas pela Laurissilva</h2>

                <p>
                    As levadas são canais históricos de irrigação
                    transformados em trilhos únicos de caminhada.
                </p>

                <p>
                    São uma das formas mais autênticas de descobrir
                    a exuberante natureza da Madeira,
                    incluindo a Floresta Laurissilva,
                    Património Mundial da UNESCO.
                </p>

                <p class="highlight">
                    Caminhadas para todos os níveis,
                    com paisagens incríveis,
                    cascatas e miradouros inesquecíveis.
                </p>

            </div>

        </div>

        <!-- AVALIAÇÕES -->
        <section class="avaliacoes">

            <div class="titulo-avaliacoes">
                <h2>O que dizem os nossos hóspedes</h2>

                <p>
                    Experiências reais de quem viveu
                    a magia da Madeira.
                </p>
            </div>

            <div class="avaliacoes-grid">

                <div class="review-card">
                    <i class="fa-solid fa-quote-left"></i>

                    <p>
                        “A base perfeita para explorar a ilha
                        e um enorme obrigado pelo passeio de barco!”
                    </p>

                    <h4>Tomás Silva</h4>
                </div>

                <div class="review-card">
                    <i class="fa-solid fa-quote-left"></i>

                    <p>
                        “Uma autêntica casa madeirense
                        com uma vista de sonho.
                        Experiência incrível!”
                    </p>

                    <h4>Alice Figueiredo</h4>
                </div>

                <div class="review-card">
                    <i class="fa-solid fa-quote-left"></i>

                    <p>
                        “Experiência sem stress,
                        excelentes dicas locais
                        e alojamento impecável.”
                    </p>

                    <h4>Maria Drummond</h4>
                </div>

            </div>

        </section>

    </div>

</section>

<?php include 'includes/footer.php'; ?>

</body>
</html>