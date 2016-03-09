//
//window.wp = window.wp || {};
//
//wp.api = wp.api || angular.module( 'wp.api', [ 'ngResource' ] )
// 
//	// API resource
//	.factory( 'wpAPIResource', [ '$resource', function ( $resource ) {
//
//		return $resource(
//			wpAPIData.base + '/:param1/:param2/:param3/:param4/:param5/:param6/:param7/',
//			{
//				_wp_json_nonce: wpAPIData.nonce
//			}
//		);
//
//	}]);



angular.module('backendApp', ['wp.api'])

.controller('backendCtrl', function($scope, $sce, $http, wpAPIResource){
//  $http.get('http://cas.threecordsstudio.com/wp-json/wp/v2/cas_school')
//    .then(function(response){
//    $scope.schools = response.data;
//    console.log($scope.schools);
//  });
    $scope.schools = wpAPIResource.query( {
      param1: 'cas_school',
      'filter[posts_per_page]': -1
    } );

    $scope.user = wpAPIResource.get( {
    param1: 'users',
    param2: wpAPIData.user_id
    } );
  
  //Variables for sort/order
  $scope.search = '';
  
  
  //Modal
  $scope.isShowingModal = false;
  $scope.modalSchool = null;
  $scope.showModal = function(i){
    jQuery(document.body).toggleClass('modal-open');
    if(i>-1){
      $scope.modalSchool = wpAPIResource.get( {
        param1: 'cas_school',
        param2: i
      } );
      $scope.isShowingModal = true;
      return;
    }else{
      $scope.modalSchool = null;
      $scope.isShowingModal = false;
      return;
    }
  }
  
  
  
  //google map creator
  $scope.createMap = function(i, j, k, l){
    var map = 'https://www.google.com/maps/embed/v1/place?key=AIzaSyAF9M0oLUumyRJ-0NMlKt-rmXyik_4K7ag&q=' + i + '+' + j + ',' +k + '+' + l;		
    console.log(map);
    var safe = $sce.trustAsResourceUrl(map)
    return safe;
  }
});