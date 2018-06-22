<?php
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