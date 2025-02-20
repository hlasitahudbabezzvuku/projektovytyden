async function generateQuestions(gameCode) {
  fetch(
    'http://pubz.infinityfreeapp.com/api/get-questions.php?code=' + gameCode
  )
}

let index = 0
let data = {}
let playerFinished = {}

async function getQuestions(gameCode) {
  console.log('ahoj')
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
  fetch(
    'http://pubz.infinityfreeapp.com/api/check-if-all-finished.php?code=' +
      gameCode
  )
    .then((response) => response.json())
    .then((response) => {
      if (response.allFinished === true) {
        document.getElementById('continue-button').disabled = false
        addStage(gameCode)
        clearInterval(gameInterval)
      } else {
        document.getElementById('continue-button').disabled = true
      }
    })
}

async function resetStage(gameCode) {
  fetch('http://pubz.infinityfreeapp.com/api/reset-stage.php?code=' + gameCode)
  gameInterval = setInterval(getFinished, 2000, gameCode)
}

async function finishStage(playerId) {
  fetch(
    'http://pubz.infinityfreeapp.com/api/finish-stage.php?player_id=' + playerId
  ).then((response) => {
    window.location.replace('http://pubz.infinityfreeapp.com/stage-end.php')
  })
}

function printQuestions() {
  getQuestions().then(() => {
    document.getElementById('question').innerHTML = ''
    let div = document.getElementById('question')
    div.append(document.createElement('p').innerText(data[index].otazka))

    data[index]['odpovedi'].forEach((element) => {
      div.append(
        document
          .createElement('div')
          .append(document.createElement('button').innerText(element))
      )
    })
  })
}

async function addStage(gameCode) {
  fetch('http://pubz.infinityfreeapp.com/api/add-stage.php?code=' + gameCode)
}

console.log(data)
