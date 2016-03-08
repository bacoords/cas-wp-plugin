
angular.module('backendApp', ['wp.api'])



.controller('backendCtrl', function($scope, $http, wpAPIResource){
//  $http.get('http://cas.threecordsstudio.com/wp-json/wp/v2/cas_school')
//    .then(function(response){
//    $scope.schools = response.data;
//    console.log($scope.schools);
//  });
    $scope.schools = wpAPIResource.query( {
      param1: 'cas_school'
    } );

  $scope.search = '';
});