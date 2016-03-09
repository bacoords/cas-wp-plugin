jQuery(document).ready(function(){
  if(jQuery('#loginform')){
    jQuery('#user_login').attr( 'placeholder', 'Username' );
    jQuery('#user_pass').attr( 'placeholder', 'Password' );
  }
});



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
  $scope.sortType = '_cas_school_name';
  $scope.sortReverse = false;
  
  //Modal
  $scope.isShowingModal = false;
  $scope.modalSchool = null;
  $scope.nearbySchoolsObj = null;
  $scope.showModal = function(i){
    
    if(i>-1){
      jQuery(document.body).addClass('modal-open');
      $scope.modalSchool = wpAPIResource.get( {
        param1: 'cas_school',
        param2: i
      } );
      $scope.isShowingModal = true;
      return;
    }else{
      jQuery(document.body).removeClass('modal-open');
      $scope.modalSchool = null;
      $scope.nearbySchoolsObj = null;
      $scope.isShowingModal = false;
      return;
    }
  }
  
  //email modal
  
  $scope.isShowingEmail = false;
  
  $scope.emailSchool = null;
  $scope.showEmail = function(i){
   
    if(i>-1){
      jQuery(document.body).addClass('modal-open');
      $scope.emailSchool = wpAPIResource.get( {
        param1: 'cas_school',
        param2: i
      } );
      $scope.isShowingEmail = true;
      return;
    }else{
      jQuery(document.body).removeClass('modal-open');
      $scope.emailSchool = null;
      $scope.isShowingEmail = false;
      return;
    }
  }
  
  
  
  //google map creator
  $scope.createMap = function(i, j, k, l){
    var map = 'https://www.google.com/maps/embed/v1/place?key=AIzaSyAF9M0oLUumyRJ-0NMlKt-rmXyik_4K7ag&q=' + i + '+' + j + ',' +k + '+' + l;		
    var safe = $sce.trustAsResourceUrl(map)
    return safe;
  }
  
  
//  //get nearby schools
//  $scope.nearbySchools = function(a){
//    
//    if((a) && ($scope.nearbySchoolsObj === null)){
//        $scope.nearbySchoolsObj = (wpAPIResource.get( {
//          param1: 'cas_school',
//          param2: a
//        } ));     
//      console.log($scope.nearbySchoolsObj);
//    }
//    
//    
//    return $scope.nearbySchoolsObj;
//    
//  }
//  
});