async function generateQuestions(gameCode) {
  const formData = new FormData()
  formData.append('generate', 'true')
  formData.append('code', gameCode)

  fetch('http://pubz.infinityfreeapp.com/api/get-questions.php', {
    method: 'POST',
    body: formData
  })
}

let data = {}
let playerFinished = {}

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
    .then((responseData) => {
      playerFinished = responseData
    })

  if (playerFinished.allFinished === true) {
    resetStage(gameCode)
  }
}

async function resetStage(gameCode) {
  const formData = new FormData()
  formData.append('code', gameCode)
  formData.append('resetStage', 'true')
  fetch('http://pubz.infinityfreeapp.com/api/get-question.php', {
    method: 'POST',
    body: formData
  })
}

async function finishStage(playerId, gameCode) {
  console.log(playerId, gameCode)

  const formData = new FormData()
  formData.append('finishStage', playerId)
  formData.append('code', gameCode)
  fetch('http://pubz.infinityfreeapp.com/api/get-questions.php', {
    method: 'POST',
    body: formData
  })
}

console.log(data)
