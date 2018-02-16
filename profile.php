<?php
	include "header.php";
?>

<h1>Profile</h1><br>

<?php
	if (isset($_SESSION['id'])) {
		echo "Hello ".$_SESSION['firstName']." ".$_SESSION['lastName']."!";
		echo "You can only see this text if you're logged in.";
	} else {
		echo "You are not logged in.";
	}
?>

<br>
<br>
<p>This part here and following this, everyone can see, logged in or not.</p>
<br>
<p>In the future, you'll be able to see a bunch of stats here, such as the following (these are only a sample):</p>

<h1>Your stats</h1>
<table>
	<thead>
		<tr>
			<th rowspan="2">Level</th>
			<th colspan="2">Starts</th>
			<th colspan="2">Finishes</th>
			<th colspan="2">Avg Score</th>
			<th rowspan="2">Percentile</th>
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
			<td>75</td>
		</tr>
		<tr>
			<td>2</td>
			<td>21</td>
			<td>45</td>
			<td>20</td>
			<td>44</td>
			<td>76%</td>
			<td>68%</td>
			<td>67</td>
		</tr>
		<tr>
			<td>3</td>
			<td>18</td>
			<td>39</td>
			<td>18</td>
			<td>38</td>
			<td>71%</td>
			<td>65%</td>
			<td>58</td>
		</tr>
		<tr>
			<td>4</td>
			<td>25</td>
			<td>30</td>
			<td>25</td>
			<td>29</td>
			<td>68%</td>
			<td>61%</td>
			<td>56</td>
		</tr>
		<tr>
			<td>5</td>
			<td>6</td>
			<td>26</td>
			<td>6</td>
			<td>24</td>
			<td>52%</td>
			<td>63%</td>
			<td>38</td>
		</tr>
	</tbody>
</table>

<p>You'll be able to see such stats as:</p>
<ul>
	<li>all quizzes you've started, whether you finished, your score, the avg score of everyone, your percentile ranking</li>
	<li>click on the quiz for details: time taken to complete, answers given, correct answers, etc.</li>
	<li>all the quizzes you've submitted, their rating, avg score, how many times taken, etc.</li>
	<li>other good stuff</li>
</ul>
























