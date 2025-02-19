<?php

require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
require $_SERVER["DOCUMENT_ROOT"] . "/utils/uuid.php";

function pridatOdpovedi($odpovedi) {
  global $database;
  $odpovedi_id = uuidb();

  while ($database->get("Odpovedi", "*", ["id" => $odpovedi_id])) {
    $odpovedi_id = uuidb();
  }

  $database->insert("Odpovedi", [
    "id" => $odpovedi_id,
    "a" => $odpovedi["a"],
    "b" => $odpovedi["b"],
    "c" => $odpovedi["c"],
    "d" => $odpovedi["d"],
    "spravna" => $odpovedi["spravna"]
  ]);

  return $odpovedi_id;
}

function pridatOtazku($otazka, $typ) {
  global $database;
  $otazka_id = uuidb();
  while ($database->get($typ."Otazky", "*", ["id" => $otazka_id,])) {
    $otazka_id = uuidb();
  }
  $database->insert("Otazky", ["id" => $otazka_id, "type" => $typ, "id_odpovedi" => pridatOdpovedi($otazka['odpovedi'])]);
  $database->insert($typ."Otazky", [
    "id" => $otazka_id,
    $typ => $otazka[$typ]
  ]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  echo json_encode(["success" => "Questions added successfully"]);

  $json_data = file_get_contents("php://input");
  $data = json_decode($json_data, true);

  $textove = $data["textove"];
  $zvuk = $data["zvuk"];
  $video = $data["video"];
  $ilustrace = $data["ilustrace"];

  foreach ($textove as $otazka) {
    pridatOtazku($otazka, "text");
  }

  foreach ($zvuk as $otazka) {
    pridatOtazku($otazka, "zvuk");
  }

  foreach ($video as $otazka) {
    pridatOtazku($otazka, "video");
  }

  foreach ($ilustrace as $otazka) {
    pridatOtazku($otazka, "ilustrace");
  }
  exit();
}

?>

<!doctype html>
<html lang="cz">
  <head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../addQuestions.js"></script>
  </head>
  <body>
    <button onclick="addQuestion()">Pridat otazky</button>
  </body>
</html>
