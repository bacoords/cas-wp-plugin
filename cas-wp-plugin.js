jQuery(document).ready(function(){
  if(jQuery('#loginform')){
    jQuery('#user_login').attr( 'placeholder', 'Username' );
    jQuery('#user_pass').attr( 'placeholder', 'Password' );
  }
});


//TinyMCE Functions re: https://gist.github.com/RadGH/523bed274f307830752c
function tmce_getContent(editor_id, textarea_id) {
  if ( typeof editor_id == 'undefined' ) editor_id = wpActiveEditor;
  if ( typeof textarea_id == 'undefined' ) textarea_id = editor_id;
  
  if ( jQuery('#wp-'+editor_id+'-wrap').hasClass('tmce-active') && tinyMCE.get(editor_id) ) {
    return tinyMCE.get(editor_id).getContent();
  }else{
    return jQuery('#'+textarea_id).val();
  }
}

function tmce_setContent(content, editor_id, textarea_id) {
  if ( typeof editor_id == 'undefined' ) editor_id = wpActiveEditor;
  if ( typeof textarea_id == 'undefined' ) textarea_id = editor_id;
  
  if ( jQuery('#wp-'+editor_id+'-wrap').hasClass('tmce-active') && tinyMCE.get(editor_id) ) {
    return tinyMCE.get(editor_id).setContent(content);
  }else{
    return jQuery('#'+textarea_id).val(content);
  }
}

function tmce_focus(editor_id, textarea_id) {
  if ( typeof editor_id == 'undefined' ) editor_id = wpActiveEditor;
  if ( typeof textarea_id == 'undefined' ) textarea_id = editor_id;
  
  if ( jQuery('#wp-'+editor_id+'-wrap').hasClass('tmce-active') && tinyMCE.get(editor_id) ) {
    return tinyMCE.get(editor_id).focus();
  }else{
    return jQuery('#'+textarea_id).focus();
  }
}





angular.module('backendApp', ['wp.api'])

