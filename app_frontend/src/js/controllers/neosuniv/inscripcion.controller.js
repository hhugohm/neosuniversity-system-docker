'use strict';

/* git controller */

  // bootstrap controller
  app.controller('InscripcionController', ['$scope','$state','courseFactory','$stateParams',
                                  function( $scope,  $state,  courseFactory,  $stateParams) {

     //console.log('inscripcion controller');

     $scope.userLogged = $scope.$parent.$parent.$parent.userLogged;
     $scope.isfree = $stateParams.isfree;


     $scope.params = { 
       //user logged
       email : $scope.userLogged.mail,
       courseId: $stateParams.courseId
     };

    $scope.paramsPrem = {
       //user logged
     email : $scope.userLogged.mail,
     courseId: $stateParams.courseId,
     payIsComplete: 0,
     paypalOrderId  : '',
     paypalPaymentId: ''
      };

     if ($scope.isfree ==='1') {
         $scope.service = courseFactory.subscription($scope.params);
     } else {
         $scope.service = courseFactory.subscriptionPremier($scope.paramsPrem);
     }
    

     $scope.service.then(
      // OnSuccess function
      function(res) {
          if($scope.isfree === '1') {
              $state.go('app.cursoGitAlumno');
          } else {
              var id = $scope.makeid();
              $state.go('app.cursopremier', { courseId: $scope.params.courseId, id: id});
          }
        
      } , function(reason) {
        console.log(reason);
      });

         $scope.makeid = function() {
             var text = "";
             var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

             for (var i = 0; i < 80; i++)
                 text += possible.charAt(Math.floor(Math.random() * possible.length));

             return text;
         }



}]);



