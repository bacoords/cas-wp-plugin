<?php
get_header();
?>
<div class="cwp cas-wp-plugin" ng-app="backendApp">

  <div ng-controller="backendCtrl">
   
   <div class="cwp-header">
<!--
     <div class="cwp-header__logo">
       CAS
     </div>
-->
     <div class="cwp-header__search">
       <input type="text" ng-model="search" class="cwp-search" placeholder="Search Our Schools">
     </div>
<!--
     <div class="cwp-header__calendar">
       CALENDAR THING
     </div>
-->
   </div>
   <BR><BR><BR><BR>
   
    <table>
      <tr>
       <td>Shortcuts</td>
        <td>School</td>
        <td>Location</td>
        <td>Last Modified</td>
        <td>Links</td>
      </tr>
      <tr ng-repeat="school in schools | filter:search | orderBy:'_cas_school_name'">
        <td>
          <a class="cwp-button cwp-button--blue">+info</a>
          <a class="cwp-button">email</a>
        </td>
        <td> {{school._cas_school_name}}</td>
        <td> {{school._cas_school_city}},  {{school._cas_school_state}}</td>
        <td>{{school.modified | date: 'M/d/yy'}}</td> 
        <td>
          <a ng-href="{{school.link}}" class="cwp-button" target="_blank">CAS</a>
          <a ng-href="{{school._cas_school_team_bank_url}}" class="cwp-button" target="_blank">TB</a>
        </td>
      
      </tr>
    </table>
    <BR><BR><BR><BR><BR>
    
    <div class="cwp-modal-overlay">
      <div class="cwp-modal">
        TEST
      </div>
    </div>
    
  </div>

</div>
<?php 

get_footer(); 

?>