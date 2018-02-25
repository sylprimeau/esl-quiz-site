/*

Three ways to handle the AJAX problem (so far)
1) called a full AJAX twice (or whenever you need it)
2) pass a function to the ajax that you want executed
3) use a wait screen (disable the div while waiting)

*/

var quizScore = 0;
var quizNum = 1;
var problemIndex = 0;
var userAnswers = [];
var quiz;
var completed = 0;
var completedQuizIds = [];
var level = 1;
var categories = ["Vocabulary"];

init();

function init() {
	console.log("init invoked");
	setListeners();
	// refactor this so that level1 is selected programmatically onload
	// pre-select "level 1" button
	levelBtn = document.querySelectorAll(".level-btn");
	levelBtn[0].classList.toggle("selected");
	// pre-select all categories
	var catBtn = document.querySelectorAll(".category-btn");
	catBtn[0].classList.toggle("selected");
}

function setListeners() {
	console.log("setListeners invoked");
	// click filters button to show filter options box
	var filtersBtn = document.querySelector(".filters-btn");
	filtersBtn.addEventListener("click", function(e) {
		e.stopPropagation();
		document.querySelector(".filters-box").classList.toggle("hide");
	});
	// click X to close filters options box
	var filtersBoxX = document.querySelector(".filters-box .x-close");
	filtersBoxX.addEventListener("click", function(e) {
		e.stopPropagation();
		document.querySelector(".filters-box").classList.toggle("hide");
	});
	// click to select a category
	var catButton = document.querySelectorAll(".category-btn");
	for (var i = 0; i < catButton.length; i++) {
		catBtnListeners(i, catButton)
	}
	// click to select a level
	var levelButton = document.querySelectorAll(".level-btn");
	for (var i = 0; i < levelButton.length; i++) {
		levelBtnListeners(i, levelButton);
	}
	var answerButton = document.querySelectorAll(".answerButton");
	for (var index = 0; index < answerButton.length; index++) {
		AnsBtnListeners(index, answerButton);
	}
	var quizReviewDiv = document.querySelector(".quizReview");
	quizReviewDiv.addEventListener("click", function() {
		quizReviewDiv.classList.toggle("hide");
	});
	var star = document.querySelectorAll(".ratingStar");
	for (var i = 0; i < star.length; i++) {
		setRating(i, star);
	}
	var startButton = document.querySelector(".start-button");
	startButton.addEventListener("click", function() {
		document.querySelector(".quiz-list").classList.toggle("hide");
		document.querySelector("#problem").style.display = "block";
		getQuiz();
	})
}

function catBtnListeners(index, catButton) {
	catButton[index].addEventListener("click", function() {
		if (problemIndex > 0) { // prevent changing categories mid-quiz
			return;
		} else {
			// if category exists in array, remove it
			if (categories.includes(catButton[index].innerHTML) === true) {
				// must have minimum 1 category in array
				if (categories.length < 2) {
					return;
				}
				catButton[index].classList.toggle("selected");
				var position = categories.indexOf(catButton[index].innerHTML);
				categories.splice(position, 1);
			} else {
			// if cat doesn't exist, add it
				catButton[index].classList.toggle("selected");
				categories.push(catButton[index].innerHTML);
			}
		}
		console.log("Categories are: " + categories);
	});
}

function levelBtnListeners(index, levelButton) {
	levelButton[index].addEventListener("click", function() {
		if (problemIndex > 0) { // prevent changing levels mid-quiz
			return;
		} else {
			console.log("level selected");
			toggleLevelBtnColor(index, levelButton);
			level = index + 1;
			completed = 0;
		}
	});
}

function AnsBtnListeners(index, answerButton) {
	answerButton[index].addEventListener("click", function() {
		console.log("You clicked answer button " + index);
		recordAnswer(index);
		if (problemIndex === quiz.problems.length - 1) {
			calcScore();
			nextQuiz();
		} else {
			nextQuestion();
		}
	});	
}

