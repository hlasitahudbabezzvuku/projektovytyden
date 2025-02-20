let currentQuestionIndex = 0
let questions = {}
let answers = []
let playerFinished = {}
let buttons = document.querySelectorAll('.answer-button')
let currentCategoryIndex = 0
// let totalScore = 0
// let categoryScore = 0

if (localStorage.getItem('answers')) {
  answers = JSON.parse(localStorage.getItem('answers'))
  currentQuestionIndex = answers.length
}

async function generateQuestions(gameCode) {
  await fetch(
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

    questions = await response.json()

    let stageResponse = await fetch(
      'http://pubz.infinityfreeapp.com/api/get-stage.php?game=' + gameCode
    )
    let stage = await stageResponse.text()
    console.log('Stage: ' + stage)

    switch (stage) {
      case '1':
        currentCategoryIndex = 0
        break
      case '3':
        currentCategoryIndex = 1
        break
      case '5':
        currentCategoryIndex = 2
        break
      case '7':
        currentCategoryIndex = 3
        break
    }
  } catch (error) {
    console.error('Error:', error)
    questions = null
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
  await fetch(
    'http://pubz.infinityfreeapp.com/api/reset-stage.php?code=' + gameCode
  )
  gameInterval = setInterval(checkFinished, 2000, gameCode)
}

async function finishStage(playerId, gameCode) {
  await fetch(
    'http://pubz.infinityfreeapp.com/api/finish-stage.php?player_id=' + playerId
  )

  let response = await fetch(
    'http://pubz.infinityfreeapp.com/api/get-stage.php?game=' + gameCode
  )
  let stage = await response.text()
  console.log('Stage: ' + stage)

  if (stage == '7') {
    await fetch(
      'http://pubz.infinityfreeapp.com/api/update-leaderboard.php/player_id=' +
        playerId
    )
    window.location.replace('http://pubz.infinityfreeapp.com/end.php')
  } else {
    window.location.replace('http://pubz.infinityfreeapp.com/stage-end.php')
  }
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
  p.innerText = questions[currentQuestionIndex].otazka
  div.append(p)

  for (const [key, value] of Object.entries(data[index]['odpovedi'])) {
    let btnContainer = document.createElement('div')
    let button = document.createElement('button')
    button.innerText = value
    button.onclick = () => nextQuestion(gameCode, playerId, key)
    buttons.push(button)
    btnContainer.appendChild(button)
    div.appendChild(btnContainer)
  }
}

async function nextQuestion(gameCode, playerId, value) {
  buttons.forEach((button) => {
    button.disabled = true
  })

  answers.push(value)
  localStorage.setItem('answers', JSON.stringify(answers))
  console.log('answers: ' + answers)

  currentQuestionIndex++
  if (currentQuestionIndex > questions.length - 1) {
    finishStage(playerId, gameCode)
  } else {
    loadQuestion(gameCode, playerId)
  }
}

async function addStage(gameCode) {
  await fetch(
    'http://pubz.infinityfreeapp.com/api/add-stage.php?code=' + gameCode
  )
}

async function startGame(gameCode) {
  await addStage(gameCode)
  await generateQuestions(gameCode)
  window.location.replace(
    'http://pubz.infinityfreeapp.com/monitor.php?id=' + gameCode
  )
}

async function nextStage(gameCode) {
  await addStage(gameCode)
  await generateQuestions(gameCode)
  await resetStage(gameCode)
}

async function getFinishedPlayers(gameCode) {
  fetch(
    'http://pubz.infinityfreeapp.com/api/get-finished-players.php?code=' +
      gameCode
  )
    .then((response) => response.json())
    .then((responseData) => {
      console.log(responseData)

      let div = document.getElementById('score-board')

      div.innerHTML = ''

      responseData.forEach((player) => {
        let btnContainer = document.createElement('div')
        let name = document.createElement('p')
        let score = document.createElement('p')

        name.innerText = player.name
        score.innerText = player.score

        btnContainer.appendChild(name)
        btnContainer.appendChild(score)
        div.appendChild(btnContainer)
      })
    })
}

async function getResult(playerId, gameCode) {
  let resultList = document.getElementById('results-list')

  fetch(
    'http://pubz.infinityfreeapp.com/api/get-correct-answers.php?player_id=' +
      playerId +
      '&answers=' +
      encodeURIComponent(JSON.stringify(answers)) +
      '&code=' +
      gameCode
  )
    .then((response) => response.text())
    .then((response) => console.log(response))

  // let results = response.json()

  // console.log(results)

  if (localStorage.getItem('answers')) localStorage.removeItem('answers')
}

// NOVY
//jsony s kategoriema + v nich otázky === jen pro vyplnění (smazat)
const categories = ['Text', 'Zvuk', 'Video', 'Obrázek']
let audio
let playPauseBtn
let audioTimeline
//promenne pro rozeznavani kategorii a skore

//funkce pro loadovani otazek
async function loadQuestion(gameCode, playerId, home) {
  const categories = ['Text', 'Zvuk', 'Video', 'Obrázek']
  await getQuestions(gameCode)
  // if (currentCategoryIndex >= categories.length) {
  //   //kdyz se odpovi vsechny otazky (hrac dokonci posledni kategorii)
  //   console.log('kviz dokoncen!!')
  //   //ZDE DEJ KOD PRO PRESMEROVANI NA FINALNI STRANKU S TABULKOU
  // }
  // const currentCatQuestions = questions[categories[currentCategoryIndex]].length
  // if (currentQuestionIndex >= currentCatQuestions) {
  //   //pokud podminka true => zmena kategorie
  //   totalScore += categoryScore
  //   currentQuestionIndex = 0
  //   categoryScore = 0
  //   currentCategoryIndex++
  //   loadQuestion()
  //   return
  // }
  //ZMENA MEDIAPLACEHOLDERU (tam kde se dava bud text, zvuk, yt nebo ilustrace) podle toho jaka kategorie je aktualni
  const mediaPlaceholder = document.querySelector('.media-placeholder')
  if (categories[currentCategoryIndex] === 'Text') {
    mediaPlaceholder.style.display = 'none'
  } else {
    mediaPlaceholder.style.display = 'flex'
    mediaPlaceholder.style.opacity = 0
    setTimeout(() => {
      if (categories[currentCategoryIndex] === 'Zvuk') {
        mediaPlaceholder.style.height = '80px'
        mediaPlaceholder.innerHTML =
          '<audio ontimeupdate="changeTimeLine()" id="myAudio" src="' +
          questions[currentQuestionIndex].zvuk +
          '" preload="auto"></audio><input type="range" id="audioTimeline" oninput="acceptInput()" value="0" step="1" style="width: 100%; margin-top: 10px;"><button id="playPauseBtn" onclick="togglePlayPause()">Play</button>'
        audio = document.getElementById('myAudio')
        playPauseBtn = document.getElementById('playPauseBtn')
        audioTimeline = document.getElementById('audioTimeline')
      } else if (categories[currentCategoryIndex] === 'Video') {
        mediaPlaceholder.style.height = '300px'
        mediaPlaceholder.innerHTML =
          '<iframe width="100%" height="100%" src="' +
          questions[currentQuestionIndex].video +
          '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="rounded-lg"></iframe>'
      } else if (categories[currentCategoryIndex] === 'Obrázek') {
        mediaPlaceholder.style.height = '300px'
        mediaPlaceholder.innerHTML =
          '<img src="' +
          questions[currentQuestionIndex].ilustrace +
          '" alt="Obrázek" class="w-full h-full object-cover rounded-lg">'
      }
      mediaPlaceholder.style.opacity = 1
    }, 500)
  }

  // //aktualizovani stavu kolecek (ikonek kategorii nahore na strance)
  const circles = document.querySelectorAll('.circle')
  circles.forEach((circle, index) => {
    if (index === currentCategoryIndex) {
      circle.classList.add('bg-yellow-500')
    } else {
      circle.classList.remove('bg-yellow-500')
    }
  })
  // const category = categories[currentCategoryIndex]
  // const questionData = questions[category][currentQuestionIndex]
  const questionBox = document.querySelector('.question-box')
  questionBox.style.opacity = 0
  setTimeout(() => {
    questionBox.textContent = questions[currentQuestionIndex].otazka
    questionBox.style.opacity = 1
  }, 300)
  console.log('Load otazky: ' + JSON.stringify(questions))

  buttons.forEach((btn, index) => {
    btn.disabled = false
    btn.textContent = `${
      Object.keys(questions[currentQuestionIndex].odpovedi)[index]
    }) ${
      questions[currentQuestionIndex].odpovedi[
        Object.keys(questions[currentQuestionIndex].odpovedi)[index]
      ]
    }`
    btn.onclick = () => {
      nextQuestion(
        gameCode,
        playerId,
        Object.keys(questions[currentQuestionIndex]['odpovedi'])[index]
      )
    }
  })
  // document.querySelector('.feedback').textContent = ''
  // document.querySelector('.feedback').style.color = '#ffffff'
}

// //funkce pro kontrolu odpovedi
// function checkAnswer(selectedIndex) {
//   const category = categories[currentCategoryIndex]
//   const questionData = questions[category][currentQuestionIndex]
//   const buttons = document.querySelectorAll('.answer-button')
//   buttons.forEach((btn) => (btn.onclick = null))
//   if (selectedIndex === questionData.correct) {
//     categoryScore++
//   }
//   currentQuestionIndex++
//   loadQuestion()
// }

// document.getElementById('menuBtn').addEventListener('click', () => {
//   window.location.href = 'index.html'
// })

function changeTimeLine() {
  const progress = (audio.currentTime / audio.duration) * 100
  audioTimeline.value = progress
}

// Update audio time when the timeline is clicked
function acceptInput() {
  const newTime = (audioTimeline.value / 100) * audio.duration
  audio.currentTime = newTime
}

// Toggle Play/Pause button functionality
function togglePlayPause() {
  if (audio.paused) {
    audio.play()
    playPauseBtn.textContent = 'Pause'
  } else {
    audio.pause()
    playPauseBtn.textContent = 'Play'
  }
}
