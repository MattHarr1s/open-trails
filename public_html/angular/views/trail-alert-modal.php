<!-- trail alert modal -->

<div class="modal-body">
	<form id="trailAlertModal" name="trailAlertModal" class="form-inline">
		<h2>Trail Alert</h2>
		<hr/>

		<label class="control-label" for="trailCondition">Tell us what's wrong with this trail.</label>

		<div class="form-group" ng-class="{ 'has-error' : trailAlertData.trailCondition.$touched && trailAlertData.trailCondition.$invalid}">
			<label class="control-label sr-only" for="trailCondition">Tell us what's wrong with this trail.</label>

			<div class="input-group">
				<div class="input-group-addon">
					<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
				</div>
				<input type="text" class="form-control" id="trailCondition" name="trailCondition" placeholder="" ng-model="trailAlertData.trailCondition" ng-required="true"/>
			</div>
			<div class="alert alert-danger" role="alert" ng-messages="trailAlertData.trailCondition.$error" ng-if="trailAlertData.trailCondition.$touched" ng-hide="trailAlertData.trailCondition.$valid">
				<p ng-message="required">Please enter something.</p>
			</div>
		</div>
		<hr/>
		<button type="submit" class="btn btn-lg btn-info" ng-click="ok();" ng-disabled="trailAlertData.$invalid">
			<i class="fa fa-check" aria-hidden="true"></i>Submit
		</button>
	</form>
</div>