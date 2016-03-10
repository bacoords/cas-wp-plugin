<?php
get_header();


if(is_user_logged_in ()){ ?>
<div class="cwp cas-wp-plugin" ng-app="backendApp">

  <div ng-controller="backendCtrl">
   
   <div class="cwp-header">
     <div class="cwp-header__logo">
       <img src="https://communityallstars.com/wp-content/uploads/2016/03/casschoolsportallogo.png" alt="CAS LOGO">
     </div>
     <div class="cwp-header__search">
       <input type="text" ng-model="search" class="cwp-search" placeholder="Search Our Schools">
     </div>
     <div class="cwp-header__calendar">
       <img src="https://communityallstars.com/wp-content/uploads/2016/03/cwpiconcal.png" alt="Cal Link">
     </div>
   </div>
   <div class="no-print"><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR></div>
   

    <table>
      <tr>
       <td>Shortcuts</td>
        <td>
          <a ng-click="sortType = '_cas_school_name'; sortReverse = !sortReverse">
           School
            <span ng-show="sortType == '_cas_school_name' && !sortReverse">&#9650;</span>
            <span ng-show="sortType == '_cas_school_name' && sortReverse">&#9660;</span>
          </a>
        </td>
        <td>
          <a ng-click="sortType = '_cas_school_city'; sortReverse = !sortReverse">
            Location
            <span ng-show="sortType == '_cas_school_city' && !sortReverse">&#9650;</span>
            <span ng-show="sortType == '_cas_school_city' && sortReverse">&#9660;</span>
          
          </a>
        </td>
        <td>
          <a ng-click="sortType = 'modified'; sortReverse = !sortReverse">
            Modified
            <span ng-show="sortType == 'modified' && !sortReverse">&#9650;</span>
            <span ng-show="sortType == 'modified' && sortReverse">&#9660;</span>
          </a>
        </td>
        <td>Links</td>
      </tr>
      <tr ng-repeat="school in schools | filter:search | orderBy:sortType:sortReverse">
        <td>
          <a class="cwp-button cwp-button--blue" ng-click="showModal(school.id)">+info</a>
          <a class="cwp-button" ng-click="showEmail(school.id)">email</a>
        </td>
        <td> {{school._cas_school_name}}</td>
        <td> {{school._cas_school_city}},  {{school._cas_school_state}}</td>
        <td>{{school.modified | date: 'M/d/yy'}}</td> 
        <td>
          <a ng-href="{{school.link}}" class="cwp-button cwp-button--hasicon" target="_blank"><img src="https://communityallstars.com/wp-content/uploads/2016/03/casicontiny.png" alt="CAS Icon"></a>
          <a ng-href="{{school._cas_school_team_bank_url}}" class="cwp-button cwp-button--hasicon" target="_blank"><img src="https://communityallstars.com/wp-content/uploads/2016/03/teambankicon.png" alt="TB Icon"></a>
        </td>
      
      </tr>
    </table>
    <div class="no-print">
      <BR><BR><BR>
      <div class="frame">
        <div class="bit-1">
          <div class="center padding">

            <a href="<?php echo wp_logout_url(home_url() ); ?>" class="cwp-button">Logout</a>
          </div>
        </div>
      </div>
      <br><br><br>
    </div>
    <div class="cwp-modal-overlay ng-hide" ng-show="isShowingModal">
      <div class="cwp-modal cwp-modal__print">
       
       <a class="cwp-button cwp-modal-close" ng-click="showModal(-1)">&#10006;</a>
        <div class="cwp-modal__header">
           <div class="cwp-modal__header__logo">
             <img ng-src="{{modalSchool._cas_school_logo}}" alt="{{modalSchool._cas_school_name}} Logo">
           </div>
           <div class="cwp-modal__header__desc padding">
            <div class="frame">
              <div class="bit-1">
                <div class="padding">
                  
                   <span class="cwp-modal__header__desc__title">
                     <strong>{{modalSchool._cas_school_name}} </strong>
                     <br>
                     {{modalSchool._cas_school_subheading}} 
                   </span>
                   <br>
                  <span class="cwp-modal__header__desc__address">
                   {{modalSchool._cas_school_address}} {{modalSchool._cas_school_city}}, {{modalSchool._cas_school_state}} {{modalSchool._cas_school_zip}}
                  </span>
                </div>
              </div>
            </div>
            <div class="frame">
              <div class="bit-40">
                <div class="padding">
                  Product: <strong><span class="cwp-modal__header__desc__product">{{modalSchool._cas_school_poster_program}}</span></strong>
                </div>
              </div>
              <div class="bit-60">
                <div class="padding">
                  Seasons: <strong>{{modalSchool._cas_school_season_sports}}</strong>
                </div>
              </div>
            </div>
             
             
           </div>
           <div class="cwp-modal__header__buttons">
             <a class="cwp-button cwp-button--full cwp-button--large cwp-button--faded" ng-click="showEmail(modalSchool.id)">send email</a><BR>
             <a ng-href="{{school._cas_school_salesforce_url}}" class="cwp-button cwp-button--full cwp-button--large cwp-button--faded">current sales</a><BR>
             <a href="javascript:window.print()" class="cwp-button cwp-button--full cwp-button--large cwp-button--faded">print page</a><BR>
           </div>
          
           
          
        </div>
         <div class="cwp-modal__body">
           <div class="frame">
             <div class="bit-60">
               <div class="padding">
                 <div class="frame">
                   <div class="bit-2">
                     <div class="padding">
                      {{modalSchool._cas_school_contact_title}}:<BR> 
                      <strong>{{modalSchool._cas_school_contact_name}} </strong>
                     </div>
                   </div>
                   <div class="bit-2">
                     <div class="padding">
                        {{modalSchool._cas_school_contact_phone}}<BR>
                        {{modalSchool._cas_school_contact_email}}
                     </div>
                   </div>
                 </div>
                 <BR>
                 <div class="frame">
                   <div class="bit-1">
                     <div class="padding">
                       <p class="text-gray--dark">{{modalSchool._cas_school_info_field_sports}}</p>
                     </div>
                   </div>
                 </div>
                 <BR>
                 <div class="frame">
                   <div class="bit-1">
                     <div class="padding">
                       <strong>About the School:</strong><br><BR>
                       <p class="text-gray--dark">{{modalSchool._cas_school_description}}</p>
                     </div>
                   </div>
                 </div>
                 <BR>
                 <div class="frame">
                   <div class="bit-1">
                     <div class="padding">
                       <strong>About the City:</strong><br><br>
                       <p class="text-gray--dark">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perspiciatis quos quidem placeat non distinctio! Quidem maiores reprehenderit est amet quam officiis nesciunt labore voluptatum, architecto, odio repudiandae incidunt inventore quaerat.</p>
                     </div>
                   </div>
                 </div>
                 <BR>
                 <div class="frame">
                   <div class="bit-1">
                     <div class="padding">
                       <strong>Sports Achievements:</strong><br><br>
                       <p class="text-gray--dark">{{modalSchool._cas_school_testimonial_achievements}}</p>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
             <div class="bit-40">
               <div class="padding">
                  <div class="frame">
                    <div class="bit-1">
                      <div class="padding">
                        <a ng-href="{{modalSchool.link}}" class="cwp-button cwp-button--hasicon" target="_blank"><img src="https://communityallstars.com/wp-content/uploads/2016/03/casicontiny.png" alt="CAS Icon"></a> 
                        <a ng-href="{{modalSchool.link}}" class="cwp-button cwp-button--no-border cwp-button--link" target="_blank">{{modalSchool.link}}</a> 
                        
                      </div>
                    </div>
                  </div>
                  <div class="frame" ng-show="modalSchool._cas_school_team_bank_url">
                    <div class="bit-1">
                      <div class="padding">
                        <a ng-href="{{modalSchool._cas_school_team_bank_url}}" class="cwp-button cwp-button--hasicon" target="_blank">
                          <img src="https://communityallstars.com/wp-content/uploads/2016/03/teambankicon.png" alt="TB Icon">
                        </a>
                         <a ng-href="{{modalSchool._cas_school_team_bank_url}}" class="cwp-button cwp-button--no-border cwp-button--link" target="_blank">
                          {{modalSchool._cas_school_team_bank_url}}
                        </a> 
                      </div>
                    </div>
                  </div>
                  
                  <BR>
                  
                  <div class="frame">
                    <div class="bit-1">
                      <div class="padding">
                        <strong>Schools Nearby</strong>
                        <br>
<!--                        <p ng-repeat="nearby in modalSchool._attached_cmb2_attached_posts">{{nearbySchools(nearby)}}</p>-->
                      </div>
                    </div>
                  </div>
                  
                  <BR>
                  
                  <div class="frame">
                    <div class="bit-1">
                      <div class="google-maps"><iframe width="300" height="300" frameborder="0" style="border:0" ng-src="{{createMap(modalSchool._cas_school_address, modalSchool._cas_school_city, modalSchool._cas_school_state, modalSchool._cas_school_zip)}}"></iframe></div>
                    </div>
                  </div>
                </div>
             </div>
           </div>
         </div>
      </div>
    </div>

   
      
    <div class="cwp-modal-overlay ng-hide" ng-show="isShowingEmail">
      <div class="cwp-modal cwp-modal__email">
       
       <a class="cwp-button cwp-modal-close" ng-click="showEmail(-1)">&#10006;</a>
        <div class="cwp-modal__header">
           <div class="frame">
             <div class="bit-2">
               <div class="padding">
                 Email For: <strong>{{emailSchool._cas_school_name}}</strong>
               </div>
             </div>
             <div class="bit-2">
               <div class="padding">
                 
               </div>
             </div>
           </div>
          
        </div>
        <div class="cwp-modal__body">
          body stuff
        </div>
      </div>
   </div>
   
   
    
  </div>
</div>
<?php }else{ ?>
<div class="cwp cas-wp-plugin" >


<!--
   
   <div class="cwp-header">
     <div class="cwp-header__logo">
       <img src="https://communityallstars.com/wp-content/uploads/2016/03/casschoolsportallogo.png" alt="CAS LOGO">
     </div>
     <div class="cwp-header__search">
        <h1>Schools Portal</h1>
     </div>
  </div>
-->
  <BR><BR><BR><BR><BR><BR>
  <div class="cwp-login-form">
    <div class="cwp-login-form_header">
      <img src="https://communityallstars.com/wp-content/uploads/2016/03/casschoolsportallogo.png" alt="CAS LOGO">
    </div>
    <div class="cwp-login-form_body">
       <?php wp_login_form(); ?>
       <br>
       <p class="center disclaimer">Password is changed periodically, ask management for current password.</p>
       <br>
    </div>
    
  </div>

 <BR><BR><BR><BR><BR><BR>
</div>

            
<?php 
}

get_footer(); 

?>