.controller('backendCtrl', function($scope, $sce, $http, wpAPIResource){
//  $http.get('http://cas.threecordsstudio.com/wp-json/wp/v2/cas_school')
//    .then(function(response){
//    $scope.schools = response.data;
//    console.log($scope.schools);
//  });
  
  
    $scope.loading = true;
    wpAPIResource.query( {
      param1: 'cas_school',
      'filter[posts_per_page]': -1
    } ).$promise.then(function (result) {
      $scope.schools = result;
      $scope.loading = false;
    })
    $scope.emails = wpAPIResource.query( {
      param1: 'cas_email_template',
      'filter[posts_per_page]': -1
    } );
    
//    $scope.user = wpAPIResource.get( {
//    param1: 'users',
//    param2: wpAPIData.user_id
//    } );
  
  
   $http.get('https://spreadsheets.google.com/feeds/list/11R4iEUMzOFfozho3GUMX9IXrMJx_bpZ2-0AlUDQQVyQ/od6/public/values?alt=json')
    .then(function(response){
    $scope.calendar = response.data.feed.entry;

  }); 
  
  //Variables for sort/order/view
  $scope.search = '';
  $scope.sortType = '_cas_school_name';
  $scope.sortReverse = false;
  $scope.sortTypeCal = 'gsx$closedate.$t';
  $scope.sortReverseCal = false;
  
  
  //Swap CIew
  $scope.currentView = true;

  
  
  //Modal
  $scope.isShowingModal = false;
  $scope.modalSchool = null;
  $scope.nearbySchoolsObj = null;
  $scope.showModal = function(i){
    $scope.loading = true;
    if(i>-1){
      jQuery(document.body).addClass('modal-open');
      wpAPIResource.get( {
        param1: 'cas_school',
        param2: i
      } ).$promise.then(function(result){
        $scope.modalSchool = result;
        $scope.isShowingModal = true;
        $scope.loading = false;
        $scope.getNearbySchools(result);
      });
      return;
    }else{
      jQuery(document.body).removeClass('modal-open');
      $scope.modalSchool = null;
      $scope.nearbySchoolsObj = null;
      $scope.isShowingModal = false;
      $scope.loading = false;
      return;
    }
  }
  
  //email modal
  
  $scope.isShowingEmail = false;
  $scope.emailToName = '';
  $scope.emailToAddress = '';
  $scope.emailCC = '';
  $scope.emailBody = '';
  $scope.emailSelect = null;
  $scope.emailSchool = null;
  $scope.showEmail = function(i){
    $scope.loading = true;
    if(i>-1){
      jQuery(document.body).addClass('modal-open');
      wpAPIResource.get( {
        param1: 'cas_school',
        param2: i
      } ).$promise.then(function(result){
        $scope.emailSchool = result;
        $scope.isShowingEmail = true;
        $scope.loading = false;
      });
      return;
    }else{
      jQuery(document.body).removeClass('modal-open');
      $scope.emailSchool = null;
      $scope.isShowingEmail = false;
      $scope.loading = false;
      return;
    }
  }
  
  $scope.getEmailSelect = function(e){
    $scope.emailSelect = e;
    jQuery('.cwp-button--email-template').removeClass('cwp-button--email-template__selected');
    jQuery('#email-link-' + e.id).addClass('cwp-button--email-template__selected');    
    var q = jQuery(e.content.rendered).text();
    var q = q.replace(/\[SCHOOL\]/g, $scope.emailSchool._cas_school_name);
    var q = q.replace(/\[TITLE\]/g, $scope.emailSchool._cas_school_contact_title);
    var q = q.replace(/\[CONTACT\]/g, $scope.emailSchool._cas_school_contact_name);
    var q = q.replace(/\[PHONE\]/g, $scope.emailSchool._cas_school_contact_phone);
    var q = q.replace(/\[MASCOT\]/g, $scope.emailSchool._cas_school_mascot);
    var q = q.replace(/\[SCHOOLURL\]/g, $scope.emailSchool.link);
    var q = q.replace(/\[SPONSOR\]/g, $scope.emailToName);
    tmce_setContent( q, 'tab-editor' );
  }
  
//  $scope.emailSubmit = function(){
//    var z = '';
//    if($scope.emailToAddress && $scope.emailSelect){
//      //set up variables
//      var a = encodeURIComponent($scope.emailToFirstName);
//      var aa = encodeURIComponent($scope.emailToLastName);
//      var b = encodeURIComponent($scope.emailToAddress);
//      var c = encodeURIComponent($scope.emailCC);
//      var q = jQuery($scope.emailSelect.content.rendered).text();
//      var q = q.replace(/\[SCHOOL\]/g, $scope.emailSchool._cas_school_name);
//      var q = q.replace(/\[TITLE\]/g, $scope.emailSchool._cas_school_contact_title);
//      var q = q.replace(/\[CONTACT\]/g, $scope.emailSchool._cas_school_contact_name);
//      var q = q.replace(/\[PHONE\]/g, $scope.emailSchool._cas_school_contact_phone);
//      var q = q.replace(/\[MASCOT\]/g, $scope.emailSchool._cas_school_mascot);
//      var q = q.replace(/\[SCHOOLURL\]/g, $scope.emailSchool.link);
//      var q = q.replace(/\[SPONSOR\]/g, $scope.emailToName);
//      var r = 'Email Subject';
//      var r = $scope.emailSelect._cas_email_template_subject;
//      console.log(r);
//      var r = r.replace(/\[SCHOOL\]/g, $scope.emailSchool._cas_school_name);
//      var r = r.replace(/\[TITLE\]/g, $scope.emailSchool._cas_school_contact_title);
//      var r = r.replace(/\[CONTACT\]/g, $scope.emailSchool._cas_school_contact_name);
//      var r = r.replace(/\[PHONE\]/g, $scope.emailSchool._cas_school_contact_phone);
//      var r = r.replace(/\[MASCOT\]/g, $scope.emailSchool._cas_school_mascot);
//      var r = r.replace(/\[SCHOOLURL\]/g, $scope.emailSchool.link);
//      var r = r.replace(/\[SPONSOR\]/g, $scope.emailToName);
//      
//      var d = encodeURIComponent(q);  
//      
//      if($scope.emailToFirstName && $scope.emailToLastName){
//        z += 'mailto:' + a + ' ' + aa + '<' + b + '>?';
//      }else{
//        z += 'mailto:' + b + '?';
//      }
//      
//      if($scope.emailCC){
//        z += 'cc=' + c + '&';
//      }
//      console.log(r);
//      z += 'subject=' + r + '&';
//      
//      z += 'body=' + d + '';
//      
//      
//      window.open(
//        z,
//        '_blank' // <- This is what makes it open in a new window.
//      );
//    }
//    return;
//  }

  
  
  //google map creator
  $scope.createMap = function(i, j, k, l){
    var map = 'https://www.google.com/maps/embed/v1/place?key=AIzaSyAF9M0oLUumyRJ-0NMlKt-rmXyik_4K7ag&q=' + i + '+' + j + ',' +k + '+' + l;		
    var safe = $sce.trustAsResourceUrl(map)
    return safe;
  }
  
  
//  //get nearby schools
  $scope.getNearbySchools = function(a){
    var b = a._attached_cmb2_attached_posts;
    console.log(b);
    $scope.nearbySchoolsObj = [];
    for(var i = 0; i < b.length; i++){
      wpAPIResource.get( {
        param1: 'cas_school',
        param2: b[i]
      } ).$promise.then(function(result){
        $scope.nearbySchoolsObj.push(result.title.rendered);
        console.log($scope.nearbySchoolsObj);
      });
      
    }    
    return;
    
  }
//  
});