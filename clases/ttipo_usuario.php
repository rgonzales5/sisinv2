<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ttipo_usuario
 *
 * @author Usuario
 */
/*
 create table tid_tablas
( 
  idtabla int not null,
  nombre char(20) not null,
  codigoactual bigint not null,
  primary key(idtabla)
)engine=innodb;
 */
class ttipo_usuario {
    
    private $idtabla;
    private $nombre;
    private $codigoactual;
    private $cnx;
    //constructor
    public function ttipo_usuario($cnx)
    {
        $this->idtabla = 0;
        $this->nombre = "";
        $this->codigoactual = "";
        $this->cnx = $cnx;
    }
    //---------------------------------
    public function getidtabla()
    {
        return $this->idtabla;
    }
    public function setidtabla($valor)
    {
        $this->idtabla = $valor;
    }
       //---------------------------------
    public function getnombre()
    {
        return $this->nombre;
    }
    public function setnombre($valor)
    {
        $this->nombre = $valor;
    }
       //---------------------------------
    public function getcodigoactual()
    {
        return $this->codigoactual;
    }
    public function setcodigoactual($valor)
    {
        $this->codigoactual = $valor;
    }
       //---------------------------------
    public function guardar()
    {
        if($this->validar())
	{
		$sql="insert into ttipo_usuario values(
                         0,
                         '$this->nombre',
                          $this->codigoactual,
                         )";
		return $this->cnx->execute($sql);
	}
	else
	{
	       return false;
	}
    }
    public function validar()
    {
        
        if(strlen(trim($this->nombre))==0)
        {
            return false;
        }
        if($this->codigoactual<=0)
            return false;
        return true;
    }  
	public function buscar_listadoabm($criterio)
	{
	    $sql = "SELECT * FROM ttipousuario where nombre like '%$criterio%' "
	
	}  
}
?>