<!-- trail alert modal -->
<div class="modal fade" id="alert" tabindex="-1" role="dialog" aria-labelledby="alert">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" id="alert">Alert!</h3>
			</div>
			<div class="modal-body">
				<form id="alert" name="alert" class="form" action="<?php echo $PREFIX?>php/controllers/sign-up-controller.php" method="post">												// ????????????????
					<div class="form-group">
						<label for="commentText">alert text</label>
						<input type="text" class="form-control" id="commentText" name="commentText" placeholder="Is there something wrong with the trail? Tell us here."
					</div>
					<div class="form-group">
						<label for="commentPhoto">upload photo</label>
						<input type="commentPhoto" class="form-control" id="commentPhoto" name="commentPhoto" placeholder="upload photo">														// HOW TO DO PHOTO???????????
					</div>
					<div class="form-group">																																												// FORM GROUP?????????????????
							<button type="submit" class="btn modal-button" id="submitButton" name="submitButton">Submit Alert</button>
																																																										// TRUFORK????????????????????
					</div>
				</form>
				<div id="outputArea"></div>																																													// ?????????????????????????
			</div>
		</div>
	</div>
</div>