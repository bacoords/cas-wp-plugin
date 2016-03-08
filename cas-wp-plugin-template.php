<?php
get_header();
?>
<div class="cas-wp-plugin" ng-app="backendApp">


  <h1 class="center">Custom Backend!</h1>
  <div ng-controller="backendCtrl">
   <p ng-if="data.currentUser.id">Hello! 
   {{data.currentUser.name}}!</p>
   
    <ul>
      
      <li ng-repeat="school in schools">{{school.title.rendered}} &amp; {{school._cas_school_name}}</li>
    </ul>
    
    
  </div>

</div>
<?php 

get_footer(); 

?>