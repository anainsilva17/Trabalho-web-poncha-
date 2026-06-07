<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* contador do Favoritos */
$totalFavoritos = isset($_SESSION['Favoritos'])
    ? count($_SESSION['Favoritos'])
    : 0;
?>

<header class="topo">

    <div class="logo-area">
        <a href="index_final_corrigido.php">
            <img src="img/logo_todo.png" alt="Logo Poncha-te Aqui">
        </a>
    </div>

<nav class="menu">

        <a href="sugestoes.php">As nossas sugestões</a>
        <a href="nos.php">Sobre nós</a>

       <?php if (isset($_SESSION['user_id'])): ?>

    <?php
    $nomes = explode(" ", trim($_SESSION['user_nome']));

    if (count($nomes) >= 2) {
        $iniciais = strtoupper(
            substr($nomes[0], 0, 1) .
            substr(end($nomes), 0, 1)
        );
    } else {
        $iniciais = strtoupper(substr($nomes[0], 0, 1));
    }
    ?>

    <div class="user-area">

    <a href="perfil.php"
       class="perfil-btn-header">

        <div class="perfil-avatar">
            <?= $iniciais; ?>
        </div>

    </a>

</div>

<?php else: ?>

    <a href="login.php" class="registar-btn">
        Entrar / Registar
    </a>

<?php endif; ?>

    </nav>

</header>
<script src="/Poncha-te-Aqui/includes/menu.js"></script>