function clearScreen() {
	var answers = document.querySelectorAll(".answerText");
	for (var i = 0; i < answers.length; i++) {
		answers[i].innerHTML = "";
	}
	document.querySelector(".questionText").innerHTML = "";
	document.querySelector("#questionNumber").innerHTML = "";
}

function showRating() {
	console.log("showRating called");
	clearYellowStars();
	var star = document.querySelectorAll(".ratingStar");
	if (quiz.rating > 0) {
		for (var i = 0; i < Math.floor(quiz.rating); i++) {
			star[i].style.backgroundImage = "url('images/star-icon-yellow.png')";
		}
		if ((quiz.rating - Math.floor(quiz.rating)) >= 0.4) {
			star[i].style.backgroundImage = "url('images/half-star-icon-yellow.png')";
		}
		if ((quiz.rating - Math.floor(quiz.rating)) >= 0.7) {
			star[i].style.backgroundImage = "url('images/star-icon-yellow.png')";
		}
	}
}

function displayProblem() {
	document.querySelector(".categoryDiv").innerHTML = quiz.category;
	document.getElementById("questionNumber").innerHTML = "This is question " + (Number(problemIndex) + 1) + " of " + quiz.problems.length;
	document.querySelector(".questionText").innerHTML = quiz.problems[problemIndex].question;
	var answer = document.querySelectorAll(".answerText");
	answer.forEach(function(elem, index) {
		elem.innerHTML = quiz.problems[problemIndex].answers[index];
	});
	if (quiz.timesTaken === 1) {
		document.querySelector("#timesTaken").innerHTML = quiz.timesTaken + " person has taken this quiz so far!";
	} else {
		document.querySelector("#timesTaken").innerHTML = quiz.timesTaken + " people have taken this quiz so far!";
	}
	document.querySelector("#avgScore").innerHTML = "The average score for this quiz is " + quiz.avgScore + "/" + quiz.problems.length;
	showRating();
	var mediaContainer = document.getElementById("mediaContainer");
	if (quiz.problems[problemIndex].picUrl) {
		mediaContainer.innerHTML = "<img src='" + quiz.problems[problemIndex].picUrl + "' height='100px'>";
	} else if (quiz.problems[problemIndex].audUrl) {
		mediaContainer.innerHTML = "<audio controls><source src='" + quiz.problems[problemIndex].audUrl + "' type='audio/mpeg'>";
	} else if (quiz.problems[problemIndex].vidUrl) {
		mediaContainer.innerHTML = quiz.problems[problemIndex].vidUrl;
	} else {
		mediaContainer.innerHTML = "";
	}
}

function reviewQuiz(quizScore, total) {
	var text = "";
	document.querySelector(".quizReview").innerHTML = "";
	createReviewScreen();
	completed += 1;
	var quizText = "quizzes";
	if (completed === 1) {
		quizText = "quiz";
	}
	var percent = Math.round(quizScore/total * 100);
	if (percent >= 90) {
		text += "Outstanding! Your score was " + quizScore + " out of " + total + ".<br>You scored " + percent + "%!<br>You have completed " + completed + " " + quizText + " in this level so far!";
	} else if (percent >= 70) {
		text += "Very good! Your score was " + quizScore + " out of " + total + ".<br>You scored " + percent + "%!<br>You have completed " + completed + " " + quizText + " in this level so far!";
	} else if (percent >= 50) {
		text += "Doing pretty good! Your score was " + quizScore + " out of " + total + ".<br>You scored " + percent + "%!<br>You have completed " + completed + " " + quizText + " in this level so far!";
	} else if (percent >= 30) {
		text += "Keep trying. You'll get there! Your score was " + quizScore + " out of " + total + ".<br>You scored " + percent + "%!<br>You have completed " + completed + " " + quizText + " in this level so far!";
	} else {	
		text += "Oh no! Maybe try one level lower? Your score was " + quizScore + " out of " + total + ".<br>You scored " + percent + "%!<br>You have completed " + completed + " " + quizText + " in this level so far!";
	}
	document.querySelector(".quizReview").classList.toggle("hide");
	document.querySelector("#scoreDiv").innerHTML = text;

	for (var i = 0; i < quiz.problems.length; i++) {
		if (userAnswers[i] === quiz.problems[i].correctAns) {
			document.querySelector("#checkOrXDiv" + i).setAttribute("src", "images/check.png");
		} else {
			document.querySelector("#checkOrXDiv" + i).setAttribute("src", "images/x.png");
		}
		document.querySelector("#probNumP" + i).innerHTML = "Problem #" + (i + 1);
		document.querySelector("#questionP" + i).innerHTML = quiz.problems[i].question;
		document.querySelector("#userAnswerP" + i).innerHTML = "User answer: " + quiz.problems[i].answers[userAnswers[i]];
		document.querySelector("#corrAnswerP" + i).innerHTML = "Correct answer: " + quiz.problems[i].answers[quiz.problems[i].correctAns];
	}
}

