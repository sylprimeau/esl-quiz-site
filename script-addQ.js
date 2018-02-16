var problemNum = 1;

function addQuestion() {
		
	problemNum += 1;
	
	if (problemNum > 20) {
		alert("Sorry. The maximum number of problems per quiz is: " + (problemNum - 1));
		return;
	}

	var problem = document.createElement("div");
	problem.setAttribute("class", "problem");
	
	var pNumElem = document.createElement("p");
	var pNumTextNode = document.createTextNode("Problem #" + problemNum);
	pNumElem.appendChild(pNumTextNode);
	problem.appendChild(pNumElem);
	
	var qTextNode = document.createTextNode("Question: ");
	problem.appendChild(qTextNode);
	var qInput = document.createElement("textarea");
	problem.appendChild(qInput);
	qInput.setAttribute("name", "question[]");
	qInput.setAttribute("id", "qText" + problemNum);
	qInput.setAttribute("cols", "50");
	qInput.setAttribute("rows", "4");
	qInput.setAttribute("onfocus",  "this.focus();this.select()");
	qInput.required = true;
	var br = document.createElement("br");
	problem.appendChild(br);
	qInput.value = document.querySelector("#qText" + (problemNum - 1)).value;

	var aTextNode = document.createTextNode("Answer A: ");
	problem.appendChild(aTextNode);
	var aInput = document.createElement("textarea");
	problem.appendChild(aInput);
	aInput.setAttribute("name", "answerA[]");
	aInput.setAttribute("id", "aText" + problemNum);
	aInput.setAttribute("cols", "50");
	aInput.setAttribute("rows", "4");
	aInput.setAttribute("onfocus",  "this.focus();this.select()");
	aInput.required = true;
	var br = document.createElement("br");
	problem.appendChild(br);
	aInput.value = document.querySelector("#aText" + (problemNum - 1)).value;

	var bTextNode = document.createTextNode("Answer B: ");
	problem.appendChild(bTextNode);
	var bInput = document.createElement("textarea");
	problem.appendChild(bInput);
	bInput.setAttribute("name", "answerB[]");
	bInput.setAttribute("id", "bText" + problemNum);
	bInput.setAttribute("cols", "50");
	bInput.setAttribute("rows", "4");
	bInput.setAttribute("onfocus",  "this.focus();this.select()");
	bInput.required = true;
	var br = document.createElement("br");
	problem.appendChild(br);
	bInput.value = document.querySelector("#bText" + (problemNum - 1)).value;

	var cTextNode = document.createTextNode("Answer C: ");
	problem.appendChild(cTextNode);
	var cInput = document.createElement("textarea");
	problem.appendChild(cInput);
	cInput.setAttribute("name", "answerC[]");
	cInput.setAttribute("id", "cText" + problemNum);
	cInput.setAttribute("cols", "50");
	cInput.setAttribute("rows", "4");
	cInput.setAttribute("onfocus",  "this.focus();this.select()");
	cInput.required = true;
	var br = document.createElement("br");
	problem.appendChild(br);
	cInput.value = document.querySelector("#cText" + (problemNum - 1)).value;

	var dTextNode = document.createTextNode("Answer D: ");
	problem.appendChild(dTextNode);
	var dInput = document.createElement("textarea");
	problem.appendChild(dInput);
	dInput.setAttribute("name", "answerD[]");
	dInput.setAttribute("id", "dText" + problemNum);
	dInput.setAttribute("cols", "50");
	dInput.setAttribute("rows", "4");
	dInput.setAttribute("onfocus",  "this.focus();this.select()");
	dInput.required = true;
	var br = document.createElement("br");
	problem.appendChild(br);
	dInput.value = document.querySelector("#dText" + (problemNum - 1)).value;

	var corrAnsTextNode = document.createTextNode("Correct answer (0-3): ");
	problem.appendChild(corrAnsTextNode);
	var corrAnsInput = document.createElement("input");
	problem.appendChild(corrAnsInput);
	corrAnsInput.setAttribute("name", "corrAns[]");
	corrAnsInput.required = true;
	var br = document.createElement("br");
	problem.appendChild(br);
	var br = document.createElement("br");
	problem.appendChild(br);

	var notesTextNode = document.createTextNode("Notes (optional): ");
	problem.appendChild(notesTextNode);
	var notesInput = document.createElement("input");
	problem.appendChild(notesInput);
	notesInput.setAttribute("name", "notes[]");
	var br = document.createElement("br");
	problem.appendChild(br);

	var picUrlTextNode = document.createTextNode("Image URL (optional): ");
	problem.appendChild(picUrlTextNode);
	var picUrlInput = document.createElement("input");
	problem.appendChild(picUrlInput);
	picUrlInput.setAttribute("name", "picUrl[]");
	var br = document.createElement("br");
	problem.appendChild(br);

	var audUrlTextNode = document.createTextNode("Audio URL (optional): ");
	problem.appendChild(audUrlTextNode);
	var audUrlInput = document.createElement("input");
	problem.appendChild(audUrlInput);
	audUrlInput.setAttribute("name", "audUrl[]");
	var br = document.createElement("br");
	problem.appendChild(br);

	var vidUrlTextNode = document.createTextNode("YouTube URL (optional): ");
	problem.appendChild(vidUrlTextNode);
	var vidUrlInput = document.createElement("input");
	problem.appendChild(vidUrlInput);
	vidUrlInput.setAttribute("name", "vidUrl[]");
	var br = document.createElement("br");
	problem.appendChild(br);

	document.getElementById("quiz").appendChild(problem);
}
	
document.getElementById("addQuestion").addEventListener("click", addQuestion);
