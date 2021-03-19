<?php

namespace Alura\PDO\Domain\Repository;

use Alura\Pdo\Domain\Model\Student;

interface StudentRepository
{
public function allStudents():array;
public function studentsBirthAt(\DateTimeInterface $birthdate):array;
public function save(Student $student):bool;
public function insert(Student $student):bool;
public function update(Student $student):bool;
public function remove(Student $student):bool;
}
