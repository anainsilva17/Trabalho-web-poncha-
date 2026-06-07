<?php
session_start();

// limpar todas as variáveis de sessão
session_unset();

// destruir a sessão
session_destroy();

// voltar para a página inicial
header("Location: index_final_corrigido.php");
exit;