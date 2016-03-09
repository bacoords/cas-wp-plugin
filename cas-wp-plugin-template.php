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
          <a class="cwp-button cwp-button--blue" ng-click="showModal(school.id)">+info</a>
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
    
    <div class="cwp-modal-overlay" ng-show="isShowingModal">
      <div class="cwp-modal">
       
       <a class="cwp-button cwp-modal-close" ng-click="showModal(-1)">&#10006;</a>
        <div class="cwp-modal__header">
           <div class="cwp-modal__header__logo">
             <img ng-src="{{modalSchool._cas_school_logo}}" alt="{{modalSchool._cas_school_name}} Logo">
           </div>
           <div class="cwp-modal__header__desc">
             {{modalSchool._cas_school_name}} <br>
             {{modalSchool._cas_school_address}} {{modalSchool._cas_school_city}}, {{modalSchool._cas_school_state}} {{modalSchool._cas_school_zip}} <BR>
             Product: <strong>{{modalSchool._cas_school}}</strong>
             Seasons: <strong>{{modalSchool._cas_school}}</strong>
           </div>
           <div class="cwp-modal__header__buttons">
             <a href="#" class="cwp-button cwp-button--full">send email</a><BR>
             <a href="#" class="cwp-button cwp-button--full">current sales</a><BR>
             <a href="#" class="cwp-button cwp-button--full">print page</a><BR>
           </div>
          
           
          
        </div>
         <div class="cwp-modal__body">
           <div class="frame">
             <div class="bit-40">
               <div class="padding">
                 <div class="frame">
                   <div class="bit-2">
                     <div class="padding">
                      {{modalSchool._cas_school_contact_name}}:<BR> 
                      <strong>{{modalSchool._cas_school_contact_title}} </strong>
                     </div>
                   </div>
                   <div class="bit-2">
                     <div class="padding">
                        {{modalSchool._cas_school_contact_phone}}<BR>
                        {{modalSchool._cas_school_contact_email}}
                     </div>
                   </div>
                 </div>
               </div>
             </div>
             <div class="bit-40">
               <div class="padding">
                  <a ng-href="{{modalSchool.link}}" class="cwp-button" target="_blank">CAS</a> {{modalSchool.link}}
                  <BR>
                  <a ng-href="{{modalSchool._cas_school_team_bank_url}}" class="cwp-button" target="_blank">TB</a> {{modalSchool._cas_school_team_bank_url}}
               </div>
             </div>
           </div>
        </div>
      </div>
    </div>
    
  </div>

</div>
<?php 

get_footer(); 

?>