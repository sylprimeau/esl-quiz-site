/*

Three ways to handle the AJAX problem (so far)
1) called a full AJAX twice (or whenever you need it)
2) pass a function to the ajax that you want executed
3) use a wait screen (disable the div while waiting)

*/

var quizScore = 0;
var quizNum = 1;
var problemIndex = -1;
var userAnswers = [];
var quiz;
var quizPreviews;
var level;
var categories = [];

init();

function init() {
	getCategories();
	getLevel();
	getFilteredQuizPreviews();
	setListeners();
}

// confirm abandoning mid-quiz (click on nav, etc)
function confirmAbandon(e) {
	var confirmAbandon = confirm("You are not finished this quiz yet. Are you sure you want to abandon it?");
	if (!confirmAbandon) {
		e.preventDefault();
	}
}

// This function uses the hardcoded text in the HTML to (de)select categories. Ideally, however, you should have an array of "categories" that populates the buttons and then set an array of "selectedCategories" that will also be used to select the appropriate buttons.
function getCategories() {
	// get categories from local storage if they exist
	if (localStorage.getItem("categories")) {
		categories = localStorage.getItem("categories");
		categories = categories.split(","); // needed because LS only stores strings
	} else {
		// get all categories from HTML
		var catBtn = document.querySelectorAll(".category-btn");
		catBtn.forEach(function(elem) {
			categories.push(elem.innerHTML);
		});
	}
	// highlight category buttons
	var catBtn = document.querySelectorAll(".category-btn");
	catBtn.forEach(function(elem) {
		var text = elem.innerHTML;
		if (categories.includes(text)) {
			elem.classList.toggle("selected");
		}
	});
}

function getLevel() {
	// get level from local storage if it exists
	if (localStorage.getItem("level")) {
		level = localStorage.getItem("level");
	} else {
		level = 1;
	}
	// highlight level button
	var levelBtn = document.querySelectorAll(".level-btn");
	levelBtn[level-1].classList.toggle("selected");
}

// Note: Should this be refactored? Looks like I set listeners for everything at once but maybe they should only be set when the items are shown?
function setListeners() {
	var navBar = document.querySelector("nav");
	navBar.addEventListener("click", function(e) {
		if (problemIndex >= 0) {
			confirmAbandon(e);
		}
	});
	// click filters button to show filter options box
	var filtersBtn = document.querySelector(".filters-btn");
	filtersBtn.addEventListener("click", function() {
		document.querySelector(".filters-box").classList.toggle("hide");
	});
	
	// click a category button in filters to select a category
	var catButton = document.querySelectorAll(".category-btn");
	catButton.forEach(catBtnListeners);
	
	// click a level button in filters to select a level
	var levelButton = document.querySelectorAll(".level-btn");
	// tried to use forEach here but couldn't figure out how to get it to work because levelBtnListeners uses [index-1] as an index
	for (var i = 0; i < levelButton.length; i++) {
		levelBtnListeners(i, levelButton);
	}

	// click X to close filters options box
	var filtersBoxX = document.querySelector(".filters-box .x-close");
	filtersBoxX.addEventListener("click", function() {
		setFilters();
		getFilteredQuizPreviews();
		document.querySelector(".filters-box").classList.toggle("hide");
	});
	// click an answer button in response to quiz question
	var answerButton = document.querySelectorAll(".answerButton");
	for (var index = 0; index < answerButton.length; index++) {
		AnsBtnListeners(index, answerButton);
	}
	// click on the quiz review div to hide it
	var quizReviewDiv = document.querySelector(".quizReview");
	quizReviewDiv.addEventListener("click", function() {
		quizReviewDiv.classList.toggle("hide");
		location.reload();
	});
	var star = document.querySelectorAll(".ratingStar");
	for (var i = 0; i < star.length; i++) {
		setRating(i, star);
	}
}

// add or remove categories to array by clicking category buttons in filters
function catBtnListeners(elem) {
	elem.addEventListener("click", function() {
		// if category exists in array, remove it
		if (categories.includes(elem.innerHTML)) {
			// must have minimum 1 category in array
			if (categories.length < 2) {
				return;
			}
			elem.classList.toggle("selected");
			var position = categories.indexOf(elem.innerHTML);
			categories.splice(position, 1);
		} else {
		// if cat doesn't exist, add it
			elem.classList.toggle("selected");
			categories.push(elem.innerHTML);
		}
	});
}

function levelBtnListeners(index, levelButton) {
	levelButton[index].addEventListener("click", function() {
		if (index == level - 1) {
			// user clicks on current level
			return;
		} else {
			// user clicks on different level than current
			levelButton[level - 1].classList.toggle("selected");
			levelButton[index].classList.toggle("selected");
		}
		level = index + 1;
	});
}

