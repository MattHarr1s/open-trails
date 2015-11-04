<!DOCTYPE HTML>
<HTML lang="eng>"
	<!--Header for Trail Quail landing page-->
	<head>
		<meta charset="UTF-8">
		<title>Trail Quail</title>
	</head>
	<!--Body for Trail Quail landing page-->
	<body>
		<!--Name of Project-->
		<h1>Trail Quail</h1>
		<!--Executive Summary-->
			<div>
				<h2>Executive Summary</h2>
						<!--Text of Trail Quail Executive summary-->
							<p>Trail Quail will be a website for hikers and mountain bikers, used primarily as a way to find trail maps
			and pertinent information, both official and crowd-sourced, to meet the needs of hikers and mountain bikers of
			all abilities from novice to expert.  Non-registered users will be able to search for specific hikes and/or
			mountain bike rides by area, level of difficulty, amenities, elevation gain, and length (distance).
			For each hike or ride, they will also be able access trail information uploaded by registered users, including
			ratings, comments, and photos. They will also see current weather conditions and trail updates. In addition,
			registered users will be able to arrange meet-ups, set up a current hike/ride group, share information
			with friends, and build a trail map for future use.  There will also be a section containing Tips, Tricks, and
			General Information for users wishing to increase their hiking or mountain biking proficiency.
							</p>
			</div>
			<!--Personas and the links to them-->
			<div>
				<h2>Personas</h2>
					<p>Trail Quail will be accessible by anyone interested in hiking or biking, regardless of experience level.
					Trail Quail's UX has been designed around the following Personas:
					</p>
					<ul>
						<li><a href="persona-maria.php">Maria, 53 F, Parks and Recreation Employee </a></li>
						<li><a href="persona-matt.php">Matt, 56 M, Engineer</a></li>
						<li><a href="persona-shawn.php">Shawn, 38 M, Financial Adviser</a></li>
					</ul>
			</div>
			<!--Use cases-->
			<div>
				<h2>Use Cases</h2>
					<p> The interactions between the personas and Trail Quail have been mapped as use cases, which are found
						here:
					</p>
					<h3><a href="use-cases.php">Use Cases</a></h3>
			</div> <!--Conceptual Model-->
		<h2>Conceptual Model</h2>
		<h3>Entity Name: user</h3>
		<ul>
			<li>userId</li>
			<li>account type</li>
			<li>email</li>
			<li>password:hash</li>
			<li>userBrowser</li>
			<li>userIpAddress</li>
			<li>password:salt</li>
			<li>userName</li>


		</ul>
		<br>
		<h3>Entity: comment</h3>
		<ul>
			<li>commentId</li>
			<li>userId</li>
			<li>trailId</li>
			<li>trailComments</li>
			<li>trailPhotos</li>
			<li>comBrowserType</li>
			<li>comIpAddress</li>
		</ul>
		<br>
		<h3>Entity: rating</h3>
		<ul>
			<li>trailRatingId</li>
			<li>trailId</li>
			<li>userId</li>
			<li>rating</li>
		</ul>
		<br>
		<h3>Entity: trail</h3>
		<ul>
			<li>trailInfoId</li>
			<li>trailId</li>
			<li>trailUuid</li>
			<li>accessibility</li>
			<li>amenities</li>
			<li>browserType</li>
			<li>difficulty</li>
			<li>distance</li>
			<li>ipAddress</li>
			<li>submissionType</li>
			<li>terrain</li>
			<li>trailCondition</li>
			<li>trailDescription</li>
			<li>trailName</li>
			<li>trailTraffic</li>
			<li>trailUse</Li>
		</ul>
		<br>
		<h3>Entity: segment</h3>
		<ul>
			<li>segmentId</li>
			<li>start</li>
			<li>stop</li>
			<li>elevation</li>
		</ul>
		<br>
		<h3>Entity: trail relationship</h3>
		<ul>
			<li>trailId</li>
			<li>segmentId</li>
			<li>segmentType</li>
		</ul>
		<br>





	</body>
	<footer>
		<a href="https://twitter.com/Trail_Quail" class="twitter-follow-button" data-show-count="false" data-size="large">
			Follow @Trail_Quail</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if
			(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.
				parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
		</script>
	</footer>
