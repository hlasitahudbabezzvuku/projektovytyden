async function generateQuestions() {
    const formData = new FormData()
    formData.append('generate', 'true')

    fetch('http://pubz.infinityfreeapp.com/api/get-questions.php', {
        method: 'POST',
        body: formData
    })
}

generateQuestions()
