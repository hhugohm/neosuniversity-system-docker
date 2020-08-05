angular.module('app')
    .directive('loading',   ['$http' ,function ($http)
    {
        //http://www.nasa.gov/multimedia/videogallery/ajax-loader.gif
        return {
            restrict: 'A',
            template: '<div class="loading-spiner"><div class="fa-3x"><span class="fa fa-spinner fa-spin" style="color:#23b7e5"></span></div>',
            link: function (scope, elm, attrs)
            {
                scope.isLoading = function () {
                    return $http.pendingRequests.length > 0;
                };

                scope.$watch(scope.isLoading, function (v)
                {
                    if(v){
                        elm.show();
                    }else{
                        elm.hide();
                    }
                });
            }
        };
    }])