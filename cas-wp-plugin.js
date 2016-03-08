

angular.module('backendApp', [])



.controller('backendCtrl', function($scope, $http){
  $http.get('http://cas.threecordsstudio.com/wp-json/wp/v2/cas_school')
    .then(function(response){
    $scope.schools = response.data;
    console.log($scope.schools);
  });
 $http.get('http://cas.threecordsstudio.com/wp-json/wp/v2/cas_school?post_status=publish&page=2&posts_per_page=10&filter[posts_per_page]=10')
    .then(function(response){
    $scope.schools += response.data;
    console.log($scope.schools);
  }); 
  $scope.search = '';
});