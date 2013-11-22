<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>form-Tipo de usuario</title>
<script language="JavaScript" type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>
<script language="JavaScript" type="text/javascript">
            $(document).ready
            (
				function ()
				{
					//alert("hola");
					$('#btnbuscar').click
					(
					   function ()
					   {
					        $.post
							(
							   "frmtipousuario_ajax.php",{txtbusqueda:$('#txtbusqueda').val()},
							   function(responseText)
					           {
							        $('#divbusqueda').html(responseText);   
							   }
							);
					  
					   }
					);										
									
				}
			);
			
			
			
</script>

</head>

<body>
  <table width="100%" border="1">
    <tr>
      <td colspan="2">Tipo de usuario</td>
    </tr>
    <tr>
      <td>Buscar:</td>
      <td><label>
        <input name="txtbusqueda" type="text" id="txtbusqueda" size="50" maxlength="50" />
        <input type="button" name="btnbuscar" id="btnbuscar" value="Buscar" />
      </label></td>
    </tr>
    <tr>
      <td colspan="2">
      
      </td>
    </tr>
    <tr>
      <td colspan="2"><label>
        <input name="btnnuevo" type="button" id="btnnuevo" value="Nuevo Registro" />
      </label></td>
    </tr>
    <tr>
      <td colspan="2">
      <div id="divbusqueda" name="divbusqueda">
      
      </div>
      </td>
    </tr>
  </table>
</body>
</html>
