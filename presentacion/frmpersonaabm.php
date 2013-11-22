<?php
	require_once("../clases/conexion.php");
	require_once("../clases/tpersona.php");
	require_once("../clases/ctrl_contador.php");
	require_once("../clases/ctrl_tpersona.php");
		
	$cnx=new conexion();
	$objpersona=new tpersona($cnx);
	
	$op=0;
	$operacionMsg = "";
	$error="";
	$msg = "";
	
	$codigo = "";
    $nombres = "";
    $apellidop = "";
	$apellidom = "";
	$ci = "";
    $telefono = "";
	$estado = "A";
	$email = "";
							 
	if(isset($_GET["op"]))
	{
		$op=$_GET["op"];
		$codigo=$_GET["codigo"];
		$objpersona->traer($codigo);
		$codigo 	= $objpersona->getcodigo();
		$nombres 	= $objpersona->getnombres();
		$telefono 	= $objpersona->gettelefono();
		$estado 	= $objpersona->getestado();
		$email 		= $objpersona->getemail();
		$apellidop 	= $objpersona->getapellidop();
		$apellidom 	= $objpersona->getapellidom();
		$ci  		= $objpersona->getci();
		
	}
	
	if(isset($_POST["btnaceptar"]))
	{
	   
		$op=$_POST["txtoperacion"];
		switch($op)
		{
			case 1: guardar(); break;
			case 2: modificar(); break;
			case 3: eliminar(); break;
		}
	}
	
	switch($op)
	{
	   case 1: $operacionMsg = "Registrar nuevo"; break;
	   case 2: $operacionMsg = "Modificar el registgro"; break;
	   case 3: $operacionMsg = "Eliminar !!! el registro"; break;
	   default: header("location:frmpersona.php?msg=Operacion no valida");break;
	}
	
	function cargar_datos()
	{
                global $objpersona;
                global $op;
		global $codigo;
		global $nombres;
                $nombres = $_POST["txtnombre"];
		global $apellidop;
                $apellidop = $_POST["txtapellidop"];
		global $apellidom;
                $apellidom = $_POST["txtapellidom"];
		global $ci;
                $ci= $_POST["txtci"];
		global $telefono;
                $telefono = $_POST["txttelefono"];
		global $estado;
                $estado = $_POST["opcEstado"];
		global $email;
                $email = $_POST["txtemail"];
		if($op == 2 || $op == 3)
		{
		   $codigo =  $_POST["txtcodigo"];
		}
		else
		{
		   $codigo = 0;//se buscara con incremento en la tabla
		}
		$objpersona->setcodigo($codigo);
		$objpersona->setapellidop($apellidop);
		$objpersona->setapellidom($apellidom);
		$objpersona->setnombres($nombres);
		$objpersona->setci($ci);
		$objpersona->settelefono($telefono);
		$objpersona->setemail($email);
		$objpersona->setestado($estado);
		
	}
	
	function guardar()
	{
	    global $cnx;
		global $error;
		try
                {
                    global $error;
                    global $objpersona;
                    cargar_datos();

                    if(ctrl_tpersona::guardar($cnx,$objpersona)==true)
                    {
					    $cnx->close();
                        header("Location:frmpersona.php?msg=Persona adicionada correctamente");
                    }
                    else
                    {                        
                        $error="Error al guardar la persona revise los datos e intente nuevamente";
                    }
                }
                catch(Exception $e)
                {
                    $cnx->close();
                }
                
	}
	function modificar()
	{
	    global $cnx;
		global $error;
		try
                {
                    global $error;
                    global $objpersona;
                    cargar_datos();
                     
                    if(ctrl_tpersona::modificar($cnx,$objpersona)==true)
                    {
					    $cnx->close();
                        header("Location:frmpersona.php?msg=Persona Modificada correctamente");
                    }
                    else
                    {                        
                        $error="Error al modificar la persona revise los datos e intente nuevamente";
                    }
                }
                catch(Exception $e)
                {
                    $cnx->close();
                }
                
	}
	function eliminar()
	{
	    global $cnx;
		global $error;
		try
                {
                    global $error;
                    global $objpersona;
                    cargar_datos();

                    if(ctrl_tpersona::eliminar($cnx,$objpersona)==true)
                    {
					    $cnx->close();
                        header("Location:frmpersona.php?msg=Persona eliminada correctamente");
                    }
                    else
                    {                        
                        $error="Error al eliminar la persona revise los datos e intente nuevamente";
                    }
                }
                catch(Exception $e)
                {
                    $cnx->close();
                }
                
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>REGISTRO:PERSONAS</title>
<link rel="stylesheet" type="text/css" href="../css/estilos_grales.css">
<link type="text/css" rel="Stylesheet" href="../css/jquery.validity.css"/>
<link rel="stylesheet" media="all" type="text/css" href="../css/jquery-impromptu.css"/>

<script language="JavaScript" type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
<script type="text/javascript" src="../js/jquery.validity.js"></script>
<script type="text/javascript" src="../js/expresiones_regulares.js"></script>

<script type="text/javascript" src="../js/jquery-impromptu.js"></script>

<script language="JavaScript" type="text/javascript">
        
            $(document).ready
            (
				function ()
				{
				    //ocultar los div de busquedas 
					$('#divbusqueda1').hide();
					
					
					function loading_show(){
						$('#loading').html("<img src='../images/loading.gif'/>").fadeIn('fast');
					}
					
					function loading_hide(){
						$('#loading').fadeOut('fast');
					}
					                
					function loadData(page){
						loading_show();    
						//alert('hola data');                
						
						$.ajax
						(
							{
								type: "POST",
								url: "frmpersona_ajax.php",
								data: {page_sel:page,criterio:$('#txtcriteriobusq1').val()},
								dataType:"HTML"
							}
						).done(function(respuesta){
										loading_hide();
										$("#container").html(respuesta);
										$('#divbusqueda1').show();
						}
						);
						
						
					}
					
					//$("#container").on("click",".texto", function(){ alert( $(this).text() ); });

					
					$('#container').on('click','.pagination li.active',function(){
						var page = $(this).attr('p');
						//alert(page);
						loadData(page);
						
					});   
					        
					$('#go_btn').delegate('click',function(){
						var page = parseInt($('.goto').val());
						var no_of_pages = parseInt($('.total').attr('a'));
						if(page != 0 && page <= no_of_pages){
							loadData(page);
						}else{
							alert('Enter a PAGE between 1 and '+no_of_pages);
							$('.goto').val("").focus();
							return false;
						}
						
					});
					
					
					$('#container').on('click','.btnsel',function(){
						var idtipopsel = parseInt($(this).attr('codigo'));
						alert(idtipopsel);
						var descripcionsel = $(this).attr('descripcion');
						
						$('#txtidtipopersona').val(idtipopsel);
						$('#txtdescripcion').val(descripcionsel);
						
						$('#divbusqueda1').hide();
						
					});
					
					$('#btnbuscar').on('click',function(){
						//alert('buscar');
						loadData(1);
					});
					$('#btnbuscar2').on('click',function(){
						//alert('buscar');
						loadData(1);
					});
													
										
					$('#btncancelar').click
					(
						   function()
						   {
						     // alert('cancelo');
							   window.location = "frmpersona.php?msg=operacion cancelada";
						   }
					);	
					
									
					$('form').validity(function() {
						$("#txtnombre,#txtapellidop,#txtapellidom")                         
							.require("campo obligatorio")                         
							.maxLength(25,'Longitud no validad 25 car. maximo' )                   
							.minLength(3,'Longitud no validad 3 car. minimo' )
							.match(exp_rel_nombre_persona,'Solo se permita caracteres A-Z');
						$("#txtci")                         
							.require("campo obligatorio")                         
							.maxLength(10,'Longitud no validad 10 car. maximo' )                   
							.minLength(6,'Longitud no validad 6 car. minimo' )
							.match(exp_rel_ci,'Solo se permita caracteres A-Z');
						
						$("#txttelefono")                         
							.require("campo obligatorio")                         
							.maxLength(15,'Longitud no validad 15 car. maximo' )                   
							.minLength(5,'Longitud no validad 5 car. minimo' )
							.match(exp_rel_telefono,'Solo se permita caracteres A-Z');
						
						$("#txtemail")                         
							.maxLength(50,'Longitud no validad 50 car. maximo' )                   
							.minLength(5,'Longitud no validad 5 car. minimo' )
							.match('email','Email no valido');
					});
																						
				}
			);
	        function confirmarenvio()
			{		
			
			    if(confirm("Esta seguro"))
				{
				    //document.form1.submit();
					return true; 
				}
				else
				   return false
			   	/*
				$.prompt
				(
					"Esta seguro de realizar la operacion?",
					{
						title: "Esta seguro?",
						buttons: {"Si": true, "No": false },
						submit: function(e,v,m,f)
						{
							// use e.preventDefault() to prevent closing when needed or return false. 
							e.preventDefault();
							e.stopPropagation(); 
							//console.log("Value clicked was: "+ v);
							//alert(v);
							if(v==true)
							   resultado = true;
							alert(resultado);
							$.prompt.close();
							alert('ulrimo RESULTADO');
							return resultado;
						}
					}
				);
				*/
			
			}
					
			
</script>

<style type="text/css">
            body{
                margin: 0 auto;
                padding: 0;
            }
            #loading{
                width: 100%;
                position: absolute;
                top: 100px;
                left: 100px;
				margin-top:200px;
            }
            #container .pagination ul li.inactive,
            #container .pagination ul li.inactive:hover{
                background-color:#ededed;
                color:#bababa;
                border:1px solid #bababa;
                cursor: default;
            }
            #container .data ul li{
                list-style: none;
                font-family: verdana;
                margin: 0px 0 0px 0;
                color: #000;
                font-size: 13px;
            }

            #container .pagination{
                width: 800px;
                height: 18px;
            }
            #container .pagination ul li{
                list-style: none;
                float: left;
                border: 1px solid #006699;
                padding: 2px 6px 2px 6px;
                margin: 0 3px 0 3px;
                font-family: arial;
                font-size: 14px;
                color: #006699;
                font-weight: bold;
                background-color: #f2f2f2;
            }
            #container .pagination ul li:hover{
                color: #fff;
                background-color: #006699;
                cursor: pointer;
            }
			
			.go_button
			{
			background-color:#f2f2f2;border:1px solid #006699;color:#cc0000;padding:2px 6px 2px 6px;cursor:pointer;position:absolute;margin-top:-1px;
			}
			.total
			{
			float:right;font-family:arial;color:#999;
			}

        </style>
