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

app.controller('CourseOverviewController', ['$scope', 'courseFactory', '$state','$stateParams', 'toaster', '$modal',
    function ($scope, courseFactory, $state, $stateParams,toaster, $modal) {

        $scope.isFirstOpen = true;
        $scope.isOpen = false;

        $scope.courseId = 'git';

        $scope.userLogged = $scope.$parent.$parent.$parent.userLogged;

        $scope.params = {
            //user logged
            email: $scope.userLogged.mail,
            courseId: $stateParams.courseId,
            description: $stateParams.description
        };


        $scope.courseDetail = courseFactory.getCourseById($scope.params);

        $scope.courseDetail.then(function (res) {
           $scope.course = res.data;
           // console.log($scope.course);

        }, function(error) {

        });


        $scope.twSections = courseFactory.getTrCourseSections($scope.params);
        $scope.twSections.then(function (sections) {
               // console.log(sections.data);
                $scope.sections = sections.data;
            },

            function (error) {
                console.log(error);
            });


        $scope.open = function (size) {
            var modalInstance = $modal.open({
                templateUrl: 'pagoBancomer.html',
                controller: 'ModalBancomerController',
                size: size,
                resolve: {
                    items: function () {
                        return $scope.items;
                    }
                }
            });
        };


        $scope.openBeca = function (size) {
            var modalInstance = $modal.open({
                templateUrl: 'becasneos.html',
                controller: 'BecaNeosController',
                size: size,
                resolve: {
                    items: function () {
                        return $scope.items;
                    }
                }
            });
        }




/*
        $scope.validatecourse = courseFactory.validateSubscription($scope.params);
        $scope.validatecourse.then(function (res) {
                if (res.data.code == 1) {

                    $state.go('app.cursoGitAlumno');
                } else {
                    $scope.showInscription = true;
                }
            },
            function (error) {
                console.log(res);

            });*/




    }]);

app.controller('ModalBancomerController', ['$scope', '$modalInstance', function($scope, $modalInstance) {


    $scope.ok = function () {
        $modalInstance.close();
    };


}])
;


app.controller('BecaNeosController', ['$scope', '$modalInstance', function($scope, $modalInstance) {


    $scope.ok = function () {
        $modalInstance.close();
    };


}])
;
