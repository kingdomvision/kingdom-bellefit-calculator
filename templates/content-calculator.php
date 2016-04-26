<div class="container-calc" id="myWizard" ng-app="calculatorApp" ng-controller="MainCtrl">
<?php 
	$cookie_token = $_GET['token'];
	if( ! empty($cookie_token) && strlen($cookie_token) == 10 )
		echo sprintf('<div data-ng-init="getData(%s)"></div>', "'".$cookie_token."'");
?>

  <div class="main-head"><h1>Choosing and Sizing</h1></div>
  <form name="frmCal">
  <div class="main-step" ng-hide="(full_step == 'recommend' || full_step == 'save')">
      <div class="navbar">
        <div class="navbar-inner">
          <ul class="nav nav-tabs">
            <li class="active" ng-class="{ 'step-complete': isSteps('step2', cal) }">
                <a href="#step1" data-toggle="tab" data-step="1">
                    <img ng-src="{{getImage('icon1.png')}}" />
                    <img ng-src="{{getImage('icon1-active.png')}}" class="active-img" />
                    <span>Childbirth &amp;<br />Delivery</span>
                </a>
            </li>
            
            <li ng-class="{'disabled': (isSteps('step2', cal) == false), 'step-complete': isSteps('step3', cal) }">
                <a ng-href="{{( isSteps('step2_a', cal) || isSteps('step2_b', cal) ) ? '#step2' : 'javascript:void(0);'}}" data-toggle="tab" data-step="2">
                    <img ng-src="{{getImage('icon2.png')}}" />
                    <img ng-src="{{getImage('icon2-active.png')}}" class="active-img" />
                    <span>Your Weight</span>
                </a>
            </li>
            
            <li ng-class="{'disabled': isSteps('step3', cal) == false, 'step-complete': isSteps('step4', cal) }">
                <a ng-href="{{( isSteps('step3', cal) ) ? '#step3' : 'javascript:void(0);'}}" data-toggle="tab" data-step="3">
                    <img ng-src="{{getImage('icon3.png')}}" />
                    <img ng-src="{{getImage('icon3-active.png')}}" class="active-img" />
                    <span>Body Shape</span>
                </a>
            </li>
            
            <li ng-class="{'disabled': (isSteps('step4', cal) == false && isSteps('step3', cal) == false), 'step-complete': isAllSteps(cal) }">
                <a ng-href="{{( isSteps('step4', cal) && isSteps('step3', cal) ) ? '#step4' : 'javascript:void(0);'}}" data-toggle="tab" data-step="4">
                    <img ng-src="{{getImage('icon4.png')}}" />
                    <img ng-src="{{getImage('icon4-active.png')}}" class="active-img" />
                    <span>Your Size</span>
                </a>
            </li>
            
          </ul>
        </div>
      </div>
      
      <div class="calc-main-title">
        <h3 ng-bind-html="stepsInfo[goBack] || 'Childbirth &amp; Delivery Method'"></h3>
      </div>
      
      <div class="progress-bar-container">
          <div class="progress">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="5" style="width: 25%;"></div>
          </div>
          <div class="progress-bar-text">25%</div>
      </div>
      
      
      <div class="tab-content">
      
        <div class="tab-pane fade in active" id="step1">
          <div class="well">
              <ul class="steps">
                  <li>
                    <label>Did you already give birth?</label>
                    
                    <ul class="field-box ul-inline">
                        <li>
                            <input type="radio" name="_1_give_birth" value="Yes" id="_1_give_birth_1" class="field-yes" ng-model="cal.give_birth" ng-change="cal_givebirth(cal)">
                            <label for="_1_give_birth_1"><span></span>Yes</label>
                        </li>
                        <li>
                            <input type="radio" name="_1_give_birth" value="No" id="_1_give_birth_0" class="field-no" ng-model="cal.give_birth" ng-change="cal_givebirth(cal)">
                            <label for="_1_give_birth_0"><span></span>No</label>
                        </li>
                    </ul>
                  </li>
                  <!-- / main li -->
                  
                  <div class="ng-hide" ng-show="cal.give_birth == 'Yes'">
                    <li>
                      <label for="_1_give_birth_date">When did you give birth?</label>
                        
                        <ul class="field-box date-row">
                            <li>
                                <div class="dropdown-box">
                                	<label>Month</label>
                                    <div class="dropdown">
                                      <button name="_1_month" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        {{cal.give_birth_month || date.getUTCMonth()+1}}
                                        <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu scrollme" aria-labelledby="dLabel" mb-scrollbar>
                                        <li ng-repeat="index in dropdown_number(1, 12)" ng-click="dropSelect(index, 'give_birth_month')">{{index}}</li>
                                      </ul>
                                    </div>
                                </div>
                                
                                <div class="dropdown-box">
                                    <label>Day</label>
                                    <div class="dropdown">
                                      <button name="_1_day" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        {{cal.give_birth_day || date.getUTCDate()}}
                                        <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu scrollme" aria-labelledby="dLabel" mb-scrollbar>
                                        <li ng-repeat="index in dropdown_number(1, 31) | filter: daysInMonth(cal.give_birth_month -1, cal.give_birth_year)" ng-click="dropSelect(index, 'give_birth_day')">{{index}}</li>
                                      </ul>
                                    </div>
                                </div>
                                
                                <div class="dropdown-box">
                                    <label>Year</label>
                                    <div class="dropdown">
                                      <button name="_1_year" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        {{cal.give_birth_year || date.getUTCFullYear()}}
                                        <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu scrollme" aria-labelledby="dLabel" mb-scrollbar>
                                        <li ng-repeat="index in dropdown_number((date.getFullYear()-10), date.getFullYear())" ng-click="dropSelect(index, 'give_birth_year')">{{index}}</li>
                                      </ul>
                                    </div>
                                </div>
                                
                            </li>
                        </ul>
                    </li>
                    <!-- / main li -->
                    
                    <li>
                      <label>Did you give birth by C-Section?</label>
                      
                      <ul class="field-box ul-inline">
                          <li>
                              <input type="radio" name="_1_birth_by_csection" value="Yes" id="_1_birth_by_csection_1" ng-model="cal.birth_by_csection">
                              <label for="_1_birth_by_csection_1"><span></span>Yes</label>
                          </li>
                          <li>
                              <input type="radio" name="_1_birth_by_csection" value="No" id="_1_birth_by_csection_0" ng-model="cal.birth_by_csection">
                              <label for="_1_birth_by_csection_0"><span></span>No</label>
                          </li>
                      </ul>
                    </li>
                    <!-- / main li -->
                    
                    <li class="ng-hide" ng-show="cal.birth_by_csection != null">
                      <label>Post-Baby Pooch Swelling</label>
                        
                      <ul class="field-box">
                            <li>
                              <input type="radio" name="_1_baby_pooch" value="very-swollen" id="_1_baby_pooch_1" ng-model="cal.postpartum_swelling">
                                <label for="_1_baby_pooch_1"><span></span>Swollen, I still look pregnant</label>
                            </li>
                            <li>
                              <input type="radio" name="_1_baby_pooch" value="pretty-swollen" id="_1_baby_pooch_2" ng-model="cal.postpartum_swelling">
                                <label for="_1_baby_pooch_2"><span></span>Pretty Swollen, but getting better</label>
                            </li>
                        <li>
                          <input type="radio" name="_1_baby_pooch" value="slightly-swollen" id="_1_baby_pooch_3" ng-model="cal.postpartum_swelling">
                                <label for="_1_baby_pooch_3"><span></span>Slightly Swollen</label>
                        </li>
                        <li>
                            <input type="radio" name="_1_baby_pooch" value="no-swelling" id="_1_baby_pooch_4" ng-model="cal.postpartum_swelling">
                              <label for="_1_baby_pooch_4"><span></span>No Swelling</label>
                        </li>
                      </ul>
                    </li>
                    <!-- / main li -->
                    
                  </div>
                  <!-- / .active-yes -->
                  
                  <div class="ng-hide" ng-show="cal.give_birth == 'No'">
                    <li>
                      <label>Do you plan on having a c-section?</label>
                        
                      <ul class="field-box">
                            <li>
                              <input type="radio" name="_1_plan_on_csection" value="Yes" id="_1_plan_on_csection_1" ng-model="cal.plan_on_csection">
                                <label for="_1_plan_on_csection_1"><span></span>Yes</label>
                            </li>
                            <li>
                              <input type="radio" name="_1_plan_on_csection" value="No" id="_1_plan_on_csection_2" ng-model="cal.plan_on_csection">
                                <label for="_1_plan_on_csection_2"><span></span>No</label>
                          </li>
                            <li>
                                <input type="radio" name="_1_plan_on_csection" value="Uncertain" id="_1_plan_on_csection_3" ng-model="cal.plan_on_csection">
                                <label for="_1_plan_on_csection_3"><span></span>Not Sure</label>
                            </li>
                      </ul>
                    </li>
                    <!-- / main li -->
                    
                    <li class="ng-hide" ng-show="cal.plan_on_csection != null">
                      <label>Pre-Pregnancy Weight, <strong>weeks</strong></label>
                        
                      <ul class="field-box">
                          <li>
                            <div class="dropdown weeks">
                              <button name="_1_how_many_week" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                              	{{cal.how_many_week}}
                                <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu scrollme" aria-labelledby="dLabel" mb-scrollbar>
                                <li ng-click="dropSelect('under 20', 'how_many_week')">Under 20</li>
                                <li ng-repeat="index in dropdown_number(20, 40)" ng-click="dropSelect(index, 'how_many_week')">{{index}}</li>
                              </ul>
                            </div>
                          </li>
                      </ul>
                    </li>
                    <!-- / main li -->
                    
                    <div ng-show="cal.how_many_week < 36 || cal.how_many_week == 'under 20'" class="ng-hide tab1-important row">
                        <li>
                          <label class="important">IMPORTANT</label>
                          <p>It's best to measure at week <span>36</span>. 
                          Receive a Sizing Reminder in <span>3 weeks</span>.</p>
                          
                          <ul class="field-box ul-inline">
                              <li>
                                <input type="radio" name="_1_measure_week" value="Yes" id="_1_measure_week_1" ng-model="cal.measure_week">
                                <label for="_1_measure_week_1"><span></span>Yes</label>
                              </li>
                              <li>
                                <input type="radio" name="_1_measure_week" value="No" id="_1_measure_week_2" ng-model="cal.measure_week">
                                <label for="_1_measure_week_2"><span></span>Not now</label>
                              </li>
                          </ul>
                        </li>
                        <!-- / main li -->
                        
                        <li class="ng-hide" ng-show="cal.measure_week == 'Yes'">
                          <label for="_1_email">Email</label>
                          
                          <ul class="field-box">
                              <li>
                                <div class="required-field">
                                <span class="error" ng-show="frmCal._1_email.$error.required">Please, fill in this field</span>
                                <span class="error" ng-show="frmCal._1_email.$error.email">Your email address is invalid</span>
                                <input type="email" name="_1_email" id="_1_email" placeholder="Please write your email" ng-model="cal.week_email" required></div>
                              </li>
                          </ul>
                        </li>
                        <!-- / main li -->
                    </div>
                    
                  </div>
                  <!-- / .active-no -->
                  
              </ul>
          </div>
          
          <div class="button-container">
              <a class="btn btn-default btn-lg next" href="" ng-if="isSteps('step2_a', cal)" data-ng-click="goNext(1)">To The Next Step</a>
              <a class="btn btn-default btn-lg next" href="" ng-if="isSteps('step2_b', cal)" data-ng-click="goNext(2)">To The Next Step</a>
              <a class="save-later" href="" data-ng-click="goNext(5)">Save for Later</a>
          </div>
          
        </div>
        <!-- / #step1 -->
          
        <div class="tab-pane fade" id="step2">
          <div class="well">
              <ul class="steps">
                  
                  <div class="ng-hide" ng-show="cal.give_birth == 'Yes'">
                      <li>
                        <label>Pre-Pregnancy Weight</label>
                          
                          <ul class="field-box">
                              <li>
                                <div class="dropdown">
                                  <button name="_2_pregnancy_weight" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                    {{cal._2_pregnancy_weight}} Lb
                                    <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu scrollme" aria-labelledby="dLabel" mb-scrollbar>
                                    <li ng-repeat="index in dropdown_number(80, 250)" ng-click="dropSelect(index, '_2_pregnancy_weight'); cal_remain_weight_gain(cal)">{{index}} Lb</li>
                                  </ul>
                                </div>
                              </li>
                          </ul>
                      </li>
                      <!-- / main li -->
                      
                      <li>
                        <label>Your Weight Just Before Gave Birth</label>
                          
                          <ul class="field-box">
                              <li>
                                <div class="dropdown">
                                  <button name="_2_heaviest_weight" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                    {{cal._2_heaviest_weight}} Lb
                                    <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu scrollme" aria-labelledby="dLabel" mb-scrollbar>
                                    <li ng-repeat="index in dropdown_number(80, 250) | filter: greaterThan(cal._2_pregnancy_weight)" ng-click="dropSelect(index, '_2_heaviest_weight'); cal_remain_weight_gain(cal)">{{index}} Lb</li>
                                  </ul>
                                </div>
                              </li>
                          </ul>
                      </li>
                      <!-- / main li -->
                      
                      <li>
                        <label>Your Weight Now <strong>Lb</strong></label>
                          
                          <ul class="field-box">
                              <li>
                                <div class="dropdown">
                                  <button name="_2_weight_now" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                    {{cal._2_weight_now}} Lb
                                    <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu scrollme" aria-labelledby="dLabel" mb-scrollbar>
                                    <li ng-repeat="index in dropdown_number(80, 250) | filter: greaterThan(cal._2_pregnancy_weight) | filter: lessThan(cal._2_heaviest_weight)" ng-click="dropSelect(index, '_2_weight_now'); cal_remain_weight_gain(cal)">{{index}} Lb</li>
                                  </ul>
                                </div>
                              </li>
                          </ul>
                      </li>
                      <!-- / main li -->
                      
                      <li ng-if="(cal.pregnancy_gained > cal.after_childbirth && cal.pregnancy_gained > cal.remain_weight)">
                        <ul class="field-box result-box">
                              <li>
                                  <label>During Your Pregnance You Gaines</label>
                                  <div class="lb"><strong>{{cal.pregnancy_gained}}</strong> Lb</div>
                                  <input type="hidden" name="_2_pregnancy_you_gained" id="_2_pregnancy_you_gained" str-int ng-model="cal.pregnancy_gained" disabled>
                              </li>
                              <li>
                                  <label>From Giving Birth Until Now You Lost</label>
                                  <div class="lb"><strong>{{cal.after_childbirth}}</strong> Lb</div>
                                  <input type="hidden" name="_2_after_childbirth" id="_2_after_childbirth" str-int ng-model="cal.after_childbirth" disabled>
                              </li>
                              <li>
                                  <label>Remaining Weight Left to Lose</label>
                                  <div class="lb"><strong>{{cal.remain_weight}}</strong> Lb</div>
                                  <input type="hidden" name="_2_remain_weight" id="_2_remain_weight" str-int ng-model="cal.remain_weight" disabled>
                              </li>
                        </ul>
                      </li>
                      <!-- / main li -->
                  </div>
                  <!-- / .active-yes -->
                  
                  <div class="ng-hide" ng-show="cal.give_birth == 'No'">
                      <li>
                        <label>Pre-Pregnancy Weight</label>
                          
                          <ul class="field-box">
                              <li>
                                <div class="dropdown">
                                  <button name="pregnancy_weight_no" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                    {{cal.pregnancy_weight_no}} Lb
                                    <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu scrollme" aria-labelledby="dLabel" mb-scrollbar>
                                    <li ng-repeat="index in dropdown_number(80, 250)" ng-click="dropSelect(index, 'pregnancy_weight_no'); cal_weight_gain_pregnant(cal)">{{index}} Lb</li>
                                  </ul>
                                </div>
                              </li>
                          </ul>
                      </li>
                      <!-- / main li -->
                      
                      <li>
                        <label>Your Weight Now <strong>Lb</strong></label>
                          
                          <ul class="field-box">
                              <li>
                                <div class="dropdown">
                                  <button name="weight_now_no" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                    {{cal.weight_now_no}} Lb
                                    <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu scrollme" aria-labelledby="dLabel" mb-scrollbar>
                                    <li ng-repeat="index in dropdown_number(80, 250) | filter: greaterThan(cal.pregnancy_weight_no)" ng-click="dropSelect(index, 'weight_now_no'); cal_weight_gain_pregnant(cal)">{{index}} Lb</li>
                                  </ul>
                                </div>
                                
                              </li>
                          </ul>
                      </li>
                      <!-- / main li -->
                      
                      <li class="ng-hide" ng-show="cal.weight_gain_pregnant > 0">
                        <ul class="field-box result-box">
                          <li>
                              <label>During Your Pregnance You Gain</label>
                              <div class="lb"><strong>{{cal.weight_gain_pregnant}}</strong> Lb</div>
                              <input type="hidden" name="_2_weight_gain_pregnancy" id="_2_weight_gain_pregnancy" ng-model="cal.weight_gain_pregnant" disabled>
                          </li>
                        </ul>
                      </li>
                      <!-- / main li -->
                  </div>
                  <!-- / .active-no -->
                  
              </ul>
          </div>
          
          <div class="button-container">
              <a class="btn btn-default pull-left back" href="" data-ng-click="goNext(0)"></a>
              <a class="btn btn-default" href="" ng-if="isSteps('step3', cal)" data-ng-click="goNext(2)">To The Next Step</a>
              <a class="save-later" href="" data-ng-click="goNext(5)">Save for Later</a>
          </div>
          
        </div>
        <!-- / #step2 -->
        
        <div class="tab-pane fade" id="step3">
          <div class="well">
              <ul class="steps">
                  <li>
                    <label>How tall are you?</label>
                      
                      <ul class="field-box">
                          <li>
                            <div class="dropdown">
                              <button name="_3_tall_are_you" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                {{cal.tall_are_you}}
                                <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu scrollme" aria-labelledby="dLabel" mb-scrollbar>
                                <li ng-click="dropSelect('under-5-7', 'tall_are_you')">under-5-7</li>
                                <li ng-click="dropSelect('over-5-7', 'tall_are_you')">over-5-7</li>
                              </ul>
                            </div>
                          </li>
                      </ul>
                  </li>
                  <!-- / main li -->
                  
                  <li class="ng-hide" ng-show="cal.tall_are_you != null">
                    <label>Where do you tend to carry your weight?</label>
                      
                    <ul class="field-box">
                          <li>
                            <input type="radio" name="_3_carry_your_weight" value="thighs" id="_3_thighs_hips" ng-model="cal.carry_your_weight" ng-change="cal.body_shapes=''">
                              <label for="_3_thighs_hips"><span></span>Thighs & Hips</label>
                          </li>
                          <li>
                            <input type="radio" name="_3_carry_your_weight" value="stomach" id="_3_stomach" ng-model="cal.carry_your_weight" ng-change="cal.body_shapes=''">
                              <label for="_3_stomach"><span></span>My Stomach & Mid-Section</label>
                        </li>
                        <li>
                            <input type="radio" name="_3_carry_your_weight" value="chest" id="_3_chest_body" ng-model="cal.carry_your_weight" ng-change="cal.body_shapes=''">
                            <label for="_3_chest_body"><span></span>Chest & Upper Body</label>
                        </li>
                        <li>
                            <input type="radio" name="_3_carry_your_weight" value="even" id="_3_even" ng-model="cal.carry_your_weight" ng-change="cal.body_shapes=''">
                            <label for="_3_even"><span></span>Evenly Distributed</label>
                        </li>
                    </ul>
                  </li>
                  <!-- / main li -->
                  
                  <div class="ng-hide" ng-show="cal.carry_your_weight != null">
                    <li>
                    <label>Possible Body Shapes</label>
                    
                    <ul class="steps">
                        
                        <div class="shape-box">
                            <div ng-show="cal.carry_your_weight == 'thighs'">
                            <li class="active">
                              <input type="radio" name="_3_body_shapes" value="Hourglass" id="_3_hourglass" ng-model="cal.body_shapes">
                              <label for="_3_hourglass">
                                  <img ng-src="{{ cal.body_shapes == 'Hourglass' && getImage('shapes/hourglass2.png') || getImage('shapes/hourglass1.png') }}" alt="Hourglass"  />
                                  <span></span>Hourglass
                              </label>
                            </li>
                            
                            <li>
                              <input type="radio" name="_3_body_shapes" value="Triangle" id="_3_triangle" ng-model="cal.body_shapes" ng-checked="body_tri">
                              <label for="_3_triangle">
                                  <img ng-src="{{ cal.body_shapes == 'Triangle' && getImage('shapes/triangle2.png') || getImage('shapes/triangle1.png') }}" alt="Triangle"  />
                                  <span></span>Triangle
                              </label>
                            </li>
                            </div>
                            
                            <div>
                            <li ng-show="cal.carry_your_weight == 'stomach'">
                              <input type="radio" name="_3_body_shapes" value="Oval" id="_3_oval" ng-model="cal.body_shapes">
                              <label for="_3_oval">
                                  <img ng-src="{{ cal.body_shapes == 'Oval' && getImage('shapes/round2.png') || getImage('shapes/round1.png') }}" alt="Oval"  />
                                  <span></span>Oval
                              </label>
                            </li>
                            <li ng-show="cal.carry_your_weight == 'even'">
                              <input type="radio" name="_3_body_shapes" value="Rectangle" id="_3_rectangle" ng-model="cal.body_shapes">
                              <label for="_3_rectangle">
                                  <img ng-src="{{ cal.body_shapes == 'Rectangle' && getImage('shapes/rectangle2.png') || getImage('shapes/rectangle1.png') }}" alt="Rectangle"  />
                                  <span></span>Rectangle
                              </label>
                            </li>
                            <li ng-show="cal.carry_your_weight == 'chest'">
                              <input type="radio" name="_3_body_shapes" value="Inverted-Triangle" id="_3_inverted_triangle" ng-model="cal.body_shapes">
                              <label for="_3_inverted_triangle">
                                  <img ng-src="{{ cal.body_shapes == 'Inverted-Triangle' && getImage('shapes/intriangle2.png') || getImage('shapes/intriangle1.png') }}" alt="Inverted-Triangle"  />
                                  <span></span>Inverted-Triangle
                              </label>
                            </li>
                            </div>
                        </div>
                        
                        <div class="shape-text">
                            <div ng-show="cal.carry_your_weight == 'thighs'">
                                <li class="ng-hide" ng-show="cal.body_shapes == 'Hourglass'">
                                  <span>Hourglass</span>
                                  <p>You are curvy and you carry your weight evenly on your shoulders and chest as well as your 
                                  hips and thighs and have a defined waistline.</p>
                                </li>
                                
                                <li class="ng-hide" ng-show="cal.body_shapes == 'Triangle'">
                                  <span>Triangle</span>
                                  <p>You carry most of your weight on your hips and thighs with a smaller upper body.</p>
                                </li>
                            </div>
                            
                            <li class="ng-hide" ng-show="cal.body_shapes == 'Oval'">
                              <span>Oval</span>
                              <p>You carry most of your weight on your hips and thighs with a smaller upper body.</p>
                            </li>
                            
                            <li class="ng-hide" ng-show="cal.body_shapes == 'Rectangle'">
                              <span>Rectangle</span>
                              <p>You carry most of your weight on your hips and thighs with a smaller upper body.</p>
                            </li>
                            
                            <li class="ng-hide" ng-show="cal.body_shapes == 'Inverted-Triangle'">
                              <span>Inverted-Triangle</span>
                              <p>You carry most of your weight on your hips and thighs with a smaller upper body.</p>
                            </li>
                            
                        </div>
                        
                    </ul>
                    </li>
                  </div>
                  
              </ul>
              
          </div>
          
          <div class="button-container">
              <a class="btn btn-default pull-left back" href="" ng-if="isSteps('step2_b', cal)" data-ng-click="goNext(0)"></a>
              <a class="btn btn-default pull-left back" href="" ng-if="isSteps('step2_b', cal) == false" data-ng-click="goNext(1)"></a>
              <a class="btn btn-default next" href="" ng-if="(isSteps('step4', cal) && isSteps('step3', cal))" data-ng-click="goNext(3)">To The Next Step</a>
              <a class="save-later" href="" data-ng-click="goNext(5)">Save for Later</a>
          </div>
          
        </div>
        <!-- / #step3 -->
        
        <div class="tab-pane fade" id="step4">
          <div class="well">
              <ul class="steps">
                  <li>
                    <label>Pre-Pregnancy Jean Size</label>
                      
                      <ul class="field-box">
                          <li>
                            <div class="dropdown">
                              <button name="_3_pregnancy_jean_size" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                {{cal.pregnancy_jean_size}}
                                <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu scrollme" aria-labelledby="dLabel" mb-scrollbar>
                                <li ng-repeat="index in loop_number(0, 18, 'range')" ng-click="dropSelect(index, 'pregnancy_jean_size')">{{index}}</li>
                              </ul>
                            </div>
                          </li>
                      </ul>
                  </li>
                  <!-- / main li -->
                  
                  <li class="ng-hide" ng-show="cal.pregnancy_jean_size != null">
                    <label>Measure your Hip Contour?</label>
                      
                    <ul class="field-box ul-inline">
                        <li>
                          <input type="radio" name="_3_your_hip_contour" value="Yes" id="_3_your_hip_contour_1" ng-model="cal.your_hip_contour" class="select-yes">
                            <label for="_3_your_hip_contour_1"><span></span>I have a measuring tape</label>
                        </li>
                        <li>
                          <input type="radio" name="_3_your_hip_contour" value="No" id="_3_your_hip_contour_0" ng-model="cal.your_hip_contour" class="select-no">
                            <label for="_3_your_hip_contour_0"><span></span>I don't have a measuring tape</label>
                        </li>
                    </ul>
                  </li>
                  <!-- / main li -->
                  
                  <div class="ng-hide" ng-show="cal.pregnancy_jean_size && cal.your_hip_contour == 'Yes'">
                      <li>
                        <label>Hip Measurement in Inches</label>
                          
                          <ul class="field-box">
                              <li>
                                <div class="dropdown">
                                  <button name="_3_measuring_inches" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                    {{cal.measuring_inches}}
                                    <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu scrollme" aria-labelledby="dLabel" mb-scrollbar>
                                    <li ng-repeat="index in loop_number(33, 53.5, 'point')" ng-click="dropSelect(index, 'measuring_inches')">{{index}}</li>
                                  </ul>
                                </div>
                              </li>
                          </ul>
                      </li>
                      <!-- / main li -->
                  </div>
                  
                  <div class="ng-hide" ng-show="cal.pregnancy_jean_size && cal.your_hip_contour == 'No'">
                      <li>
                        <a href="#" class="btn-down">Download Printable Tape</a>
                      </li>
                      <!-- / main li -->
                  </div>
                  
              </ul>
              
              <div class="ng-hide step-measuring" ng-show="cal.pregnancy_jean_size">
              <h3>Measuring Your Hips</h3>
              
              <ul class="steps">
                  <li>
                      <!--<iframe src=""></iframe>-->
                      <iframe src="https://player.vimeo.com/video/156710000" width="780" height="438" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                  </li>
              </ul>
              </div>
          </div>
          
          <div class="button-container">
              <a class="btn btn-default pull-left back" href="" data-ng-click="goNext(2)"></a>
              <a class="btn btn-default next ng-hide" href="" data-ng-click="goNext(4); dataSubmit(cal)" ng-show="(cal.pregnancy_jean_size && cal.your_hip_contour == 'Yes') && isAllSteps(cal)">Your Style &amp; Size</a>
              <a class="btn btn-default next ng-hide" href="" data-ng-click="goNext(4); dataSubmit(cal)" ng-show="(cal.pregnancy_jean_size && cal.your_hip_contour == 'No') && isAllSteps(cal)">View Your Styles</a>
              <a class="save-later" href="" data-ng-click="goNext(5)">Save for Later</a>
          </div>
          
        </div>
        <!-- / #step4 -->
        
      </div>
      <!-- / .tab-content -->
      
  </div>
  <!-- / .main-step -->
  
  <div class="main-recommend ng-hide" ng-show="(full_step == 'recommend') && isAllSteps(cal)">
      <div class="tab-pane fade" id="" ng-class="{'active in': (full_step == 'recommend') && isAllSteps(cal)}">
        <div class="well">
        
          <div class="recommend-box green">
          	<h3>Your Recommended Size</h3>
          	
            <div ng-if="cal.your_hip_contour == 'Yes' && rec_size != 'Call for Sizing'">
                <p>For <strong>immediate</strong> postpartum support</p>
                <h4>{{rec_size}}</h4>
            </div>
            
            <div ng-if="cal.your_hip_contour == 'No'">
                <p>Because you have not entered your <strong>Hip Contour</strong> measurement, we are unable to recommend your size.</p>
                <p>Based on your body shapes, below are your recommended styles.</p>
            </div>
            
            <div ng-if="cal.your_hip_contour == 'Yes' && rec_size == 'Call for Sizing'">
                <p>We would like to contact you so that one of our Sizing Specialists can review your measurements and recommend the best size.</p>
                <p>Below are your recommended styles.</p>
            </div>
            
          </div>
          
          <div class="recommend-box rc-box1">
          <h3>Your Recommended Styles</h3>
          <ul class="steps">
              <li ng-repeat="style in rec_styles">
                  <div class="image" ng-if="style.img"><img ng-src="{{style.img}}" alt="{{style.title}}" /></div>
                  <div class="title" ng-bind-html="style.title"></div>
                  <div class="price" ng-show="style.price">Regular Price:
                      <span ng-class="{'cut':style.sale_price}" ng-bind-html="style.price"></span>
                  </div>
                  <div class="sale_price" ng-show="style.sale_price" ng-bind-html="style.sale_price"></div>
                  <div class="link"><a href="{{style.link}}" target="_new">Get Your Size</a></div>
              </li>
          </ul>
          </div>
          
          <div class="recommend-box rc-box2">
          <h3>Your Recommended Bundles</h3>
          <ul class="steps">
              <li ng-repeat="bundle in rec_bundles">
                  <div class="image" ng-if="bundle.img"><img ng-src="{{bundle.img}}" alt="{{bundle.title}}" /></div>
                  <div class="title" ng-bind-html="bundle.title"></div>
                  <div class="price" ng-show="bundle.price">Regular Price: 
                      <span ng-class="{'cut':bundle.sale_price}" ng-bind-html="bundle.price"></span>
                  </div>
                  <div class="sale_price" ng-show="bundle.sale_price">
                      <div ng-bind-html="bundle.sale_price"></div>
                  </div>
                  <div class="link"><a href="{{bundle.link}}" target="_new">Get {{bundle.sku}} &gt;&gt;</a></div>
              </li>
          </ul>
          </div>
          
          <div class="recommend-box rc-box3">
          <h3>Additional Options</h3>
          <ul class="steps">
              <li>
              	  <label>Email</label>
                  <div class="required-field">
                    <span class="error" ng-show="frmCal.email.$error.required">Please, fill in this field</span>
                    <span class="error" ng-show="frmCal.email.$error.email">Your email address is invalid</span>
                  <input type="email" name="email" placeholder="Type your Email here" ng-model="cal.result_email" required></div>
              </li>
              <li>
                  <input type="checkbox" id="need_to_speak" name="need_to_speak">
                  <label for="need_to_speak"><span></span>I need to speak to a sizing specialist before i make a decision.</label>
              </li>
              <li class="w-half">
                  <label>Phone Number</label>
                  <input type="text" name="phone" placeholder="Your Phone number goes here">
              </li>
              
              <li class="w-half">
                  <label>Name</label>
                  <input type="text" name="fullname" placeholder="Your Name">
              </li>
              
              <li class="email-submit">
                  <a class="btn-email ng-hide" href="javascript:;" data-ng-click="resultSubmit(cal)" ng-hide="( cal.result_email == null )">Email Me My Results</a>
                  <strong class="ng-hide" ng-show="res_result.status == 'success'">{{res_result.html}}</strong>
              </li>
          </ul>
          </div>
          
        </div>
        
            <div class="button-container recommend-btn">
            	<a class="btn btn-default pull-left back" href="" data-ng-click="goNext(3)"></a>
            	<a class="btn btn-default btn-success first" href="" data-ng-click="goNext(0)">Start Over</a>
            </div>
      </div>
      <!-- / #step5 -->
      
  </div>
  <!-- / .main-recommend -->
  
  <div class="main-save ng-hide" ng-show="full_step == 'save'">
      <div class="well">
      
      <div class="save-box">
      <h3>Save My Sizing Session</h3>
      
      <ul class="steps">
          <li>
              <p>Save this link to return later from any device. Link valid for 30 days.</p>
          </li>
          
          <li>
              <?php $save_link = get_permalink() . "?action=retrive_form&token="; ?>
              <a href="<?php echo $save_link; ?>{{cal.uniqid}}" id="save-link"><?php echo $save_link; ?>{{cal.uniqid}}</a>
          </li>
          
          <li>
              <a href="javascript:;" class="copy-link" data-ng-click="dataSave(cal)">Copy Link</a>
          </li>
          
          <li class="ng-hide" ng-show="res_save == 'success'">
              ALL SET! The Link was sent to the following email address:
              <br />
              {{cal.save_email}}
          </li>
          
          <li class="ng-hide" ng-hide="res_save == 'success'">
              <div class="required-field">
              <span class="error" ng-show="frmCal.save_email.$error.required">Please, fill in this field</span>
              <span class="error" ng-show="frmCal.save_email.$error.email">Your email address is invalid</span>
              <input type="email" name="save_email" placeholder="Your email goes here" ng-model="cal.save_email" required></div>
          </li>
          
          <li>
              <button type="button" data-ng-click="dataSave(cal)" ng-disabled="( cal.save_email == null )">Email me the Link</button>
          </li>
          
      </ul>
      </div>
     </div>
      
     <div class="button-container">
     	<a href="javascript:;" class="btn btn-default pull-left back" data-ng-click="goNext(goBack)"></a>
     </div>
     
  </div>
  <!-- / .main-save -->
  
  </form>
  
</div>

<script type='text/javascript'>
jQuery(document).ready(function() {
	// use jQuery to update progress bar
	jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		
		//update progress
		var step = jQuery(e.target).data('step');
		var percent = (parseInt(step) / 4) * 100;
		
		jQuery('.progress-bar').css({width: percent + '%'});
		jQuery('.progress-bar-text').text(percent + "%");
		
	});
});
</script>