function setFilters() {
	localStorage.setItem("level", level);
	localStorage.setItem("categories", categories.join());
}

// fetch and load homepage with quiz previews restricted by filter settings 
function getFilteredQuizPreviews() {
	xhr = new XMLHttpRequest();
	xhr.open("GET", "getfilteredquizpreviews.php?level=" + level + "&categories=" + categories, true);
	xhr.send();
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var response = this.responseText;
			var quizPreviews = document.querySelector(".quiz-previews");
			quizPreviews.innerHTML = response;
			// Event listeners need to be attached here, after the HTML is received in response
			// click quiz preview to go directly to that quiz
			var quizPreview = document.querySelectorAll(".quiz-specific-start");
			quizPreview.forEach(quizPreviewListeners);
			// click on "random quiz" box to load random quiz
			var startButton = document.querySelector(".quiz-random-start");
			startButton.addEventListener("click", function() {
				document.querySelector(".quiz-list").classList.toggle("hide");
				document.querySelector("#problem").style.display = "block";
				getQuiz();
			});
		}
	};
}

function quizPreviewListeners(elem) {
	elem.addEventListener("click", function() {
		console.log("Quiz ID is: " + elem.dataset.quizid);
		document.querySelector(".quiz-list").classList.toggle("hide");
		document.querySelector("#problem").style.display = "block";
		getQuiz(elem.dataset.quizid);
	});
}

function getQuiz(id) {
	xhr = new XMLHttpRequest();
	if (id) {
		xhr.open("GET", "getquiz.php?quizId=" + id, true);
	} else {
		xhr.open("GET", "getquiz.php?level=" + level + "&categories=" + categories, true);
	}
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
				quiz = JSON.parse(quiz);
				console.table(quiz);
				savequizstarted();
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

function AnsBtnListeners(index, answerButton) {
	answerButton[index].addEventListener("click", function() {
		console.log("You clicked answer button " + index);
		recordAnswer(index);
		if (problemIndex === quiz.problems.length - 1) {
			calcScore();
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
	document.getElementById("questionNumber").innerHTML = "Question " + (Number(problemIndex) + 1) + " of " + quiz.problems.length;
	document.querySelector(".categoryDiv").innerHTML = quiz.category + " - Level " + quiz.level;
	document.querySelector(".quiz-title").innerHTML = quiz.title;
	document.querySelector(".questionText").innerHTML = quiz.problems[problemIndex].question;
	var answer = document.querySelectorAll(".answerText");
	answer.forEach(function(elem, index) {
		elem.innerHTML = quiz.problems[problemIndex].answers[index];
	});
//	if (quiz.timesTaken === 1) {
//		document.querySelector("#timesTaken").innerHTML = quiz.timesTaken + " person has taken this quiz so far!";
//	} else {
//		document.querySelector("#timesTaken").innerHTML = quiz.timesTaken + " people have taken this quiz so far!";
//	}
//	document.querySelector("#avgScore").innerHTML = "The average score for this quiz is " + quiz.avgScore + "/" + quiz.problems.length;
//	showRating();
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
	var percent = Math.round(quizScore/total * 100);
	if (percent >= 90) {
		text += "Outstanding! Your score was " + quizScore + " out of " + total + ".<br>You scored " + percent + "%!";
	} else if (percent >= 70) {
		text += "Very good! Your score was " + quizScore + " out of " + total + ".<br>You scored " + percent + "%!";
	} else if (percent >= 50) {
		text += "Doing pretty good! Your score was " + quizScore + " out of " + total + ".<br>You scored " + percent + "%!";
	} else if (percent >= 30) {
		text += "Keep trying. You'll get there! Your score was " + quizScore + " out of " + total + ".<br>You scored " + percent + "%!";
	} else {	
		text += "Oh no! Maybe try one level lower? Your score was " + quizScore + " out of " + total + ".<br>You scored " + percent + "%!";
	}
	document.querySelector(".quizReview").classList.toggle("hide");
	document.querySelector("#problem").style.display = "none";
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
	savequizcompleted(quizScore);
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
	toggleLevelBtnColor(level, document.querySelectorAll(".level-btn"));
	level += 1;
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

function savequizstarted() {
	xhr = new XMLHttpRequest();
	xhr.open("GET", "savequizstarted.php?quizId=" + quiz.quizId, true);
	xhr.send();
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var response = this.responseText;
			console.log(response);
		}
	}
}

function savequizcompleted(quizScore) {
	xhr = new XMLHttpRequest();
	xhr.open("GET", "savequizcompleted.php?quizId=" + quiz.quizId + "&score=" + quizScore, true);
	xhr.send();
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var response = this.responseText;
			console.log(response);
		}
	}
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






















