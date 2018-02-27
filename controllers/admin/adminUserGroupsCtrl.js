(function() {
    "use strict";
    angular.module('p2lApp')
        .controller('adminUserGroupsCtrl', function($rootScope, $scope, $http, $timeout, $state) {
            var request = { request: 'getAdmins' };
            $http.post('http://localskoot.com/api.php', request).then(function(res) {
                console.log(res.data);
            });
        });
})();