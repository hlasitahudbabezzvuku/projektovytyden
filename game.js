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
    fetch('http://pubz.infinityfreeapp.com/api/get-questions.php', {
        method: 'POST',
        body: formData
    })
        .then((response) => response.json()) // Parse the JSON response
        .then((data) => {
            // Store the response in a variable
            const responseData = data
            console.log(responseData) // This will log the response to the console
            // You can now use responseData as needed in your application
        })
        .catch((error) => {
            console.error('Error:', error) // Handle any errors
        })
}

generateQuestions()

console.log(data)
