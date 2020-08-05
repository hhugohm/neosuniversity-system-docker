Teoria JWT
Json Web Token es un conjunto de medios de seguridad para peticiones http y así representar demandas para ser transferidos entre dos partes (cliente y servidor). Las partes de un JWT se codifican como un objeto JSON que está firmado digitalmente utilizando JSON Web Signature( JWS ).

Existen distintas librerías en cada uno de los lenguajes de programación para codificar y decodificar Json Web Token de forma muy sencilla.

Para crear un token necesitamos tres cosas, imaginemos que tenemos un login de usuarios, pues la primera cosa serían los datos del usuario una vez ha hecho login, es decir, el user_id y el username, por ejemplo, la segunda debe ser una clave secreta que haga de salt, y la tercera el tipo de encriptación que por defecto suele ser HS256, HS384 o HS512.

¿Por qué utilizar Json Web Token?
Hoy en día muchas aplicaciones consumen servicios rest y están alojadas en distintos dominios con lo cuál no podemos trabajar con sesiones ya que se almacenan en este.

Podemos decir que la mejor alternativa es llevar a cabo la autenticación haciendo uso de tokens que vayan del servidor al cliente, un usuario hace login (no necesita enviar token porque no lo tiene), una vez el servidor de ok retorna un token cómo respuesta y el usuario debe enviar dicho token en las siguientes peticiones para poder acceder a los recursos del servicio.

En cada petición el servidor debe comprobar el token proporcionado por el usuario y si es correcto podrá acceder a los recursos solicitados, de otra forma deberá denegar la petición.

En angularjs tenemos un módulo para decodificar Json Web Token en el lado del cliente (sólo el payload).

Ejemplo de JWT con php
Así que nosotros podríamos generar un token de la siguiente forma, para ello primero descarga la clase para php desde aquí.

PHP

1
2
3
4
5
6
7
8
9
$key = 'mi-secret-key';
$token = array(
        "id" => "1",
    "name" => "unodepiera",
    "iat" => 1356999524,
    "nbf" => 1357000000
);
 
$jwt = JWT::encode($token, $key, 'HS256');

La clave iat es un identificador opcional que permite saber en que momento fue emitido el token.

La clave nbf es un identificador también opcional que permite saber hasta cuando se pueden hacer peticiones con ese token.
Ambos son campos de tipo NumericDate (1357000000) y un standar de Json Web Token.

Aquí tienes más información sobre los standards de Json Web Token.

Como resultado conseguiremos una cadena que contiene 3 trozos separados por un punto cada uno de ellos y codificada en base64.

PHP

1
eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLm9yZyIsImF1ZCI6Imh0dHA6XC9cL2V4YW1wbGUuY29tIiwiaWF0IjoxMzU2OTk5NTI0LCJuYmYiOjEzNTcwMDAwMDB9.zbam7fZ8ym4mExBxqVKX4EkmPnPIIjQLmGPU3WBNKucstdClass 

Json Web Token tiene un método decode para llevar a cabo la función de obtener únicamente el llamado payload, es decir, la información a desencriptar.
Para desencriptar un token necesitamos dos cosas, el token y la clave de encriptación que hemos utilizado para encriptarlo.

PHP

1
2
3
$jwt = JWT::encode($token, $key);
$decoded = JWT::decode($jwt, $key);
print_r($decoded);

Y la salida será la siguiente.
PHP

1
Object ( [id] => 1 [name] => unodepiera [iat] => 1356999524 [nbf] => 1357000000 )

Cómo puedes ver hemos desencriptado el token, pero la única información obtenida es la propia del usuario (payload).



Practica
El codigo se encuentra en 
https://github.com/uno-de-piera/jwt-angularjs-codeigniter


En esta entrada vamos a ver cómo podemos crear un sistema de autenticación utilizando Json Web Token (JWT), el cliente lo haremos con angularjs y el servidor con codeigniter, pero es simple implementarlo con nodejs, laravel, ruby o python.

