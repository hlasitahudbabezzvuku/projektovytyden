async function generateQuestions(gameCode) {
  fetch(
    'http://pubz.infinityfreeapp.com/api/get-questions.php?code=' + gameCode
  )
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
    window.location.replace(
      'http://pubz.infinityfreeapp.com/monitor.php?continue=true'
    )
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

async function finishStage(playerId) {
  fetch(
    'http://pubz.infinityfreeapp.com/api/finish-stage.php?player_id=' + playerId
  )
}

console.log(data)
