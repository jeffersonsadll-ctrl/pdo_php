<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$pdo = ConectionConstructor::createConnection();

$student = new Student(null, "Jeff' Teste", new \DateTimeImmutable('1997-10-15'));

$name = $student->name();

$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (:col_name, :col_birth_date);";
$statement = $pdo->prepare($sqlInsert);
$statement->bindParam(':col_name', $name);
$statement->bindValue(':col_birth_date', $student->birthDate()->format('Y-m-d'));

$name = "Jefferson Teste NOVO";

if( $statement->execute() ) {
    echo "Aluno inserido com sucesso!" . PHP_EOL;
} else {
    echo "Erro ao inserir aluno." . PHP_EOL;
}
