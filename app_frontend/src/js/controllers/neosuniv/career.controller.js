/*
 * This file is part of the NeosUniversity Software.
 *
 * (c) Neossoftware Corporation 2018
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * Lista de cursos
 *  @author Mario Hidalgo aka neossoftware
 *
 * */
'use strict';

app.controller('CareerController', ['$scope', 'courseFactory', '$state',
    function ($scope, courseFactory, $state) {


        /*
         * Verifica que el alumno este inscrito en el curso, si es asi muestra el detalle
         * del curso
         * */
        $scope.detalle = function (idCurso,description) {

            $scope.userLogged = $scope.$parent.$parent.$parent.userLogged;

            $scope.params = {
                //user logged
                email: $scope.userLogged.mail,
                courseId: idCurso
            };

            $scope.validatecourse = courseFactory.validateSubscription($scope.params);

            $scope.validatecourse.then(function (res) {
                    if (res.data.code === 1) {
                        // redirect state
                        $scope.courseDetail = courseFactory.getCourseById($scope.params);
                        $scope.courseDetail.then(function (respuesta) {
                            //console.log(respuesta);
                            $scope.curso = respuesta.data;
                            if ($scope.curso.isfree ===  0) {
                                //premium
                                var id = $scope.makeid();
                                $state.go('app.cursopremier', { courseId: $scope.params.courseId, id: id});
                            } else {
                                $state.go('app.cursoGitAlumno'); // TODO falta esto dejarlo generico
                            }


                        }, function (err){
                            console.log(err);
                        });





                    } else {
                        $state.go('app.course-overview', { courseId: idCurso , description: description});
                    }
                },
                function (error) {
                    console.log(error);
                });


        };


        $scope.makeid = function() {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for (var i = 0; i < 80; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        }




    }]);


app.directive('labelColor', function () {
    return function (scope, $el, attrs) {
        $el.css({'color': attrs.color});
    }
});
