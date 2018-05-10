<?php
    $session = $this->session->userdata('user_data');
?>
<!DOCTYPE html>
<html ng-app="myapp">
<head>
    <title>Edit Review</title>
    <link rel="icon" href="https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/images/dinner.png">
    <link rel="stylesheet" type="text/css" href="<?= base_url('js/home.css') ?>">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('js/timepicker.css') ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url('js/timepicker.js') ?>"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnckJfCM0a0gmuUUpvzrmUHZgqavIZIkk&libraries=places" async defer></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '#top', () => {
                $('html, body').animate({scrollTop:0}, 250);
                return false;
            });

            $("#dtBox").DateTimePicker();
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
                        $scope.res.RES_PHONE = $scope.restaurant[0].RES_PHONE;
                        $scope.res.RES_SCORE = $scope.restaurant[0].RES_SCORE;
                        $scope.res.RES_IMAGE = $scope.restaurant[0].RES_IMAGE;

                        let latitude = $scope.restaurant[0].RES_LATITUDE;
                        var longitude = $scope.restaurant[0].RES_LONGITUDE;
                        initMap(latitude, longitude);


                        document.getElementById('latclicked').value = $scope.restaurant[0].RES_LATITUDE;
                        document.getElementById('longclicked').value = $scope.restaurant[0].RES_LONGITUDE;

                        if($scope.restaurant[0].OPENNING_TIME != null) {
                            let openning_time = $scope.restaurant[0].OPENNING_TIME.split(":");
                            $scope.res.OPENNING_TIME = openning_time[0] + ":" + openning_time[1];
                        } else {
                            $scope.res.OPENNING_TIME = null;
                        }

                        if($scope.restaurant[0].CLOSING_TIME != null) {
                            let closing_time = $scope.restaurant[0].CLOSING_TIME.split(":");
                            $scope.res.CLOSING_TIME = closing_time[0] + ":" + closing_time[1];
                        } else {
                            $scope.res.CLOSING_TIME = null;
                        }
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

            $scope.edit_res = () => {
                $scope.res.POST_BY = "<?= $this->session->userdata('user_data')['token'] ?>";

                if(document.getElementById('openning').value != '') {
                    $scope.res.OPENNING_TIME = document.getElementById('openning').value;
                } else {
                    $scope.res.OPENNING_TIME = null;
                }

                if(document.getElementById('closing').value != '') {
                    $scope.res.CLOSING_TIME = document.getElementById('closing').value;
                } else {
                    $scope.res.CLOSING_TIME = null;
                }
                
                $scope.res.RES_LATITUDE = document.getElementById('latclicked').value;
                $scope.res.RES_LONGITUDE = document.getElementById('longclicked').value;

                if(document.getElementById('photo_res').value != null && document.getElementById('photo_res').value != '') {
                    $scope.res.RES_IMAGE = document.getElementById('photo_res').value.substring(12);
                } else if($scope.res.RES_IMAGE == null) {
                    $scope.res.RES_IMAGE = null;
                }

                $http.put('https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/~api/restaurant/<?= $data["res_id"] ?>', $scope.res);
            }

            $scope.edit_food = () => {
                $scope.fd.POST_BY = "<?= $this->session->userdata('user_data')['token'] ?>";
                if(document.getElementById('photo_food').value != null && document.getElementById('photo_food').value != '') {
                    $scope.fd.FOOD_IMAGE = document.getElementById('photo_food').value.substring(12);
                } else if($scope.fd.FOOD_IMAGE == null) {
                    $scope.fd.FOOD_IMAGE = null;
                }

                $http.put('https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/~api/restaurant/<?= $data["res_id"] ?>/food/<?= $data["food_id"] ?>', $scope.fd);
            }
        });

        function image_value() {
            if(document.getElementById('photo_res').value != null) {
                return document.getElementById('photo_res').value.substring(12);
            } else if(document.getElementById('photo_food').value != null) {
                return document.getElementById('photo_food').value.substring(12);
            } else {
                return null;
            }
        }

        function file_upload(type) {
            if(type == 0) {
                document.getElementById('photo_res').click();
            } else {
                document.getElementById('photo_food').click();
            }
        }

        function display_upload(type) {
            if(type == 0) {
                document.getElementById('filedisplay').innerHTML = document.getElementById('photo_res').value.substring(12);
            } else {
                document.getElementById('filedisplay_2').innerHTML = document.getElementById('photo_food').value.substring(12);
            }
        }

        var map;
        var markers = [];

        function initMap(latitude, longitude) {
            var latlng = new google.maps.LatLng(
                latitude,
                longitude
            );

            map = new google.maps.Map(document.getElementById('map_canvas'), {
              zoom: 16,
              center: latlng,
            });

            var marker = new google.maps.Marker({
                position: latlng,
                map: map
            });
            clearMarkers();
            markers = [];
            markers.push(marker);

            // This event listener will call addMarker() when the map is clicked.
            map.addListener('click', function(event) {
                addMarker(event.latLng);
            });

            google.maps.event.addListener(map,'click',function(event) {                
                document.getElementById('latclicked').value = event.latLng.lat();
                document.getElementById('longclicked').value =  event.latLng.lng();
            });

            marker.addListener('click', function(event) {              
                document.getElementById('latclicked').value = event.latLng.lat();
                document.getElementById('longclicked').value =  event.latLng.lng();
            });
        }

          // Adds a marker to the map and push to the array.
        function addMarker(location) {
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
            clearMarkers();
            markers = [];
            markers.push(marker);
        }
          
          // Sets the map on all markers in the array.
        function setMapOnAll(map) {
            for (var i = 0; i < markers.length; i++) {
              markers[i].setMap(map);
            }
        }

          // Removes the markers from the map, but keeps them in the array.
        function clearMarkers() {
            setMapOnAll(null);
        }
    </script>
    
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

        <?php if(isset($data['exception'])) { ?>
        <div class="alert alert-danger fade in">
            <?= $data['exception'] ?>
        </div>
        <?php } ?>

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
                        <form action="<?= base_url('review/edit?type=restaurant&res_id=') . $data["res_id"] ?>" method="post" ng-submit="edit_res()" enctype="multipart/form-data">
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
                                    <input type="text" class="form-control" ng-model="res.OPENNING_TIME" data-field="time" id="openning" required readonly placeholder="Openning Time" style="background: #fff; cursor: unset;">
                                </div>
                                <div class="form-group col-md-6">
                                    <label style="font-size: 14px">Closing Time</label>
                                    <input type="text" class="form-control" ng-model="res.CLOSING_TIME" data-field="time" id="closing" required readonly placeholder="Closing Time" style="background: #fff; cursor: unset;">
                                </div>
                                <div class="form-group col-md-12">
                                    <label style="font-size: 14px">Phone</label>
                                    <input type="text" class="form-control" ng-model="res.RES_PHONE" placeholder="Phone" minlength="10" maxlength="10" pattern="[0-9]{10}">
                                </div>
                                <div class="form-group col-md-12">
                                    <label style="font-size: 14px">Score</label>
                                    <select class="form-control" ng-model="res.RES_SCORE">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <div id="map_canvas" class="col-md-12" style="margin-top: 10px; width: 100%; height: 250px"></div>
                                    <input type="hidden" id="latclicked">
                                    <input type="hidden" id="longclicked">
                                </div>
                                <div class="form-group col-md-12" style="margin-top: 10px;">
                                    <div id="filechoose" class="btn btn-default" onclick='file_upload(0)'>Choose File</div>
                                    <small id="filedisplay" class="text-muted">Choose images for restaurant.</small>
                                    <input type="file" id="photo_res" name="photo" onchange="display_upload(0)" accept=".png, .jpg, .jpeg" style="display: none;">
                                </div>
                            </div>
                            <div class="row col-md-12 text-right">
                                <input type="submit" class="btn btn-default" value="EDIT">
                            </div>
                        </form>
                    </div>
                    <div class="form-group" ng-show="type === 'food'">
                        <form action="<?= base_url('review/edit') ?>" method="post" ng-submit="edit_food()" enctype="multipart/form-data">
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
                                    <input type="text" class="form-control" ng-model="fd.FOOD_PRICE" placeholder="Price" required pattern="[0-9]+" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label style="font-size: 14px">Score</label>
                                    <select class="form-control" ng-model="fd.FOOD_SCORE">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12" style="margin-top: 10px;">
                                    <div id="filechoose" class="btn btn-default" onclick='file_upload(1)'>Choose File</div>
                                    <small id="filedisplay_2" class="text-muted">Choose images for food.</small>
                                    <input type="file" id="photo_food" name="photo" onchange="display_upload(1)" accept=".png, .jpg, .jpeg" style="display: none;">
                                </div>
                            </div>
                            <div class="row col-md-12 text-right">
                                <input type="submit" class="btn btn-default" value="EDIT">
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
    <div id="dtBox"></div>
</body>
</html>