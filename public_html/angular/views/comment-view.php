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
</div>