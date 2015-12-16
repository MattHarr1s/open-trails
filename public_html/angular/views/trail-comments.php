<div class="container">
	<div class="row" ng-repeat="comment in comments">
		<div class="panel panel-primary">
			<div class="panel-body">
				<p>{{comment.commentText}}</p>
				<small>Posted on: {{comment.createDate | date:"MM/dd/yyyy 'at' h:mma"}}</small>
			</div>
		</div>
	</div>
</div>