<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>form-Tipo de usuario</title>
<link rel="stylesheet" type="text/css" href="../css/estilos_grales.css"> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script> 
<script type="text/javascript">
            $(document).ready
			(
				function()
				{
					function loading_show(){
						$('#loading').html("<img src='../images/loading.gif'/>").fadeIn('fast');
					}
					function loading_hide(){
						$('#loading').fadeOut('fast');
					}                
					function loadData(page){
						loading_show();                    
						$.ajax
						({
							type: "POST",
							url: "frmpersona_ajax.php",
							data: {"page":page,"criterio":$('#txtbusqueda').val()},
							success: function(msg)
							{
								$("#container").ajaxComplete(function(event, request, settings)
								{
									loading_hide();
									$("#container").html(msg);
								});
							}
						});
					}
					loadData(1);  // For first time page load default results
					$('#container .pagination li.active').live('click',function(){
						var page = $(this).attr('p');
						loadData(page);
						
					});           
					$('#go_btn').live('click',function(){
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
				
					$('#btnbuscar').click
					(
						   function ()
						   {
							   loadData(1);
						   }
					);
					
					$('#btnnuevo').click
					(
						   function()
						   {
							   window.location = "frmpersonaabm.php?op=1";
						   }
					);	
				
            	}
			);
        </script>

<style type="text/css">
            body{
                width: 800px;
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
                margin: 5px 0 5px 0;
                color: #000;
                font-size: 13px;
            }

            #container .pagination{
                width: 800px;
                height: 25px;
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
  <table width="100%" border="1">
   <thead>
    <tr>
      <th colspan="2">REGISTRO DE PERSONAS</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>Buscar(Nombre)</td>
      <td><label>
        <input name="txtbusqueda" type="text" id="txtbusqueda" size="50" maxlength="50" />
        <input type="button" name="btnbuscar" id="btnbuscar" value="Buscar" />
      </label></td>
    </tr>
    <tr>
      <td colspan="2">   
       <div align="center">
        <div id="loading"></div>
        <div id="container">
            <div class="data"></div>
            <div class="pagination"></div>
        </div>
       </div>
      </td>
    </tr>
    <tr>
      <td colspan="2"><label>
      <input name="btnnuevo" type="button" id="btnnuevo" value="Nuevo Registro" />
      </label></td>
    </tr>
    <tr>
      <th colspan="2" align="left">
      <div id="divmensaje" name="divmensaje">
       Mensajes:
	   <?php 
	       if(isset($_GET["msg"]))
		     echo $_GET["msg"];
	   ?>
        </div>
       </th>
    </tr>
    </tbody>
  </table>
</body>
</html>
