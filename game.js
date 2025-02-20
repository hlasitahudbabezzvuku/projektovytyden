let index = 0
let data = {}
let answers = []
let playerFinished = {}

if (localStorage.getItem('answers')) {
  answers = JSON.parse(localStorage.getItem('answers'))
  index = answers.length
}

async function generateQuestions(gameCode) {
  fetch(
    'http://pubz.infinityfreeapp.com/api/generate-questions.php?code=' +
      gameCode
  )
}

async function getQuestions(gameCode) {
  console.log('Fetching questions...')

  try {
    const response = await fetch(
      'http://pubz.infinityfreeapp.com/api/get-questions.php?code=' + gameCode
    )

    if (!response.ok) {
      throw new Error('Failed to fetch questions: ' + response.status)
    }

    data = await response.json()
    console.log('Fetched questions:', data)
  } catch (error) {
    console.error('Error:', error)
    data = null
  }
}

async function checkFinished(gameCode) {
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
  gameInterval = setInterval(checkFinished, 2000, gameCode)
}

async function finishStage(playerId, gameCode) {
  console.log('ahoj')
  fetch(
    'http://pubz.infinityfreeapp.com/api/finish-stage.php?player_id=' +
      playerId +
      '&answers=' +
      encodeURIComponent(JSON.stringify(answers)) +
      '&code=' +
      gameCode
  ).then((response) => {
    window.location.replace('http://pubz.infinityfreeapp.com/stage-end.php')
  })
}

async function printQuestions(gameCode, playerId) {
  await getQuestions(gameCode)

  let div = document.getElementById('question')
  div.innerHTML = ''

  if (!data || !Array.isArray(data) || data.length === 0) {
    div.innerText = 'No questions available.'
    return
  }

  let p = document.createElement('p')
  p.innerText = data[index].otazka
  div.append(p)

  for (const [key, value] of Object.entries(data[index]['odpovedi'])) {
    let btnContainer = document.createElement('div')
    let button = document.createElement('button')
    button.innerText = value
    button.onclick = () => nextQuestion(gameCode, playerId, key)
    btnContainer.appendChild(button)
    div.appendChild(btnContainer)
  }
}

async function nextQuestion(gameCode, playerId, value) {
  answers.push(value)
  localStorage.setItem('answers', JSON.stringify(answers))
  console.log('answers: ' + answers)

  index++
  if (index > data.length - 1) {
    localStorage.removeItem('answers')
    finishStage(playerId, gameCode)
  } else {
    printQuestions(gameCode, playerId)
  }
}

async function addStage(gameCode) {
  fetch('http://pubz.infinityfreeapp.com/api/add-stage.php?code=' + gameCode)
}

async function startGame(gameCode) {
  addStage(gameCode)
  generateQuestions(gameCode)
  window.location.replace(
    'http://pubz.infinityfreeapp.com/monitor.php?id=' + gameCode
  )
}

async function nextStage(gameCode) {
  addStage(gameCode)
  generateQuestions(gameCode)
  resetStage(gameCode)
}

async function getFinishedPlayers(gameCode) {
  fetch(
    'http://pubz.infinityfreeapp.com/api/get-finished-players.php?code=' +
      gameCode
  ).then((response) => {
    console.log(response.json())
  })
}
