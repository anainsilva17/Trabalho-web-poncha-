<?php
include 'includes/db.php';

$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    /* verificar se email já existe */
    $stmt = $conn->prepare("SELECT id FROM utilizadores WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {

        $erro = "Este email já está registado.";

    } else {

        /* criar utilizador */
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("
            INSERT INTO utilizadores 
            (nome, email, password, pontos)
            VALUES (?, ?, ?, 0)
        ");

        $stmt->bind_param("sss", $nome, $email, $password);

    if ($stmt->execute()) {

    $sucesso = "Conta criada com sucesso! Já pode iniciar sessão.";

} else {

    $erro = "Erro MySQL: " . $stmt->error;

}
}
}
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registar | Poncha-te Aqui</title>

    <link rel="stylesheet" href="style.css?v=5">
    <link rel="shortcut icon" href="img/logos.png">
</head>

<body>

<?php include 'includes/header.php'; ?>

<div class="container">

    <header class="registo-header">
        <h1>Crie a Sua Conta</h1>
        <p>
            Junte-se à comunidade Poncha-te Aqui
            para gerir as suas reservas.
        </p>
    </header>

    <div class="registo-form registo-simples">

        <?php if (!empty($erro)): ?>
            <p style="color:red; text-align:center;">
                <?= $erro; ?>
            </p>
        <?php endif; ?>

        <?php if (!empty($sucesso)): ?>
            <p style="color:green; text-align:center;">
                <?= $sucesso; ?>
            </p>
        <?php endif; ?>

        <form method="POST">

            <div class="form-group">
                <label>Nome Completo</label>
                <input type="text" name="nome" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Palavra-passe</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="submit-btn">
                CRIAR CONTA
            </button>

        </form>

    </div>

</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>