<?php
    $session = $this->session->userdata('user_data');
?>
<!DOCTYPE html>
<html ng-app="myapp">
<head>
    <title>Review</title>
    <link rel="icon" href="https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/images/dinner.png">
    <link rel="stylesheet" type="text/css" href="<?= base_url('js/home.css') ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
            $scope.refresh = () => {
                $http.get('https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/~api/restaurant/<?php echo $id; ?>')
                    .then((response) => {
                        $scope.restaurant = response.data.restaurant;
                        let latitude = $scope.restaurant[0].RES_LATITUDE;
                        var longitude = $scope.restaurant[0].RES_LONGITUDE;
                        initMap(latitude, longitude);

                        if($scope.restaurant[0].OPENNING_TIME != null) {
                            let openning_time = $scope.restaurant[0].OPENNING_TIME.split(":");
                            $scope.restaurant[0].OPENNING_TIME = openning_time[0] + ":" + openning_time[1];
                        } else {
                            $scope.restaurant[0].OPENNING_TIME = null;
                        }

                        if($scope.restaurant[0].CLOSING_TIME != null) {
                            let closing_time = $scope.restaurant[0].CLOSING_TIME.split(":");
                            $scope.restaurant[0].CLOSING_TIME = closing_time[0] + ":" + closing_time[1];
                        } else {
                            $scope.restaurant[0].CLOSING_TIME = null;
                        }
                    });

                $http.get('https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/~api/restaurant/<?php echo $id;?>/food')
                    .then((response) => {
                        $scope.food = response.data.food;
                    });
            }
            $scope.refresh();
        });

        function initMap(latitude, longitude) {
            var latlng = new google.maps.LatLng(
                latitude,
                longitude
            );
            map = new google.maps.Map(document.getElementById('map_canvas'), {
                center: latlng,
                zoom: 18
            });

            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                title: 'Click to zoom'
            });

            marker.addListener('click', function() {
                map.setZoom(18);
                map.setCenter(marker.getPosition());
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnckJfCM0a0gmuUUpvzrmUHZgqavIZIkk&libraries=places" async defer></script>
</head>
<body ng-controller="myctrl">
    <div class="container" style="padding-bottom: 100px;">
        <div class="row" style="padding-bottom: 25px;">
            <div class="col-md-12">
                <div class="row" style="background: #fafafa; border-radius: 3px;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24); height: 48px; font-size: 18px">
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
                <div ng-repeat="x in restaurant" style="margin-top: 10px;">
                    <div class="row" style="background: #fafafa; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24); height: 48px; font-size: 18px">
                        <div class="col-md-12 title-card-2 text-center">
                            {{x.RES_NAME}}
                        </div>
                    </div>
                    <div class="row" style="background: #fafafa; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24); font-size: 16px; padding: 10px 0px">
                        <div class="col-md-4 title-card-2 text-right">
                            <img src="https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/images/{{x.RES_IMAGE}}" style="width:100%; height: 170px" ng-hide="x.RES_IMAGE == null">
                            <img src="https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/images/thumbnail-default.jpg" style="width:100%" ng-hide="x.RES_IMAGE != null">
                        </div>
                        <div class="col-md-8" style="border-left: #ec2652 2px solid;">
                            <div class="row">
                                <div class="col-md-12" style="padding-top: 5px; word-wrap: break-word">{{x.RES_REVIEW}}</div>
                                <div class="col-md-12" ng-hide="x.OPENNING_TIME == null" style="padding-top: 10px;">Opening Time : {{x.OPENNING_TIME}}</div>
                                <div class="col-md-12" ng-hide="x.CLOSING_TIME == null" style="padding-top: 10px;">Closing Time : {{x.CLOSING_TIME}}</div>
                                <div class="col-md-12" ng-hide="x.RES_PHONE == null" style="padding-top: 10px;">Phone Number : {{x.RES_PHONE}}</div>
                                <div class="col-md-12" style="padding-top: 10px;">
                                    <span ng-repeat="n in [1,2,3,4,5]">
                                        <span class="fa fa-star" style="color: #ec2652;" ng-if="x.RES_SCORE >= n"></span>
                                        <span class="fa fa-star-o" ng-if="x.RES_SCORE < n"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="font-size: 14px; color: #444;">
                            <div class="col-md-12 text-right">Post by : {{x.POST_BY}}</div>
                        </div>
                    </div>
                </div>
                <div class="row" style="background: #fafafa; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24); font-size: 18px; height: 300px;">
                    <div id="map_canvas" style="width: 100%; height: 100%"></div>
                </div>
            </div>
        </div>
        <div class="row" ng-if="food !== 'No data in Restaurant api.'">
            <div class="col-md-3" ng-repeat="x in food | filter: search">
                <div class="polaroid" ng-repeat="y in restaurant">
                        <a href="<?= base_url('food') ?>?id={{x.FOOD_ID}}&resid={{y.RES_ID}}" style="text-decoration: none">
                            <img src="https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/images/{{x.FOOD_IMAGE}}" style="width:100%; height: 170px" ng-hide="x.FOOD_IMAGE == null">
                            <img src="https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/images/thumbnail-default.jpg" style="width:100%" ng-hide="x.FOOD_IMAGE != null">
                            <div class="content">
                                <div>{{x.FOOD_NAME}}</div>
                                <div>
                                    <span ng-repeat="n in [1,2,3,4,5]">
                                        <span class="fa fa-star" style="color: #ec2652;" ng-if="x.FOOD_SCORE >= n"></span>
                                        <span class="fa fa-star-o" ng-if="x.FOOD_SCORE < n"></span>
                                    </span>
                                </div>
                                <div>Post by: {{x.POST_BY}}</div>
                            </div>
                        </a>
                </div>
            </div>
        </div>
        <div class="row" ng-if="food === 'No data in Restaurant api.'">
            <div class="col-md-12">
                <div class="polaroid">
                    <div class="content">
                        <div class="title">No information in database.</div>
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