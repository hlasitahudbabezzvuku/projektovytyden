async function generateQuestions(gameCode) {
  fetch(
    'http://pubz.infinityfreeapp.com/api/get-questions.php?code=' + gameCode
  )
}

let data = {}
let playerFinished = {}

async function getQuestions(gameCode) {
  fetch(
    'http://pubz.infinityfreeapp.com/api/get-questions.php?code=' + gameCode
  )
    .then((response) => response.text())
    .then((responseData) => {
      data = JSON.parse(responseData)
      console.log(data)
    })
    .catch((error) => {
      console.error('Error:', error)
    })
}

async function getFinished(gameCode) {
  const formData = new FormData()
  formData.append('getFinished', 'true')
  formData.append('code', gameCode)
  fetch(
    'http://pubz.infinityfreeapp.com/api/check-if-all-finished.php?code=' +
      gameCode
  )
    .then((response) => response.json())
    .then((responseData) => {
      playerFinished = responseData
      console.log(playerFinished)
    })
    .then(() => {
      if (playerFinished.allFinished === true) {
        document.getElementById('continue-button').disabled = false
      }
    })
}

async function resetStage(gameCode) {
  fetch('http://pubz.infinityfreeapp.com/api/reset-stage.php?code=' + gameCode)
}

async function finishStage(playerId) {
  fetch(
    'http://pubz.infinityfreeapp.com/api/finish-stage.php?player_id=' + playerId
  )
}

async function addStage(gameCode) {
  fetch('http://pubz.infinityfreeapp.com/api/add-stage.php?code=' + gameCode)
}

console.log(data)
