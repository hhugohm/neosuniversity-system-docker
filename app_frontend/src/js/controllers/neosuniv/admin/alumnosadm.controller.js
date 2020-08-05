'use strict';


/*
 * This file is part of the NeosUniversity Software.
 *
 * (c) Neossoftware Corporation
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Mario Hidalgo aka neossoftware
 * 2018
 */

app.controller('AlumnosAdmController', ['$scope', 'courseFactory', '$state', 'toaster',
    function ($scope, courseFactory, $state, toaster) {

        //console.log('Alumno Controller');
        $scope.toaster = {
            type: 'success',
            title: 'Nuevo Curso',
            text: ''
        };
        $scope.alumno = {};
        $scope.alumnosremote = [];

        $scope.getDate = function(date) {
            var strDate = moment(date).format('DD/MM/YYYY');
            return strDate;

        };


        $scope.listCourses = function () {
            $scope.getall = courseFactory.getPremierCourses();

            $scope.getall.then(function (res) {
                $scope.courses = res.data;

                $scope.viewListCourses();
            }, function (reason) {
                $scope.toaster.type = 'error';
                toaster.pop($scope.toaster.type, $scope.toaster.title, reason.data.error);
            });
        };

        $scope.showFormInscripcion =  function() {
            $scope.alumno = {};
            $scope.viewInscripcion();
        }

        $scope.showAlumnosByCurso = function(curso) {
            $scope.curso = curso;

            $scope.promiseAlumnos= courseFactory.getUsersByCourse({courseId: curso.id});
            $scope.promiseAlumnos.then(function (res) {
                $scope.alumnos = res.data;
                $scope.viewListAlumnos();
            }, function (reason) {
                $scope.toaster.type = 'error';
                toaster.pop($scope.toaster.type, $scope.toaster.title, reason.data.error);
            });


        }

        $scope.autoCompleteOptions = {
            minimumChars: 2,
            data: function (searchText) {
                return courseFactory.getUserslikemail({email: searchText}).then(function(response) {
                    var users = response.data;
                    $scope.alumnosremote = users;
                    // ideally filtering should be done on the server
                   // var users = _.filter(response.data, function (user) {
                    //    return user.email.startsWith(searchText);
                    //});

                    return _.map(users, 'email');
                });

            },
            itemSelected: function (e) {
                $scope.alumnoSelected = $scope.searchAlumnosRemote(e.item);
            }
        };

        $scope.addAlumno = function(){

            var params = {
                courseId : $scope.curso.id,
                email : $scope.alumno.email,
                payIsComplete: 0,
                paypalOrderId  : '',
                paypalPaymentId: ''
            };

            $scope.addprom = courseFactory.subscriptionPremier(params);

            $scope.addprom.then(function (res) {

                if (res.data.code === 0) {
                    $scope.toaster.type = 'success';
                    toaster.pop($scope.toaster.type, "Sucess!", res.data.message);
                }  else {
                    $scope.toaster.type = 'error';
                    toaster.pop($scope.toaster.type, "Error", res.data.message);
                }


                $scope.showAlumnosByCurso($scope.curso);
            }, function (reason) {
                $scope.toaster.type = 'error';
                toaster.pop($scope.toaster.type, $scope.toaster.title, reason.data.error);
            });
        };

        $scope.searchAlumnosRemote= function(emailSelected) {

            var mail;
            var alumnoSelected;
            for (var i= 0; i<$scope.alumnosremote.length; i++) {
                mail = $scope.alumnosremote[i].email;
                if (emailSelected === mail) {
                    alumnoSelected = $scope.alumnosremote[i];
                    break;
                }
            }
            return alumnoSelected;
        }

        $scope.viewListCourses = function() {
            $scope.showListCourses= true;
            $scope.showListaAlumnos =false;
            $scope.showInscribir = false;
        }

        $scope.viewListAlumnos = function() {
            $scope.showListCourses= false;
            $scope.showListaAlumnos =true;
            $scope.showInscribir = false;
        }

        $scope.viewInscripcion = function() {
            $scope.showListCourses= false;
            $scope.showListaAlumnos =false;
            $scope.showInscribir = true;
        }

        $scope.listCourses();

    }]);
