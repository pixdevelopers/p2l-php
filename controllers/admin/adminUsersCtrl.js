(function() {
    "use strict";
    angular.module('p2lApp')
        .controller('adminUsersCtrl', function($rootScope, $scope, $http, $timeout, $state, $stateParams) {

            $scope.getUserGroups = function() {
                var req = { "table": 'usergroups' };
                $http.post('api/read.php', req).then(function(res) {
                    $scope.userGroupsList = res.data;
                });
            }

            $scope.getUsers = function() {
                var req = { "table": 'users' };
                $http.post('api/read.php', req).then(function(res) {
                    if (res.data) {
                        $scope.users = res.data;
                    }
                });

            }

            $scope.getNamebyId = function(id){
                // Get user group name using user group ID :
                if ($scope.userGroupsList.find(item => item.id == id)) {
                    return $scope.userGroupsList.find(item => item.id == id).name;
                }
            }


            $scope.createUser = function() {
                var req = {
                    "table": 'users',
                    "fields": ["name", "email", "password", "userGroupID", "status"],
                    "values": [$scope.name, $scope.email, $scope.password, $scope.userGroup.id, $scope.status] // Example : "Mamo" , "+90123456789" , "yzmamo@email.com"
                }
                $http.post('api/add.php', req).then(function(res) {
                    if (res.data) {
                        iziToast.success({
                            title: 'Created',
                            timeout: 2000,
                            position: 'topRight',

                            message: 'User has been created successfully'
                        });
                        $state.go('admin-users');
                    } else {
                        iziToast.error({
                            title: 'Ooops!',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'There is a problem creating new user'
                        });
                    }
                });
            }

            $scope.deleteUser = function(id) {
                var req = {
                    "table": 'users',
                    "where": 'id',
                    "value": id
                }
                $http.post('api/delete.php', req).then(function(res) {
                    if (res.data) {
                        console.log(res.data);
                        iziToast.success({
                            title: 'Deleted',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'User has been deleted successfully'
                        });
                        $state.go('admin-users');
                        $scope.getUsers();

                    } else {
                        iziToast.error({
                            title: 'Ooops!',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'There is a problem deleting user'
                        });
                    }

                });
            }





            $scope.getCurrentUser = function() {
                var req = {
                    "table": 'users',
                    "where": 'id',
                    "whereValue": $stateParams.userId
                }
                $http.post('api/findOne.php', req).then(function(res) {
                    if (res.data[0]) {
                        $scope.id = res.data[0].id;
                        $scope.name = res.data[0].name;
                        $scope.password = res.data[0].password;
                        $scope.email = res.data[0].email;
                        $scope.status = !!+res.data[0].status;
                        if ($scope.userGroupsList.find(item => item.id == res.data[0].userGroupID)) {
                            $scope.userGroup = res.data[0].userGroupID;
                        }
                    } else $state.go('admin-users');

                });
            }


            $scope.updateUser = function() {




                var req = {
                    "table": 'users',
                    "where": 'id',
                    "whereValue": $scope.id,
                    "fields": ["name", "email", "password", "userGroupID", "status"],
                    "values": [$scope.name, $scope.email, $scope.password, $scope.userGroup, $scope.status]
                }
                $http.post('api/update.php', req).then(function(res) {
                    if (res.data) {
                        iziToast.success({
                            title: 'Updated',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'User has been updated successfully'
                        });
                        $state.go('admin-users');
                    } else {
                        iziToast.error({
                            title: 'Ooops!',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'There is a problem updating user'
                        });
                    }
                });
            }


            $scope.getUserGroups();
            $scope.getUsers();
            $scope.getCurrentUser();

            $rootScope.$on('$viewContentLoaded', function(event) {
                $timeout(function() {
                    $('.bootstrap-select').selectpicker('refresh');
                }, 500);
            });


        });
})();