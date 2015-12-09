<!--this is the trail submission/alert/update form this will be my first stab at it
		@author George Kephart <gkephart@cnm.edu>-->

<!-- The div class="form-wrap" is the black box containing the form. It's set to a column width of 6 for medium screens on up -->
<div class="form-wrap">
	<!-- Form is centered within its container, and is set to be 10 columns wide RELATIVE TO ITS CONTAINER, and offset to the right by one column. See classes: col-xs-offset-1 & col-xs-10 -->
	<form method="get" action="" id="sample-form" class="form-horizontal">

		<div class="form-group">
			<!-- Labels for each field are places within a <label> tag. Use the "for" attribute. the class="control-label" is for styling. -->
			<label for="amenities" class="control-label">amenities</label>
			<!-- the div class="input-group" contains both the text field and the icon to the left -->
			<div class="input-group">
				<!-- this div and span contains the glyphicon to the left. aria-hidden is so that screen readers don't read this element -->
				<div class="input-group-addon">
					<!-- text field input. pay attention to the id, placeholder text, type, and placeholder attributes -->
					<input type="text" class="form-control" id="amenities" maxlength="256"/>
				</div>
			</div>
		</div>

		<div class="form-group">
		<label for="condition" class="control-label">Condition</label>
			<div class="input-group">
				<div class="input-group-addon">
					<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
				</div>
				<input type="text" class="form-control" id="condition" maxlength="256">
			</div>
		</div>

		<div class="form-group">
			<label for="description" class="control-label">Description</label>
			<div class="input-group">
				<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
			</div>
			<input type="text" class="form-control" id="description" maxlength="512">
		</div>

		<div class="form-group">
			<label for="name" class="control-label">Name</label>
			<div class="input-group">
				<div class="input-group-addon">
					<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
				</div>
				<input type="text" class="form-control" id="name" maxlength="64">
			</div>
		</div>

		<div class="form-group">
			<label for="terrain" class="control-label">Terrain</label>
			<div class="input-group">
				<div class="input-group-addon">
					<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
				</div>
				<input type="text" class="form-control" id="terrain" maxlength="128">
			</div>
		</div>

		<div class="form-group">
			<label for="Traffic" class="control-label">Traffic</label>
			<div class="input-group">
				<div class="input-group-addon">
					<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
				</div>
				<input type="text" class="form-control" id="Traffic" maxlength="48">
			</div>
		</div>

		<div class="form-group">
			<label for="use" class="control-label">Use</label>
			<div class="input-group">
				<div class="input-group-addon">
					<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
				</div>
				<input type="text" class="form-control" id="use" maxlength="48">
			</div>
		</div>


</div>


