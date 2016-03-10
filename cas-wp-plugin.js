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
    $scope.emails = wpAPIResource.query( {
      param1: 'cas_email_template',
      'filter[posts_per_page]': -1
    } );

    $scope.user = wpAPIResource.get( {
    param1: 'users',
    param2: wpAPIData.user_id
    } );
  
  
    //11R4iEUMzOFfozho3GUMX9IXrMJx_bpZ2-0AlUDQQVyQ
  
   $http.get('https://spreadsheets.google.com/feeds/list/11R4iEUMzOFfozho3GUMX9IXrMJx_bpZ2-0AlUDQQVyQ/od6/public/values?alt=json')
    .then(function(response){
    $scope.calendar = response.data.feed.entry;

  }); 
  
  //Variables for sort/order/view
  $scope.search = '';
  $scope.sortType = '_cas_school_name';
  $scope.sortReverse = false;
  $scope.sortTypeCal = 'gsx$school.$t';
  $scope.sortReverseCal = false;
  
  
  //Swap CIew
  $scope.currentView = true;

  
  
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
  $scope.emailToName = '';
  $scope.emailToAddress = '';
  $scope.emailCC = '';
  $scope.emailBody = '';
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
  
  $scope.emailSubmit = function(){
    var z = '';
    if($scope.emailToAddress && $scope.emailBody){
      var a = encodeURIComponent($scope.emailToName);
      var b = encodeURIComponent($scope.emailToAddress);
      var c = encodeURIComponent($scope.emailCC);
      var d = encodeURIComponent($scope.emailBody);

      z += 'mailto:' + a + '<' + b + '>?';
      if($scope.emailCC){
        z += 'cc=' + c + '&';
      }
      z += 'body=' + d + '';
    }
    window.location.href = z;
    return;
  }
//      <input type="text" ng-model="emailToName">
//              <input type="text" ng-model="emailToAddress">
//              <input type="text" ng-model="emailCC">
//              <textarea ng-model="emailBody"> 
  
  
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