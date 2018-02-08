(function() {
    "use strict";
    angular.module('p2lApp')
        .config(['$stateProvider', '$urlRouterProvider', '$locationProvider', '$httpProvider', function($stateProvider, $urlRouterProvider, $locationProvider, $httpProvider) {

            $stateProvider
                .state('home', {
                    url: '/',
                    templateUrl: 'views/home.html',
                    controller: 'homeCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('controllers/homeCtrl.js', 'assets/scripts/jquery.countTo.js', 'assets/scripts/jquery.waypoints.min.js');
                        }]
                    }
                })
                .state('step-1', {
                    url: '/order-now',
                    templateUrl: 'views/steps/step-1.html',
                    controller: 'orderNowCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('controllers/orderNowCtrl.js');
                        }]
                    }
                })
                .state('step-2', {
                    url: '/order-now/step2',
                    templateUrl: 'views/steps/step-2.html',
                    controller: 'orderNowCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('controllers/orderNowCtrl.js');
                        }]
                    }
                })
                .state('step-2-b', {
                    url: '/order-now/step2/build-a-package',
                    templateUrl: 'views/steps/step-2-b.html',
                    controller: 'orderNowCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('controllers/homeCtrl.js');
                        }]
                    }
                })
                .state('step-3', {
                    url: '/order-now/step3',
                    templateUrl: 'views/steps/step-3.html',
                    controller: 'orderNowCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('controllers/orderNowCtrl.js');
                        }]
                    }
                })
                .state('step-4', {
                    url: '/order-now/step4',
                    templateUrl: 'views/steps/step-4.html',
                    controller: 'orderNowCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('controllers/orderNowCtrl.js');
                        }]
                    }
                })
                .state('finish-order', {
                    url: '/order-now/finish',
                    templateUrl: 'views/steps/thanks.html',
                    controller: 'orderNowCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('controllers/orderNowCtrl.js');
                        }]
                    }
                })
                .state('how-it-works', {
                    url: '/how-it-works',
                    templateUrl: 'views/how-it-works.html',
                    controller: 'howItWorksCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('controllers/howItWorksCtrl.js');
                        }]
                    }
                })
                .state('services', {
                    url: '/services',
                    templateUrl: 'views/services.html',
                    controller: 'servicesCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('controllers/servicesCtrl.js');
                        }]
                    }
                })
                .state('projects', {
                    url: '/projects',
                    templateUrl: 'views/projects.html',
                    controller: 'projectsCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('controllers/projectsCtrl.js');
                        }]
                    }
                })
                .state('our-team', {
                    url: '/our-team',
                    templateUrl: 'views/our-team.html',
                    controller: 'ourTeamCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('controllers/ourTeamCtrl.js');
                        }]
                    }
                })
                .state('about-us', {
                    url: '/about-us',
                    templateUrl: 'views/about-us.html',
                    controller: 'aboutUsCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('controllers/aboutUsCtrl.js');
                        }]
                    }
                })
                .state('contact-us', {
                    url: '/contact-us',
                    templateUrl: 'views/contact-us.html',
                    controller: 'contactUsCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('controllers/contactUsCtrl.js');
                        }]
                    }
                })
                .state('privacy-policy', {
                    url: '/privacy-policy',
                    templateUrl: 'views/privacy-policy.html',
                    controller: 'privacyPolicyCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('controllers/privacyPolicyCtrl.js');
                        }]
                    }
                })
                .state('terms-of-service', {
                    url: '/terms-of-service',
                    templateUrl: 'views/terms-of-service.html',
                    controller: 'termsOfServiceCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('controllers/termsOfServiceCtrl.js');
                        }]
                    }
                })
                .state('faq', {
                    url: '/faq',
                    templateUrl: 'views/faq.html',
                    controller: 'faqCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load('controllers/homeCtrl.js');
                        }]
                    }
                });
        }]);




})();