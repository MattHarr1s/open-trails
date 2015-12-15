<!--
<!-- This is the sign-up form for the Trail Quail website -->
<!-- 																	-->
<!-- @author Louis Gill <lgill7@cnm.edu> -->
<!--

<!-- The div class="form-wrap" is the black box containing the form. It's set to a column width of 6 for medium screens on up -->
<div class="col-xs-12 col-md-7 form-wrap">
	<!-- Form is centered within its container, and is set to be 10 columns wide RELATIVE TO ITS CONTAINER, and offset to the right by one column. See classes: col-xs-offset-1 & col-xs-10 -->
	<form method="get" action="" id="sample-form" class="form-horizontal" col-xs-10 col-xs-offset-1">
		<div class="form-group">
			<!-- Labels for each field are places within a <label> tag. Use the "for" attribute. the class="control-label" is for styling. -->
			<label for="userName" class="control-label">user name</label>
			<!-- the div class="input-group" contains both the text field and the icon to the left -->
			<div class="input-group">
				<!-- this div and span contains the glyphicon to the left. aria-hidden is so that screen readers don't read this element -->
				<div class="input-group-addon">
					<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				</div>
				<!-- text field input. pay attention to the id, placeholder text, type, and placeholder attributes -->
				<input type="text" class="form-control" id=""
			</div>
		</div>
	</form>
</div>