<?php
	include "header.php";
?>

		<div class="wrapper quiz-list">
			<div class="filters-bar">
				<div class="filters-btn">
					<p>Filters: Vocabulary (Basic)</p>
				</div>
			</div>

			<div class="filters-box hide">
				<div class="filters-box-inner">
					<div class="x-close">
						<div class="x-fwd-slash"></div>
						<div class="x-bwd-slash"></div>
					</div>
					<div class="categories-div group">
						<h2>Category</h2>
						<ul>
							<li class="category-btn">Vocabulary</li>
							<li class="category-btn">Grammar</li>
							<li class="category-btn">Pronunciation</li>
							<li class="category-btn">Conversation</li>
							<li class="category-btn">Idioms</li>
						</ul>
					</div>

					<div class="levels-div group">
						<h2>Level</h2>
						<ul>
							<li class="level-btn">Level 1 (basic)</li>
							<li class="level-btn">Level 2 (easy)</li>
							<li class="level-btn">Level 3 (medium)</li>
							<li class="level-btn">Level 4 (hard)</li>
							<li class="level-btn">Level 5 (native)</li>
						</ul>
					</div>
				</div>
			</div>


			<div class="quiz-previews">
				<div class="quiz-preview start-button">
					<h3 class="title">Random Quiz</h3>
					<p>Click here to get a random quiz!</p>
				</div>
				
				<?php
					include "dbh.php";
					$sql = "SELECT * FROM quizzes";
					$result = mysqli_query($conn,$sql);
				?>
				
				<?php while ($row = mysqli_fetch_array($result)): ?>
					<div class="quiz-preview">
						<h3 class="title"><?php echo $row['title']; ?></h3>
						<h5 class="category <?php echo strtolower($row['category']); ?>"><?php echo $row['category']; ?></h5>
						<h5 class="level level<?php echo $row['level']; ?>">Level <?php echo $row['level']; ?></h5>
						<p class="description"><?php echo $row['description']; ?></p>
					</div>
				<?php endwhile; ?>
				
			</div>
<!--
			<div class="quiz-previews">
				<div class="quiz-preview start-button">
					<h3 class="title">Random Quiz</h3>
					<p>Click here to get a random quiz!</p>
				</div>
				<div class="quiz-preview">
					<h5 class="category vocabulary">Vocabulary</h5>
					<h5 class="level easy">Easy</h5>
					<h3 class="title">Nationalities & Languages</h3>
					<p>Can you match the language to the nationality?</p>
				</div>
				<div class="quiz-preview">
					<h5 class="category grammar">Grammar</h5>
					<h5 class="level easy">Easy</h5>
					<h3 class="title">"The" or "A"?</h3>
					<p>Do you know which one native speakers would use?</p>
				</div>
				<div class="quiz-preview">
					<h5 class="category vocabulary">Vocabulary</h5>
					<h5 class="level basic">Basic</h5>
					<h3 class="title">Prepositions of location</h3>
					<p>In front of, behind, above, below, beside, inside, outside, etc.</p>
				</div>
				<div class="quiz-preview">
					<h5 class="category idioms">Idioms</h5>
					<h5 class="level hard">Hard</h5>
					<h3 class="title">"Blue" Idioms</h3>
					<p>Idioms that contain the word "blue".</p>
				</div>
				<div class="quiz-preview">
					<h5 class="category conversation">Conversation</h5>
					<h5 class="level easy">Easy</h5>
					<h3 class="title">Countables and Uncountables</h3>
					<p>When to use which?</p>
				</div>
				<div class="quiz-preview">
					<h5 class="category vocabulary">Vocabulary</h5>
					<h5 class="level native">Native</h5>
					<h3 class="title">Fancy Colors</h3>
					<p>Do you know the names of these colors?</p>
				</div>
				<div class="quiz-preview">
					<h5 class="category vocabulary">Vocabulary</h5>
					<h5 class="level easy">Easy</h5>
					<h3 class="title">Holidays</h3>
					<p>Everyone loves holidays! Yay!</p>
				</div>
				<div class="quiz-preview">
					<h5 class="category pronunciation">Pronunciation</h5>
					<h5 class="level medium">Medium</h5>
					<h3 class="title">Similar Sounds</h3>
					<p>Similar but not the same.</p>
				</div>
			</div>
-->


			<footer>
				<p>Footer will go here</p>
			</footer>
		</div>
		
		<div id="problem">
			<div class="categoryDiv">Quiz Category</div>
			<div id="questionNumber"></div>
			<div id="mediaContainer"></div>
			<div class="questionDiv">
				<p class="questionText">The question goes here</p>
			</div>
			<div class="answers">
				<div class="answerButton noselect">
					<p id="0" class="answerText"></p>
				</div>
				<div class="answerButton noselect">
					<p id="1" class="answerText"></p>
				</div>
				<div class="answerButton noselect">
					<p id="2" class="answerText"></p>
				</div>
				<div class="answerButton noselect">
					<p id="3" class="answerText"></p>
				</div>
			</div>
			<div id="avgScore"></div>
			<div id="timesTaken"></div>
			<div class="ratingStars">
				<span class="starsTooltip">Click to rate!</span>
				<div id="star1" class="ratingStar"></div>
				<div id="star2" class="ratingStar"></div>
				<div id="star3" class="ratingStar"></div>
				<div id="star4" class="ratingStar"></div>
				<div id="star5" class="ratingStar"></div>
			</div>
		</div>
		<div class="quizReview hide"></div>
		
		<script src="script.js"></script>
	</body>
	
</html>


