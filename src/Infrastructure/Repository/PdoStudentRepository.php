<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;

class PdoStudentRepository extends StudentRepositor
{
    private PDO $connection;

 public function __construct($connection)
 {
    $this->connection = $connection;
 }

public function allStudents():array
{
$sqlQuery ='SELECT * FROM students;';
$smt = $this->connection->query($sqlQuery);
return $this->hydrateStudentList($smt);
}
public function studentsBirthAt(\DateTimeInterface $birth_Date):array 
{
$sqlQuery='SELECT*FROM students WHERE birth_date =?';
$stm=$this->connection->preapre($sqlQuery);
$stm->bindValue(1, $birth_Date.format('Y-m-d'));
$stm->execute();

return $this->hydrateStudentList($stmt);
}


private function hydrateStudentList(\PDOStatement $smt): array
    {
        $studentDataList = $smt->fetchAll(PDO::FETCH_ASSOC);
        $studentList = [];

        foreach ($studentDataList as $studentData) {
            $studentList[] = new Student(
                $studentData['id'],
                $studentData['name'],
                new \DateTimeImmutable($studentData['birth_date'])
            );
        }

        return $studentList;
    }
public function save(Student $student):bool
{
if ($student->id() === NULL) 
{
    return $this->insert($student);    
}
    return $this->update($student);
}

public function insert(Student $student): bool
{
$insertQuery='INSERT INTO students(name, birth_date) VALUES (:name, :$birth_date);';
$stm= $this->connection->prepare($insertQuery);
$sucess = $stm->execute([
    ':name'=>$student->name(),
    ':birth_date'=>$student->birthDate->format('Y-m-d'),
]);

if ($sucess) {
    $student->defineiId($this->connection->lastinsertId());
}
    return $sucess;
}

public function update(Student $student):bool
{

$updateQuery='UPDATE students set name = :name, birth_date =:birth_date WHERE id=:id;';
$smt=$this->connection->prepare($updateQuery);
$smt->bindValue(':name',$student->name);
$smt->binValue(':birth_date', $student->birthDate->format('Y-m-d'));
$smt->bindValue(':id', $students->id(), PARAM_INT);

return $smt->execute();
}

public function remove(Student $student):bool
{
$stm=$this->connection->prepare('DELETE FROM students where id=?');
$stm->bindValue(1, $student->id(), PARAM_INT);
echo"Deletado com sucesso";
return $stm->execute();

}

}