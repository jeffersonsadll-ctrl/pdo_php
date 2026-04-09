<?php

use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$pdo = ConnectionConstructor::createConnection();

$studentRepository = new PdoStudentRepository($pdo);

// $studentList = $studentRepository->allStudents();
$studentList = $studentRepository->allStudentsWithPhones();

// $databasePath = __DIR__ . '/banco.sqlite';
// $pdo = new PDO('sqlite:' . $databasePath);

// $statement = $pdo->query('SELECT * FROM students;');
// $studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
// $studentList = [];

// foreach ($studentDataList as $studentData) {
//     $studentList[] = new Student(
//         $studentData['id'],
//         $studentData['name'],
//         new \DateTimeImmutable($studentData['birth_date'])
//     );
// }

var_dump($studentList);
// var_dump($studentList[0]->phones()->id);
