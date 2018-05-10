<?php
    $session = $this->session->userdata('user_data');
?>
<!DOCTYPE html>
<html ng-app="myapp">
<head>
    <title>Home</title>
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
                $http.get('https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/~api/account/<?= $session['token'] ?>/restaurant')
                    .then((response) => {
                        $scope.restaurant = response.data.restaurant;
                    });

                $http.get('https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/~api/account/<?= $session['token'] ?>/food')
                    .then((response) => {
                        $scope.food = response.data.food;
                    });
            }
            $scope.refresh();

            $scope.drop_retuarant = (RES_ID) => {
                $http.delete('https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/~api/restaurant/' + RES_ID)
                    .then((response) => {
                        $scope.refresh();
                    });
            }

            $scope.drop_food = (RES_ID, FOOD_ID) => {
                $http.delete('https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/~api/restaurant/' + RES_ID + '/food/' + FOOD_ID)
                    .then((response) => {
                        $scope.refresh();
                    });
            }
        });
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
                <div class="row" style="background: #fafafa; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24); height: 48px; font-size: 18px">
                    <div class="col-md-4 title-card-2">
                        My Review
                    </div>
                    <div class="col-md-8 text-right button-container">
                        <a href="<?= base_url('review/add') ?>" style="margin-top: 10px">
                            ADD
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="background: #ec2652; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24); height: 38px; width: 100%; margin-left: 0px; margin-bottom: 15px; font-size: 20px; border-radius: 6px;">
            <div class="col-md-12" style="margin-top: 4px; color: #fff">
                Restaurant
            </div>
        </div>
        <div class="row" ng-if="restaurant !== 'No data in Restaurant api.'">
            <div class="col-md-3" ng-repeat="x in restaurant | filter: search">
                <div class="polaroid">
                    <span class="delete" ng-click="drop_retuarant(x.RES_ID)">
                        <i class="fa fa-close"></i>
                    </span>
                    <a href="<?= base_url('review/edit') ?>?type=restaurant&res_id={{x.RES_ID}}" style="text-decoration: none">
                        <img src="https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/images/{{x.RES_IMAGE}}" style="width:100%; height: 170px" ng-hide="x.RES_IMAGE == NULL">
                        <img src="https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/images/thumbnail-default.jpg" style="width:255px" ng-hide="x.RES_IMAGE != NULL">
                        <div class="content">
                            <div>{{x.RES_NAME}}</div>
                            <hr>
                            <div>
                                <span ng-repeat="n in [1,2,3,4,5]">
                                    <span class="fa fa-star" style="color: #ec2652;" ng-if="x.RES_SCORE >= n"></span>
                                    <span class="fa fa-star-o" ng-if="x.RES_SCORE < n"></span>
                                </span>
                            </div>
                            <div>post by: {{x.POST_BY}}</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row" ng-if="restaurant === 'No data in Restaurant api.'">
            <div class="col-md-12">
                <div class="polaroid">
                    <div class="content">
                        <div class="title">No information in database.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="background: #ec2652; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24); height: 38px; width: 100%; margin-left: 0px; margin-bottom: 15px; font-size: 20px; border-radius: 6px;">
            <div class="col-md-12" style="margin-top: 4px; color: #fff">
                Food
            </div>
        </div>
        <div class="row" ng-if="food !== 'No data in Food api.'">
            <div class="col-md-3" ng-repeat="x in food | filter: search">
                <div class="polaroid">
                    <span class="delete" ng-click="drop_food(x.RES_ID, x.FOOD_ID)">
                        <i class="fa fa-close"></i>
                    </span>
                    <a href="<?= base_url('review/edit') ?>?type=food&res_id={{x.RES_ID}}&food_id={{x.FOOD_ID}}" style="text-decoration: none">
                        <img src="https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/images/{{x.FOOD_IMAGE}}" style="width:100%; height: 170px" ng-hide="x.FOOD_IMAGE == NULL">
                        <img src="https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/images/thumbnail-default.jpg" style="width:100%" ng-hide="x.FOOD_IMAGE != NULL">
                        <div class="content">
                            <div>{{x.FOOD_NAME}}</div>
                            <hr>
                            <div>
                                <span ng-repeat="n in [1,2,3,4,5]">
                                    <span class="fa fa-star" style="color: #ec2652;" ng-if="x.FOOD_SCORE >= n"></span>
                                    <span class="fa fa-star-o" ng-if="x.FOOD_SCORE < n"></span>
                                </span>
                            </div>
                            <div>post by: {{x.POST_BY}}</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="row" ng-if="food === 'No data in Food api.'">
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