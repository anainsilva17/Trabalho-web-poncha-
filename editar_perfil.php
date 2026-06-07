<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM utilizadores
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

$utilizador = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $password = $_POST['password'];
    $confirmar_password = $_POST['confirmar_password'];

    /* se quiser alterar a password */
    if (!empty($password)) {

        if ($password != $confirmar_password) {

            die("As palavras-passe não coincidem.");

        }

        $password_hash =
            password_hash(
                $password,
                PASSWORD_DEFAULT
            );

        $sql = "UPDATE utilizadores
                SET nome = ?,
                    email = ?,
                    password = ?
                WHERE id = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "sssi",
            $nome,
            $email,
            $password_hash,
            $user_id
        );

    }

    /* apenas nome e email */
    else {

        $sql = "UPDATE utilizadores
                SET nome = ?,
                    email = ?
                WHERE id = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "ssi",
            $nome,
            $email,
            $user_id
        );

    }

    $stmt->execute();

    $_SESSION['user_nome'] = $nome;
    $_SESSION['user_email'] = $email;

    header("Location: perfil.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Editar Perfil</title>

    <link rel="stylesheet" href="style.css?v=20">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<?php include 'includes/header.php'; ?>

<main class="container py-5"
      style="margin-top:120px; min-height:80vh;">

    <div class="card shadow-sm rounded-4 border-0 mx-auto"
         style="max-width:700px;">

        <div class="card-body p-5">

            <h1 class="fw-bold mb-4">
                ✏️ Editar Perfil
            </h1>

            <form method="POST">

                <div class="mb-4">

                    <label class="fw-bold mb-2">
                        Nome
                    </label>

                    <input
                        type="text"
                        name="nome"
                        class="form-control"
                        value="<?= $utilizador['nome']; ?>"
                        required>

                </div>

                <div class="mb-4">

                    <label class="fw-bold mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="<?= $utilizador['email']; ?>"
                        required>

                </div>
<div class="mb-4">

    <label class="fw-bold mb-2">
        Nova Palavra-passe
    </label>

    <input
        type="password"
        name="password"
        class="form-control">

</div>

<div class="mb-4">

    <label class="fw-bold mb-2">
        Confirmar Palavra-passe
    </label>

    <input
        type="password"
        name="confirmar_password"
        class="form-control">

</div>
                <button
                    type="submit"
                    class="btn btn-success w-100 rounded-4 fw-bold">

                    Guardar Alterações

                </button>

            </form>

        </div>

    </div>

</main>

<?php include 'includes/footer.php'; ?>

