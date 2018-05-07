<?php
    $session = $this->session->userdata('user_data');
?>
<!DOCTYPE html>
<html ng-app="myapp">
<head>
    <title>Home</title>
    <link rel="icon" href="https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/images/dinner.png">
    <link rel="stylesheet" type="text/css" href="<?= base_url('js/home.css') ?>">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
        $(document).on('click', '#top', () => {
            $('html, body').animate({scrollTop:0}, 250);
            return false;
        });
        let app = angular.module('myapp', []);
        app.controller('myctrl', ($scope, $http) => {
            $scope.type = '<?= $data["type"] ?>';
            if($scope.type === 'restaurant') {
                $http.get('https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/~api/restaurant/<?= $data["res_id"] ?>')
                    .then((response) => {
                        $scope.restaurant = response.data.restaurant;
                        $scope.res = {};
                        $scope.res.RES_ID = $scope.restaurant[0].RES_ID;
                        $scope.res.RES_NAME = $scope.restaurant[0].RES_NAME;
                        $scope.res.RES_REVIEW = $scope.restaurant[0].RES_REVIEW;
                        $scope.res.OPENNING_TIME = $scope.restaurant[0].OPENNING_TIME;
                        $scope.res.CLOSING_TIME = $scope.restaurant[0].CLOSING_TIME;
                        $scope.res.RES_PHONE = $scope.restaurant[0].RES_PHONE;
                        $scope.res.RES_SCORE = $scope.restaurant[0].RES_SCORE;
                        $scope.res.RES_IMAGE = $scope.restaurant[0].RES_IMAGE;
                    });
            } else {
                $http.get('https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/~api/restaurant')
                    .then((response) => {
                        $scope.restaurant = response.data.restaurant;
                    });

                $http.get('https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/~api/restaurant/<?= $data["res_id"] ?>/food/<?= $data["food_id"] ?>')
                    .then((response) => {
                        $scope.food = response.data.food;
                        $scope.fd = {};
                        $scope.fd.FOOD_ID = $scope.food[0].FOOD_ID;
                        $scope.fd.FOOD_NAME = $scope.food[0].FOOD_NAME;
                        $scope.fd.FOOD_REVIEW = $scope.food[0].FOOD_REVIEW;
                        $scope.fd.FOOD_PRICE = $scope.food[0].FOOD_PRICE;
                        $scope.fd.FOOD_SCORE = $scope.food[0].FOOD_SCORE;
                        $scope.fd.FOOD_IMAGE = $scope.food[0].FOOD_IMAGE;
                        $scope.fd.RES_ID = '<?= $data["res_id"] ?>';
                    });
            }
        });

        function file_upload() {
            document.getElementById('photo').click();
        }
        function display_upload() {
            document.getElementById('filedisplay').innerHTML = document.getElementById('photo').value.substring(12);
        }

        function initMap(latitude, longitude) {
            var latlng = new google.maps.LatLng(
                0,
                0
            );
            map = new google.maps.Map(document.getElementById('map_canvas'), {
                center: latlng,
                zoom: 18
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnckJfCM0a0gmuUUpvzrmUHZgqavIZIkk&libraries=places&callback=initMap" async defer></script>
</head>
<body ng-controller="myctrl">
    <div class="container" style="padding-bottom: 100px;">
        <div class="row" style="padding-bottom: 25px;">
            <div class="col-md-12">
                <div class="row" style="background: #fafafa; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24); height: 48px; font-size: 18px">
                    <div class="col-md-4 title-card">
                        <?= $session['name'] ?>
                    </div>
                    <div class="col-md-8 text-right button-container">
                        <input type="text" name="search" ng-model="search" ng-blur="search = ''">
                        <a href="<?= base_url('home') ?>" style="margin-top: 10px">
                            Home
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="padding-bottom: 25px;">
            <div class="col-md-12">
                <div class="row" style="background: #fafafa; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24); height: 48px; font-size: 18px">
                    <div class="col-md-4 title-card-2">
                        Edit Review
                    </div>
                    <div class="col-md-8 text-right button-container">
                        <a href="<?= base_url('review') ?>" style="margin-top: 10px">
                            BACK
                        </a>
                    </div>
                </div>
                
                <div class="row" style="background: #f9f9f9; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24); font-size: 18px; padding: 20px 0px;">
                    <div class="form-group" ng-show="type === 'restaurant'">
                        <form action="<?= base_url('review/add') ?>" method="post">
                            <div class="row col-md-12" style="margin-left: 0px">
                                <div class="form-group col-md-12">
                                    <label style="font-size: 14px">Restaurant Name</label>
                                    <input type="text" class="form-control" ng-model="res.RES_NAME" placeholder="Restaurant Name" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label style="font-size: 14px">Review</label>
                                    <textarea rows="5" class="form-control" ng-model="res.RES_REVIEW" maxlength="250" required></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label style="font-size: 14px">Openning Time</label>
                                    <input type="text" class="form-control" ng-model="res.OPENNING_TIME" placeholder="Openning Time" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label style="font-size: 14px">Closing Time</label>
                                    <input type="text" class="form-control" ng-model="res.CLOSING_TIME" placeholder="Closing Time" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label style="font-size: 14px">Phone</label>
                                    <input type="text" class="form-control" ng-model="res.RES_PHONE" placeholder="Phone" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label style="font-size: 14px">Score</label>
                                    <input type="text" class="form-control" ng-model="res.RES_SCORE" placeholder="Score" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <div id="map_canvas" class="col-md-12" style="margin-top: 10px; width: 100%; height: 250px"></div>
                                </div>
                                <div class="form-group col-md-12" style="margin-top: 10px;">
                                    <div id="filechoose" class="btn btn-default" onclick='file_upload()'>Choose File</div>
                                    <small id="filedisplay" class="text-muted">
                                        <span ng-show="x.RES_IMAGE == NULL">Choose images for restaurant.</span>
                                        <span ng-show="x.RES_IMAGE != NULL">{{x.RES_IMAGE}}</span>
                                    </small>
                                    <input type="file" id="photo" ng-model="res.RES_IMAGE" onchange="display_upload()" accept=".png, .jpg, .jpeg" style="display: none;">
                                </div>
                            </div>
                            <div class="row col-md-12 text-right">
                                <input type="submit" class="btn btn-default" ng-click="add()" value="ADD">
                            </div>
                        </form>
                    </div>
                    <div class="form-group" ng-show="type === 'food'">
                        <form action="<?= base_url('review/add') ?>" method="post">
                            <div class="row col-md-12" style="margin-left: 0px">
                                <div class="form-group col-md-12">
                                    <label style="font-size: 14px">Restaurant</label>
                                    <select class="form-control" ng-model="fd.RES_ID">
                                        <option ng-repeat="x in restaurant" value="{{x.RES_ID}}">{{x.RES_NAME}}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label style="font-size: 14px">Food Name</label>
                                    <input type="text" class="form-control" ng-model="fd.FOOD_NAME" placeholder="Food Name" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label style="font-size: 14px">Review</label>
                                    <textarea rows="5" class="form-control" ng-model="fd.FOOD_REVIEW" maxlength="250" required></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label style="font-size: 14px">Price</label>
                                    <input type="text" class="form-control" ng-model="fd.FOOD_PRICE" placeholder="Price" min="1" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label style="font-size: 14px">Score</label>
                                    <input type="text" class="form-control" ng-model="fd.FOOD_SCORE" placeholder="Score" min="0" max="5" required>
                                </div>
                                <div class="form-group col-md-12" style="margin-top: 10px;">
                                    <div id="filechoose" class="btn btn-default" onclick='file_upload()'>Choose File</div>
                                    <small id="filedisplay" class="text-muted">
                                        <span ng-show="x.RES_IMAGE == NULL">Choose images for food.</span>
                                        <span ng-show="x.RES_IMAGE != NULL">{{x.FOOD_IMAGE}}</span>
                                    </small>
                                    <input type="file" id="photo" ng-model="fd.FOOD_IMAGE" onchange="display_upload()" accept=".png, .jpg, .jpeg" style="display: none;">
                                </div>
                            </div>
                            <div class="row col-md-12 text-right">
                                <input type="submit" class="btn btn-default" ng-click="add()" value="ADD">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <a id="top" class="footer" href="">
            <i class="fa fa-level-up"></i>
        </a>
    </div>
</body>
</html>