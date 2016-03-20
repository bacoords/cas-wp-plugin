<?php

//email post stuff
$sent = false;
if (!empty($_POST)){

  //   $_POST['firstname'];
  //   $_POST['lastname'];
  //   $_POST['to'];
  //   $_POST['from'];
  //   $_POST['cc'];
  //   $_POST['subject'];
  //   $_POST['emailBody'];

  
  $to =  $_POST['firstname'] . ' ' . $_POST['lastname'] . ' <' . $_POST['to'] . '>';
  $headers = array(
  'From: Community All Stars <' . $_POST['from'] . '>;',
  );
  
  if(isset($_POST['cc']) && !empty($_POST['cc'])){
    $cc = 'CC: ' . $_POST['cc'] . ';';
    array_push($headers, $cc);
  }
  print_r($headers);
  array_push($headers, 'Content-Type: text/html; charset=UTF-8');
  $sent = wp_mail( $to, $_POST['subject'], $_POST['emailBody'], $headers );
  
}



get_header();


if(is_user_logged_in ()){ ?>
<div class="cwp cas-wp-plugin" ng-app="backendApp">

  <div ng-controller="backendCtrl">
   
    <div class="cwp-header">
     <div class="cwp-header__logo">
       <img src="https://communityallstars.com/wp-content/uploads/2016/03/casschoolsportallogo.png" alt="CAS LOGO">
     </div>
     <div class="cwp-header__search">
       <input type="text" ng-model="search" class="cwp-search ng-class:{disabled:!currentView}" placeholder="Search Our Schools">
     </div>
     <div class="cwp-header__calendar">
       <a ng-click="currentView = !currentView">
         <img src="https://communityallstars.com/wp-content/uploads/2016/03/cwpiconcal.png" class="ng-hide" alt="Cal Link" ng-show="currentView">
         <img src="https://communityallstars.com/wp-content/uploads/2016/03/capiconsch.png" class="ng-hide" alt="Cal Link" ng-show="!currentView">
       </a>
     </div>
     <div class="cwp-header__logout">
       <a href="<?php echo wp_logout_url(home_url() ); ?>" class="cwp-button">Logout</a>
     </div>
   </div>

       
 
    <div class="cs-loader no-print" ng-show="loading">
      <div class="cs-loader-inner">
        <label>	●</label>
        <label>	●</label>
        <label>	●</label>
        <label>	●</label>
        <label>	●</label>
        <label>	●</label>
      </div>
    </div>
    <div class="no-print"><BR><BR><BR><BR><BR><BR><BR><BR></div>
    
    <div class="cwp-view__school-list ng-hide" ng-show="currentView">
      <div class="frame">
        <div class="bit-1">
          <div class="cwp-subheader cwp-subheader__calendar">
            <div class="cwp-subheader__img">
              <img src="https://communityallstars.com/wp-content/uploads/2016/03/capiconsch.png" alt="Cal Link">
            </div>
            <div class="cwp-subheader__title">
              <span>SCHOOL LIST AND INFO</span>
              <span>Find school info, contacts, and email templates</span>
              <span>Sorted by school descending</span>
            </div>
          </div>
        </div>
      </div>
            <?php if($sent){ ?>
      <div class="frame no-print">
        <div class="bit-1">
          <div class="center padding">
            <h1>Email Sent!</h1>
            <?php print_r($headers) ?>
          </div>
        </div>
      </div> 
          <?php } ?>
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
            <a ng-href="{{school.link}}" class="cwp-button cwp-button--cas-icon" target="_blank">CAS</a>
            <a ng-href="{{school._cas_school_team_bank_url}}" class="cwp-button cwp-button--tb-icon" target="_blank" ng-show="school._cas_school_team_bank_url">TB</a>
          </td>

        </tr>
      </table>

      <div class="no-print"><BR><BR><br><BR></div>

      <div class="cwp-modal-overlay ng-hide" ng-show="isShowingModal">
       <a class="cwp-modal-overlay__close" ng-click="showModal(-1)"></a>
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
                   <BR class="no-print">
                   <div class="frame">
                     <div class="bit-1">
                       <div class="padding">
                         <p class="text-gray--dark">{{modalSchool._cas_school_info_field_sports}}</p>
                         <p class="text-gray--dark no-print" ng-hide="{{modalSchool._cas_school_info_field_sports}}"><em>No Info</em></p>
                       </div>
                     </div>
                   </div>
                   <BR class="no-print">
                   <div class="frame">
                     <div class="bit-1">
                       <div class="padding">
                         <strong>About the School:</strong><br>
                         <p class="text-gray--dark">{{modalSchool._cas_school_description}}</p>
                         <p class="text-gray--dark no-print" ng-hide="{{modalSchool._cas_school_description}}"><em>No Info</em></p>
                       </div>
                     </div>
                   </div>
                   <BR class="no-print">
                   <div class="frame">
                     <div class="bit-1">
                       <div class="padding">
                         <strong>About the City:</strong><br>
                         <p class="text-gray--dark">{{modalSchool._cas_school_city_info}}</p>
                         <p class="text-gray--dark no-print" ng-hide="{{modalSchool._cas_school_city_info}}"><em>No Info</em></p>
                       </div>
                     </div>
                   </div>
                   <BR class="no-print">
                   <div class="frame">
                     <div class="bit-1">
                       <div class="padding">
                         <strong>Sports Achievements:</strong><br>
                         <p class="text-gray--dark">{{modalSchool._cas_school_testimonial_achievements}}</p>
                         <p class="text-gray--dark no-print" ng-hide="{{modalSchool._cas_school_testimonial_achievements}}"><em>No Info</em></p>
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
                          <a ng-href="{{modalSchool.link}}" class="cwp-button cwp-button--cas-icon" target="_blank">CAS</a> 
                          <a ng-href="{{modalSchool.link}}" class="cwp-button cwp-button--no-border cwp-button--link" target="_blank">{{modalSchool.link}}</a> 

                        </div>
                      </div>
                    </div>
                    <div class="frame" ng-show="modalSchool._cas_school_team_bank_url">
                      <div class="bit-1">
                        <div class="padding">
                          <a ng-href="{{modalSchool._cas_school_team_bank_url}}" class="cwp-button cwp-button--tb-icon" target="_blank">
                            TB
                          </a>
                           <a ng-href="{{modalSchool._cas_school_team_bank_url}}" class="cwp-button cwp-button--no-border cwp-button--link" target="_blank">
                            {{modalSchool._cas_school_team_bank_url}}
                          </a> 
                        </div>
                      </div>
                    </div>

                    <BR class="no-print">

                    <div class="frame" ng-show="nearbySchoolsObj">
                      <div class="bit-1">
                        <div class="padding">
                          <strong>Schools Nearby</strong>
                          <br>
                          <p ng-repeat="nearby in nearbySchoolsObj">{{nearby}}</p>
                        </div>
                      </div>
                    </div>

                    <BR>

                    <div class="frame no-print">
                      <div class="bit-1">
                        <div class="google-maps"><iframe width="360" height="360" frameborder="0" style="border:0" ng-src="{{createMap(modalSchool._cas_school_address, modalSchool._cas_school_city, modalSchool._cas_school_state, modalSchool._cas_school_zip)}}"></iframe></div>
                      </div>
                    </div>
                  </div>
               </div>
             </div>
           </div>
        </div>
      </div>

      <div class="cwp-modal-overlay ng-hide" ng-show="isShowingEmail">
       
         <a class="cwp-modal-overlay__close" ng-click="showEmail(-1)"></a>
        <div class="cwp-modal cwp-modal__email">

         <a class="cwp-button cwp-modal-close" ng-click="showEmail(-1)">&#10006;</a>
          <div class="cwp-modal__header cwp-modal__email__header">
             <div class="frame">
               <div class="bit-1">
                 <div class="padding center">
                   Email For: <strong>{{emailSchool._cas_school_name}}</strong>
                 </div>
               </div>
             </div>

          </div>
          <div class="cwp-modal__body cwp-modal__email__body">
            <div class="frame">
              
               <div class="bit-25">
                 <div class="padding">
                   Templates:
                 </div>
               </div>
               <div class="bit-75">
                 <div class="padding">
                   
                   <a ng-click="getEmailSelect(email)" ng-repeat="email in emails" class="cwp-button cwp-button--email-template" id="email-link-{{email.id}}">
                     {{email.title.rendered}}
                   </a>
                 </div>
               </div>
            </div>
            <form id="email-form" action="" method="post"s>
              <div class="frame">
                <div class="bit-2"><input type="text" name="firstname"  placeholder="To (First Name)"></div>
                <div class="bit-2"><input type="text" name="lastname" placeholder="To (Last Name)"></div>
              </div> 
              
              
              <input type="text" name="to" placeholder="To Email Address">
              <input type="text" name="from" placeholder="From Email Address">
              <input type="text" name="cc" placeholder="CC">
              <input type="text" name="subject" ng-model="emailSubject" placeholder="Subject">
              <?php wp_editor('Select a Template', 'tab-editor', array('editor_height'=>'500px','textarea_name'=>'emailBody')); ?>
<!--              <textarea ng-model="emailBody"></textarea>-->
<!--              <a ng-click="emailSubmit()" class="cwp-button cwp-button--email-submit" target="_blank">SEND EMAIL</a>-->
              <input type="submit" class="cwp-button cwp-button--email-submit" target="_blank">SEND EMAIL</a>
            </form>
          </div>
        </div>
     </div>
   
    </div>
    
    <div class="cwp-view__calendar ng-hide" ng-show="!currentView">
      <div class="frame">
        <div class="bit-1">
          <div class="cwp-subheader cwp-subheader__calendar">
            <div class="cwp-subheader__img">
              <img src="https://communityallstars.com/wp-content/uploads/2016/03/cwpiconcal.png" alt="Cal Link">
            </div>
            <div class="cwp-subheader__title">
              <span>SALES CLOSE DATE</span>
              <span>See when current campaigns close</span>
              <span>Sorted by close date descending</span>
            </div>
          </div>
        </div>
      </div>
      <table class="cwp-cal-table"> 
        <tr>
          <td>
            <a ng-click="sortTypeCal = 'gsx$school.$t'; sortReverseCal = !sortReverseCal">
             School
              <span ng-show="sortTypeCal == 'gsx$school.$t' && !sortReverseCal">&#9650;</span>
              <span ng-show="sortTypeCal == 'gsx$school.$t' && sortReverseCal">&#9660;</span>
            </a>
          </td>
          <td>
            <a ng-click="sortTypeCal = 'gsx$closedate.$t'; sortReverseCal = !sortReverseCal">
              Date
              <span ng-show="sortTypeCal == 'gsx$closedate.$t' && !sortReverseCal">&#9650;</span>
              <span ng-show="sortTypeCal == 'gsx$closedate.$t' && sortReverseCal">&#9660;</span>

            </a>
          </td>
        </tr>
        <tr ng-repeat="cal in calendar | orderBy:sortTypeCal:sortReverseCal">
          
          <td> {{cal.gsx$school.$t}}</td>
          <td> {{cal.gsx$closedate.$t}}</td>
         
        </tr>
      </table>
      
      <div class="no-print"><BR><BR><BR><BR><BR><BR></div>
      
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