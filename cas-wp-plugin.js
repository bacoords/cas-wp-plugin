angular.module('backendApp', [])
.controller('backendCtrl', function($scope, $http){
  $http.get('http://cas.threecordsstudio.com/wp-json/wp/v2/cas_school')
    .then(function(response){
    $scope.schools = response.data;
    console.log($scope.schools);
  });
});