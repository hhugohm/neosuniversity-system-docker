'use strict';

/* Controllers */
  // signin controller
  app.controller('SigninFormController', ['$scope', '$http', '$state', 'API','jwtHelper', 'store', 'authFactory',
    function($scope,   $http,   $state,   API,  jwtHelper,   store ,  authFactory) {
      $scope.user = {};
      $scope.loading = false;
      $scope.authError = null;

      store.remove('token');
      //console.log("Token was removed");

      $scope.alerts = [
    //{ type: 'danger', msg: 'Oh snap! Change a few things up and try submitting again.' },
    //{ type: 'success', msg: 'Well done! You successfully read this important alert message.' }
    ];

    $scope.login = function() {

      $scope.loading = true;

      $scope.alerts = []; //empty alerts  
      $scope.authError = null;

      $scope.service= authFactory.login($scope.user);

      $scope.service.then(
        // OnSuccess function
        function(res) {
         
         if (res.data && res.data.code==0) {
           var token = res.data.response.token
           store.set('token', token );
           var tokendecoded = jwtHelper.decodeToken(token);
           
             $scope.$parent.$parent.$parent.userLogged = {
                   mail : tokendecoded.mail,
                   name : tokendecoded.name,
                    rol: tokendecoded.rol
              };            
           $state.go('app.dashboard-v1');
         } else if (res.data && res.data.code==1) {
           $scope.alerts.push({msg: res.data.message});
         } else {
          $scope.alerts.push({msg: 'Error de comunicación con el servidor'});
        }
      },
        // OnFailure function
        function(reason) {
          $scope.alerts.push({msg: 'Error de comunicación con el servidor'});
          
        }
        ).finally(function() {
         
          
        //console.log('This finally block');
        // $scope.loading = false;
      });
/*
      $http({
         method: 'POST',
         skipAuthorization: true,
         url: API.APIURL + '/app_dev.php/api/login',   
         data: "email=" + $scope.user.email + "&password="+ $scope.user.password,
         headers: {'Content-type':'application/x-www-form-urlencoded'}
      }) .then (function (res) {
         $scope.loading = false;
            if (res.data && res.data.code==0) {
                 store.set('token', res.data.response.token);
                 $state.go('app.dashboard-v1');
            } else if (res.data && res.data.code==1) {
                   $scope.alerts.push({msg: res.data.message});
            } else {
              $scope.alerts.push({msg: 'Error de comunicación con el servidor'});
            }
      }, function (x) { 
         
         $scope.alerts.push({msg: 'Error de comunicación con el servidor'});
          
      }).finally(function() {
 $scope.loading = false;
        

        //console.log('This finally block');
        // $scope.loading = false;
      }); */
      
    };


    $scope.closeAlert = function(index) {
      $scope.alerts.splice(index, 1);
    };

  }])
  ;
