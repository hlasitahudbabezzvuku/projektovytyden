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
      return JSON.parse(responseData)
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

async function printQuestions(gameCode) {
  data = await getQuestions(gameCode) // Wait for data to load

  let div = document.getElementById('question')
  div.innerHTML = '' // Clear previous content
  console.log(data)

  if (!data || !data[index]) {
    div.innerText = 'No questions available.'
    return
  }

  // Add question text
  let p = document.createElement('p')
  p.innerText = data[index].text // Use "text" instead of "otazka"
  div.append(p)

  // Loop through odpovedi (answers)
  Object.entries(data[index]['odpovedi']).forEach(([key, value]) => {
    let btnContainer = document.createElement('div')
    let button = document.createElement('button')
    button.innerText = value
    button.dataset.answer = key // Store the answer key (optional)
    btnContainer.append(button)
    div.append(btnContainer)
  })
}

async function addStage(gameCode) {
  fetch('http://pubz.infinityfreeapp.com/api/add-stage.php?code=' + gameCode)
}

console.log(data)
