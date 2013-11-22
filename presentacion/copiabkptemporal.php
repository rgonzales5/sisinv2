<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
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
							   "frmpersona_ajax.php",{txtbusqueda:$('#txtbusqueda').val()},
							   function(responseText)
					           {
							        $('#divbusqueda').html(responseText);   
									
							   }
							);
					  
					   }
					);
					$('#btnnuevo').click
					(
					   function()
					   {
					       window.location = "frmpersonaabm.php?op=1";
					   }
					);	
					
					//----
					 function loading_show()
					 {
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
							data: "page="+page,
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
					$('#container .pagination li.active').live('click',function()
					{
						var page = $(this).attr('p');
						loadData(page);
						
					});           
					$('#go_btn').live('click',function()
					{
						var page = parseInt($('.goto').val());
						var no_of_pages = parseInt($('.total').attr('a'));
						if(page != 0 && page <= no_of_pages){
							loadData(page);
						}else{
							alert('Enter a PAGE between 1 and '+no_of_pages);
							$('.goto').val("").focus();
							return false;
						}
						
					}
					);
					//---									
									
				}
			);
			
			
			
</script>

</head>

<body>
</body>
</html>
