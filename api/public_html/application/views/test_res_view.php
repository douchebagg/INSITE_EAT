<html ng-app="myApp">
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
	<script>
		let app = angular.module('myApp', []);
		app.controller('myCtrl', function($scope, $http) {
			$scope.refresh = function() {
				$http.get('<?= base_url("restaurant") ?>')
			        .then(function(response) {
			            $scope.restaurant = JSON.parse(response.data.restaurant);
			        });
			}

			$scope.add_restaurant = function() {
				$http.post("<?= base_url('restaurant') ?>", $scope.add)
					.then(function(response) {
						$scope.refresh();
					});
			}

			$scope.edit_restaurant = function($id) {
				$http.put("<?= base_url('restaurant/') ?>" + $id, $scope.edit)
					.then(function(response) {
						$scope.refresh();
					});
			}

		    $scope.delete_restaurant = function($id) {
		    	$http.delete("<?= base_url('restaurant/') ?>" + $id)
		    		.then(function(response) {
		    			$scope.refresh();
		    		});
			}

			$scope.refresh();
			$scope.activity = 1;
			$scope.isadd = function() {
				$scope.activity = 1;
			}
			$scope.isedit = function($id) {
				$http.get('<?= base_url("restaurant/") ?>' + $id)
			        .then(function(response) {
			            $scope.edit_data = JSON.parse(response.data.restaurant);
			            $scope.edit = {};
			            $scope.edit.RES_ID = $scope.edit_data[0].RES_ID;
			            $scope.edit.RES_NAME = $scope.edit_data[0].RES_NAME;
			            $scope.edit.RES_REVIEW = $scope.edit_data[0].RES_REVIEW;
			            $scope.edit.RES_LOCALTION = $scope.edit_data[0].RES_LOCALTION;
			            $scope.edit.OPENNING_TIME = $scope.edit_data[0].OPENNING_TIME;
			            $scope.edit.CLOSING_TIME = $scope.edit_data[0].CLOSING_TIME;
			            $scope.edit.RES_PHONE = $scope.edit_data[0].RES_PHONE;
			            $scope.edit.RES_SCORE = $scope.edit_data[0].RES_SCORE;
			        });
				$scope.activity = 0;
			}
		});
	</script>
</head>
<body ng-controller="myCtrl">
	<div ng-hide="activity == 0">
		<h2>ADD</h2>
		{{add}} <br>
		id: <input type="text" ng-model="add.RES_ID"><br>
		name: <input type="text" ng-model="add.RES_NAME"><br>
		review: <input type="text" ng-model="add.RES_REVIEW"><br>
		location: <input type="text" ng-model="add.RES_LOCALTION"><br>
		openning: <input type="text" ng-model="add.OPENNING_TIME"><br>
		closing: <input type="text" ng-model="add.CLOSING_TIME"><br>
		phone: <input type="text" ng-model="add.RES_PHONE"><br>
		score: <input type="text" ng-model="add.RES_SCORE"><br>
		<input type="submit" ng-click="add_restaurant()">
	</div>

	<div ng-hide="activity == 1">
		<h2>EDIT</h2>
		{{edit}} <br>
		id: <input type="text" ng-model="edit.RES_ID" disabled><br>
		name: <input type="text" ng-model="edit.RES_NAME"><br>
		review: <input type="text" ng-model="edit.RES_REVIEW"><br>
		location: <input type="text" ng-model="edit.RES_LOCALTION"><br>
		openning: <input type="text" ng-model="edit.OPENNING_TIME"><br>
		closing: <input type="text" ng-model="edit.CLOSING_TIME"><br>
		phone: <input type="text" ng-model="edit.RES_PHONE"><br>
		score: <input type="text" ng-model="edit.RES_SCORE"><br>
		<input type="submit" ng-click="edit_restaurant(edit.RES_ID)">
	</div>

	<hr>
	<button ng-click="isadd()" ng-hide="activity == 1">add</button>
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
				<button ng-click="isedit(x.RES_ID)">edit</button>
				<button ng-click="delete_restaurant(x.RES_ID)">delete</button>
			</td>
		</tr>
	</table>
</body>
</html>