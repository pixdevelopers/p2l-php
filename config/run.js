(function() {
    "use strict";
    var appRun;
    appRun = function($rootScope, $state, $document, $stateParams) {
        $rootScope.$state = $state;
        $rootScope.$stateParams = $stateParams;
        $rootScope.$on('$stateChangeSuccess', function(event, toState, toParams, fromState, fromParams) {
            var states = ['user-login', 'user-signup', 'user-forgot', 'user-reset', 'user-dashboard', 'user-projects','user-single-project','user-messages','user-payments','user-settings','user-profile'];
            $document[0].body.scrollTop = $document[0].documentElement.scrollTop = 0;
            $rootScope.hideHeaderFooter = (states.indexOf(toState.name) > -1) ? true : false;

        });
    }
    angular.module('p2lApp').run(['$rootScope', '$state', '$document', '$stateParams', appRun]);
})();