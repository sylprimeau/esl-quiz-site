<?php
	include "header.php";
?>

<section class="profile-page">
	<h1>Your Profile</h1>
	<?php	if (!isset($_SESSION['id'])): ?>
		<p>You must log in or create an account to view your profile.</p>
	<?php else: ?>
		<p>Hello <?php echo $_SESSION['firstName'].' '.$_SESSION['lastName'] ?>!</p><br>
		<form action="includes/logout.inc.php">
			<button>Log out</button>
		</form>
		
		<?php
		if (isset($_SESSION['username'])) {
			$username = $_SESSION['username'];
			echo "<p>You have done the following quizzes:</p>";
			include "dbh.php";
			$sql = "SELECT * FROM quizzes_taken WHERE username = '".$username."'";
			$result = mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_array($result)) {
				echo "<p> Quiz #".$row['quizId']."</p>";
			}
		}
		?>
		
		<p>Sorry! I'm still working on profile pages. There's not much to see here at the moment, but in the future you'll be able to see a bunch of stats here, such as the following (these are only a sample):</p>
		<p>You'll be able to see such stats as:</p>
		<ul>
			<li>all quizzes you've started, whether you finished, your score, the avg score of everyone, your percentile ranking</li>
			<li>click on the quiz for details: time taken to complete, answers given, correct answers, etc.</li>
			<li>all the quizzes you've submitted, their rating, avg score, how many times taken, etc.</li>
			<li>other good stuff like this table:</li>
		</ul>
		<h1>Your stats</h1>
		<table class="user-stats">
			<thead>
				<tr>
					<th rowspan="2">Level</th>
					<th colspan="2">Starts</th>
					<th colspan="2">Finishes</th>
					<th colspan="2">Avg Score</th>
				</tr>
				<tr>
					<th>You</th>
					<th>All</th>
					<th>You</th>
					<th>All</th>
					<th>You</th>
					<th>All</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td>20</td>
					<td>53</td>
					<td>20</td>
					<td>51</td>
					<td>83%</td>
					<td>71%</td>
				</tr>
				<tr>
					<td>2</td>
					<td>21</td>
					<td>45</td>
					<td>20</td>
					<td>44</td>
					<td>76%</td>
					<td>68%</td>
				</tr>
				<tr>
					<td>3</td>
					<td>18</td>
					<td>39</td>
					<td>18</td>
					<td>38</td>
					<td>71%</td>
					<td>65%</td>
				</tr>
				<tr>
					<td>4</td>
					<td>25</td>
					<td>30</td>
					<td>25</td>
					<td>29</td>
					<td>68%</td>
					<td>61%</td>
				</tr>
				<tr>
					<td>5</td>
					<td>6</td>
					<td>26</td>
					<td>6</td>
					<td>24</td>
					<td>52%</td>
					<td>63%</td>
				</tr>
			</tbody>
		</table>
	<?php endif; ?>
</section>
























