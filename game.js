async function generateQuestions(gameCode) {
  const formData = new FormData()
  formData.append('generate', 'true')
  formData.append('code', gameCode)

  fetch('http://pubz.infinityfreeapp.com/api/get-questions.php', {
    method: 'POST',
    body: formData
  })
}

data = {}

async function getQuestions(gameCode) {
  const formData = new FormData()
  formData.append('getJSON', 'true')
  formData.append('code', gameCode)
  fetch('http://pubz.infinityfreeapp.com/api/get-questions.php', {
    method: 'POST',
    body: formData
  })
    .then((response) => response.json()) // Parse the JSON response
    .then((responseData) => {
      // Store the response in a variable
      data = responseData // This will log the response to the console
      // You can now use responseData as needed in your application
    })
    .catch((error) => {
      console.error('Error:', error) // Handle any errors
    })
}

async function getFinished(gameCode) {
  const formData = new FormData()
  formData.append('getFinished', 'true')
  formData.append('code', gameCode)
  fetch('http://pubz.infinityfreeapp.com/api/get-questions.php', {
    method: 'POST',
    body: formData
  })
    .then((response) => response.json())
    .then((responseData) => {
      console.log(responseData)
    })
    .catch((error) => {
      console.error('Error:', error) // Handle any errors
    })
}

console.log(data)
