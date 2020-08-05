'use strict';

/* git controller */

// bootstrap controller
app.controller('MisCursosController', ['$scope','$state','courseFactory','$sce',
    function( $scope,  $state,  courseFactory, $sce) {

        $scope.userLogged = $scope.$parent.$parent.$parent.userLogged;

        $scope.alerts = [];

        $scope.params = {
            //user logged
            email : $scope.userLogged.mail
        };

        $scope.service= courseFactory.getCoursesByUser($scope.params);


        $scope.service.then(
            // OnSuccess function
            function(res) {
             $scope.courses = res.data;

                //no se tienen cursos asignados
                if (res.data.length ===0) {
                    var msg ='No tienes cursos asignados verifica los cursos ' +
                        'que tenemos disponibles:  <br> <br> <a href="#/app/courses"><button class="btn btn-info"> Cursos disponibles</button></a>';

                        msg = $sce.trustAsHtml(msg);
                    $scope.alerts.push({type:'warning', msg:msg});
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


        $scope.detalle = function(courseId, description) {

            $scope.userLogged = $scope.$parent.$parent.$parent.userLogged;

            $scope.params = {
                //user logged
                email: $scope.userLogged.mail,
                courseId: courseId,
            };

            $scope.validatecourse = courseFactory.validateSubscription($scope.params);

            $scope.validatecourse.then(function (res) {
                //si esta inscrito al curso
                    if (res.data.code == 1) {
                        $scope.courseProm = courseFactory.getCourseById($scope.params);
                        $scope.courseProm.then(function (response) {

                            if (response.data.isfree === 1) {
                                $state.go('app.cursoGitAlumno');
                            } else {
                                var id = $scope.makeid();
                                $state.go('app.cursopremier', { courseId: courseId, id: id});
                            }

                          //  console.log(response);
                        }, function (error){
                            console.log(error);
                        });

                        // redirect state
                     //
                   // } else {
                   //     $state.go('app.course-overview', { courseId: courseId , description: description});
                    }
                },
                function (error) {
                    console.log(error);
                });



        }



    }]);

