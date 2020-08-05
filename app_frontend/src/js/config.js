// config

var app =  
angular.module('app')
  .config(
    [        '$controllerProvider', '$compileProvider', '$filterProvider', '$provide',
    function ($controllerProvider,   $compileProvider,   $filterProvider,   $provide) {
        
        // lazy controller, directive and service
        app.controller = $controllerProvider.register;
        app.directive  = $compileProvider.directive;
        app.filter     = $filterProvider.register;
        app.factory    = $provide.factory;
        app.service    = $provide.service;
        app.constant   = $provide.constant;
        app.value      = $provide.value;
    }
  ])
  .constant('API', { 
    //APIURL: "http://localhost/codeigniter/cijwt",
    //APIURL: "http://192.168.0.30/api/web"
    // APIURL: "http://localhost/api/web/app_dev.php"
    APIURL: "http://localhost:8001"
   })
  .config(['$translateProvider', '$httpProvider', 'jwtInterceptorProvider',
    function($translateProvider, $httpProvider, jwtInterceptorProvider){

      jwtInterceptorProvider.tokenGetter =  function() {
        return localStorage.getItem('token');
      };

      jwtInterceptorProvider.whiteListedDomains= ['localhost'];

    $httpProvider.interceptors.push('jwtInterceptor');
    // Register a loader for the static files
    // So, the module will search missing translation tables under the specified urls.
    // Those urls are [prefix][langKey][suffix].
    $translateProvider.useStaticFilesLoader({
      prefix: 'l10n/',
      suffix: '.js'
    });
    // Tell the module what language to use by default
    $translateProvider.preferredLanguage('en');
    // Tell the module to store the language in the local storage
    $translateProvider.useLocalStorage();
  }]);