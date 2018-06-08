(function() {
    "use strict";
    angular.module('p2lApp')
        .controller('adminUserGroupsCtrl', function($rootScope, $scope, $http, $timeout, $state, $stateParams) {
            $scope.getUserGroups = function() {
                var req = { "table": 'usergroups' };

                $http.post('api/read.php', req).then(function(res) {
                    if (res.data) {
                        $scope.userGroups = res.data;
                    }
                });

            }

            $scope.deleteUserGroup = function(id) {
                var req = {
                    "table": 'usergroups', // Example : 'myTable'
                    "where": 'id', // Example : 'id'
                    "value": id // Example : '0123456789'
                }
                $http.post('api/delete.php', req).then(function(res) {
                    if (res.data) {
                        console.log(res.data);
                        iziToast.success({
                            title: 'Deleted',
                            timeout: 2000,
                            position: 'topRight',

                            message: 'User Group has been deleted successfully'
                        });
                        $scope.getCurrentUserGroup();
                        $scope.getUserGroups();

                    } else {
                        iziToast.error({
                            title: 'Ooops!',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'There is a problem deleting user group'
                        });
                    }

                });
            }

            $scope.createUserGroup = function() {
                var req = {
                    "table": 'usergroups', // Example : 'myTable'
                    "fields": ["name", "manageUserGroups", "manageAdmins", "manageFeatures", "managePackages", "manageUsers"], // Example : "name" , "phone" , "email"
                    "values": [$scope.userGroupName, $scope.userGroupRole.manageUserGroups, $scope.userGroupRole.manageAdmins, $scope.userGroupRole.manageFeatures, $scope.userGroupRole.managePackages, $scope.userGroupRole.manageUsers] // Example : "Mamo" , "+90123456789" , "yzmamo@email.com"
                }
                $http.post('api/add.php', req).then(function(res) {
                    if (res.data) {
                        iziToast.success({
                            title: 'Created',
                            timeout: 2000,
                            position: 'topRight',

                            message: 'User Group has been created successfully'
                        });
                        $state.go('admin-user-groups');
                    } else {
                        iziToast.error({
                            title: 'Ooops!',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'There is a problem creating new user group'
                        });
                    }
                });
            }
            $scope.getUserGroups();

            $scope.getCurrentUserGroup = function() {
                var req = {
                    "table": 'usergroups',
                    "where": 'id',
                    "whereValue": $stateParams.groupId
                }
                $http.post('api/findOne.php', req).then(function(res) {
                    if (res.data[0]) {
                        console.log(res.data[0].id);
                        $scope.userGroupId = res.data[0].id;
                        $scope.userGroupName = res.data[0].name;
                        $scope.userGroupRole = [];
                        $scope.userGroupRole.manageUserGroups = !!+res.data[0].manageUserGroups;
                        $scope.userGroupRole.manageFeatures = !!+res.data[0].manageFeatures;
                        $scope.userGroupRole.managePackages = !!+res.data[0].managePackages;
                        $scope.userGroupRole.manageUsers = !!+res.data[0].manageUsers;
                        $scope.userGroupRole.manageAdmins = !!+res.data[0].manageAdmins;
                    } else $state.go('admin-user-groups');

                });
            }

            $scope.updateUserGroup = function() {
                var req = {
                    "table": 'usergroups',
                    "where": 'id',
                    "whereValue": $stateParams.groupId,
                    "fields": ["name", "manageUserGroups", "manageFeatures", "managePackages", "manageUsers", "manageAdmins"],
                    "values": [$scope.userGroupName, $scope.userGroupRole.manageUserGroups, $scope.userGroupRole.manageFeatures, $scope.userGroupRole.managePackages, $scope.userGroupRole.manageUsers, $scope.userGroupRole.manageAdmins]
                }
                $http.post('api/update.php', req).then(function(res) {
                    if (res.data) {
                        iziToast.success({
                            title: 'Updated',
                            timeout: 2000,
                            position: 'topRight',

                            message: 'User Group has been updated successfully'
                        });
                        $state.go('admin-user-groups');
                    } else {
                        iziToast.error({
                            title: 'Ooops!',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'There is a problem updating user group'
                        });
                    }
                });
            }

            $scope.getCurrentUserGroup();


        });
})();