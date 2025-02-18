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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    print_r($_POST);
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    $textove = $data['textove'];
    $zvuk = $data['zvuk'];
    $video = $data['video'];
    $ilustrace = $data['ilustrace'];

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
}
?>

<!doctype html>
<html lang="cz">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const otazky = {
            "textove": {
                "0": {
                    "text": "What is the capital of France?",
                    "odpovedi": {
                        "a": "Berlin",
                        "b": "Madrid",
                        "c": "Paris",
                        "d": "Rome",
                        "spravna": "c"
                    }
                },
                "1": {
                    "text": "What is 2 + 2?",
                    "odpovedi": {
                        "a": "3",
                        "b": "4",
                        "c": "5",
                        "d": "6",
                        "spravna": "b"
                    }
                },
                "2": {
                    "text": "Who wrote '1984'?",
                    "odpovedi": {
                        "a": "George Orwell",
                        "b": "J.K. Rowling",
                        "c": "Aldous Huxley",
                        "d": "F. Scott Fitzgerald",
                        "spravna": "a"
                    }
                },
                "3": {
                    "text": "What is the largest planet in our solar system?",
                    "odpovedi": {
                        "a": "Earth",
                        "b": "Jupiter",
                        "c": "Saturn",
                        "d": "Mars",
                        "spravna": "b"
                    }
                },
                "4": {
                    "text": "What is the chemical symbol for water?",
                    "odpovedi": {
                        "a": "H2O",
                        "b": "CO2",
                        "c": "O2",
                        "d": "H2",
                        "spravna": "a"
                    }
                }
            },
            "video": {
                "0": {
                    "video": "https://example.com/video1.mp4",
                    "odpovedi": {
                        "a": "Python",
                        "b": "JavaScript",
                        "c": "C++",
                        "d": "Java",
                        "spravna": "b"
                    }
                },
                "1": {
                    "video": "https://example.com/video2.mp4",
                    "odpovedi": {
                        "a": "Ruby",
                        "b": "Swift",
                        "c": "Java",
                        "d": "PHP",
                        "spravna": "c"
                    }
                },
                "2": {
                    "video": "https://example.com/video3.mp4",
                    "odpovedi": {
                        "a": "Go",
                        "b": "Python",
                        "c": "C#",
                        "d": "Kotlin",
                        "spravna": "a"
                    }
                },
                "3": {
                    "video": "https://example.com/video4.mp4",
                    "odpovedi": {
                        "a": "Rust",
                        "b": "Node.js",
                        "c": "Dart",
                        "d": "Scala",
                        "spravna": "b"
                    }
                },
                "4": {
                    "video": "https://example.com/video5.mp4",
                    "odpovedi": {
                        "a": "HTML",
                        "b": "CSS",
                        "c": "JavaScript",
                        "d": "PHP",
                        "spravna": "d"
                    }
                }
            },
            "zvuk": {
                "0": {
                    "zvuk": "https://example.com/audio1.mp3",
                    "odpovedi": {
                        "a": "Lions",
                        "b": "Tigers",
                        "c": "Bears",
                        "d": "Wolves",
                        "spravna": "a"
                    }
                },
                "1": {
                    "zvuk": "https://example.com/audio2.mp3",
                    "odpovedi": {
                        "a": "Elephants",
                        "b": "Lions",
                        "c": "Monkeys",
                        "d": "Giraffes",
                        "spravna": "b"
                    }
                },
                "2": {
                    "zvuk": "https://example.com/audio3.mp3",
                    "odpovedi": {
                        "a": "Owls",
                        "b": "Hawks",
                        "c": "Pigeons",
                        "d": "Eagles",
                        "spravna": "d"
                    }
                },
                "3": {
                    "zvuk": "https://example.com/audio4.mp3",
                    "odpovedi": {
                        "a": "Frogs",
                        "b": "Toads",
                        "c": "Snakes",
                        "d": "Crocodiles",
                        "spravna": "a"
                    }
                },
                "4": {
                    "zvuk": "https://example.com/audio5.mp3",
                    "odpovedi": {
                        "a": "Cats",
                        "b": "Dogs",
                        "c": "Birds",
                        "d": "Rats",
                        "spravna": "b"
                    }
                }
            },
            "ilustrace": {
                "0": {
                    "ilustrace": "https://example.com/image1.jpg",
                    "odpovedi": {
                        "a": "A dog",
                        "b": "A cat",
                        "c": "A rabbit",
                        "d": "A horse",
                        "spravna": "b"
                    }
                },
                "1": {
                    "ilustrace": "https://example.com/image2.jpg",
                    "odpovedi": {
                        "a": "A lion",
                        "b": "A giraffe",
                        "c": "A zebra",
                        "d": "A tiger",
                        "spravna": "a"
                    }
                },
                "2": {
                    "ilustrace": "https://example.com/image3.jpg",
                    "odpovedi": {
                        "a": "A bird",
                        "b": "A fish",
                        "c": "A dog",
                        "d": "A cat",
                        "spravna": "c"
                    }
                },
                "3": {
                    "ilustrace": "https://example.com/image4.jpg",
                    "odpovedi": {
                        "a": "A dolphin",
                        "b": "A whale",
                        "c": "A shark",
                        "d": "A seal",
                        "spravna": "b"
                    }
                },
                "4": {
                    "ilustrace": "https://example.com/image5.jpg",
                    "odpovedi": {
                        "a": "A mouse",
                        "b": "A rat",
                        "c": "A bat",
                        "d": "A rabbit",
                        "spravna": "d"
                    }
                }
            }
        };
        function addQuestion() {
            $.ajax({
                url: 'add-questions.php',
                type: 'POST',
                contentType: 'application/json', // Specify JSON content type
                dataType: 'json',                // Expect JSON response
                data: JSON.stringify(otazky),    // Send JSON data
                success: function(response) {
                    console.log("Success:", response);
                },
                error: function(xhr, status, error) {
                    console.log("AJAX Error:", status, error);
                    console.log("Response Text:", xhr.responseText); // Logs server error response
                }
            });
        }
        addQuestion()
    </script>
</head>
<body>
<p>Pridani otazek</p>
</body>
</html>