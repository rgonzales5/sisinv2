<?php
//error_reporting(1);
class conexion  
{

	private $server = "localhost";
	private $dbname = "bdinventario";
	private $username = "root"; 
	private $password = "";

	public $cnx = "";

	function conexion() 
	{
		$this->cnx = mysql_connect($this->server, $this->username, $this->password) ;		
                @mysql_select_db($this->dbname, $this->cnx);
     }
      function ultimoid()
      {
          return mysql_insert_id($this->cnx);
      }

    
	function execute($sql)
	{
            $res = @mysql_query($sql, $this->cnx);
            return $res;
    }
//cuantos registros devuelve "count"
	function count($res)
	{
            return @mysql_num_rows($res);
    }
//avanzar un record set en un registro es como si fuera un datatable como si fueraa una matriz
	function next($res) 
	{
             return @mysql_fetch_array($res);
    }
//cerrar un objeto de conexion
        function close()
		 {
            try 
			{
              @mysql_close($this->cnx);
            } 
				catch (Exception $e)
			 { 
			 
			 }

          }
	function validar_caracteres($str)
	{
	   return mysql_real_escape_string($str,$this->cnx);
	}
}
?>