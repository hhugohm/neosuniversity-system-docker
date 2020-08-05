'use strict';

// signup controller
app.controller('SignupFormController', ['$scope', 'authFactory', '$state', function($scope, authFactory, $state) {
	$scope.user = {};

	$scope.alerts = [];
	$scope.signup = function(form) {

		$scope.alerts = [];


  if (!form.$invalid) {
	  //gets the promise
	  $scope.service = authFactory.signup($scope.user);

	  $scope.service.then(
		  // OnSuccess function
		  function (res) {

			  if (res.data && res.data.code == 0) {
				  $state.go("access.success-signup");

			  } else if (res.data && res.data.code == 1) {
				  $scope.alerts.push({msg: res.data.message});
			  } else {
				  $scope.alerts.push({msg: 'Error de comunicación con el servidor'});
			  }
		  },
		  // OnFailure function
		  function (reason) {
			  $scope.alerts.push({msg: 'Error de comunicación con el servidor'});
		  }
	  ).catch(function (reason) {

		  $scope.alerts.push({msg: 'Error de comunicación con el servidor'});

	  });

  }


    };
}])
;