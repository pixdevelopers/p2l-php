(function() {
    "use strict";
    angular.module('p2lApp')
        .directive('navigation', [function() {
            return {
                restrict: 'A',
                templateUrl: 'views/directives/navigation.html'
            };
        }])
        .directive('footer', [function() {
            return {
                restrict: 'A',
                templateUrl: 'views/directives/footer.html'
            };
        }])
        .directive('stepsNavigation', [function() {
            return {
                restrict: 'A',
                templateUrl: 'views/directives/steps-navigation.html'
            };
        }])
        .directive('authNavigation', [function() {
            return {
                restrict: 'A',
                templateUrl: 'views/directives/auth-navigation.html'
            };
        }])
         .directive('dashboardSidebar', [function() {
            return {
                restrict: 'A',
                templateUrl: 'views/directives/dashboard-sidebar.html'
            };
        }]);

})();