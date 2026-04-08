<?php 

require_once 'vendor/autoload.php';

use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;
use Alura\Pdo\Domain\Model\Student;


$connection = ConectionConstructor::createConnection();
$studentRepository = new PdoStudentRepository($connection);

$connection->beginTransaction();

try{

  $studentRepository->save(new Student(
      null,
      'Maria',
      new DateTimeImmutable('2000-01-01')
  ));

  $studentRepository->save(new Student(
      null,
      'João',
      new DateTimeImmutable('2000-01-01')
  ));

  $connection->commit();
  echo "Alunos cadastrados com sucesso!" . PHP_EOL;

}catch (\PDOException $e) {

  $connection->rollBack();
  echo "Erro ao cadastrar alunos: " . $e->getMessage() . PHP_EOL;

}