function calcScore() {
	var quizScore = 0;
	var total = quiz.problems.length;
	for (var i = 0; i < total; i++) {
		if (userAnswers[i] == quiz.problems[i].correctAns) {
			quizScore += 1;
		}
	}
	updateQuizInfo(quizScore);
	reviewQuiz(quizScore, total);
	completedQuizIds.push(quiz.quizId);
}

function addPoints(currentScore, points) {
	return currentScore + points;
}

function deductPoints(currentScore, points) {
	return currentScore - points;
}

function getRndNum(limit) {
  return Math.floor(Math.random() * limit);
}

function checkArray(chkNum, arr) {
  var exists = false;
  arr.forEach(function(num) {
    if (num === chkNum) {
      exists = true;
    }
  });
  return exists;
}

function nextQuestion() {
	console.log("next question called");
	problemIndex++;
	displayProblem();
}

function recordAnswer(answer) {
	console.log("recordAnswer called");
	userAnswers.push(answer);
	console.log("record answer: " + userAnswers);
}

function nextQuiz() {
	console.log("next quiz called");
	userAnswers = [];
	quizNum += 1;
	getQuiz();
}

function toggleLevelBtnColor(index, levelButton) {
	console.log("toggle called");
	if (index == level - 1) {
	// user clicks on current level
		console.log("return called");
		return;
	} else {
	// user clicks on different level than current
		console.log("else called");
//		levelButton[level - 1].style.backgroundColor = "dodgerblue";
		levelButton[level - 1].classList.toggle("selected");
//		levelButton[index].style.backgroundColor = "deepskyblue";
		levelButton[index].classList.toggle("selected");
	}
}

function clearYellowStars() {
	for (var j = 0; j < 5; j++) {
		document.querySelectorAll(".ratingStar")[j].style.backgroundImage = "url('images/star-icon-grey.png')";
	}
}

function setRating(i, star) {
	// turn active stars black on hover
	star[i].addEventListener("mouseenter", function() {
		clearYellowStars();
		for (var j = 0; j < i + 1; j++) {
			document.querySelectorAll(".ratingStar")[j].style.backgroundImage = "url('images/star-icon-black.png')";
		}
	});
	// return stars to showing rating on mouseleave
	star[i].addEventListener("mouseleave", function() {
		clearYellowStars();
		showRating();
	});
	// send user rating to server upon clicking a star
	star[i].addEventListener("click", function() {
		//calculate average rating including new user rating
		var rating = i + 1; // add one to index value to get rating value
		var oldTotal = quiz.timesRated * quiz.rating;
		var newTotal = oldTotal + rating;
		quiz.timesRated += 1;
		quiz.rating = newTotal / quiz.timesRated;
		//update db with new rating
		xhr = new XMLHttpRequest();
		xhr.open("GET", "setRating.php?quizId=" + quiz.quizId + "&avgRating=" + quiz.rating, true);
		xhr.send();
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				showRating();
			}
		}
	});
}

