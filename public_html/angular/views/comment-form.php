<!---------------------------------------------------------->
<!-- This is the comment form for the Trail Quail website -->
<!-- 																	    -->
<!-- @author saulj@me.com  (December 2015)  				    -->
<!---------------------------------------------------------->

<!-- The div class="form-wrap" is the black box containing the form. It's set to a column width of 12 for small screens, and a column width of 6 for medium screens on up -->
<div class="form-wrap">
	<!-- Form is centered within it's container, and is set to 10 be columns wide RELATIVE TO IT'S CONTAINER, and offset to the right by one column. See classes: col-xs-offset-1 & col-xs-10 -->
	<form method="post" ng-submit="createComment(newComment, comment-form.$valid);" id="comment-form" name="comment-form"
			class="form-horizontal" novalidate>
		<!-- Text box for inputting text comments up to 256 characters below -->
		<div class="form-group">
			<!-- Labels for each field are places within the label tag -->
			<label for="txtareaComments" class="control-label"></label>
			<br>
			<textarea class="form-control" cols="20" rows="5" id="txtareaComments" name="txtareaComments"
						 ng-maxlength="256" placeholder="Write a comment..." ng-model="newComment.commentText" required
						 ng-required="true"></textarea>
		</div>
		<!--		<pre>comment-form.txtareaComments.$error =-->
		<!--			{{ comment-form.txtareaComments.$error | json }}</pre>-->
		<div ng-messages="comment-form.txtareaComments.$error" role="alert" ng-if="comment-form.txtareaComments.$touched"
			  ng-hide="comment-form.txtareaComments.$valid">
			<div ng-message="required">
				You must enter a text comment before you submit.
			</div>
			<div ng-message="maxlength">
				Your comment is too long. Limit your comment to 256 characters.
			</div>
		</div>
		<br>
		<br>

		<!--	Input form for 1 photo per comment -- Photo files must be png or jpg	-->

		<!--  <div class="form-group">
			<label for="photoFile" class="control-label">
				<span class="glyphicon glyphicon-camera" aria-hidden="true"></span> Select photo file to
				upload (.png or .jpg files only)
			</label>

			<div class="input-group">
				<div class="input-group-addon">
				</div>
				<input type="file" id="photofile1" class="form-control"/>
			</div>
		</div>  -->

		<!-- buttons for submit -->
		<br>
		<button class="btn btn-md btn-info pull-right" type="submit">Submit</button>

		<p class="well">{{ newComment | json }}</p>
		<p class="well">{{ comment-form.$valid }}</p>
		<p class="well">{{ comment-form.txtareaComments.$valid }}</p>
	</form>
</div> <!-- CLOSE FORM WRAP -->