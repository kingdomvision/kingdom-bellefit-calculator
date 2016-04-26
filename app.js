var calApp = angular.module('calculatorApp', ['ngCookies', 'ngSanitize', 'mb-scrollbar'])
// Main Controller
.controller('MainCtrl', ['$scope', '$http', '$cookieStore', function($scope, $http, $cookieStore) {
	
	/* 
		Create Variable / Scope / Objects
	*/
	$scope.date = new Date();
	$scope.regexValid = {
					"email": "/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/",
					"number" : "\\d+"
				};
				
	$scope.cal = {};
	$scope.full_step = false;
	$scope.goBack = '';
	
	var cal = {};
	var cookie_name = "calculate";
	
	if( $cookieStore.get(cookie_name) != null ) {
		cal = $cookieStore.get(cookie_name);
	}
	
	cal.uniqid = numGenerated();
	$scope.cal = cal;
	$scope.stepsInfo = [
						'Childbirth &amp; Delivery Method',
						'Your Weight',
						'Body Shape',
						'Your Size'
					   ];
	
/* ****************************************** */
	
	/* 
		Create Functions
	*/
	function numGenerated() {
		var number = Math.random() 
		number.toString(36);
		var id = number.toString(36).substr(2, 10);
		return id;
	}
	
	var newObject = function(data) {
		var uniqid = numGenerated();
		var obj = [];
		obj[uniqid] = data;
		return obj;
	}
	
	$scope.sumTotal = function(value1, value2) {
		return parseInt((value1 + value2));
	}
	
	$scope.subTotal = function(value1, value2) {
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
	
	$scope.loop_number = function(start, end, format){
		var i = parseInt(start);
		var total = parseInt(end);
		var values = Array();
		for(i; i <= total; i++) {
			if(format == 'range') {
				var val = i + '-' + (i+1);
			}
			else {
				i -= (0.5);
				var val = i.toFixed(1);
			}
				
			values.push(val);
		}
		return values;
	}
	
	$scope.getImage = function(image) {
		return calUrl + '/images/' + image;
	}
	
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
	
	$scope.cal_remain_weight_gain = function(data){
		data.pregnancy_gained = $scope.subTotal(data._2_heaviest_weight, data._2_pregnancy_weight);
		data.after_childbirth = $scope.subTotal(data._2_heaviest_weight, data._2_weight_now);
		data.remain_weight = $scope.subTotal(data.pregnancy_gained, data.after_childbirth);
		
    };
	
	$scope.cal_weight_gain_pregnant = function(data){
		data.weight_gain_pregnant = $scope.subTotal(data.weight_now_no, data.pregnancy_weight_no);
    };
	
	$scope.cal_givebirth = function(data){
		 return $scope.cal = {uniqid: data.uniqid, give_birth: data.give_birth}
    };
	
/* ****************************************** */
	
	/* 
		Create Filters
	*/
	
	$scope.daysInMonth = function(m, y) {
		switch (m) {
			case 1 :
				return function(data){
					var curYear = $scope.date.getUTCFullYear();
					y = (y == null) ? curYear : y;
					var feb = (y % 4 == 0 && y % 100) || y % 400 == 0 ? 29 : 28;
					if (data <= feb) return true;
				}
			case 8 : case 3 : case 5 : case 10 :
				return function(data){
					if (data <= 30) return true;
				}
			default :
				return function(data){
					if (data <= 31) return true;
				}
		}
	}
	
	$scope.dropSelect = function(data, key) {
		$scope.cal[key] = data;
	};
	
	$scope.greaterThan = function(val){
		return function(data){
			if (data > val) return true;
		}
	}
	
	$scope.lessThan = function(val){
		return function(data){
			if (data < val) return true;
		}
	}
	
/* ****************************************** */

	/* 
		Create Conditions
	*/
	
	$scope.isSteps = function(steps, data){
		var step = false;
		if( steps == 'step2_a' && (data.how_many_week > 35 || data.postpartum_swelling) ) {
			step = true;
		}
		else if( steps == 'step2_b' ) {
			if( data.how_many_week == 'under 20' || data.how_many_week < 36 ) 
				if( (data.week_email != null && data.measure_week == 'Yes') || data.measure_week == 'No' )
					step = true;
		}
		else if( steps == 'step2' && ( $scope.isSteps('step2_a', data) || $scope.isSteps('step2_b', data) ) ) {
			step = true;
		}
		else if( steps == 'step3' && ( $scope.isSteps('step2_b', data) || ((data.weight_gain_pregnant > 0) || (data.pregnancy_gained > data.after_childbirth && data.pregnancy_gained > data.remain_weight)) ) ) {
			step = true;
		}
		else if( steps == 'step4' && (data.tall_are_you != null && data.carry_your_weight != null && data.body_shapes != null) ) {
			step = true;
		}
		else if( steps == 'step5' && (data.pregnancy_jean_size != null) && ( (data.your_hip_contour == 'Yes' && data.measuring_inches != null) || (data.your_hip_contour == 'No') ) ) {
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
	
/* ****************************************** */
	
	
	$scope.getData = function(id){
		var data = {};
		data.id = id;
		console.log(data);
		
		$http.post(calUrl +'/includes/request.php', data).
		success(function(res, status, headers, config) {
			
			console.log(res);
			if(res.status == 'success')
				$scope.cal = res.cookie;
				
		}).
		error(function(res, status, headers, config) {
			$scope.returnMsg = 'Data send error.';
		});
	};
	
	$scope.dataSubmit = function(data){
		console.log(data);
		data.model = 'step';
		
		// Put cookies
		$cookieStore.put(cookie_name, data);
		// Get cookie
		var calculateCookie = $cookieStore.get(cookie_name);
  
		$http.post(calUrl +'/includes/recommendation.php', data).
		success(function(res, status, headers, config) {
			
			$scope.rec_size = res.size;
			$scope.rec_styles = angular.fromJson(res.style);
			$scope.rec_bundles = angular.fromJson(res.bundle);
		}).
		error(function(res, status, headers, config) {
			$scope.returnMsg = 'Data send error.';
		});
	};
	
	$scope.resultSubmit = function(data){
		console.log(data);
		$http.post(calUrl +'/includes/email_results.php', data).
		success(function(res, status, headers, config) {
			if( res.status = 'success' ) {
				console.log(res);
				$scope.res_result = res;
			}
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
			if( res.status = 'success' ) {
				console.log(res);
				$scope.res_save = res.status;
			}
		}).
		error(function(res, status, headers, config) {
			$scope.returnMsg = 'Data send error.';
		});
	};
}])

/* 
	Create Directive
*/
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
});