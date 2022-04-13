<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    if ($_GET['szekek' ] == '') {
        $stmt = $pdo->prepare('SELECT * FROM szekek');
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'));
    $stmt = $pdo->prepare('INSERT INTO szekek (asztal_id, allapot) VALUES (?, ?)');
    $stmt->execute([$data->asztal_id, $data->allapot]);
    $data->id = $pdo->lastInsertId();
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents('php://input'));
    $query = "UPDATE szekek SET asztal_id='$data->asztal_id', allapot='$data->allapot' WHERE id=".$data->id;
    $stmt = $pdo->query($query);
    return;
}
?>