<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$student = new Student(
    null,
    'rodrigo moura tavares',
    new \DateTimeImmutable('1996-09-24')
);

echo $student->age();
