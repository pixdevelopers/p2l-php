(function() {
    "use strict";
    angular.module('p2lApp')
        .controller('adminPackageOptionsCtrl', function($rootScope, $scope, $http, $timeout, $state, $stateParams) {

            $scope.getOptions = function() {
                var req = { "table": 'packageoptions' };
                $http.post('api/read.php', req).then(function(res) {
                    $scope.optionsList = res.data;
                });
            }


            $scope.createOption = function() {
                var req = {
                    "table": 'packageoptions',
                    "fields": ["description"],
                    "values": [$scope.description]
                }
                $http.post('api/add.php', req).then(function(res) {
                    if (res.data) {
                        iziToast.success({
                            title: 'Created',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'Package option has been created successfully'
                        });
                        $state.go('admin-package-options');
                    } else {
                        iziToast.error({
                            title: 'Ooops!',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'There is a problem creating new package option'
                        });
                    }
                });
            }

            $scope.deleteOption = function(id) {
                var req = {
                    "table": 'packageoptions',
                    "where": 'id',
                    "value": id
                }
                $http.post('api/delete.php', req).then(function(res) {
                    if (res.data) {
                        iziToast.success({
                            title: 'Deleted',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'Package option has been deleted successfully'
                        });
                        $state.go('admin-package-options');
                        $scope.getOptions();
                    } else {
                        iziToast.error({
                            title: 'Ooops!',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'There is a problem deleting package option'
                        });
                    }

                });
            }





            $scope.getCurrentOption = function() {
                var req = {
                    "table": 'packageoptions',
                    "where": 'id',
                    "whereValue": $stateParams.optionId
                }
                $http.post('api/findOne.php', req).then(function(res) {
                    if (res.data[0]) {
                        $scope.id = res.data[0].id;
                        $scope.description = res.data[0].description;
                    } else $state.go('admin-package-options');

                });
            }


            $scope.updateOption = function() {



                var req = {
                    "table": 'packageoptions',
                    "where": 'id',
                    "whereValue": $scope.id,
                    "fields": ["description"],
                    "values": [$scope.description]
                }
                $http.post('api/update.php', req).then(function(res) {
                    if (res.data) {
                        iziToast.success({
                            title: 'Updated',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'Package option has been updated successfully'
                        });
                        $state.go('admin-package-options');
                    } else {
                        iziToast.error({
                            title: 'Ooops!',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'There is a problem updating package option'
                        });
                    }
                });
            }


            $scope.getOptions();
            $scope.getCurrentOption();



        })
        .controller('adminPackagesCtrl', function($rootScope, $scope, $http, $timeout, $state, $stateParams) {
            $scope.getOptions = function() {
                var req = { "table": 'packageoptions' };
                $http.post('api/read.php', req).then(function(res) {
                    $scope.optionsList = res.data;
                });
            }

            $scope.getFeatures = function() {
                var req = { "table": 'features' };
                $http.post('api/read.php', req).then(function(res) {
                    $scope.featuresList = res.data;
                });
            }

            $scope.getFeatureCats = function() {
                var req = { "table": 'featurescategory' };
                $http.post('api/read.php', req).then(function(res) {
                    $scope.featureCatsList = res.data;
                });
            }

            $scope.getFeaturesByCat = function(id) {
                console.log(id);
                var feature = $scope.featuresList.filter(function(item) {
                    if (item.catid === id) {
                        return item;
                    }

                });
                return feature[0];
            }




            $scope.createPackage = function() {
                var req = {
                    "table": 'packageoptions',
                    "fields": ["description"],
                    "values": [$scope.description]
                }
                $http.post('api/add.php', req).then(function(res) {
                    if (res.data) {
                        iziToast.success({
                            title: 'Created',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'Package option has been created successfully'
                        });
                        $state.go('admin-package-options');
                    } else {
                        iziToast.error({
                            title: 'Ooops!',
                            timeout: 2000,
                            position: 'topRight',
                            message: 'There is a problem creating new package option'
                        });
                    }
                });
            }

            $scope.getOptions();
            $scope.getFeatures();
            $scope.getFeatureCats();
        });

})();