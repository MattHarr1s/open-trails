<!-- this is the view for comments. this is a custom directive view that will be uploaded directly into the trail-view
page. This way the Comment API can be passed a trailId

George Kephart g.e.kephart@gmail.com -->
<!-- begining the actual comment feild -->
<div>
	<!-- the actual comment view section -->
	<div class="comment-view">
		<div class="row">
			<div class="col-md-12">
				<div ng-repeat="comment in comments | orderBy:'-createDate'" ng-init ="getUserName(nextComment.commentProfileId)">
					<p class="comment">{{userName}} said: {{comment.commentText}}</p>
					{{comment.createDate | date : 'short'}}
				</div>
			</div>
		</div>
	</div>

	<!-- view to actually load the needed comment -->
	<div class="create-comment">
		<div class="row">
			<form name="comment-form" id="comment-form" ng-submit="submit(comment,comment-form.$vaild);" novalidate>
				<div class="input-group">
					<input type="text" class="form-control" name="comment" id="comment" cols="30" row="3" ng-minlength="2" ng-maxlength="256" ng-required="true" placeholder="comment" ng-model="commentData.commentText">

					<span class="input-group-btn"><button type="submit" class="btn btn-default"><i class="fa fa-comment"></i>&nbsp;Submit</button></span>
				</div>
			</form>
		</div>
	</div>
</div>