En el tutorial anterior ya vimos que es JWT y lo útil que puede ser en nuestras aplicaciones cuando consumimos servicios rest y necesitamos mantener de alguna forma las sesiones en el lado del cliente, por ejemplo, en angularjs.

Entonces tendremos lo siguiente:

Un formulario de login para iniciar sesión.
Una vez haga login si las credenciales son correctas crearemos un token con JWT y le daremos 5 minutos de vida.
El token lo devolveremos al cliente (angularjs) y utilizando el módulo angular-jwt podremos decodificar su payload.
Una vez en el cliente y utilizando el módulo angular-storage guardaremos en localStorage el token proporcionado por el servidor para enviarlo en futuras peticiones.
A través del provider jwtInterceptorProvider haremos que de forma automática nuestro token sea envíado en cada petición a través de los headers con un nombre y un prefijo para así capturarlo en el servidor, esto lo podremos hacer de forma dinámica cómo veremos más adelante.
Gracias al método run y al evento $routeChangeStart podremos comprobar si nuestro token ha expirado, y si es así mandaremos al usuario fuera de la aplicación.
Una vez el usuario esté dentro de la aplicación tendremos un botón para hacer una petición al servidor, recoger allí el token, comprobar si el usuario existe y si es así devolver un JSON con una tabla de películas que creareamos.
Cómo puedes ver tenemos trabajo, pero la idea es coger muchos conceptos y verlos en práctica ya que es la mejor forma de entender cómo funcionan las cosas.

JWT en el servidor
Lo primero que tenemos que hacer es crear nuestro proyecto php, utiliza el framework que quieras, yo lo haré con codeigniter, descargar el archivo JWT.php, guardalo en la carpeta helpers y cargalo en el autoload, así lo tendremos disponible, haz lo mismo con la base de datos.

Aquí tienes la base de datos que vamos a utilizar.

Descargar base de datos

Simplemente tiene dos tablas, accounts y movies.

Ahora crea un nuevo controlador llamado auth.php y dentro añade el siguiente código.

PHP

1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
27
28
29
30
31
32
33
34
35
36
37
38
39
40
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Auth extends CI_Controller
{
    public function login()
    {
        if($this->input->is_ajax_request())
        {
            if(!$this->input->post("email") || !$this->input->post("password"))
            {
                echo json_encode(array("code" => 1, "response" => "Datos insuficientes"));
            }
            $email = $this->input->post("email");
            $password = sha1($this->input->post("password"));
            $this->load->model("auth_model");
            $user = $this->auth_model->login($email, $password);
            if($user !== false)
            {
                //ha hecho login
                $user->iat = time();
                $user->exp = time() + 300;
                $jwt = JWT::encode($user, '');
                echo json_encode(
                    array(
                        "code" => 0,
                        "response" => array(
                            "token" => $jwt
                        )
                    )
                );
            }
        }
    }
    else
    {
        show_404();
    }
}
/* End of file auth.php */
/* Location: ./application/controllers/auth.php */

Simplemente hacemos login al usuario, si los datos enviados desde el formulario son correctos entonces debemos crear el token con JWT, y lo más importante de esto es ver cómo añadimos las propiedades iat (time() en el que se creo el token) y exp (time() cuando expira el token), en este caso 5 minutos.
Estas dos propiedades aparte de muchas otras son standard en JWT, por ende el módulo que vamos a utilizar en angularjs tiene un método que comprueba si el token ha expirado, y justamente necesita esta propiedad.

JWT en el cliente con AngularJS
Lo primero que debemos hacer es instalar algunos módulos con bower.

AngularJS:

Shell

1
bower install angular

NgRoute:
Shell

1
bower install angular-route

Para mantener el token con localStorage:
Shell

1
bower install a0-angular-storage

JWT en AngularJS:
Shell

1
bower install angular-jwt

Bootstrap:
Shell

1
bower install bootstrap

