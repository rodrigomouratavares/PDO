<?php

use Alura\Pdo\Infraestructure\Repository\PdoStudentRepository;


$pdo = new PDO('');
$repository = new PdoStudentRepository($pdo);

empty($repository->allStudents());