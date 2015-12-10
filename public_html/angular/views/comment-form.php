<!---------------------------------------------------------->
<!-- This is the comment form for the Trail Quail website -->
<!-- 																	    -->
<!-- @author saulj@me.com  (December 2015)  				    -->
<!---------------------------------------------------------->

<!-- The div class="form-wrap" is the black box containing the form. It's set to a column width of 12 for small screens, and a column width of 6 for medium screens on up -->
<div class="form-wrap">
	<label class="control-label" for txtareaComments"></label>


	<!-- Form is centered within it's container, and is set to 10 be columns wide RELATIVE TO IT'S CONTAINER, and offset to the right by one column. See classes: col-xs-offset-1 & col-xs-10 -->
	<form method="get" action="#" id="login-form" class="form-horizontal">

		<!-- Text box for inputting comments below -->
		<div class="form-group">
			<!-- Labels for each field are places within the label tag -->
			<label for="trailComment" class="control-label">Comment on this Trail below:</label>
			<br>
			<textarea class="form-control" rows="5" id="txtareaComments" maxlength="500" placeholder="500 characters max."></textarea>
		</div>

		<div class="form-group">
			<label for="photoFile" class="control-label"></label>
		</div>

		<!-- buttons for submit and reset -->
		<br>
		<button class="btn btn-md btn-info" type="submit">Submit</button>
		<button class="btn btn-md btn-warning" type="reset">Reset</button>
		<br>
		<div>Are you sure?</div>
		<button class="btn btn-md btn-info" type="submit">Yes</button>


	</form>
</div> <!-- CLOSE FORM WRAP -->