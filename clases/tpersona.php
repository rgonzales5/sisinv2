<?php
/*
create table tpersona
(
  codigo int not null,
  nombres varchar(25) not null,
  apellidop varchar(20) not null,
  apellidom varchar(20) not null,
  ci        varchar(20) not null,
  telefono  varchar(15) not null,
  estado varchar(1) not null,
  email varchar(50),
  primary key(codigo)
)engine=innodb;
*/
class tpersona
{    
	  private $codigo;
	  private $nombres;
	  private $apellidop;
	  private $apellidom;
	  private $ci;
	  private $telefono;
	  private $estado;
	  private $email;
  
      private $cnx;
    //constructor
    public function tpersona($cnx)
    {
		$this->limpiarcampos();
        $this->cnx = $cnx;
    }
    //---------------------------------
    public function getcodigo()
    {
        return $this->codigo;
    }
    public function setcodigo($valor)
    {
        $this->codigo = $valor;
    }
    //---------------------------------
    public function getnombres()
    {
        return $this->nombres;
    }
    public function setnombres($valor)
    {
        $this->nombres = $this->cnx->validar_caracteres($valor);
    }
       //---------------------------------
    public function getapellidop()
    {
        return $this->apellidop;
    }
    public function setapellidop($valor)
    {
        $this->apellidop = $this->cnx->validar_caracteres($valor);
    }
       //---------------------------------
    public function getapellidom()
    {
        return $this->apellidom;
    }
    public function setapellidom($valor)
    {
        $this->apellidom = $this->cnx->validar_caracteres($valor);
    }

       //---------------------------------
	  public function getci()
    {
        return $this->ci;
    }
    public function setci($valor)
    {
        $this->ci= $this->cnx->validar_caracteres($valor);
    }  
	
	//---------------------------------
	public function gettelefono()
    {
        return $this->telefono;
    }
    public function settelefono($valor)
    {
        $this->telefono= $this->cnx->validar_caracteres($valor);
    }  
	//---------------------------------
	public function getestado()
    {
        return $this->estado;
    }
    public function setestado($valor)
    {
        $this->estado = $valor;
    }
	
