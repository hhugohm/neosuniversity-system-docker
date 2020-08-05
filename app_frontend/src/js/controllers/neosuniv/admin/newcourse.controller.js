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

app.controller('NewCourseController', ['$scope', 'courseFactory', '$state', 'toaster',
    function ($scope, courseFactory, $state, toaster) {


        $scope.viewList = function () {
            $scope.showList = true;
            $scope.showAlta = false;
            $scope.showModificacion = false;
        };

        $scope.viewAlta = function () {
            $scope.showList = false;
            $scope.showAlta = true;
            $scope.showModificacion = false;
        };

        $scope.viewModif = function () {
            $scope.showList = false;
            $scope.showAlta = false;
            $scope.showModificacion = true;
        };

        $scope.toaster = {
            type: 'success',
            title: 'Nuevo Curso',
            text: ''
        };

        $scope.authors = [
            {authorId: "1", name: "Mario Hidalgo"},
            {authorId: "2", name: "Hugo Hidalgo"},

        ];

        $scope.courseUp = {
            courseName: null,
            author: null,
            isFree: null,
            isOnline: null,
            urlcourseonline:null,
            cost: 0.00,
            imgThumb: null,
            img: null,
            shortDesc: null,
            description: null,
            id: null
        };

        $scope.newcourse = {
            courseName: null,
            author: "1",
            isFree: '1',
            isOnline: '0',
            cost: 0.00,
            imgThumb: null,
            img: null,
            shortDesc: null,
            description: null
        };

        $scope.showUpdate = function (curso) {


            courseFactory.getCourseById({courseId: curso.id}).then(function(res)  {
                $scope.courseSrv = res.data;
                $scope.courseUp.courseName =$scope.courseSrv.coursename;
                $scope.courseUp.author =$scope.courseSrv.author.id.toString();
                $scope.courseUp.description = $scope.courseSrv.coursedesc;
                $scope.courseUp.isFree = $scope.courseSrv.isfree.toString();
                $scope.courseUp.isOnline = $scope.courseSrv.is_online.toString();
                $scope.courseUp.cost = $scope.courseSrv.cost;
                $scope.courseUp.imgThumb = $scope.courseSrv.imgthumb;
                $scope.courseUp.img =  $scope.courseSrv.imgcourse;
                $scope.courseUp.shortDesc = $scope.courseSrv.shortdesc;
                $scope.courseUp.id = $scope.courseSrv.id;
                $scope.courseUp.urlcourseonline = $scope.courseSrv.url_course_online;

                //console.log($scope.courseSrv);
                $scope.viewModif();
            }, function( reason) {
                $scope.toaster.type = 'error';
                toaster.pop($scope.toaster.type, $scope.toaster.title, reason.data.error);
            });
        };

        $scope.listCourses = function () {
            $scope.getall = courseFactory.getAllCourses();

            $scope.getall.then(function (res) {
                $scope.courses = res.data;
            }, function (reason) {
                $scope.toaster.type = 'error';
                toaster.pop($scope.toaster.type, $scope.toaster.title, reason.data.error);
            });
        };

        /**
         * actualiza un curso
         *
         * @param form
         * @returns {boolean}
         */
        $scope.updateCourse = function (form) {
            if (form.$invalid) {
                return false;
            }

            courseFactory.updateCourse($scope.courseUp).then(function(res) {

                $scope.toaster.text = res.data.message;
                if (res.data.code !== 0) {
                    $scope.toaster.type = 'error';
                    toaster.pop($scope.toaster.type, $scope.toaster.title, $scope.toaster.text);
                } else {
                    $scope.toaster.type = 'success';
                    toaster.pop($scope.toaster.type, $scope.toaster.title, $scope.toaster.text);

                    //show list of courses
                    $scope.listCourses();
                    $scope.viewList();

                }

            }, function(reason) {

                $scope.toaster.type = 'error';
                toaster.pop($scope.toaster.type, $scope.toaster.title, reason.data.error);

            });
            
        };


        $scope.saveNewCourse = function (form) {
            if (form.$invalid) {
                return false;
            }
            $scope.service = courseFactory.addNewCourse($scope.newcourse);

            $scope.service.then(
                // OnSuccess function
                function (res) {
                    $scope.toaster.text = res.data.message;
                    if (res.data.code !== 0) {
                        $scope.toaster.type = 'error';
                        toaster.pop($scope.toaster.type, $scope.toaster.title, $scope.toaster.text);
                    } else {
                        $scope.toaster.type = 'success';
                        toaster.pop($scope.toaster.type, $scope.toaster.title, $scope.toaster.text);

                        //show list of courses
                        $scope.listCourses();
                        $scope.viewList();

                    }
                },
                // OnFailure function
                function (reason) {
                    $scope.toaster.type = 'error';
                    toaster.pop($scope.toaster.type, $scope.toaster.title, reason.data.error);
                }
            );
        };

        /**
         * muestra temario del curso seleccionado
         * */
        $scope.showTemario = function(curso) {
            $state.go("app.adminsections", {courseId: curso.id, courseName: encodeURIComponent(curso.coursename)});
        };

        $scope.viewList();
        $scope.listCourses();


    }]);