function shuffleArray(arr, corrAns, probNum) {
  var tmpArr = [];
  var newArr = [];
  var ansMoved = false;
  for (var i = 0; i < arr.length; i++) {
    do {
      var rndNum = getRndNum(arr.length);
      var exists = checkArray(rndNum, tmpArr);
      if (!exists) {
        tmpArr.push(rndNum);
        newArr.push(arr[rndNum]);
        if (rndNum == corrAns && ansMoved === false) { // use "==" for this to work!
          quiz.problems[probNum].correctAns = i;
          ansMoved = true;
        }
      }
    } while (exists === true);
  }
  return newArr;
}

function nextLevel() {
	toggleLevelBtnColor(level, document.getElementsByClassName("levelButton"));
	level += 1;
	completed = 0;
	getQuiz();
}

// why do i have to pass quizScore as a parameter? It's global...
function updateQuizInfo(quizScore) {
	xhr = new XMLHttpRequest();
	xhr.open("GET", "updateQuizInfo.php?quizId=" + quiz.quizId + "&userScore=" + quizScore, true);
	xhr.send();
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			console.log("timesTaken updated on quiz #" + quiz.quizId);
		}
	}
}

function getQuiz() {
	xhr = new XMLHttpRequest();
	xhr.open("GET", "getquiz.php?level=" + level + "&completedQuizIds=" + completedQuizIds + "&categories=" + categories, true);
	xhr.send();
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			quiz = this.responseText;
			problemIndex = 0;
			var userAnswers = [];
			if (!quiz) {
				if (level === 5) {
					alert("There are no more quizzes for your selected category. Try a lower level or other categories.");
					clearScreen();
					return;
				} else {
					alert("There are no more quizzes for your selected category in this level. Let's try the next level!");
					nextLevel();
				}
			} else {
				console.log("You have completed the following quizIds: " + completedQuizIds);
				quiz = JSON.parse(quiz);
				console.table(quiz);
				if (quiz.randomPs === true) {
					quiz.problems = shuffleArray(quiz.problems);
				}
				if (quiz.randomAs === true) {
					for (var i = 0; i < quiz.problems.length; i++) {
						quiz.problems[i].answers = shuffleArray(quiz.problems[i].answers, quiz.problems[i].correctAns, i);
					}
				}
				displayProblem();
			}
		}
	};
}

function createReviewScreen() {
	var scoreDiv = document.createElement("div");
	scoreDiv.setAttribute("id", "scoreDiv");
	scoreDiv.setAttribute("class", "scoreDiv");
	document.querySelector(".quizReview").appendChild(scoreDiv);
	
	for (var i = 0; i < quiz.problems.length; i++) {
		var containerDiv = document.createElement("div");

		var checkOrXDiv = document.createElement("img");
		checkOrXDiv.setAttribute("class", "checkOrXDiv");
		checkOrXDiv.setAttribute("id", "checkOrXDiv" + i);
		containerDiv.appendChild(checkOrXDiv);

		var probNumP = document.createElement("p");
		probNumP.setAttribute("class", "probNumP");
		probNumP.setAttribute("id", "probNumP" + i);
		containerDiv.appendChild(probNumP);

		var questionP = document.createElement("p");
		questionP.setAttribute("class", "questionP");
		questionP.setAttribute("id", "questionP" + i);
		containerDiv.appendChild(questionP);

		var corrAnswerP = document.createElement("p");
		corrAnswerP.setAttribute("class", "corrAnswerP");
		corrAnswerP.setAttribute("id", "corrAnswerP" + i);
		containerDiv.appendChild(corrAnswerP);

		var userAnswerP = document.createElement("p");
		userAnswerP.setAttribute("class", "userAnswerP");
		userAnswerP.setAttribute("id", "userAnswerP" + i);
		containerDiv.appendChild(userAnswerP);

		var br = document.createElement("br");
		containerDiv.appendChild(br);
		
		document.querySelector(".quizReview").appendChild(containerDiv);
	}
}











