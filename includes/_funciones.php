<?php 
include_once("_db.php");
switch ($_POST["accion"]) {
	case 'login':
		login();
		break;
	case 'consultar_usuarios':
		consultar_usuarios();
		break;
	case 'consultar_usuario':
		consultar_usuario($_POST['id']);
		break;
	case 'editar_usuario':
		editar_usuario();
		break;
	case 'insertar_usuario':
		insertar_usuario();
		break;
	case 'eliminar_usuario':
		eliminar_usuario($_POST['id']);
		break;
	case 'editar_banner':
		editar_banner();
		break;
	case 'insertar_banner':
		insertar_banner();
		break;
	case 'eliminar_banner':
		eliminar_banner($_POST['id']);
		break;
	case 'consultar_banner':
	     consultar_banner();	
		break;
	case 'consultar_download':
		consultar_download();
		break;
	case 'insertar_download':
		insertar_download();
		break;
	case 'carga_foto':
		carga_foto();
		break;
	default:
 
		break;
	
	
}
/*
function carga_foto(){
	if(isset($_FILES["foto"]){
		$file = $_FILES["foto"];
		$nombre = $_FILES["foto"]["name"];
		$tmp = $_FILES["foto"]["tmp_name"];
		$tipo = $_FILES["foto"]["type"];
		$tamaño = $_FILES["fot"]["size"];
		$dir = "../../img/usuarios/";
		$respuesta = [
			"archivo" => "../../img/usuarios/logotipo.png",
			"status" => 0
		];
		if (move_uploaded_file($tmp, $dir.$nombre)){
			$respuesta["archivo"] = "../img/usuarios/".$dir.$nombre;
			$respuesta["status"] = 1;
		}
		echo json_encode($respuesta);
	}
}
*/

function login(){
	global $mysqli;
	$mail= $_POST["mail"];
	$pass = $_POST["password"];
	
	if (empty($mail) && empty($pass)) {
	//empty boxes
       echo"2";
	}  
	
	else {
		$query = "SELECT * FROM web_usr WHERE usr_correo = '$mail'";
		$res = $mysqli->query($query);
		$row = $res->fetch_assoc();
   		if ($row == 0) {
   		//Correo no existe
    	 echo "0";
		}else{
	    	$query = "SELECT * FROM web_usr WHERE usr_correo = '$mail' AND usr_pass = '$pass'";
			$res = $mysqli->query($query);
			$row = mysqli_fetch_array($res);
			//Si el password no es correcto, imprimir 0
			if ($row["usr_pass"] != $pass) {
			echo "0";
			//Si el usuario es correcto, imprimir 1
			}elseif ($mail == $row["usr_correo"] && $pass == $row["usr_pass"]) {
			echo "1";
		
	    	}
	    }
	}
}

function consultar_usuarios(){
	global $mysqli;
	$query = "SELECT * FROM web_usr";
	$res = mysqli_query($mysqli, $query);
	$arreglo = [];
	while($fila = mysqli_fetch_array($res)){
		array_push($arreglo, $fila);
	}
	echo json_encode($arreglo); //Imprime el JSON ENCODEADO
}

function insertar_usuario(){
	global $mysqli;
	$nombre= $_POST["nombre"];
	$tel= $_POST["tel"];
	$mail = $_POST["mail"];
	$pass = $_POST["pass"];

	if (empty($nombre) && empty($mail) && empty($tel) && empty($pass)) {
		echo "0";
		
	}elseif (empty($nombre)) {
		echo "0";
	
	}elseif (empty($mail)) {
		echo "0";
	
	}elseif (empty($tel)) {
		echo "0";
	
	}elseif (empty($pass)) {
		echo "0";
	
	}else{

	$query = "INSERT INTO web_usr (id, usr_correo, usr_pass, usr_nombre, usr_telefono)  VALUES ('','$mail','$pass','$nombre','$tel')";
	$res = mysqli_query($mysqli, $query);
	echo "1";
	}	
}

function eliminar_usuario($id){
	global $mysqli;
	$query = "DELETE FROM web_usr WHERE id = $id";
	$res = $mysqli->query($query);
}

function consultar_usuario($id){
	global $mysqli;
	$query = "SELECT * FROM web_usr WHERE id = $id";
	$res = $mysqli->query($query);
	$fila = mysqli_fetch_array($res);
	echo json_encode($fila); //Imprime Json encodeado	
}

function editar_usuario(){
	global $mysqli;
	extract($_POST);

	if (empty($nombre) && empty($mail) && empty($tel) && empty($pass)) {
		echo "0";
		
	}elseif (empty($nombre)) {
		echo "0";
	
	}elseif (empty($mail)) {
		echo "0";
	
	}elseif (empty($tel)) {
		echo "0";
	
	}elseif (empty($pass)) {
		echo "0";
	
	}else{
		$query = "UPDATE web_usr SET usr_correo = '$usr_correo', usr_pass = '$correo_usr', usr_nombre = '$usr_nombre', usr_telefono = '$usr_telefono'
		WHERE id = '$id'";
		$res = $mysqli->query($query);
		if ($res) {
			echo "1";
		}
	}
}


function consultar_download(){
	global $mysqli;
	$query = "SELECT * FROM download";
	$res = mysqli_query($mysqli, $query);
	$arreglo = [];
	while($fila = mysqli_fetch_array($res)){
		array_push($arreglo, $fila);
	}
	echo json_encode($arreglo); //Imprime el JSON ENCODEADO
}

function insertar_download(){
	global $mysqli;
	$download_texto1 = $_POST['download_texto1'];
	$download_texto2 = $_POST['download_texto2'];
	$download_link = $_POST['download_link'];
	if (empty($download_texto1) && empty($download_texto2) && empty($download_link)) {
		echo "0";
	}elseif (empty($download_texto1)) {
		echo "0";
	}elseif (empty($download_texto2)) {
		echo "0";
	}elseif (empty($download_link)) {
		echo "0";
	}else{
	$query = "INSERT INTO download VALUES ('','$download_texto1','$download_texto2','$download_link')";
	$res = mysqli_query($mysqli,$query);
	echo "1";
	}

	function insertar_banner(){
	global $mysqli;
	$titulo1 = $_POST['titulo1'];
	$titulo2 = $_POST['titulo2'];
	
	if (empty($titulo1) && empty($titulo2)) {
		echo "0";
	}elseif (empty($titulo1)) {
		echo "0";
	}elseif (empty($titulo2)) {
		echo "0";
	}else{
	$query = "INSERT INTO banner VALUES ('','$titulo1','$tituloo2')";
	$res = mysqli_query($mysqli,$query);
	echo "1";
	}

	function consultar_banner(){
	global $mysqli;
	$query = "SELECT * FROM banner";
	$res = mysqli_query($mysqli, $query);
	$arreglo = [];
	while($fila = mysqli_fetch_array($res)){
		array_push($arreglo, $fila);
	}
	echo json_encode($arreglo); //Imprime el JSON ENCODEADO

	function eliminar_banner($id){
	global $mysqli;
	$query = "DELETE FROM banner WHERE id = $id";
	$res = $mysqli->query($query);
}

function editar_banner(){
	global $mysqli;
	extract($_POST);

	if (empty($titulo1) && empty($titulo2)) {
		echo "0";
		
	}elseif (empty($titulo1)) {
		echo "0";
	
	}elseif (empty($titulo2)) {
		echo "0";
	
	}else{
		$query = "UPDATE banner SET titulo1= '$titulo1', titulo2 = '$titulo2'
		WHERE id = '$id'";
		$res = $mysqli->query($query);
		if ($res) {
			echo "1";
		}
}
}		
?>