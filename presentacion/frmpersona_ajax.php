<?php
   
   require_once('../clases/conexion.php');
   require_once('../clases/tpersona.php');
   require_once('../clases/utilitarios.php');
   
   $cnx = new conexion();
   $objPersona = new tpersona($cnx);
   /*if(isset($_POST["txtbusqueda"]))
   {
   		$criterio = $_POST["txtbusqueda"];
   		$objPersona->buscar_listadoabm($criterio,"frmpersonaabm.php");
   }*/
   if(isset($_POST["page"]))
   {
      $criterio = $cnx->validar_caracteres($_POST["criterio"]);
      paginar($_POST["page"],$criterio,$objPersona,"frmpersonaabm.php");
	  //paginarseleccion($_POST["page"],$criterio,$objPersona,"frmpersonaabm.php");
   }
   if(isset($_POST["page_sel"]))
   {
      $criterio = $cnx->validar_caracteres($_POST["criterio"]);
      paginar_seleccion($_POST["page_sel"],$criterio,$objPersona,"btnsel_tipopersona");
	  //paginarseleccion($_POST["page"],$criterio,$objPersona,"frmpersonaabm.php");
   }
   
   
   
?>