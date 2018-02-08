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
                })
                .state('user-dashboard', {
                    url: '/user/dashboard',
                    templateUrl: 'views/user/dashboard.html',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('assets/styles/limitless.min.css','assets/scripts/limitless.min.js');
                        }]
                    }
                })
                .state('user-projects', {
                    url: '/user/dashboard/projects',
                    templateUrl: 'views/user/projects.html',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('assets/styles/limitless.min.css','assets/scripts/limitless.min.js');
                        }]
                    }
                })
                .state('user-messages', {
                    url: '/user/dashboard/messages',
                    templateUrl: 'views/user/messages.html',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('assets/styles/limitless.min.css','assets/scripts/limitless.min.js');
                        }]
                    }
                })
                .state('user-payments', {
                    url: '/user/dashboard/payments',
                    templateUrl: 'views/user/payments.html',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('assets/styles/limitless.min.css','assets/scripts/limitless.min.js');
                        }]
                    }
                })
                .state('user-profile', {
                    url: '/user/dashboard/profile',
                    templateUrl: 'views/user/profile.html',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('assets/styles/limitless.min.css','assets/scripts/limitless.min.js');
                        }]
                    }
                })
                .state('user-settings', {
                    url: '/user/dashboard/settings',
                    templateUrl: 'views/user/settings.html',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('assets/styles/limitless.min.css','assets/scripts/limitless.min.js');
                        }]
                    }
                })
                .state('user-single-project', {
                    url: '/user/dashboard/projects/:projectId',
                    templateUrl: 'views/user/single-project.html',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('assets/styles/limitless.min.css','assets/scripts/limitless.min.js');
                        }]
                    }
                });
        });




})();