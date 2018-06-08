(function() {
    "use strict";
    angular.module('p2lApp')
        .config(function($stateProvider) {
            $stateProvider
                .state('admin-login', {
                    url: '/admin/login',
                    templateUrl: 'views/admin/login.html',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                name: 'ctrl',
                                files: ['controllers/admin/adminAuthCtrl.js']
                            }, {
                                name: 'limitless-css',
                                files: ['assets/styles/limitless.min.css', 'controllers/admin/adminAuthCtrl.js']
                            }, {
                                name: 'limitless-js',
                                files: ['assets/scripts/limitless.min.js']
                            }]);
                        }]
                    }
                })
                .state('admin-dashboard', {
                    url: '/admin/dashboard',
                    templateUrl: 'views/admin/dashboard.html',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                name: 'limitless-css',
                                files: ['assets/styles/limitless.min.css', 'controllers/admin/adminAuthCtrl.js']
                            }, {
                                name: 'limitless-js',
                                files: ['assets/scripts/limitless.min.js']
                            }]);
                        }]
                    }
                })
                .state('admin-user-groups', {
                    url: '/admin/dashboard/user-groups',
                    templateUrl: 'views/admin/user-groups.html',
                    controller: 'adminUserGroupsCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                    name: 'ctrl',
                                    files: ['controllers/admin/adminUserGroupsCtrl.js']
                                },
                                {
                                    name: 'limitless-css',
                                    files: ['assets/styles/limitless.min.css', 'controllers/admin/adminAuthCtrl.js']
                                }, {
                                    name: 'limitless-js',
                                    files: ['assets/scripts/limitless.min.js']
                                }
                            ]);
                        }]
                    }
                })
                .state('admin-user-groups-add', {
                    url: '/admin/dashboard/user-groups/add',
                    templateUrl: 'views/admin/user-groups-add.html',
                    controller: 'adminUserGroupsCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                    name: 'ctrl',
                                    files: ['controllers/admin/adminUserGroupsCtrl.js']
                                },
                                {
                                    name: 'limitless-css',
                                    files: ['assets/styles/limitless.min.css', 'controllers/admin/adminAuthCtrl.js']
                                }, {
                                    name: 'limitless-js',
                                    files: ['assets/scripts/limitless.min.js']
                                }
                            ]);
                        }]
                    }
                })
                .state('admin-user-groups-edit', {
                    url: '/admin/dashboard/user-groups/edit/:groupId',
                    templateUrl: 'views/admin/user-groups-edit.html',
                    controller: 'adminUserGroupsCtrl',

                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                    name: 'ctrl',
                                    files: ['controllers/admin/adminUserGroupsCtrl.js']
                                },
                                {
                                    name: 'limitless-css',
                                    files: ['assets/styles/limitless.min.css', 'controllers/admin/adminAuthCtrl.js']
                                }, {
                                    name: 'limitless-js',
                                    files: ['assets/scripts/limitless.min.js']
                                }
                            ]);
                        }]
                    }
                })
                .state('admin-users', {
                    url: '/admin/dashboard/users',
                    templateUrl: 'views/admin/users.html',
                    controller: 'adminUsersCtrl',

                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                    name: 'ctrl',
                                    files: ['controllers/admin/adminUsersCtrl.js']
                                },
                                {
                                    name: 'limitless-css',
                                    files: ['assets/styles/limitless.min.css', 'controllers/admin/adminAuthCtrl.js']
                                }, {
                                    name: 'limitless-js',
                                    files: ['assets/scripts/limitless.min.js']
                                }
                            ]);
                        }]
                    }
                })
                .state('admin-users-add', {
                    url: '/admin/dashboard/users/add',
                    templateUrl: 'views/admin/users-add.html',
                    controller: 'adminUsersCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                name: 'ctrl',
                                files: ['controllers/admin/adminUsersCtrl.js']
                            }, {
                                name: 'limitless-css',
                                files: ['assets/styles/limitless.min.css', 'controllers/admin/adminAuthCtrl.js']
                            }, {
                                name: 'limitless-js',
                                files: ['assets/scripts/limitless.min.js']
                            }]);
                        }]
                    }
                })
                .state('admin-users-edit', {
                    url: '/admin/dashboard/users/edit/:userId',
                    templateUrl: 'views/admin/users-edit.html',
                    controller: 'adminUsersCtrl',

                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                name: 'ctrl',
                                files: ['controllers/admin/adminUsersCtrl.js']
                            }, {
                                name: 'limitless-css',
                                files: ['assets/styles/limitless.min.css', 'controllers/admin/adminAuthCtrl.js']
                            }, {
                                name: 'limitless-js',
                                files: ['assets/scripts/limitless.min.js']
                            }]);
                        }]
                    }
                })
                .state('admin-feature-categories', {
                    url: '/admin/dashboard/feature-categories',
                    controller: 'adminFeaturesCategoryCtrl',
                    templateUrl: 'views/admin/feature-categories.html',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                name: 'ctrl',
                                files: ['controllers/admin/adminFeaturesCtrl.js']
                            }, {
                                name: 'limitless-css',
                                files: ['assets/styles/limitless.min.css', 'controllers/admin/adminAuthCtrl.js']
                            }, {
                                name: 'limitless-js',
                                files: ['assets/scripts/limitless.min.js']
                            }]);
                        }]
                    }
                })
                .state('admin-feature-category-add', {
                    url: '/admin/dashboard/feature-categories/add',
                    controller: 'adminFeaturesCategoryCtrl',

                    templateUrl: 'views/admin/feature-category-add.html',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                name: 'ctrl',
                                files: ['controllers/admin/adminFeaturesCtrl.js']
                            }, {
                                name: 'limitless-css',
                                files: ['assets/styles/limitless.min.css', 'controllers/admin/adminAuthCtrl.js']
                            }, {
                                name: 'limitless-js',
                                files: ['assets/scripts/limitless.min.js']
                            }]);
                        }]
                    }
                })
                .state('admin-feature-category-edit', {
                    url: '/admin/dashboard/feature-categories/edit/:catId',
                    controller: 'adminFeaturesCategoryCtrl',

                    templateUrl: 'views/admin/feature-category-edit.html',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                name: 'ctrl',
                                files: ['controllers/admin/adminFeaturesCtrl.js']
                            }, {
                                name: 'limitless-css',
                                files: ['assets/styles/limitless.min.css', 'controllers/admin/adminAuthCtrl.js']
                            }, {
                                name: 'limitless-js',
                                files: ['assets/scripts/limitless.min.js']
                            }]);
                        }]
                    }
                })
                .state('admin-features', {
                    url: '/admin/dashboard/features',
                    controller: 'adminFeaturesCtrl',

                    templateUrl: 'views/admin/features.html',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                name: 'ctrl',
                                files: ['controllers/admin/adminFeaturesCtrl.js']
                            }, {
                                name: 'limitless-css',
                                files: ['assets/styles/limitless.min.css', 'controllers/admin/adminAuthCtrl.js']
                            }, {
                                name: 'limitless-js',
                                files: ['assets/scripts/limitless.min.js']
                            }]);
                        }]
                    }
                })
                .state('admin-feature-add', {
                    url: '/admin/dashboard/features/add',
                    controller: 'adminFeaturesCtrl',

                    templateUrl: 'views/admin/feature-add.html',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                name: 'ctrl',
                                files: ['controllers/admin/adminFeaturesCtrl.js']
                            }, {
                                name: 'limitless-css',
                                files: ['assets/styles/limitless.min.css', 'controllers/admin/adminAuthCtrl.js']
                            }, {
                                name: 'limitless-js',
                                files: ['assets/scripts/limitless.min.js']
                            }]);
                        }]
                    }
                })
                .state('admin-feature-edit', {
                    url: '/admin/dashboard/features/edit/:featureId',
                    controller: 'adminFeaturesCtrl',

                    templateUrl: 'views/admin/feature-edit.html',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                name: 'ctrl',
                                files: ['controllers/admin/adminFeaturesCtrl.js']
                            }, {
                                name: 'limitless-css',
                                files: ['assets/styles/limitless.min.css', 'controllers/admin/adminAuthCtrl.js']
                            }, {
                                name: 'limitless-js',
                                files: ['assets/scripts/limitless.min.js']
                            }]);
                        }]
                    }
                })
                .state('admin-packages', {
                    url: '/admin/dashboard/packages',
                    templateUrl: 'views/admin/packages.html',
                    controller: 'adminPackagesCtrl',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                name: 'ctrl',
                                files: ['controllers/admin/adminPackagesOptionsCtrl.js']
                            }, {
                                name: 'limitless-css',
                                files: ['assets/styles/limitless.min.css', 'controllers/admin/adminAuthCtrl.js']
                            }, {
                                name: 'limitless-js',
                                files: ['assets/scripts/limitless.min.js']
                            }]);
                        }]
                    }
                })
                .state('admin-package-add', {
                    url: '/admin/dashboard/packages/add',
                    controller: 'adminPackagesCtrl',
                    templateUrl: 'views/admin/package-add.html',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                    name: 'ctrl',
                                    files: ['controllers/admin/adminPackagesOptionsCtrl.js']
                                }, {
                                    name: 'limitless-css',
                                    files: ['assets/styles/limitless.min.css', 'controllers/admin/adminAuthCtrl.js']
                                },
                                {
                                    name: 'limitless-js',
                                    files: ['assets/scripts/limitless.min.js']
                                }
                            ]);
                        }]
                    }
                })
                .state('admin-package-edit', {
                    url: '/admin/dashboard/packages/edit/:packageId',
                    controller: 'adminPackagesCtrl',
                    templateUrl: 'views/admin/package-edit.html',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                    name: 'ctrl',
                                    files: ['controllers/admin/adminPackagesOptionsCtrl.js']
                                }, {
                                    name: 'limitless-css',
                                    files: ['assets/styles/limitless.min.css', 'controllers/admin/adminAuthCtrl.js']
                                },
                                {
                                    name: 'limitless-js',
                                    files: ['assets/scripts/limitless.min.js']
                                }
                            ]);
                        }]
                    }
                })
                .state('admin-package-options', {
                    url: '/admin/dashboard/packages-options',
                    controller: 'adminPackageOptionsCtrl',
                    templateUrl: 'views/admin/package-options.html',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                name: 'ctrl',
                                files: ['controllers/admin/adminPackagesOptionsCtrl.js']
                            }, {
                                name: 'limitless-css',
                                files: ['assets/styles/limitless.min.css', 'controllers/admin/adminAuthCtrl.js']
                            }, {
                                name: 'limitless-js',
                                files: ['assets/scripts/limitless.min.js']
                            }]);
                        }]
                    }
                })
                .state('admin-package-options-add', {
                    url: '/admin/dashboard/packages-options/add',
                    controller: 'adminPackageOptionsCtrl',

                    templateUrl: 'views/admin/package-option-add.html',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                name: 'ctrl',
                                files: ['controllers/admin/adminPackagesOptionsCtrl.js']
                            }, {
                                name: 'limitless-css',
                                files: ['assets/styles/limitless.min.css', 'controllers/admin/adminAuthCtrl.js']
                            }, {
                                name: 'limitless-js',
                                files: ['assets/scripts/limitless.min.js']
                            }]);
                        }]
                    }
                })
                .state('admin-package-options-edit', {
                    url: '/admin/dashboard/packages-options/edit/:optionId',
                    controller: 'adminPackageOptionsCtrl',

                    templateUrl: 'views/admin/package-option-edit.html',
                    resolve: {
                        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                name: 'ctrl',
                                files: ['controllers/admin/adminPackagesOptionsCtrl.js']
                            }, {
                                name: 'limitless-css',
                                files: ['assets/styles/limitless.min.css', 'controllers/admin/adminAuthCtrl.js']
                            }, {
                                name: 'limitless-js',
                                files: ['assets/scripts/limitless.min.js']
                            }]);
                        }]
                    }
                });
        });




})();