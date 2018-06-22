<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once './clases/AccesoDatos.php';
require_once './clases/AutentificadorJWT.php';

require_once './clases/usuario.php';
require_once './clases/mascota.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

/*

¡La primera línea es la más importante! A su vez en el modo de 
desarrollo para obtener información sobre los errores
 (sin él, Slim por lo menos registrar los errores por lo que si está utilizando
  el construido en PHP webserver, entonces usted verá en la salida de la consola 
  que es útil).

  La segunda línea permite al servidor web establecer el encabezado Content-Length, 
  lo que hace que Slim se comporte de manera más predecible.
*/

$app = new \Slim\App(["settings" => $config]);


$app->get('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("GET => Bienvenido!!! ,a SlimFramework");
    return $response;

});

//************ AUTENTICACION ************//
$mdwAuth = function ( $request, $response, $next) {
    $token = $request->getHeader('token');
    if(AutentificadorJWT::verificarToken($token[0])){
        $response = $next($request,$response);
    }  
    return $response;
};

//************ TOKEN ************//
$app->post('/crearToken', function (Request $request, Response $response) {
    $datos = $request->getParsedBody();
    //$datos = array('usuario' => 'rogelio@agua.com','perfil' => 'profe', 'alias' => "PinkBoy");
    $token= AutentificadorJWT::CrearToken($datos); 
    $newResponse = $response->withJson($token, 200); 
    return $newResponse;
});


////revisar!
$app->post('/leerHeader', function (Request $request, Response $response) {
    $datos = $request->getParsedBody();
    $header = $request->getHeader('miHeader');
    $leido = AutentificadorJWT::ObtenerPayLoad($header);
    var_dump($leido);
    $newResponse = $response->withJson($header, 200); 
    return $newResponse;
});
//************************//



///////////////////////////////////////////////////////////////////////
//************ USUARIOS ************//

//AGREGAR USUARIO  *************************/
$app->post('/agregarUsuario',function($request,$response){
    $datos = $request->getParsedBody();
    $mail = $datos['mail'];
    $password = $datos['password'];
    $nombre = $datos['nombre'];
    $apellido = $datos['apellido'];
    $tipo = $datos['tipo'];
    $response->write(usuario::agregarUsuario($mail,$password,$nombre,$apellido,$tipo));
});

//TRAER TODOS LOS USUARIOS *************************/
$app->get('/traerTodosLosUsuarios',function ($request,$response){
    $response->write(usuario::traerTodosLosUsuarios());
    return $response;
});

//TRAER USUARIO POR ID *************************/
$app->post('/traerUsuarioPorId',function ($request,$response){
    $datos = $request->getParsedBody();
    $id = $datos['id'];
    $response->write(usuario::traerUsuarioPorId($id));
    return $response;
});

//MODIFICAR USUARIO *************************/
$app->post('/modificarUsuario',function($request,$response){
    $datos = $request->getParsedBody();
    $id = $datos['id'];
    $mail = $datos['mail'];
    $password = $datos['password'];
    $nombre = $datos['nombre'];
    $apellido = $datos['apellido'];
    $tipo = $datos['tipo'];
    $response->write(usuario::modificarUsuario($id,$mail,$password,$nombre,$apellido,$tipo));

    return $response;
});

//BORRAR USUARIO *************************/
$app->post('/borrarUsuario',function ($request,$response){
    $datos = $request->getParsedBody();
    $id = $datos['id'];
    $response->write(usuario::borrarUsuario($id));
    return $response;
});

///////////////////////////////////////////////////////////////////////
//************ MASCOTAS ************//

//AGREGAR Mascota  *************************/
$app->post('/agregarMascota',function($request,$response){
    $datos = $request->getParsedBody();
    $nombre = $datos['nombre'];
    $raza = $datos['raza'];
    $color = $datos['color'];
    $edad = $datos['edad'];
    $tipo = $datos['tipo'];
    $response->write(mascota::agregarMascota($nombre,$raza,$color,$edad,$tipo));
});

//TRAER TODOS LOS Mascotas *************************/
$app->get('/traerTodasLasMascotas',function ($request,$response){
    $response->write(mascota::traerTodasLasMascotas());
    return $response;
});

//TRAER Mascota POR ID *************************/
$app->post('/traerMascotaPorId',function ($request,$response){
    $datos = $request->getParsedBody();
    $id = $datos['id'];
    $response->write(mascota::traerMascotaPorId($id));
    return $response;
});

//TRAER Mascota POR DUENIO *************************/
$app->post('/traerMascotasPorDuenio',function ($request,$response){
    $datos = $request->getParsedBody();
    $id = $datos['id'];
    $response->write(mascota::traerMascotasPorDuenio($id));
    return $response;
});

//MODIFICAR Mascota *************************/
$app->post('/modificarMascota',function($request,$response){
    $datos = $request->getParsedBody();
    $id = $datos['id'];
    $nombre = $datos['nombre'];
    $raza = $datos['raza'];
    $color = $datos['color'];
    $edad = $datos['edad'];
    $tipo = $datos['tipo'];
    $response->write(mascota::modificarMascota($id,$nombre,$raza,$color,$edad,$tipo));

    return $response;
});

//BORRAR Mascota *************************/
$app->post('/borrarMascota',function ($request,$response){
    $datos = $request->getParsedBody();
    $id = $datos['id'];
    $response->write(mascota::borrarMascota($id));
    return $response;
});

//**********************************//



$app->run();
