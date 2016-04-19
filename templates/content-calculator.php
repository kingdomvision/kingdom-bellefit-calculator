<div class="container" id="myWizard" ng-app="calculatorApp" ng-controller="MainCtrl">

  <div class="main-head"><h1>Choosing and Sizing</h1></div>
  
  <div class="main-step" ng-hide="(full_step == 'recommend' || full_step == 'save')">
      <div class="navbar">
        <div class="navbar-inner">
          <ul class="nav nav-tabs">
            <li class="active">
                <a href="#step1" data-toggle="tab" data-step="1">
                    <img ng-src="{{getImage('icon1.png')}}" />
                    <img ng-src="{{getImage('icon1-active.png')}}" class="active-img" />
                    <span>Childbirth &amp;<br />Delivery</span>
                </a>
            </li>
            
            <li ng-class="{'disabled': (isSteps('step2_a', cal) == false && isSteps('step2_b', cal) == false)}">
                <a ng-href="{{( isSteps('step2_a', cal) || isSteps('step2_b', cal) ) ? '#step2' : 'javascript:void(0);'}}" data-toggle="tab" data-step="2">
                    <img ng-src="{{getImage('icon2.png')}}" />
                    <img ng-src="{{getImage('icon2-active.png')}}" class="active-img" />
                    <span>Your Weight</span>
                </a>
            </li>
            
            <li ng-class="{'disabled': isSteps('step3', cal) == false}">
                <a ng-href="{{( isSteps('step3', cal) ) ? '#step3' : 'javascript:void(0);'}}" data-toggle="tab" data-step="3">
                    <img ng-src="{{getImage('icon3.png')}}" />
                    <img ng-src="{{getImage('icon3-active.png')}}" class="active-img" />
                    <span>Body Shape</span>
                </a>
            </li>
            
            <li ng-class="{'disabled': (isSteps('step4', cal) == false && isSteps('step3', cal) == false)}">
                <a ng-href="{{( isSteps('step4', cal) && isSteps('step3', cal) ) ? '#step4' : 'javascript:void(0);'}}" data-toggle="tab" data-step="4">
                    <img ng-src="{{getImage('icon4.png')}}" />
                    <img ng-src="{{getImage('icon4-active.png')}}" class="active-img" />
                    <span>Your Size</span>
                </a>
            </li>
            
            <!--<li><a href="#step5" data-toggle="tab" data-step="5">Step 5</a></li>-->
          </ul>
        </div>
      </div>
      
      <div class="calc-main-title">
        <h3>Childbirth &amp; Delivery Method</h3>
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
              <h3>Childbirth &amp; Delivery Method</h3>
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
                        
                        <ul class="field-box">
                            <li>
                                <input type="text" pick-a-date="date" id="_1_give_birth_date" placeholder="Select Date" ng-model="cal.give_birth_date" />
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
                      <label>Your "Baby Pooch" Postpartum Swelling</label>
                        
                      <ul class="field-box">
                            <li>
                              <input type="radio" name="_1_baby_pooch" value="very-swollen" id="_1_baby_pooch_1" ng-model="cal.postpartum_swelling">
                                <label for="_1_baby_pooch_1"><span></span>Swollen, I still look pregnant</label>
                            </li>
                            <li>
                              <input type="radio" name="_1_baby_pooch" value="pretty-swollen" id="_1_baby_pooch_2" ng-model="cal.postpartum_swelling">
                                <label for="_1_baby_pooch_2"><span></span>Pretty Swollen, but not too bad</label>
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
                      <label>How many weeks along are you?</label>
                        
                      <ul class="field-box">
                          <li>
                            <select name="_1_how_many_week" id="_1_how_many_week" ng-model="cal.how_many_week">
                                <option value=""></option>
                                <option value="under 20">under 20</option>
                                <option ng-selected="{{cal.how_many_week == index}}" ng-repeat="index in dropdown_number(20, 40)" value="{{index}}">{{index}}</option>
                            </select>
                          </li>
                      </ul>
                    </li>
                    <!-- / main li -->
                    
                    <div ng-show="cal.how_many_week < 36 || cal.how_many_week == 'under 20'" class="ng-hide tab1-important row">
                        <li>
                          <label class="important">IMPORTANT</label>
                          <p>It's best to measure at week <strong>36</strong>.</p>
                          <p>Receive a Sizing Reminder in<strong>3 weeks</strong>.</p>
                          
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
                                <input type="email" name="_1_email" id="_1_email" ng-model="cal.week_email">
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
              <a class="btn btn-default btn-lg next pull-right" href="" ng-if="isSteps('step2_a', cal)" data-ng-click="goNext(1)">Next: Weight</a>
              <a class="btn btn-default btn-lg next pull-right" href="" ng-if="isSteps('step2_b', cal)" data-ng-click="goNext(2)">Next: Weight</a>
          </div>
          <a class="btn btn-default pull-right" href="" data-ng-click="goNext(5)">Save for Later</a>
        </div>
        <!-- / #step1 -->
          
        <div class="tab-pane fade" id="step2">
          <div class="well">
              <h3>Your Weight Stats</h3>
              
              <ul class="steps">
                  
                  <div class="ng-hide" ng-show="cal.give_birth == 'Yes'"><!--class="ng-hide" ng-show="give_birth == 'Yes'"-->
                      <li>
                        <label>Pre-Pregnancy Weight</label>
                          
                          <ul class="field-box">
                              <li>
                                <select name="_2_pregnancy_weight" id="_2_pregnancy_weight" ng-model="cal._2_pregnancy_weight" ng-change="cal_remain_weight_gain(cal)">
                                    <option value="" selected="selected">Pregnancy Weight</option>
                                    <option ng-selected="{{cal._2_pregnancy_weight == index}}" ng-repeat="index in dropdown_number(80, 250)" value="{{index}}" if>{{index}}</option>
                                </select>
                              </li>
                          </ul>
                      </li>
                      <!-- / main li -->
                      
                      <li>
                        <label>Heaviest Weight Reached During This Pregnancy</label>
                          
                          <ul class="field-box">
                              <li>
                                <select name="_2_heaviest_weight" id="_2_heaviest_weight" ng-model="cal._2_heaviest_weight" ng-change="cal_remain_weight_gain(cal)">
                                    <option value="" selected="selected">Heaviest Weight</option>
                                    <option ng-selected="{{cal._2_heaviest_weight == index}}" ng-repeat="index in dropdown_number(80, 250) | filter: greaterThan(cal._2_pregnancy_weight)" value="{{index}}">{{index}}</option>
                                </select>
                              </li>
                          </ul>
                      </li>
                      <!-- / main li -->
                      
                      <li>
                        <label>Your Weight Now</label>
                          
                          <ul class="field-box">
                              <li>
                                <select name="_2_weight_now" id="_2_weight_now" ng-model="cal._2_weight_now" ng-change="cal_remain_weight_gain(cal)">
                                    <option value="" selected="selected">Weight Now</option>
                                    <option ng-selected="{{cal._2_weight_now == index}}" ng-repeat="index in dropdown_number(80, 250) | filter: greaterThan(cal._2_pregnancy_weight) | filter: lessThan(cal._2_heaviest_weight)" value="{{index}}">{{index}}</option>
                                </select>
                              </li>
                          </ul>
                      </li>
                      <!-- / main li -->
                      
                      <li ng-if="(cal.pregnancy_gained > cal.after_childbirth && cal.pregnancy_gained > cal.remain_weight)">
                        <ul class="field-box">
                              <li>
                                <label>During Your Pregnancy You Gained</label>
                                <input type="text" name="_2_pregnancy_you_gained" id="_2_pregnancy_you_gained" str-int ng-model="cal.pregnancy_gained" disabled>
                              </li>
                              <li>
                                <label>After Childbirth You Lost</label>
                                <input type="text" name="_2_after_childbirth" id="_2_after_childbirth" str-int ng-model="cal.after_childbirth" disabled>
                              </li>
                              <li>
                                  <label>Remaining Weight Left to Lose</label>
                                  <input type="text" name="_2_remain_weight" id="_2_remain_weight" str-int ng-model="cal.remain_weight" disabled>
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
                                <select name="_2_pregnancy_weight_no" id="_2_pregnancy_weight_no" ng-model="cal.pregnancy_weight_no" ng-change="cal_weight_gain_pregnant(cal)">
                                    <option value="" selected="selected">Pregnancy Weight</option>
                                    <option ng-selected="{{cal.pregnancy_weight_no == index}}" ng-repeat="index in dropdown_number(80, 250)" value="{{index}}">{{index}}</option>
                                </select>
                              </li>
                          </ul>
                      </li>
                      <!-- / main li -->
                      
                      <li>
                        <label>Your Weight Now</label>
                          
                          <ul class="field-box">
                              <li>
                                <select name="_2_weight_now_no" id="_2_weight_now_no" ng-model="cal.weight_now_no" ng-change="cal_weight_gain_pregnant(cal)">
                                    <option value="" selected="selected">Weight Now</option>
                                    <option ng-selected="{{cal.weight_now_no == index}}" ng-repeat="index in dropdown_number(80, 250) | filter: greaterThan(index, cal.pregnancy_weight_no)" value="{{index}}">{{index}}</option>
                                </select>
                              </li>
                          </ul>
                      </li>
                      <!-- / main li -->
                      
                      <li class="ng-hide" ng-show="cal.weight_now_no >= cal.pregnancy_weight_no">
                        <ul class="field-box">
                          <li>
                            <label>Your Weight Gain this Pregnancy</label>
                            <input type="text" name="_2_weight_gain_pregnancy" id="_2_weight_gain_pregnancy" ng-model="cal.weight_gain_pregnant" disabled>
                          </li>
                        </ul>
                      </li>
                      <!-- / main li -->
                  </div>
                  <!-- / .active-no -->
                  
              </ul>
          </div>
          
          <div class="button-container">
              <a class="btn btn-default pull-left" href="" data-ng-click="goNext(0)">&lt; Back</a>
              <a class="btn btn-default pull-right" href="" ng-if="isSteps('step3', cal)" data-ng-click="goNext(2)">Next: Body Shape</a>
              <a class="btn btn-default pull-right" href="" data-ng-click="goNext(5)">Save for Later</a>
          </div>
          
        </div>
        <!-- / #step2 -->
        
        <div class="tab-pane fade" id="step3">
          <div class="well">
              <h3>Your Body Shape</h3>
              
              <ul class="steps">
                  <li>
                    <label>How tall are you?</label>
                      
                      <ul class="field-box">
                          <li>
                            <select name="_3_tall_are_you" id="_3_tall_are_you" ng-model="cal.tall_are_you">
                                <option value="" selected="selected">How tall are you</option>
                                <option value="under-5-7">I'm under 5'7"</option>
                                <option value="over-5-7">5'7" or taller</option>
                            </select>
                          </li>
                      </ul>
                  </li>
                  <!-- / main li -->
                  
                  <li class="ng-hide" ng-show="cal.tall_are_you != null">
                    <label>Where do you tend to carry your weight?</label>
                      
                    <ul class="field-box">
                          <li>
                            <input type="radio" name="_3_carry_your_weight" value="thighs" id="_3_thighs_hips" ng-model="cal.carry_your_weight">
                              <label for="_3_thighs_hips"><span></span>Thighs & Hips</label>
                          </li>
                          <li>
                            <input type="radio" name="_3_carry_your_weight" value="stomach" id="_3_stomach" ng-model="cal.carry_your_weight">
                              <label for="_3_stomach"><span></span>My Stomach & Mid-Section</label>
                        </li>
                        <li>
                            <input type="radio" name="_3_carry_your_weight" value="chest" id="_3_chest_body" ng-model="cal.carry_your_weight">
                            <label for="_3_chest_body"><span></span>Chest & Upper Body</label>
                        </li>
                        <li>
                            <input type="radio" name="_3_carry_your_weight" value="even" id="_3_even" ng-model="cal.carry_your_weight">
                            <label for="_3_even"><span></span>Evenly distributed</label>
                        </li>
                    </ul>
                  </li>
                  <!-- / main li -->
                  
              </ul>
              
              <div class="ng-hide" ng-show="cal.carry_your_weight != null">
              <h3>Possible Body Shapes</h3>
              
              <ul class="steps">
                  
                  <div class="shape-box">
                      <div ng-show="cal.carry_your_weight == 'thighs'">
                      <li class="active">
                        <input type="radio" name="_3_body_shapes" value="Hourglass" id="_3_hourglass" ng-model="cal.body_shapes">
                        <label for="_3_hourglass">
                        <img ng-src="{{getImage('shapes/hourglass1.png')}}" alt="Hourglass" />
                        <span></span>Hourglass
                        </label>
                      </li>
                      
                      <li>
                        <input type="radio" name="_3_body_shapes" value="Triangle" id="_3_triangle" ng-model="cal.body_shapes">
                        <label for="_3_triangle">
                        <img ng-src="{{getImage('shapes/triangle1.png')}}" alt="Triangle" />
                        <span></span>Triangle
                        </label>
                      </li>
                      </div>
                      
                      
                      <li ng-show="cal.carry_your_weight == 'stomach'">
                        <input type="radio" name="_3_body_shapes" value="Oval" id="_3_oval" ng-model="cal.body_shapes">
                        <label for="_3_oval">
                        <img ng-src="{{getImage('shapes/round1.png')}}" alt="Oval" />
                        <span></span>Oval
                        </label>
                      </li>
                      <li ng-show="cal.carry_your_weight == 'even'">
                        <input type="radio" name="_3_body_shapes" value="Rectangle" id="_3_rectangle" ng-model="cal.body_shapes">
                        <label for="_3_rectangle">
                        <img ng-src="{{getImage('shapes/rectangle1.png')}}" alt="Rectangle" />
                        <span></span>Rectangle
                        </label>
                      </li>
                      <li ng-show="cal.carry_your_weight == 'chest'">
                        <input type="radio" name="_3_body_shapes" value="Inverted-Triangle" id="_3_inverted_triangle" ng-model="cal.body_shapes">
                        <label for="_3_inverted_triangle">
                        <img ng-src="{{getImage('shapes/intriangle1.png')}}" alt="Inverted-Triangle" />
                        <span></span>Inverted-Triangle
                        </label>
                      </li>
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
              </div>
          </div>
          
          <div class="button-container">
              <a class="btn btn-default pull-left" href="" data-ng-click="goNext(1)">&lt; Back</a>
              <a class="btn btn-default next pull-right" href="" ng-if="(isSteps('step4', cal) && isSteps('step3', cal))" data-ng-click="goNext(3)">Next: Your Size</a>
              <a class="btn btn-default pull-right" href="" data-ng-click="goNext(5)">Save for Later</a>
          </div>
          
        </div>
        <!-- / #step3 -->
        
        <div class="tab-pane fade" id="step4">
          <div class="well">
              <h3>Your Size</h3>
                    
              <ul class="steps">
                  <li>
                    <label>Pre-Pregnancy Jean Size</label>
                      
                      <ul class="field-box">
                          <li>
                            <select name="_3_pregnancy_jean_size" id="_3_pregnancy_jean_size" ng-model="cal.pregnancy_jean_size">
                                <option value="" selected="selected">Pregnancy Jean Size</option>
                                <option value="0-1">0-1 US</option>
                                <option value="1-2">1-2 US</option>
                                <option value="2-3">2-3 US</option>
                                <option value="3-4">3-4 US</option>
                                <option value="4-5">4-5 US</option>
                                <option value="5-6">5-6 US</option>
                                <option value="6-7">6-7 US</option>
                                <option value="7-8">7-8 US</option>
                                <option value="8-9">8-9 US</option>
                                <option value="9-10">9-10 US</option>
                                <option value="10-11">10-11 US</option>
                                <option value="11-12">11-12 US</option>
                                <option value="12-13">12-13 US</option>
                                <option value="13-14">13-14 US</option>
                                <option value="14-15">14-15 US</option>
                                <option value="15-16">15-16 US</option>
                                <option value="16-17">16-17 US</option>
                                <option value="17-18">17-18 US</option>
                            </select>
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
                                <select name="_3_measuring_inches" id="_3_measuring_inches" ng-model="cal.measuring_inches">
                                    <option value="" selected="selected">Hip Measurement</option>
                                    <option value="32.5">32.5</option>
                                    <option value="33.0">33.0</option>
                                    <option value="33.5">33.5</option>
                                    <option value="34.0">34.0</option>
                                    <option value="34.5">34.5</option>
                                    <option value="35.0">35.0</option>
                                    <option value="35.5">35.5</option>
                                    <option value="36.0">36.0</option>
                                    <option value="36.5">36.5</option>
                                    <option value="37.0">37.0</option>
                                    <option value="37.5">37.5</option>
                                    <option value="38.0">38.0</option>
                                    <option value="38.5">38.5</option>
                                    <option value="39.0">39.0</option>
                                    <option value="39.5">39.5</option>
                                    <option value="40.0">40.0</option>
                                    <option value="40.5">40.5</option>
                                    <option value="41.0">41.0</option>
                                    <option value="41.5">41.5</option>
                                    <option value="42.0">42.0</option>
                                    <option value="42.5">42.5</option>
                                    <option value="43.0">43.0</option>
                                    <option value="43.5">43.5</option>
                                    <option value="44.0">44.0</option>
                                    <option value="44.5">44.5</option>
                                    <option value="45.0">45.0</option>
                                    <option value="45.5">45.5</option>
                                    <option value="46.0">46.0</option>
                                    <option value="46.5">46.5</option>
                                    <option value="47.0">47.0</option>
                                    <option value="47.5">47.5</option>
                                    <option value="48.0">48.0</option>
                                    <option value="48.5">48.5</option>
                                    <option value="49.0">49.0</option>
                                    <option value="49.5">49.5</option>
                                    <option value="50.0">50.0</option>
                                    <option value="50.5">50.5</option>
                                    <option value="51.0">51.0</option>
                                    <option value="51.5">51.5</option>
                                    <option value="52.0">52.0</option>
                                </select>
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
              
              <div class="ng-hide" ng-show="cal.pregnancy_jean_size">
              <h3>Measuring Your Hips</h3>
              
              <ul class="steps">
                  <li>
                      <!--<iframe src=""></iframe>-->
                      <iframe src="https://player.vimeo.com/video/156710000" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                  </li>
              </ul>
              </div>
          </div>
          
          <div class="button-container">
              <a class="btn btn-default pull-left" href="" data-ng-click="goNext(2)">&lt; Back</a>
              <a class="btn btn-default next pull-right ng-hide" href="" data-ng-click="goNext(4); dataSubmit(cal)" ng-show="(cal.pregnancy_jean_size && cal.your_hip_contour == 'Yes') && isAllSteps(cal)">Your Style &amp; Size &gt;</a>
              <a class="btn btn-default next pull-right ng-hide" href="" data-ng-click=" dataSubmit(cal)" ng-show="(cal.pregnancy_jean_size && cal.your_hip_contour == 'No') && isAllSteps(cal)">View Your Styles &gt;</a>
              <a class="btn btn-default pull-right" href="" data-ng-click="goNext(5)">Save for Later</a>
          </div>
          
        </div>
        <!-- / #step4 -->
        
        
        
        <?php /*?><div class="tab-pane fade" id="step6">
          <div class="well">
            <h2>Step 6</h2>
            Because you have not entered your Hip Contour measurement, we are unable to recommend your size.
          </div>
          
          <a class="btn btn-default pull-left" href="" data-ng-click="goNext(3)">&lt; Back</a>
          <a class="btn btn-success first pull-right" href="" data-ng-click="goNext(0)">Start over</a>
        </div><?php */?>
        <!-- / #step6 -->
        <!--<input ng-init="date3='2015-01-01'" ng-model="date3" datetime-picker date-format="yyyy-MM-dd" close-on-select="false" size="30" /> <br/> <br/>-->
      </div>
      <!-- / .tab-content -->
      
      <!--<div ng-repeat="index in dropdown_number(1, 12)" value="{{index}}">{{index}}</div>-->
  </div>
  <!-- / .main-step -->
  
  <div class="main-recommend ng-hide" ng-show="(full_step == 'recommend') && isAllSteps(cal)">
      <div class="tab-pane fade" id="" ng-class="{'active in': (full_step == 'recommend') && isAllSteps(cal)}">
        <div class="well">
          <h2>Step 5</h2>
          <h3>Your Recommended Size</h3>
                  
          <ul class="steps">
              <li>
                  <strong>{{rec_size}}</strong>
  
                  <p>For immediate postpartum support</p>
              </li>
          </ul>
          
          <h3>Your Recommended Styles</h3>
          
          <ul class="steps">
              <li ng-repeat="style in rec_styles">
                  <div class="image" ng-if="style.img"><img ng-src="{{style.img}}" alt="{{style.title}}" /></div>
                  <div class="title" ng-bind-html="style.title"></div>
                  <div class="price" ng-show="style.price">Regular Price: 
                      <div ng-class="{'cut':style.sale_price}" ng-bind-html="style.price"></div>
                  </div>
                  <div class="sale_price" ng-show="style.sale_price" ng-bind-html="style.sale_price"></div>
                  <div class="link"><a href="{{style.link}}" target="_new">Get Your Size</a></div>
              </li>
              <!--<li>
                  Product 2
              </li>-->
          </ul>
          
          <h3>Your Recommended Bundles</h3>
          
          <ul class="steps">
              <li ng-repeat="bundle in rec_bundles">
                  <div class="image" ng-if="bundle.img"><img ng-src="{{bundle.img}}" alt="{{bundle.title}}" /></div>
                  <div class="title" ng-bind-html="bundle.title"></div>
                  <div class="price" ng-show="bundle.price">Regular Price: 
                      <div ng-class="{'cut':bundle.sale_price}" ng-bind-html="bundle.price"></div>
                  </div>
                  <div class="sale_price" ng-show="bundle.sale_price">Your Price: 
                      <div ng-bind-html="bundle.sale_price"></div>
                  </div>
                  <div class="link"><a href="{{bundle.link}}" target="_new">Get {{bundle.sku}} &gt;&gt;</a></div>
              </li>
              <!--<li>
                  Product 2
              </li>-->
          </ul>
          
          <h3>Additional Options</h3>
          
          <ul class="steps">
              <strong>Option 1: Email My Results</strong>
              
              <li>
                  <input type="email" name="email" placeholder="Type your Email here">
              </li>
              <li>
                  <input type="checkbox" name="need_to_speak">
                  <label>I need to speak to a sizing specialist before i make a decision.</label>
              </li>
              <li>
                  <input type="text" name="phone" placeholder="Your Phone number goes here">
              </li>
              
              <li>
                  <input type="text" name="fullname" placeholder="Your Name">
              </li>
          </ul>
        </div>
        
        <a class="btn btn-default pull-left" href="" data-ng-click="goNext(3)">&lt; Back</a>
        <a class="btn btn-success first pull-right" href="" data-ng-click="goNext(0)">Start over</a>
      </div>
      <!-- / #step5 -->
      
  </div>
  <!-- / .main-recommend -->
  
  <div class="main-save ng-hide" ng-show="full_step == 'save'">
      <h3>Save My Sizing Session</h3>
      
      <ul class="steps">
          <li>
              <p>Save this link to return later from any device. Link valid for 30 days.</p>
          </li>
          
          <li>
              <a href="javascript:;"><?php echo get_permalink() . "?token="; ?>{{cal.uniqid}}</a>
          </li>
          
          <li>
              <a href="javascript:;">Copy Link</a>
          </li>
          
          <li>
              ALL SET! The Link was sent to the following email address:
              <strong></strong>
          </li>
          
          <li>
              <input type="email" name="save_email" placeholder="Your email goes here" ng-model="cal.save_email">
          </li>
          
          <li>
              <button type="button" data-ng-click="dataSave(cal)" ng-disabled="(cal.save_email == null)">Email me the Link</button>
          </li>
          
          <li>
              <a href="javascript:;" data-ng-click="goNext(goBack)">&lt; Back</a>
          </li>
      </ul>
      
  </div>
  <!-- / .main-save -->
  
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