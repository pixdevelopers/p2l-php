(function() {
    "use strict";
    angular.module('p2lApp')
        .config(function($stateProvider) {
            $stateProvider
                .state('user-login', {
                    url: '/user/login',
                    templateUrl: 'views/user/login.html',
                    controller: 'userAuthCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('controllers/user/userAuthCtrl.js');
                        }]
                    }
                })
                .state('user-signup', {
                    url: '/user/signup',
                    templateUrl: 'views/user/signup.html',
                    controller: 'userAuthCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('controllers/user/userAuthCtrl.js');
                        }]
                    }
                })
                .state('user-forgot', {
                    url: '/user/forgot',
                    templateUrl: 'views/user/forgot.html',
                    controller: 'userAuthCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('controllers/user/userAuthCtrl.js');
                        }]
                    }
                })
                .state('user-reset', {
                    url: '/user/reset',
                    templateUrl: 'views/user/reset.html',
                    controller: 'userAuthCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('controllers/user/userAuthCtrl.js');
                        }]
                    }
                });
        });




})();