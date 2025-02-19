async function generateQuestions() {
    const formData = new FormData()
    formData.append('generate', 'true')

    fetch('http://pubz.infinityfreeapp.com/api/get-questions.php', {
        method: 'POST',
        body: formData
    })
}

data = {}

async function getQuestions() {
    const formData = new FormData()
    formData.append('getJSON', 'true')
    data = fetch('http://pubz.infinityfreeapp.com/api/get-questions.php', {
        method: 'POST',
        body: formData
    })
}

generateQuestions()
getQuestions()

console.log(data)