</head>

<body>

  <form action="frmpersonaabm.php" method="post" name="form1" onsubmit="return confirmarenvio();">
    <table border="1">
      <thead>
          <tr>
            <th colspan="2">PERSONA: <?php echo $operacionMsg?></th>
          </tr>
      </thead>
      <tbody>
      <tr>
        <td width="96">Codigo (*):</td>
        <td><label>
          <input type="text" name="txtcodigo" id="txtcodigo" readonly="readonly" class="campoReadOnly" 
          value="<?php echo $codigo;?>" />
        </label></td>
      </tr>
      <tr>
        <td>Tipo(*)</td>
        <td>
          <input type="button" name="btnbuscar2" id="btnbuscar2" value="Buscar" />
          <input class="campoReadOnly" 
 name="txtidtipopersona" type="text" id="txtidtipopersona" size="10" maxlength="10" readonly="readonly" />
          <input class="campoReadOnly" 
name="txtdescripcion" type="text" id="txtdescripcion" size="50" maxlength="50"/>
          <div align="center" id="divbusqueda1" class="divbusqueda">
          <div>
            <input type="button" name="btnbuscar" id="btnbuscar" value="Buscar" />
            <input name="txtcriteriobusq1" type="text" id="txtcriteriobusq1" size="50" maxlength="50"/>
            </div>
        <div id="loading"></div>
        
        <div id="container">
            
            
            <div class="data"></div>
            <div class="pagination"></div>
        </div>
       </div>        </td>
      </tr>
      <tr>
        <td>Nombre (*):</td>
        <td><label>
          <input type="text" name="txtnombre" id="txtnombre"
          value="<?php echo $nombres;?>"/>
        </label></td>
      </tr>
      <tr>
        <td>Ap.Paterno (*):</td>
        <td><label>
          <input type="text" name="txtapellidop" id="txtapellidop"
          value="<?php echo $apellidop;?>" />
        </label></td>
      </tr>
      <tr>
        <td>Ap.Materno(*):</td>
        <td><label>
          <input type="text" name="txtapellidom" id="txtapellidom"
          value="<?php echo $apellidom;?>" />
        </label></td>
      </tr>
      <tr>
        <td>Nro. C.I. (*):</td>
        <td><label>
          <input type="text" name="txtci" id="txtci" value="<?php echo $ci;?>" />
        </label></td>
      </tr>
      <tr>
        <td>Telefono(*):</td>
        <td><label>
          <input type="text" name="txttelefono" id="txttelefono" value="<?php echo $telefono;?>" />
        </label></td>
      </tr>
      <tr>
        <td>Email:</td>
        <td><label>
          <input type="text" name="txtemail" id="txtemail" value="<?php echo $email;?>" />
        </label></td>
      </tr>
      <tr>
        <td>Estado (*):</td>
        <td><table width="200">
          <tr>
            <td><label>
              
              <input name="opcEstado" type="radio" id="opcEstado_0" <?php if($estado == 'A') echo "checked='checked'" ?> value="A" />
              Activo
              
              </label></td>
          </tr>
          <tr>
            <td><label>
              <input type="radio" name="opcEstado"  value="I" <?php if($estado == 'I') echo "checked='checked'" ?> id="opcEstado_1" />
              Inactivo</label></td>
          </tr>
          </table>        </td>
      </tr>
      <tr>
        <td colspan="2">
          <input type="submit" name="btnaceptar" id="btnaceptar" value="Aceptar"/>
          <input type="button" name="btncancelar" id="btncancelar" value="Cancelar" />        </td>
      </tr>
      <tr>
          <th align="left" colspan="2">Mensajes: <?php  echo $error;?> </th>
      </tr>
      </tbody>
    </table>
    <input type="hidden" id="txtoperacion" name="txtoperacion" value="<?php echo $op;?>"/>
  </form>

</body>
</html>
