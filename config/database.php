<?php
$host = 'localhost';
$db = 'eventos';
$user = 'postgres';
$pass = 'aluno';

$conn = pg_connect("host=$host dbname=$db user=$user password=$pass");

if (!$conn) {
    die("Erro na conexão com o banco de dados.");
}
?>
