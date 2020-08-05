'use strict';

/* Login Service */
// signin controller
app.factory("authFactory", ["$http", "$q", 'API', function ($http, $q, API) {
    return {
        login: function (user) {
            var deferred;
            deferred = $q.defer();
            $http({
                    method: 'POST',
                    skipAuthorization: true,
                    url: API.APIURL + '/api/login',
                    data: "email=" + user.email + "&password=" + user.password,
                    headers: {
                        'Content-type': 'application/x-www-form-urlencoded'
                    }
                })
                .then(function (res) {
                    deferred.resolve(res);
                })
                .then(function (error) {
                    deferred.reject(error);
                })
            return deferred.promise;
        },
        signup: function (user) {
            var deferred;
            deferred = $q.defer();
            $http({
                    method: 'POST',
                    skipAuthorization: true,
                    url: API.APIURL + '/api/signup',
                    data: "email=" + user.email + "&password=" + user.password + "&name=" + user.name,
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
        requestResetPwd: function (user) {
            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: true,
                url: API.APIURL + '/api/requestResetPwd',
                data: "email=" + user.email ,
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
        changePassword: function (user) {
            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: true,
                url: API.APIURL + '/api/changePassword',
                data: "email=" + user.email + "&password=" + user.password + "&hash=" + user.hash,
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
        validateUrl: function (user) {
            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: true,
                url: API.APIURL + '/api/validateUrl',
                data: "email=" + user.email + "&password=" + user.password + "&hash=" + user.hash,
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
    }
}])