Ahora que ya tenemos todo lo necesario podemos crear el directorio statics y dentro guardamos el siguiente archivo obtenido de bootsnipp.
Descargar style.css

Ya tenemos la base de ambos proyectos, crear un archivo index.html y añade el siguiente código típico de cualquier aplicación hecha con angularjs.

XHTML

1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
<!DOCTYPE html>
<html ng-app="app">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>AngularJS con JWT</title>
  <link rel="stylesheet" type="text/css" href="./bower_components/bootstrap/dist/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="./statics/styles.css">
  <script type='text/javascript' src="./bower_components/angular/angular.js"></script>
  <script type='text/javascript' src="./bower_components/angular-route/angular-route.js"></script>
  <script type="text/javascript" src="./bower_components/angular-jwt/dist/angular-jwt.js"></script>
  <script type="text/javascript" src="./bower_components/a0-angular-storage/dist/angular-storage.js"></script>
  <!--archivo app.js, donde hemos definido nuestro modulo app-->
  <script type='text/javascript' src="app.js"></script>
</head>
    <body>
        <div class="container">
            <div ng-view></div>
        </div>
    </body>
</html>

Ahora debemos crear el formulario de login, para ello crea un directorio llamado templates y dentro un archivo llamado login.html, a continuación añade el siguiente código.
XHTML

1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="form-wrap">
                <h1>Log in with your email account</h1>
                    <form role="form" name="loginForm" id="login-form" ng-submit="login(user)" autocomplete="off">
                        <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" ng-model="user.email" id="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="key" class="sr-only">Password</label>
                            <input type="password" ng-model="user.password" name="password" id="password" class="form-control">
                        </div>
                        <input type="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Log in">
                    </form>
                    <hr>
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

Por fin llegamos a lo que nos interesa, angularjs, crea tu archivo app.js y añade el siguiente código.
JavaScript

1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
var app = angular.module("app", ['ngRoute', 'angular-jwt', 'angular-storage']);
 
app.constant('CONFIG', {
    APIURL: "http://localhost/codeigniter/cijwt",
})
.config(["$routeProvider", "$httpProvider",  function ($routeProvider, $httpProvider) 
{
    $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
    
    $routeProvider.when('/', {
        redirectTo: "/home"
    })
    .when("/home", {
        templateUrl: 'templates/home.html',
        controller: 'homeCtrl'
    })
    .when("/login", {
        templateUrl: 'templates/login.html',
        controller: 'loginCtrl'
    })
}])

De momento sólo creamos nuestro módulo app e inyectamos los módulos ngRoute, angular-jwt y angular-storage, establecemos una constante y las rutas de nuestra aplicación, ahora necesitamos definir nuestro controlador loginCtrl, así que añade el siguiente código a continuación.
JavaScript

1
2
3
4
5
6
7
8
9
10
11
12
13
14
.controller('loginCtrl', ['$scope','CONFIG', 'authFactory', 'jwtHelper', 'store', '$location', function($scope, CONFIG, authFactory, jwtHelper, store, $location)
{
    $scope.login = function(user)
    {
        authFactory.login(user).then(function(res)
        {
            if(res.data && res.data.code == 0)
            {
                store.set('token', res.data.response.token);
                $location.path("/home");
            }
        });
    }
}])

Simple, hacemos una petición a la factoría authFactory y comprobamos el resultado, si todo va bien guardamos el token en localStorage y redirigimos a la home, ahora añade el siguiente código a continuación para crear dicha factoría.
JavaScript

