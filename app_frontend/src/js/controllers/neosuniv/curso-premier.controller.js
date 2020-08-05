/*
 * This file is part of the NeosUniversity Software.
 *
 * (c) Neossoftware Corporation 2018
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

'use strict';

/*
 *  Temario curso premier
 *
 *  @author Mario Hidalgo aka neossoftware
 *
 * */
app.controller('CoursePremieController', ['$scope', 'courseFactory', '$state', '$stateParams', 'toaster', '$ngConfirm', '$sce', '$modal',
    function ($scope, courseFactory, $state, $stateParams, toaster, $ngConfirm,$sce, $modal) {

        $scope.params = {
            courseId: $stateParams.courseId
        };

        $scope.toaster = {
            type: 'success',
            title: 'Nuevo Curso',
            text: ''
        };

        $scope.promcourse = courseFactory.getCourseById($scope.params);
        $scope.promcourse.then(function (response) {
            $scope.curso = response.data;

            if ($scope.curso.id===2){
                //Mostrar mensaje modal
                $modal.open({
                    templateUrl: 'becasneos.html',
                    controller: 'BecaNeosResumenController',
                    size: 'lg',
                    resolve: {
                        items: function () {
                            return $scope.items;
                        }
                    }
                });
            }
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

        $scope.makeid = function() {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for (var i = 0; i < 80; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        }


        $scope.trustSrc = function(src) {
            return $sce.trustAsResourceUrl(src);
        }


        $scope.playLesson = function (clase) {
            //console.log(clase);

            //la clase no esta publica
            if (clase.videourl === '') {
                $scope.toaster.type = 'info';
                $ngConfirm({
                        icon: 'fa fa-warning',
                        title: 'Aviso',
                        type: 'blue',
                        typeAnimated: true,
                        content: 'El video de laclase no se ha publicado, recuerda que el video se publica dos hrs después de haber finalizado el entrenamiento en línea.',
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
                 $state.go('app.playlesson-premier', {courseId: $scope.params.courseId , classId:clase.class_id,
                     sectionId:clase.section_id, description: description, id:id});
            }
        }


//getTrCourseSectionsPremier

    }]);



app.controller('BecaNeosResumenController', ['$scope', '$modalInstance', function($scope, $modalInstance) {


    $scope.ok = function () {
        $modalInstance.close();
    };


}])
;

