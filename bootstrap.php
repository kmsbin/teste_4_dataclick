<?php
require 'vendor/autoload.php';
 
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();
 // as duas linhas que carregam as variáveis do .env para variáveis de ambiente 
?>