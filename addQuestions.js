const data = {
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

function add() {
    $.ajax({
        url: 'http://pubz.infinityfreeapp.com/add-questions.php',
        type: 'POST',
        data: data,
        success: function(response) {
            console.log("Otazky pridany")
        }
    })
}

add();
