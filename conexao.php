<?php

$caminhoBanco = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $caminhoBanco);

// $pdo->exec('INSERT INTO phones (area_code, number, student_id) VALUES ("11", "99999-9999", 1)');
// $pdo->exec('INSERT INTO phones (area_code, number, student_id) VALUES ("11", "99999-9999", 2)');
// $pdo->exec('INSERT INTO phones (area_code, number, student_id) VALUES ("11", "99999-9999", 3)');
// $pdo->exec('INSERT INTO phones (area_code, number, student_id) VALUES ("11", "99999-9999", 3)');
// $pdo->exec('INSERT INTO phones (area_code, number, student_id) VALUES ("11", "99999-9999", 3)');
// $pdo->exec('INSERT INTO phones (area_code, number, student_id) VALUES ("11", "99999-9999", 4)');

$createTableQuery = 'CREATE TABLE IF NOT EXISTS students (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    birth_date TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS phones (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    area_code TEXT NOT NULL,    
    number TEXT NOT NULL,
    student_id INTEGER NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(id)
);
';

$pdo->exec($createTableQuery);

echo 'Conectei';
