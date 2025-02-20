let index = 0
let data = {}
let answers = []
let playerFinished = {}

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

    data = await response.json() // Parse response as JSON
    console.log('Fetched questions:', data)
  } catch (error) {
    console.error('Error:', error)
    data = null // Reset data if the request fails
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

async function finishStage(playerId) {
  console.log('ahoj')
  fetch(
    'http://pubz.infinityfreeapp.com/api/finish-stage.php?player_id=' + playerId
  ).then((response) => {
    window.location.replace('http://pubz.infinityfreeapp.com/stage-end.php')
  })
}

async function printQuestions(gameCode, playerId) {
  await getQuestions(gameCode) // Wait for data to load

  let div = document.getElementById('question')
  div.innerHTML = '' // Clear previous content

  if (!data || !Array.isArray(data) || data.length === 0) {
    div.innerText = 'No questions available.'
    return
  }

  console.log('Displaying question:', data[index])

  // Add question text
  let p = document.createElement('p')
  p.innerText = data[index].otazka // Use "text" instead of "otazka"
  div.append(p)

  // Loop through odpovedi (answers)
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
  answers += value
  index++
  if (index > data.length - 1) {
    console.log(playerId)

    // finishStage(playerId)
  }

  printQuestions(gameCode)
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
  printQuestions(gameCode)
}

async function nextStage(gameCode) {
  addStage(gameCode)
  generateQuestions(gameCode)
  resetStage(gameCode)
}
