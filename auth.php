<?php

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  return true;
}

$noAuthResources = [
  'GET' => ['etlap'],
  'GET' => ['felhasznalok'],
  'GET' => ['szekek'],
  'POST' => ['felhasznalok=login'],
  'POST' => ['etlap'],
  'POST' => ['felhasznalok'],
  'POST' => ['szekek'],
  'PUT' => ['etlap'],
  'PUT' => ['felhasznalok'],
  'PUT' => ['szekek'],
  'PATCH' => ['etlap'],
  'PATCH' => ['felhasznalok'],
  'PATCH' => ['szekek'],
  'DELETE' => ['etlap'],
  'DELETE' => ['felhasznalok'],
  'DELETE' => ['szekek']
];

if (in_array($_SERVER['QUERY_STRING'], $noAuthResources[$_SERVER['REQUEST_METHOD']])) {
  return true;
}

$jog = isset(apache_request_headers()['Jog']) ? apache_request_headers()['Jog'] : null;

$stmt = $pdo->prepare('SELECT id FROM felhasznalok WHERE jog = ?');
$stmt->execute([$jog]);
if ($stmt->fetch(PDO::FETCH_ASSOC)) {
  return true;
}

http_response_code(401);
die('Authorization error');