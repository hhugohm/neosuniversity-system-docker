/*
 * This file is part of the NeosUniversity Software.
 *
 * (c) Neossoftware Corporation 2018
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

'use strict';

/* git controller */

// bootstrap controller
app.controller('PlayLessonPremierController', ['$scope', '$stateParams', 'courseFactory', '$state', '$sce', '$ngConfirm',
    function ($scope, $stateParams, courseFactory, $state, $sce, $ngConfirm) {

        //console.log("Play lesson premier running");

        $scope.params = {};

        $scope.params.classId = $stateParams.classId;
        $scope.params.sectionId = $stateParams.sectionId;
        $scope.params.courseId = $stateParams.courseId;

        $scope.twClassProm = courseFactory.getTrClass($scope.params);
        $scope.twClassProm.then(function (tw_class) {
               // console.log(tw_class);
                $scope.tw_class = tw_class;
                if ($scope.tw_class.data.files.length !== 0) {
                    $scope.files = $scope.tw_class.data.files;
                    $scope.showListFiles = true;
                } else {
                    $scope.showListFiles = false;
                }

            },
            function (error) {
                console.log(error);
            });


        $scope.promcourse = courseFactory.getCourseById($scope.params);
        $scope.promcourse.then(function (response) {
            $scope.curso = response.data;
            //console.log($scope.curso);

        }, function (error) {
        });

        $scope.promise = courseFactory.getTrCourseSectionsPremier($scope.params);

        $scope.promise.then(function (res) {
            $scope.sections = res.data;
            //console.log(res);

        }, function (error) {
            console.log(error);

        });

        $scope.trustSrc = function (src) {
            return $sce.trustAsResourceUrl(src);
        }

        $scope.makeid = function () {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for (var i = 0; i < 80; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        }


        $scope.playLesson = function (clase) {
            //console.log(clase);

            //la clase no esta publica
            if (clase.videourl === '') {

                $ngConfirm({
                        icon: 'fa fa-warning',
                        title: 'Aviso',
                        type: 'blue',
                        typeAnimated: true,
                        content: 'La clase no se ha publicado, recuerda que las clases se publican dos hrs después del entrenamiento en línea.',
                        buttons: {
                            Aceptar: function () {
                            }
                        }
                    }
                );
                //  toaster.pop($scope.toaster.type, 'Aviso - Curso en Línea', 'La clase no se ha publicado, recuerda que las clases se publican dos hrs despues del entrenamiento en línea.');

            } else {

                var id = $scope.makeid();

                var description = encodeURIComponent(clase.classdescription);
                $state.go('app.playlesson-premier', {
                    courseId: $scope.params.courseId, classId: clase.class_id,
                    sectionId: clase.section_id, description: description, id: id
                });
            }
        }

    }]);