1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
.factory("authFactory", ["$http", "$q", "CONFIG", function($http, $q, CONFIG)
{
    return {
        login: function(user)
        {
            var deferred;
            deferred = $q.defer();
            $http({
                method: 'POST',
                skipAuthorization: true,//no queremos enviar el token en esta petición
                url: CONFIG.APIURL+'/auth/login',
                data: "email=" + user.email + "&password=" + user.password,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function(res)
            {
                deferred.resolve(res);
            })
            .then(function(error)
            {
                deferred.reject(error);
            })
            return deferred.promise;
        }
    }
}])

Hacemos la petición post con los datos del formulario (hay que mejorarlo, no es bueno enviar las contraseñas en texto plano) al método login del controlador auth que hemos creado con codeigniter y devolvemos una promesa.
Antes de comprobar si esto funciona debemos crear el controlador home y la template home.html, así que primero crea el controlador a continuación del controlador loginCtrl.

JavaScript

1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
.controller('homeCtrl', ['$scope','CONFIG', 'jwtHelper', 'store', 'moviesFactory', function($scope, CONFIG, jwtHelper, store, moviesFactory)
{
    //obtenemos el token en localStorage
    var token = store.get("token");
    //decodificamos para obtener los datos del user
    var tokenPayload = jwtHelper.decodeToken(token);
    //los mandamos a la vista como user
    $scope.user = tokenPayload;
    $scope.getMovies = function()
    {
        moviesFactory.get().then(function(res)
        {
            if(res.data && res.data.code == 0)
            {
                store.set('token', res.data.response.token);
                $scope.movies = res.data.response.movies;
            }
        });
    }
}])

Aquí ya vemos cosas más interesantes, obtenemos el token, cogemos la información perteneciente al usuario y la pasamos a la vista como user, a continuación hacemos una petición a la factoría movies para obtener todas las películas, así que vamos a crear dicha factoría.
JavaScript

1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
.factory("moviesFactory", ["$http", "$q", "CONFIG", function($http, $q, CONFIG)
{
    return{
        get: function()
        {
            var deferred;
            deferred = $q.defer();
            $http({
                method: 'GET',
                skipAuthorization: false,//es necesario enviar el token
                url: CONFIG.APIURL+'/movies'
            })
            .then(function(res)
            {
                deferred.resolve(res);
            })
            .then(function(error)
            {
                deferred.reject(error);
            })
            return deferred.promise;
        }
    }
}])


Cómo puedes ver, aquí decimos que sí es necesario enviar el token con la propiedad skipAuthorization a false, el resto es igual que antes.
Ahora es momento de crear la template home.html dentro de templates, que será donde podamos visualizar las películas obtenidas y la información del usuario.

XHTML

1
2
3
4
5
6
7
8
9
10
11
12
<div class="row">
    <div class="alert alert-info">User: {{user}}</div>
    <button ng-click="getMovies()" class="btn btn-info btn-large">Get movies</button>
 
    <div class="panel panel-default" ng-repeat="movie in movies">
        <div class="panel-heading">
            <h3 class="panel-title"><b>Título</b>: {{movie.name}}</h3>
        </div>
        <div class="panel-body"><b>Director</b>: {{movie.author}}</div>
        <div class="panel-footer"><b>Fecha de estreno</b>{{movie.created_at}}</div>
    </div>
</div>

Cómo ya habíamos dicho, en cada petición queremos enviar el token a través de los headers, para ello podemos utilizar en la configuración de nuestro módulo en provider jwtInterceptorProvider, así que deja tu sección config de la siguiente forma.
JavaScript

1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
.config(["$routeProvider", "$httpProvider", "jwtInterceptorProvider",  function ($routeProvider, $httpProvider, jwtInterceptorProvider) 
{
    $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
    
    //en cada petición enviamos el token a través de los headers con el nombre Authorization
    jwtInterceptorProvider.tokenGetter = function() {
        return localStorage.getItem('token');
    };
    $httpProvider.interceptors.push('jwtInterceptor');
 
    $routeProvider.when('/', {
        redirectTo: "/home"
    })
    .when("/home", {
        templateUrl: 'templates/home.html',
        controller: 'homeCtrl',
        authorization: true
    })
    .when("/login", {
        templateUrl: 'templates/login.html',
        controller: 'loginCtrl',
        authorization: false
    })
}])

Ahora sólo nos queda crear el método run de nuestro módulo de la siguiente forma.
JavaScript

1
2
3
4
5
6
7
8
9
10
11
12
13
.run(["$rootScope", 'jwtHelper', 'store', '$location', function($rootScope, jwtHelper, store, $location)
{
    $rootScope.$on('$routeChangeStart', function (event, next) 
    {
        var token = store.get("token") || null;
        if(!token)
            $location.path("/login");
 
        var bool = jwtHelper.isTokenExpired(token);
        if(bool === true)
            $location.path("/login");
    });
}])

Esto es muy básico, es mejor utilizar eventos pero para el ejemplo está bien, simplemente comprobamos si existe el token y este no ha expirado, de otra forma lo devolvemos a la pantalla de login.
Para finalizar nuestro trabajo debemos volver al servidor y crear el controlador movies.php, el modelo movies_model.php y el modelo auth_model.php, abre el primero y añade el siguiente código.

PHP

1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
27
28
29
30
31
32
33
34
35
36
37
38
39
40
41
42
43
44
45
46
47
48
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Movies extends CI_Controller {
 
    protected $headers;
 
    public function __construct()
    {
        parent::__construct();
        $this->headers = apache_request_headers();
    }
 
    public function index()
    {
        if(!isset($this->headers["Authorization"]) || empty($this->headers["Authorization"]))
        {
            //mejorar la validación, pero si está aquí es que no tenemos el token
        }
        else
        {
            $token = explode(" ", $this->headers["Authorization"]);
            $user = JWT::decode(trim($token[1],'"'));
            $this->load->model("auth_model");
 
            if($this->auth_model->checkUser($user->id, $user->email) !== false)
            {
                $this->load->model("movies_model");
                $movies = $this->movies_model->get();
                $user->iat = time();
                $user->exp = time() + 300;
                $jwt = JWT::encode($user, '');
                echo json_encode(
                    array(
                        "code" => 0,
                        "response" => array(
                            "token" => $jwt,
                            "movies"=> $movies
                        )
                    )
                );
            }
 
        }
    }
}
 
/* End of file movies.php */
/* Location: ./application/controllers/movies.php */

Comprobamos si podemos obtener a través de los headers la clave Authorization y si es así decodificamos el token y comprobamos si pertenece a un usuario con checkUser(), si existe el usuario obtenemos las películas y devolvemos un json.
Ahora crea el modelo auth_model.php y añade el siguiente código.

PHP

1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
27
28
29
30
31
32
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Auth_model extends CI_Model 
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function login($email, $password)
    {
        $query = $this->db->select("id, email")
        ->from("accounts")
        ->where("email", $email)
        ->where("password", $password)
        ->get();
        if($query->num_rows() === 1)
        {
            return $query->row();
        }
        return false;
    }
    
    public function checkUser($id, $email)
    {
        $query = $this->db->limit(1)->get_where("accounts", array("id" => $id, "email" => $email));
        return $query->num_rows() === 1;
    }
}
 
/* End of file auth_model.php */
/* Location: ./application/models/auth_model.php */

El método login simplemente comprueba si el usuario existe a través del email y el password, y el método checkUser hace lo mismo pero a través del payload del token con las claves id y email.
Ahora crea el modelo movies_model.php y añade el siguiente código con lo que habremos terminado.

PHP

1
2
3
4
5
6
7
8
9
10
11
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Movies_model extends CI_Model 
{
    public function get()
    {
        return $this->db->select("*")->from("movies")->get()->result();
    }
}
/* End of file movies_model.php */
/* Location: ./application/models/movies_model.php */

Finalmente obtenemos las películas y las devolvemos al controlador, así desde AngularJS ya podemos obtenerlas y mostrarlas en la vista home.html.
Si ahora haces login con los datos iparra@mail.com y 12345678 podrás hacer ir a la home y cuando pulses en el botón verás las películas, de la misma forma, en la parte alta verás el payload del usuario ya que hemos decodificado el token y pasado a la vista como user.

El código completo del ejemplo está en mi repositorio de github, lo puedes obtener y hacer con él lo que quieras