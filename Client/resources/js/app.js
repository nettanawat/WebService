'use strict';

// Declare app level module which depends on views, and components
var labApp = angular.module('labApp', [
    'ngRoute',
    'welcomeMainController'
])
labApp.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
            when('/addProduct',{
                templateUrl: 'template/editProduct.html',
                controller: 'addProductController'
            }).
            when('/editProduct/:id',{
                templateUrl: 'template/editProduct.html',
                controller: 'editProductController'
            }).
            when('/listProduct',{
                templateUrl: 'template/productList.html',
                controller: 'listProductController'
            }).
            otherwise({redirectTo: '/listProduct'});
    }]);