	//---------------------------------
	public function getemail()
    {
        return $this->email;
    }
    public function setemail($valor)
    {
        $this->email = $this->cnx->validar_caracteres($valor);
    }
	//---------------------------------
    public function guardar()
    {
		if($this->validar())
		{
				//controlando la transaccion
				$sql="insert into tpersona values(
							  $this->codigo,
							 '$this->nombres',
							 '$this->apellidop',
							 '$this->apellidom',
							 '$this->ci',
							 '$this->telefono',
							 '$this->estado',
							 '$this->email'
							 )";
				   
			   $resultado = $this->cnx->execute($sql);
			   if(isset($resultado))
			   {  
				  return true;
			   }
				else
				  return false;
		}
		else
		{
		   return false;
		}
    }
	
	public function modificar()
    {
	    if($this->validar())
		{
				//controlando la transaccion
				$sql="update tpersona set 
							  nombres   = '$this->nombres',
							  apellidop = '$this->apellidop',
							  apellidom = '$this->apellidom',
							  ci 		= '$this->ci',
							  telefono  = '$this->telefono',
							  estado    = '$this->estado',
							  email     = '$this->email'
					   where codigo  = $this->codigo";
				   
			   $resultado = $this->cnx->execute($sql);
			   if(isset($resultado))
			   {  
				  return true;
			   }
				else
				  return false;
		}
		else
		{
		   return false;
		}
    }

	public function eliminar()
    {
		if(isset($this->codigo)&& $this->codigo>0)
		{
				//controlando la transaccion
				$sql="delete from tpersona where codigo  = $this->codigo";
				   
			   $resultado = $this->cnx->execute($sql);
			   if(isset($resultado))
			   {  
				  return true;
			   }
				else
				  return false;
		}
		else
		{
		   return false;
		}
    }

	
    public function validar()
    {
        
        if(strlen(trim($this->nombres))==0)
        {
            return false;
        }
		if(strlen(trim($this->apellidop))==0)
        {
            return false;
        }        

		if(strlen(trim($this->apellidom))==0)
        {
            return false;
        }        

        return true;
    }  
	
	public function traer($codigo)
	{
	    $sql = "SELECT codigo,apellidop,apellidom,nombres,
		       ci,telefono,email,estado FROM tpersona where codigo = $codigo";
	 
	    $resultados = $this->cnx->execute($sql);
		$fila = $this->cnx->next($resultados);
		$this->limpiarcampos();
		if(isset($fila[0]))
		{
			$this->codigo = $fila[0];
			$this->apellidop=$fila[1];
			$this->apellidom=$fila[2];
			$this->nombres=$fila[3];
			$this->ci=$fila[4];
			$this->telefono=$fila[5];
			$this->email=$fila[6];
			$this->estado=$fila[7];
			return true;
		}
		else
		   return false;	
	}
	public function limpiarcampos()
	{
        $this->codigo = 0;
        $this->nombres = "";
        $this->apellidop = "";
	 	$this->apellidom = "";
        $this->ci = "";
        $this->telefono = "";	
		$this->estado = "";
        $this->email = "";	
	
	}
	public function buscar_listadoabm($criterio,$urlabm)
	{
	    $criterio = $this->cnx->validar_caracteres($criterio);
		$sql = "SELECT codigo,apellidop,apellidom,nombres,
		         ci,telefono,email,estado FROM tpersona where concat(nombres,' ',apellidop,' ',apellidom) like '%$criterio%' 
		          ORDER BY apellidop,apellidom,nombres";
	 
	    $resultados = $this->cnx->execute($sql);
		$titulo = array("#","Cod.","Ap.Paterno","Ap.Materno","Nombres","C.I.","Telefono","Email","Estado","Modificar","Eliminar");
		generar_tabla_abm($titulo,$resultados,$urlabm);
	} 
	public function generar_paginacion($criterio,$start,$per_page,$urlabm,$count)
	{
	    $criterio = $this->cnx->validar_caracteres($criterio);
		$sql = "SELECT codigo,apellidop,apellidom,nombres,
		         ci,telefono,email,estado FROM tpersona where concat(nombres,' ',apellidop,' ',apellidom) like '%$criterio%' 
		          ORDER BY apellidop,apellidom,nombres limit $start,$per_page";
	 
	    $resultados = $this->cnx->execute($sql);
		$titulo = array("#","Cod.","Ap.Paterno","Ap.Materno","Nombres","C.I.","Telefono","Email","Estado","Modificar","Eliminar");
		$resultado_html = obtener_tabla_abm_paginacion($titulo,$resultados,$urlabm);
	
	    $sql =  "SELECT count(codigo) AS cant_registros 
		         FROM tpersona where concat(nombres,' ',apellidop,' ',apellidom) like '%$criterio%'";
		$resultados_cant = $this->cnx->execute($sql);
		$fila = $this->cnx->next($resultados_cant);
		$count = $fila["cant_registros"];
		
		return $resultado_html;
	}	 
	
	public function generar_paginacion_seleccion($criterio,$start,$per_page,$nombrebtnsel,$count)
	{
	    $criterio = $this->cnx->validar_caracteres($criterio);
		$sql = "SELECT codigo,concat(nombres,' ',apellidop,' ',apellidom) as descripcion,
		         ci,telefono,email,estado FROM tpersona where concat(nombres,' ',apellidop,' ',apellidom) like '%$criterio%' 
		          ORDER BY apellidop,apellidom,nombres limit $start,$per_page";
	 
	    $resultados = $this->cnx->execute($sql);
		$titulo = array("#","Cod.","Nombre","C.I.","Telefono","Email","Estado","Seleccionar");
		$resultado_html = obtener_tabla_abm_paginacion_seleccion($titulo,$resultados,$nombrebtnsel);
	
	    $sql =  "SELECT count(codigo) AS cant_registros 
		         FROM tpersona where concat(nombres,' ',apellidop,' ',apellidom) like '%$criterio%'";
		$resultados_cant = $this->cnx->execute($sql);
		$fila = $this->cnx->next($resultados_cant);
		$count = $fila["cant_registros"];
		
		return $resultado_html;
	}	 
}
?>