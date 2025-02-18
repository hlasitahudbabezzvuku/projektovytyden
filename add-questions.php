<?php
require_once 'database.php';

function generateUUID() {
    $data = random_bytes(16);

    // Set version (4) in the correct position
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set the variant to RFC 4122
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return $data; // Returns binary(16) directly
}

function pridatOdpovedi($odpovedi) {
    global $database;
    $odpovedi_id = generateUUID();

    while ($database->get('Odpovedi', '*', ['id' => $odpovedi_id])) {
        $odpovedi_id = generateUUID();
    }

    $database->insert('Odpovedi', [
        'id' => $odpovedi_id,
        'a' => $odpovedi['a'],
        'b' => $odpovedi['b'],
        'c' => $odpovedi['c'],
        'd' => $odpovedi['d'],
        'spravna' => $odpovedi['spravna']
    ]);

    return $odpovedi_id;
}

function pridatOtazku($otazka, $typ) {
    global $database;
    $otazka_id = generateUUID();
    while ($database->get($typ.'Otazky', '*', ['id' => $otazka_id,])) {
        $otazka_id = generateUUID();
    }
    $database->insert($typ.'Otazky', [
        'id' => $otazka_id,
        $typ => $otazka[$typ],
        'odpovedi' => pridatOdpovedi($otazka['odpovedi'])
    ]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    $textove = $data['textove'];
    $zvuk = $data['zvuk'];
    $video = $data['video'];
    $ilustrace = $data['ilustrace'];

    foreach ($textove as $otazka) {
        pridatOtazku($otazka, "Text");
    }

    foreach ($zvuk as $otazka) {
        pridatOtazku($otazka, "Zvuk");
    }

    foreach ($video as $otazka) {
        pridatOtazku($otazka, "Video");
    }

    foreach ($ilustrace as $otazka) {
        pridatOtazku($otazka, "Ilustrace");
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<p>Pridani otazek</p>
</body>
</html>