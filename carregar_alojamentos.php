<?php
include 'includes/db.php';

$sql = "SELECT * FROM alojamentos ORDER BY RAND() LIMIT 4";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()):
?>

<div class="col-md-6 col-lg-3">

    <div class="card shadow h-100">

        <img src="img/<?= $row['imagem']; ?>"
             class="card-img-top"
             style="height:220px; object-fit:cover;">

        <div class="card-body">

            <h5 class="card-title">
                <?= $row['nome']; ?>
            </h5>

            <p class="text-muted">
                📍 <?= $row['localizacao']; ?>
            </p>

            <p>
                €<?= number_format($row['preco_noite'],2,',','.'); ?>/noite
            </p>

            <a href="alojamentos.php?id=<?= $row['id']; ?>"
               class="btn btn-primary w-100">

                Ver alojamento

            </a>

        </div>

    </div>

</div>

<?php endwhile; ?>