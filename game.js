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
    .then((response) => response.json())
    .then((responseData) => {
      data = responseData
    })
    .catch((error) => {
      console.error('Error:', error)
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
    .then((responseData) => console.log(responseData))
}

const finish = document.getElementById('finish')

async function finishStage(playerId, gameCode) {
  const formData = new FormData()
  formData.append('finishStage', playerId)
  formData.append('code', gameCode)
  fetch('http://pubz.infinityfreeapp.com/api/get-questions.php', {
    method: 'POST',
    body: formData
  })
}

console.log(data)
