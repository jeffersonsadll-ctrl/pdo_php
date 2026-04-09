<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Model\Phone;
use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;
use PDO;

class PdoStudentRepository implements StudentRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function allStudents(): array
    {
        $sqlQuery = 'SELECT * FROM students;';
        $stmt = $this->connection->query($sqlQuery);

        return $this->hydrateStudentList($stmt);
    }

    public function allStudentsWithPhones(): array
    {
        $sqlQuery = 'SELECT s.id AS student_id, s.name, s.birth_date, p.id AS phone_id, p.area_code, p.number
                     FROM students s
                     LEFT JOIN phones p ON s.id = p.student_id;';
        $stmt = $this->connection->query($sqlQuery);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $listStudents = [];

        foreach( $result as $row ){
            if( !isset($listStudents[$row['student_id']]) ){
                $listStudents[$row['student_id']] = new Student(
                    $row['student_id'],
                    $row['name'],
                    new \DateTimeImmutable($row['birth_date'])
                );
            }
            if ($row['phone_id'] !== null) {
                $listStudents[$row['student_id']]->addPhone(new Phone(
                    $row['phone_id'],
                    $row['area_code'],
                    $row['number']
                ));
            }

        }

        return array_values($listStudents);
    }

    public function studentsBirthAt(\DateTimeInterface $birthDate): array
    {
        $sqlQuery = 'SELECT * FROM students WHERE birth_date = ?;';
        $stmt = $this->connection->prepare($sqlQuery);
        $stmt->bindValue(1, $birthDate->format('Y-m-d'));
        $stmt->execute();

        return $this->hydrateStudentList($stmt);
    }

    private function hydrateStudentList(\PDOStatement $stmt): array
    {
        $studentDataList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $studentList = [];

        foreach ($studentDataList as $studentData) {
            $student = new Student(
                $studentData['id'],
                $studentData['name'],
                new \DateTimeImmutable($studentData['birth_date'])
            );

            $this->fillPhonesOf($student);

            $studentList[] = $student;
        }

        return $studentList;
    }

    private function fillPhonesOf(Student $student): void 
    {
        $queryPhone = "SELECT id, area_code, number FROM phones WHERE student_id = ?";
        $stmt = $this->connection->prepare($queryPhone);
        $stmt->bindValue(1, $student->id(), PDO::PARAM_INT);
        $stmt->execute();

        $phoneList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($phoneList as $phoneData) {
            $student->addPhone(new Phone(
                $phoneData['id'],
                $phoneData['area_code'],
                $phoneData['number']
            ));
        }

    }

    public function save(Student $student): bool
    {
        if ($student->id() === null) {
            return $this->insert($student);
        }

        return $this->update($student);
    }

    private function insert(Student $student): bool
    {
        $insertQuery = 'INSERT INTO students2 (name, birth_date) VALUES (:name, :birth_date);';
        $stmt = $this->connection->prepare($insertQuery);

        $success = $stmt->execute([
            ':name' => $student->name(),
            ':birth_date' => $student->birthDate()->format('Y-m-d'),
        ]);

        if ($success) {
            $student->defineId($this->connection->lastInsertId());
        }

        return $success;
    }

    private function update(Student $student): bool
    {
        $updateQuery = 'UPDATE students SET name = :name, birth_date = :birth_date WHERE id = :id;';
        $stmt = $this->connection->prepare($updateQuery);
        $stmt->bindValue(':name', $student->name());
        $stmt->bindValue(':birth_date', $student->birthDate()->format('Y-m-d'));
        $stmt->bindValue(':id', $student->id(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function remove(Student $student): bool
    {
        $stmt = $this->connection->prepare('DELETE FROM students WHERE id = ?;');
        $stmt->bindValue(1, $student->id(), PDO::PARAM_INT);

        return $stmt->execute();
    }
}
