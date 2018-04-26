(function() {
    "use strict";
    angular.module('p2lApp')
        .controller('adminUserGroupsCtrl', function($rootScope, $scope, $http, $timeout, $state) {
            $scope.createUserGroup = function() {


                var req = {
                    request: 'addNewUserGroup',
                    name: $scope.userGroupName,
                    manageUserGroups: $scope.userGroupRole.manageUserGroups,
                    manageAdmins: $scope.userGroupRole.manageAdmins,
                    manageFeatures: $scope.userGroupRole.manageFeatures,
                    managePackages: $scope.userGroupRole.managePackages,
                    manageUsers: $scope.userGroupRole.manageUsers
                };

                $http.post('api/api.php', req).then(function(res) {
                    console.log(res);
                    if (res.data) {
                        iziToast.success({
                            title: 'Success!',
                            message: 'Success Message...',
                            position: 'topRight'
                        });
                    } else {
                        iziToast.error({
                            title: 'Error!',
                            message: 'Error Message...',
                            position: 'topRight'
                        });
                    }
                });


            }



        });
})();