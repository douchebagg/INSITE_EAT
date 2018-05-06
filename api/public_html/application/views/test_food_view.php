<html ng-app="myApp">
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
	<script>
		let app = angular.module('myApp', []);
		app.controller('myCtrl', function($scope, $http) {
			$scope.refresh = function() {
				$http.get('<?= base_url("restaurant") ?>')
			        .then(function(response) {
			            $scope.restaurant = response.data.restaurant;
			        });
			}

			$scope.refresh();
		});
	</script>
</head>
<body ng-controller="myCtrl">
	<table border="1">
		<tr>
			<td>id</td>
			<td>name</td>
			<td>review</td>
			<td>location</td>
			<td>openning</td>
			<td>closing</td>
			<td>phone</td>
			<td>score</td>
			<td>operation</td>
		</tr>
		<tr ng-repeat="x in restaurant">
			<td>{{x.RES_ID}}</td>
			<td>{{x.RES_NAME}}</td>
			<td>{{x.RES_REVIEW}}</td>
			<td>{{x.RES_LOCALTION}}</td>
			<td>{{x.OPENNING_TIME}}</td>
			<td>{{x.CLOSING_TIME}}</td>
			<td>{{x.RES_PHONE}}</td>
			<td>{{x.RES_SCORE}}</td>
			<td>
				<button ng-click="show_food_at_res()">show</button>
				<button ng-click="">edit</button>
				<button ng-click="">delete</button>
			</td>
		</tr>
	</table>
</body>
</html>