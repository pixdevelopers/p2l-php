(function() {
    "use strict";
    angular.module('p2lApp')
        .controller('orderNowCtrl', function($scope, $http, $state) {
            $scope.toStepTwo = function() {
                $state.go('step-2');
            }
            $scope.choosePackage = function(thePackage) {
                $scope.packageChosen = thePackage;
                $state.go('step-3');
                console.log(thePackage);
            }
            $scope.getFeatures = function() {
                //SelectFeaturesCategories
                $http.post('api.php', { request: 'SelectFeaturesCategories' }).then(function(res) {
                    $http.post('api.php', { request: 'SelectFeatures' }).then(function(res) {

                    });
                });
            }
        });


})();