<?php
get_header();
?>
<div class="cwp cas-wp-plugin" ng-app="backendApp">


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
      <tr ng-repeat="school in schools | filter:search | orderBy:'_cas_school_name'">
        <td><a class="cwp-button">INFO</a><a class="cwp-button">EMAIL</a></td>
        <td> {{school._cas_school_name}}</td>
        <td> {{school._cas_school_city}},  {{school._cas_school_state}}</td>
        <td>{{school.modified | date: 'M/d/yy'}}</td> 
        <td><a ng-href="{{school.link}}" class="cwp-button" target="_blank">CAS</a><a ng-href="school._cas_school_team_bank_url" ng-if="school._cas_school_team_bank_url" class="cwp-button" target="_blank">TB</a></td>
      
      </tr>
    </table>
    
    
  </div>

</div>
<?php 

get_footer(); 

?>