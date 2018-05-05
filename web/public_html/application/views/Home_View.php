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
            $('html, body').animate({scrollTop:0}, 500);
            return false;
        });
        let app = angular.module('myapp', []);
        app.controller('myctrl', ($scope, $http) => {
            $scope.refresh = () => {
                $http.get('https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/~api/restaurant')
                    .then((response) => {
                        $scope.restaurant = response.data.restaurant;
                    });
            }
            $scope.refresh();
        });
    </script>
</head>
<body ng-controller="myctrl">
    <div class="container" style="padding-top: 120px; padding-bottom: 100px;">
        <div class="row">
            <div class="col-md-3" ng-repeat="x in restaurant">
                <div class="polaroid">
                    <a href="<?= base_url('restaurant') ?>/{{x.RES_ID}}" style="text-decoration: none">
                        <img src="https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/images/{{x.RES_IMAGES}}" style="width:100%" ng-hide="x.RES_IMAGES === NULL">
                        <img src="https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/images/thumbnail-default.jpg" style="width:100%" ng-hide="x.RES_IMAGES !== NULL">
                        <div class="content">
                            <div>{{x.RES_NAME}}</div>
                            <hr>
                            <div>
                                <span ng-hide="x.RES_SCORE === NULL">{{x.RES_SCORE}}</span>
                                <span ng-hide="x.RES_SCORE !== NULL">0.00</span>
                                <span class="fa fa-star" style="color: #ec2652;"></span>
                            </div>
                            <div>post by: {{x.POST_BY}}</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <a id="top" class="footer" href="">
            <i class="fa fa-level-up"></i>
        </a>
    </div>
</body>
</html>