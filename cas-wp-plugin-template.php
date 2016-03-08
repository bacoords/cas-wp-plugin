<?php
get_header();
?>
<div class="cas-wp-plugin" ng-app="backendApp">


  <h1 class="center">Schools Backend</h1>
  <div ng-controller="backendCtrl">
   
   
   <input type="text" ng-model="search">
   
   
    <table>
      <tr>
       <td>Shortcuts</td>
        <td>School</td>
        <td>Location</td>
        <td>Last Modified</td>
        <td>Links</td>
      </tr>
      <tr ng-repeat="school in schools | filter:search">
        <td>===</td>
        <td> {{school._cas_school_name}}</td>
        <td> {{school._cas_school_city}},  {{school._cas_school_state}}</td>
        <td>{{school.modified | date: 'M/d/yy'}}</td> 
        <td>===</td>
      
      </tr>
    </table>
    
    
  </div>

</div>
<?php 

get_footer(); 

?>