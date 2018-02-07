(function(window, angular, undefined) {

    "use strict";
    angular.module('p2lApp')
        .config(['$urlRouterProvider', '$locationProvider', '$httpProvider', function( $urlRouterProvider, $locationProvider, $httpProvider) {
            $httpProvider.defaults.useXDomain = true;
            delete $httpProvider.defaults.headers.common["X-Requested-With"];
            $httpProvider.defaults.headers.common["Accept"] = "application/json";
            $httpProvider.defaults.headers.common["Content-Type"] = "application/json";
            //$locationProvider.html5Mode(true);
            $urlRouterProvider.otherwise('/');
           
        }]);
})();