//from: https://github.com/jeffsebring/angular-wp-api

window.wp = window.wp || {};

wp.api = wp.api || angular.module( 'wp.api', [ 'ngResource' ] )
 
	// API resource
	.factory( 'wpAPIResource', [ '$resource', function ( $resource ) {

		return $resource(
			wpAPIData.base + '/:param1/:param2/:param3/:param4/:param5/:param6/:param7/',
			{
				_wp_json_nonce: wpAPIData.nonce
			}
		);

	}]);



angular.module('backendApp', ['wp.api'])



.controller('backendCtrl', function($scope, $http){
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