<?php
session_start();
include 'includes/db.php';

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM utilizadores WHERE email = '$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_nome'] = $user['nome'];
            $_SESSION['user_pontos'] = $user['pontos'];

            header("Location: index_final_corrigido.php");
            exit;

        } else {

            $erro = "Palavra-passe incorreta.";

        }

    } else {

        $erro = "Utilizador não encontrado.";

    }

}

?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Poncha-te Aqui</title>

    <link rel="stylesheet" href="style.css?v=5">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="shortcut icon" href="img/logos.png">
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container">

    <header class="registo-header">
        <h1>Iniciar Sessão</h1>
        <p>Aceda à sua conta Poncha-te Aqui.</p>
    </header>

    <div class="registo-form">

        <?php if (!empty($erro)) { ?>
            <p style="color:red; text-align:center; margin-bottom:20px;">
                <?php echo $erro; ?>
            </p>
        <?php } ?>

        <form method="POST">

            <div class="form-group">
                <label for="cliente-email">Email</label>
                <input type="email" name="email" id="cliente-email" required>
            </div>

            <div class="form-group">
                <label for="cliente-pass">Palavra-passe</label>
                <input type="password" name="password" id="cliente-pass" required>
            </div>

            <button type="submit" class="submit-btn">
                ENTRAR
            </button>

        </form>

        <p style="text-align:center; margin-top:20px;">
            Ainda não tem conta?
            <a href="registo.php" style="font-weight:bold;">
                Registe-se aqui
            </a>
        </p>

    </div>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>