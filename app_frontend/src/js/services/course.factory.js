'use strict';

/*
 * This file is part of the NeosUniversity Software.
 *
 * (c) Neossoftware Corporation
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

 /**
  * Call to course rest services related courses 
  *
 */
app.factory("courseFactory", ["$http", "$q", 'API', function ($http, $q, API) {

    return {

        subscription : function(params) {

            var deferred;
            deferred = $q.defer();
            $http({
                    method: 'POST',
                    skipAuthorization: false,
                    url: API.APIURL + '/api/course/subscription',
                    data: "email=" + params.email + "&courseId=" + params.courseId,
                    headers: {
                        'Content-type': 'application/x-www-form-urlencoded'
                    }
                })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                    deferred.reject(reason);
                });
            return deferred.promise;

        },
      /**Obtiene todas las secciones de un curso  */
        getCourseSections: function(params) {

            var deferred;
            deferred = $q.defer();
            $http({
                    method: 'POST',
                    skipAuthorization: false,
                    url: API.APIURL + '/api/course/allsections',
                    data: "courseId=" + params.courseId,
                    headers: {
                        'Content-type': 'application/x-www-form-urlencoded'
                    }
                })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                    deferred.reject(reason);
                });
            return deferred.promise;

        },

        /**
         * valida si un curso ya ha sido asignado a una persona
         */
        validateSubscription: function(params) {
            var deferred;
            deferred = $q.defer();
            $http({
                    method: 'POST',
                    skipAuthorization: false,
                    url: API.APIURL + '/api/course/validateSubscription',
                    data: "email=" + params.email + "&courseId=" + params.courseId,
                    headers: {
                        'Content-type': 'application/x-www-form-urlencoded'
                    }
                })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                    deferred.reject(reason);
                });
            return deferred.promise;

        },

        /**Obtiene todas las secciones de un curso  de las tablas de trabajo */
        getTwCourseSections: function(params) {

            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/course/alltwsections',
                data: "email=" + params.email + "&courseId=" + params.courseId,
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;

        },
        getTwClass: function(params) {

            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/course/getTwClass',
                data: "classId=" + params.classId + "&controlPanelId=" + params.controlPanelId + "&sectionId=" + params.sectionId,
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;

        },

        saveTwClassComplete: function(params) {

            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/course/saveTwClassComplete',
                data: "classId=" + params.classId + "&controlPanelId=" + params.controlPanelId + "&sectionId=" + params.sectionId,
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;
        },

        getCoursesByUser: function(params) {

            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/course/getCoursesByUser',
                data: "email=" + params.email,
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;
        },

        getCourseById: function(params) {

            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/getcourse',
                data: "courseId=" + params.courseId,
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;
        },

      getTrClass: function(params) {

            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/course/getTrClass',
                data: "classId=" + params.classId + "&sectionId=" + params.sectionId,
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;
        },

        getFilesByClass: function(params) {

            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/course/getFilesByClass',
                data: "sectionId=" + params.sectionId + "&classId=" + params.classId,
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;
        },

        addFileToClass: function(params) {

            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/course/addFileToClass',
                data: "sectionId=" + params.sectionId + "&classId=" + params.classId +"&fileName=" + encodeURIComponent(params.fileName) + "&filePath=" + params.filePath,
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;
        },

        updateFile: function(params) {

            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/course/updateFile',
                data: "id=" + params.id +"&fileName=" + encodeURIComponent(params.fileName) + "&filePath=" + params.filePath,
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;
        },

        /**
         * obtiene las secciones de un curso sin la URL de los videos
         *
         * */
        getTrCourseSections: function(params) {

            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/course/getTrCourseSections',
                data: "courseId=" + params.courseId,
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;
        },
         //add new course
        addNewCourse: function(params) {

            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/course/addNewCourse',
                data: "courseName=" + encodeURIComponent(params.courseName) + "&author=" + encodeURIComponent(params.author)
                + "&isFree="+params.isFree+  "&isOnline="+ params.isOnline +  "&cost="+params.cost + "&imgThumb=" + encodeURIComponent(params.imgThumb)
                + "&img=" + encodeURIComponent(params.img)+ "&shortDesc=" + encodeURIComponent(params.shortDesc)
                + "&description="+encodeURIComponent(params.description),
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;
        },

        getPremierCourses: function() {

            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/getPremierCourses',
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;
        },

        //add new course
        getAllCourses: function() {

            var deferred;
            deferred = $q.defer();
            $http({
                method: 'GET',
                skipAuthorization: false,
                url: API.APIURL + '/api/getcourse',
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;
        },

        //add new course
        updateCourse: function(params) {

            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/course/updateCourse',
                data: "courseName=" + encodeURIComponent(params.courseName) + "&author=" + encodeURIComponent(params.author)
                + "&isFree="+params.isFree+ "&isOnline="+ params.isOnline  + "&cost="+params.cost + "&imgThumb=" + encodeURIComponent(params.imgThumb)
                + "&img=" + encodeURIComponent(params.img)+ "&shortDesc=" + encodeURIComponent(params.shortDesc)
                + "&description="+encodeURIComponent(params.description) + "&id=" + params.id
                + "&urlcourseonline="+encodeURIComponent(params.urlcourseonline),
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;
        },

        saveNewSection: function(params) {

            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/course/saveNewSection',
                data: "sectionName=" + encodeURIComponent(params.sectionName) + "&courseId=" + (params.courseId),
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;
        },

        /**guarda una nueva clase
         * */
        saveNewClass: function (params) {

            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/course/saveNewClass',
                data: "sectionId=" + encodeURIComponent(params.sectionId) + "&videoURL=" + encodeURIComponent(params.videoURL) +
                "&classDescription=" + encodeURIComponent(params.classDescription),
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;


        },

        updateSection : function (params) {


            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/course/updateSection',
                data: "sectionId=" + encodeURIComponent(params.sectionId)  +
                "&description=" + encodeURIComponent(params.description),
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;
        },

        /**
         * Actualiza la clase
         *
         * */
        updateClase : function(params) {
            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/course/updateClase',
                data: "sectionId=" + encodeURIComponent(params.sectionId)  +
                "&classDescription=" + encodeURIComponent(params.classDescription) +
                "&classId=" + encodeURIComponent(params.classId) +
                "&videoURL=" + encodeURIComponent(params.videoURL)
                ,
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;

        },

        /**
         * obtiene los alumnos inscritos en un curso determinado
         * */
        getUsersByCourse: function (params) {

            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/course/getUsersByCourse',
                data: "courseId=" + params.courseId,
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;


        },
    subscriptionPremier: function (params) {

            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/course/subscriptionPremier',
                data: "courseId=" + params.courseId + "&email=" +params.email + "&payIsComplete=" + params.payIsComplete
                    + "&paypalOrderId=" + params.paypalOrderId + "&paypalPaymentId=" + params.paypalPaymentId,
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;


        },
        getTrCourseSectionsPremier: function (params) {

            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/course/getTrCourseSectionsPremier',
                data: "courseId=" + params.courseId,
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;


        },
        /**
         * obtiene los alumnos inscritos en un curso determinado
         * */
        getUserslikemail: function (params) {

            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: false,
                url: API.APIURL + '/api/course/getUserslikemail',
                data: "email=" + params.email,
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                }).catch(function (reason) {
                deferred.reject(reason);
            });
            return deferred.promise;


        }


    };
}]);