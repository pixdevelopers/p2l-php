(function() {
    "use strict";
    angular.module('p2lApp')
        .controller('adminUserGroupsCtrl', function($rootScope, $scope, $http, $timeout, $state) {
            $scope.createUserGroup = function() {
                var req = { request: 'AddUserGroup', Name: $scope.userGroupName, Privilege: $scope.userGroupRole };
                $http.post('http://localskoot.com/api.php', req).then(function(res) {
                    console.log(res);
                });
            }
        });
})();