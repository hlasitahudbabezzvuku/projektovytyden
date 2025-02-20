<?php

require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
global $database;

$data = $database->select("Players", "name", [
	"game" => $_GET["game"]
]);

if (count($data) > 0) {
  echo("");
  foreach($data as $item) {
    echo("<li class=\"flex items-center p-2 bg-gray-100 rounded shadow hover:bg-gray-200 transition-colors text-gray-900\">" .
      "<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-5 w-5 text-gray-600 mr-2\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">" .
      "<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.802.647 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z\"/>" .
      "</svg>" .
      "<span>" . $item . "</span>" .
      "</li>"
    );
  }
} else {
  echo("<li class=\"flex items-center p-2 bg-gray-100 rounded shadow hover:bg-gray-200 transition-colors text-gray-900\">" .
    "<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-5 w-5 text-gray-600 mr-2\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">" .
    "<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.802.647 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z\"/>" .
    "</svg>" .
    "<span>Žádní hráči nejsou připojeni.</span>" .
    "</li>"
  );
}

?>
