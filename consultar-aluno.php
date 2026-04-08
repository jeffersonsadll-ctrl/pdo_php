<?php

require_once 'vendor/autoload.php';

use Alura\Pdo\Domain\Model\Student;

$pdo = new PDO('sqlite:' . __DIR__ . '/banco.sqlite');
echo 'Conexão estabelecida com sucesso!' . PHP_EOL; 

$sqlSelectAluno = 'SELECT id, name, birth_date FROM students';
$statement = $pdo->query($sqlSelectAluno);
$students = $statement->fetchAll(PDO::FETCH_ASSOC);

$listStudents = [];
foreach ($students as $student) {
  $listStudents[] = new Student(
    $student['id'],
    $student['name'],
    new \DateTimeImmutable($student['birth_date'])
  );
}

var_dump($listStudents);