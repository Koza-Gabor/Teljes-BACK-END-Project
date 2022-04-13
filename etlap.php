<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET['etlap'] == '') {
        $stmt = $pdo->prepare('SELECT * FROM etlap');
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'));
    $stmt = $pdo->prepare('INSERT INTO etlap (kategoria, nev, osszetetel, alergia, ar) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$data->kategoria, $data->nev, $data->osszetetel, $data->alergia, $data->ar]);
    $data->id = $pdo->lastInsertId();
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents('php://input'));
    $query = "UPDATE etlap SET kategoria='$data->kategoria', nev='$data->nev', osszetetel='$data->osszetetel', alergia='$data->alergia', ar='$data->ar' WHERE id=".$data->id;
    $stmt = $pdo->query($query);
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $data = json_decode(file_get_contents('php://input'));
    $query = "DELETE FROM etlap WHERE id =".$data->id;
    $stmt =$pdo->query($query);
    return;
    
}
?>