<?php 

require_once 'vendor/autoload.php';

$pdo = ConectionConstructor::createConnection();

$sqlDelete = 'DELETE FROM students WHERE id = ?';
$statement = $pdo->prepare($sqlDelete);
$statement->bindValue(1, 9, PDO::PARAM_INT);

if( $statement->execute() ) {
    echo "Aluno removido com sucesso!" . PHP_EOL;
} else {
    echo "Erro ao remover aluno." . PHP_EOL;
}