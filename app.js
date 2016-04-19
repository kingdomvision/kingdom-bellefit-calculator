var calApp = angular.module('calculatorApp', ['ngCookies', 'ngSanitize', 'angular-datepicker' /*,'angularjs-datetime-picker'*/])
// Main Controller
.controller('MainCtrl', ['$scope', '$http', '$cookieStore', '$rootScope', function($scope, $http, $cookieStore, $rootScope) {
	
	//$compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|file):/);
	
	var numGenerated = function() {
		var number = Math.random() // 0.9394456857981651
		number.toString(36); // '0.xtis06h6'
		var id = number.toString(36).substr(2, 10); // 'xtis06h6'
		return id;
	}
	
	var newObject = function(data) {
		var uniqid = numGenerated();
		var obj = [];
		obj[uniqid] = data;
		return obj;
	}
	
	$scope.cal = {};
	var cal = {};
	if( $cookieStore.get('calculate') != null ) {
		cal = $cookieStore.get('calculate');
	}
	
	
	
	cal.uniqid = numGenerated();
	$scope.cal = cal;
	console.log($scope.cal);
	/*$scope.stepsInfo = [
						{ '1': 'Childbirth &amp; Delivery Method', 'step1_icon_active': calUrl+'/images/icon1-active.png' },
						{ '2': 'Your Weight', 'step2_icon_active': calUrl+'/images/icon2-active.png' },
						{ '3': 'Body Shape', 'step3_icon_active': calUrl+'/images/icon3-active.png' },
						{ '4': 'Your Size', 'step4_icon_active': calUrl+'/images/icon4-active.png' }
					   ]*/
	
	$scope.getImage = function(image) {
		return calUrl + '/images/' + image;
	}
	
	$scope.full_step = false;
	$scope.goBack = '';
	$scope.goNext = function(i) {
		if( i === 4 ) {
			$scope.full_step = 'recommend';
		}
		else if( i === 5 ) {
			$scope.full_step = 'save';
		}
		else {
			jQuery('[href=#step'+(i+1)+']').tab('show');
			$scope.full_step = false;
			$scope.goBack = i;
		}
		return false;
		
	}
	
	$scope.activeOption = function(val) {
		if(val == 'Yes')
			return true;
		else
			return false;
	}
	
	$scope.sumTotal = function(value1, value2) {
		return parseInt((value1 + value2));
	}
	
	$scope.subTotal = function(value1, value2) {
		//console.log(typeof(parseInt(value1 - value2)));
		return (value1 == null || value2 == null)? 0 : (parseInt(value1) - parseInt(value2));
	}
	
	$scope.dropdown_number = function(start, end){
		var i = parseInt(start);
		var total = parseInt(end);
		var values = Array();
		for(i; i <= total; i++) {
			values.push(i);
		}
		return values;
	}
	
	$scope.isSteps = function(steps, data){
		var step = false;
		if( steps == 'step2_a' && (data.how_many_week > 35 || data.postpartum_swelling) ) {
			step = true;
		}
		else if( steps == 'step2_b' && (data.how_many_week < 36 && data.measure_week != null) ) {
			step = true;
		}
		else if( steps == 'step3' && ((data.weight_gain_pregnant >= 0) || (data.pregnancy_gained > data.after_childbirth && data.pregnancy_gained > data.remain_weight)) ) {
			step = true;
		}
		else if( steps == 'step4' && (data.tall_are_you != null && data.carry_your_weight != null && data.body_shapes != null) ) {
			step = true;
		}
		else if( steps == 'step5' && (data.pregnancy_jean_size) && ( (data.your_hip_contour != 'Yes' && data.measuring_inches) || (data.your_hip_contour != 'No') ) ) {
			step = true;
		}
		return step;
	}
	
	$scope.isAllSteps = function(data){
		var step = false;
		if( ($scope.isSteps('step2_a', data) || $scope.isSteps('step2_b', data)) && ($scope.isSteps('step3', data) && $scope.isSteps('step4', data) && $scope.isSteps('step5', data)) ) {
			step = true;
		}
		return step;
	}
	
	$scope.cal_remain_weight_gain = function(data){
		data.pregnancy_gained = $scope.subTotal(data._2_heaviest_weight, data._2_pregnancy_weight);
		data.after_childbirth = $scope.subTotal(data._2_heaviest_weight, data._2_weight_now);
		data.remain_weight = $scope.subTotal(data.pregnancy_gained, data.after_childbirth);
		
    };
	
	$scope.cal_weight_gain_pregnant = function(data){
		data.weight_gain_pregnant = $scope.subTotal(data.weight_now_no, data.pregnancy_weight_no);
    };
	
	$scope.greaterThan = function(val){
		return function(data){
			if (data > val) return true;
			//else if (data == '') return false;
		}
	}
	
	$scope.lessThan = function(val){
		return function(data){
			if (data < val) return true;
			//else if (data == '') return false;
		}
	}
	
	$scope.cal_givebirth = function(data){
		 return $scope.cal = {uniqid: data.uniqid, give_birth: data.give_birth}
    };
	
	$scope.dataSubmit = function(data){
		console.log(data);
		data.model = 'step';
		//data.uniqid = numGenerated();
		
		// Put cookies
		$cookieStore.put('calculate', data);
		// Get cookie
		var calculateCookie = $cookieStore.get('calculate');
		//console.log(calculateCookie);
  
		$http.post(calUrl +'/includes/recommendation.php', data).
		success(function(res, status, headers, config) {
			
			console.log(res);
			$scope.rec_size = res.size;
			$scope.rec_styles = angular.fromJson(res.style);
			$scope.rec_bundles = angular.fromJson(res.bundle);
			//console.log($scope.rec_styles);
		}).
		error(function(res, status, headers, config) {
			$scope.returnMsg = 'Data send error.';
		});
	};
	
	$scope.dataSave = function(data){
		console.log(data);
		data.model = 'save';
  
		$http.post(calUrl +'/includes/recommendation.php', data).
		success(function(res, status, headers, config) {
			if( res.status = 'success' )
			console.log(res);
		}).
		error(function(res, status, headers, config) {
			$scope.returnMsg = 'Data send error.';
		});
	};
}])

.directive('strInt', function() {
	return {
		priority: 1,
		restrict: 'A',
		require: 'ngModel',
		link: function(scope, element, attr, ngModel) {
				function toModel(value) {
					return "" + value; // convert to string
				}
			
				function toView(value) {
					return parseInt(value); // convert to number
				}
				
				ngModel.$formatters.push(toView);
				ngModel.$parsers.push(toModel);
			  }
	}
})

.config( [
    '$compileProvider',
    function( $compileProvider )
    {   
        //$compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|chrome-extension):/);
		$compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|file):/);
        // Angular before v1.2 uses $compileProvider.urlSanitizationWhitelist(...)
    }
])
;