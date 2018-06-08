(function() {
    "use strict";
    angular.module('p2lApp')
        .controller('adminFeaturesCategoryCtrl', function($rootScope, $scope, $http, $timeout, $state, $stateParams) {

            $scope.getCategories = function() {
                var req = { "table": 'featurescategory' };
                $http.post('api/read.php', req).then(function(res) {
                    $scope.categoriesList = res.data;
                });
            }


            $scope.createCategory = function() {
                var req = {
                    "table": 'featurescategory',
                    "fields": ["name", "description"],
                    "values": [$scope.name, $scope.description]
                }
                $http.post('api/add.php', req).then(function(res) {
                    if (res.data) {
                        iziToast.success({
                            title: 'Created',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'Feature Category has been created successfully'
                        });
                        $state.go('admin-feature-categories');
                    } else {
                        iziToast.error({
                            title: 'Ooops!',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'There is a problem creating new category'
                        });
                    }
                });
            }

            $scope.deleteCat = function(id) {
                var req = {
                    "table": 'featurescategory',
                    "where": 'id',
                    "value": id
                }
                $http.post('api/delete.php', req).then(function(res) {
                    if (res.data) {
                        iziToast.success({
                            title: 'Deleted',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'Category has been deleted successfully'
                        });
                        $state.go('admin-feature-categories');
                        $scope.getCategories();
                    } else {
                        iziToast.error({
                            title: 'Ooops!',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'There is a problem deleting category'
                        });
                    }

                });
            }





            $scope.getCurrentCat = function() {
                var req = {
                    "table": 'featurescategory',
                    "where": 'id',
                    "whereValue": $stateParams.catId
                }
                $http.post('api/findOne.php', req).then(function(res) {
                    if (res.data[0]) {
                        $scope.id = res.data[0].id;
                        $scope.name = res.data[0].name;
                        $scope.description = res.data[0].description;
                    } else $state.go('admin-feature-categories');

                });
            }


            $scope.updateCat = function() {



                var req = {
                    "table": 'featurescategory',
                    "where": 'id',
                    "whereValue": $scope.id,
                    "fields": ["name", "description"],
                    "values": [$scope.name, $scope.description]
                }
                $http.post('api/update.php', req).then(function(res) {
                    if (res.data) {
                        iziToast.success({
                            title: 'Updated',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'Category has been updated successfully'
                        });
                        $state.go('admin-feature-categories');
                    } else {
                        iziToast.error({
                            title: 'Ooops!',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'There is a problem updating category'
                        });
                    }
                });
            }


            $scope.getCategories();
            $scope.getCurrentCat();

            $rootScope.$on('$viewContentLoaded', function(event) {
                $timeout(function() {
                    $('.bootstrap-select').selectpicker('refresh');
                }, 500);
            });


        })
        .controller('adminFeaturesCtrl', function($rootScope, $scope, $http, $timeout, $state, $stateParams) {

            $scope.getCategories = function() {
                var req = { "table": 'featurescategory' };
                $http.post('api/read.php', req).then(function(res) {
                    $scope.categoriesList = res.data;
                });
            }


            $scope.getFeauters = function() {
                var req = { "table": 'features' };
                $http.post('api/read.php', req).then(function(res) {
                    if (res.data) {
                        $scope.features = res.data;
                    }
                });

            }


            $scope.getNamebyId = function(id) {
                // Get user group name using user group ID :
                if ($scope.categoriesList.find(item => item.id == id)) {
                    return $scope.categoriesList.find(item => item.id == id).name;
                }
            }
            $scope.createFeature = function() {
                var req = {
                    "table": 'features',
                    "fields": ["name", "description", "price", "catid"],
                    "values": [$scope.name, $scope.description, $scope.price, $scope.category.id]
                }
                $http.post('api/add.php', req).then(function(res) {
                    if (res.data) {
                        iziToast.success({
                            title: 'Created',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'Feature has been created successfully'
                        });
                        $state.go('admin-features');
                    } else {
                        iziToast.error({
                            title: 'Ooops!',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'There is a problem creating new feature'
                        });
                    }
                });
            }

            $scope.deleteFeature = function(id) {
                var req = {
                    "table": 'features',
                    "where": 'id',
                    "value": id
                }
                $http.post('api/delete.php', req).then(function(res) {
                    if (res.data) {
                        iziToast.success({
                            title: 'Deleted',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'Feature has been deleted successfully'
                        });
                        $state.go('admin-features');
                        $scope.getFeauters();
                    } else {
                        iziToast.error({
                            title: 'Ooops!',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'There is a problem deleting feature'
                        });
                    }

                });
            }





            $scope.getCurrentFeature = function() {
                var req = {
                    "table": 'features',
                    "where": 'id',
                    "whereValue": $stateParams.featureId
                }
                $http.post('api/findOne.php', req).then(function(res) {
                    if (res.data[0]) {
                        $scope.id = res.data[0].id;
                        $scope.name = res.data[0].name;
                        $scope.description = res.data[0].description;
                        $scope.price = res.data[0].price;
                        if ($scope.categoriesList.find(item => item.id == res.data[0].catid)) {
                            $scope.category = res.data[0].catid;
                        }
                    } else $state.go('admin-features');

                });
            }


            $scope.updateFeature = function() {



                var req = {
                    "table": 'features',
                    "where": 'id',
                    "whereValue": $scope.id,
                    "fields": ["name", "description", "price", "catid"],
                    "values": [$scope.name, $scope.description, $scope.price, $scope.category]
                }
                $http.post('api/update.php', req).then(function(res) {
                    if (res.data) {
                        iziToast.success({
                            title: 'Updated',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'Feature has been updated successfully'
                        });
                        $state.go('admin-features');
                    } else {
                        iziToast.error({
                            title: 'Ooops!',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'There is a problem updating feature'
                        });
                    }
                });
            }

            $scope.getCategories();

            $scope.getCurrentFeature();
            $scope.getFeauters();

            $rootScope.$on('$viewContentLoaded', function(event) {
                $timeout(function() {
                    $('.bootstrap-select').selectpicker('refresh');
                }, 500);
            });


        });
})();