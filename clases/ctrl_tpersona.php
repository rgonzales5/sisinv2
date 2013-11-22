<?php
class ctrl_tpersona
{
   public static function guardar($cnx,$objpersona)
   {
   			try
            {
                    $cnx->execute("start transaction");
                    $codigoGenerado = ctrlcontador::codigoActual($cnx,1);
                    $objpersona->setcodigo($codigoGenerado);
                    
                    if($objpersona->guardar()==true)
                    {
                        ctrlcontador::incrementar($cnx, 1);
                        $cnx->execute("commit");						
                        return true;
                    }
                    else
                    {
					    
                        $cnx->execute("rollback");
                        return false;
                    }
            }
            catch(Exception $e)
            {
			       
                    $cnx->execute("rollback");
					return false;
            }
   }
   public static function modificar($cnx,$objpersona)
   {
   			try
            {
                    $cnx->execute("start transaction");
                    if($objpersona->modificar()==true)
                    {
                        $cnx->execute("commit");						
                        return true;
                    }
                    else
                    {
					    
                        $cnx->execute("rollback");
                        return false;
                    }
            }
            catch(Exception $e)
            {
			       
                    $cnx->execute("rollback");
					return false;
            }
   }

   public static function eliminar($cnx,$objpersona)
   {
   			try
            {
                    $cnx->execute("start transaction");
                    if($objpersona->eliminar()==true)
                    {
                        $cnx->execute("commit");						
                        return true;
                    }
                    else
                    {
					    
                        $cnx->execute("rollback");
                        return false;
                    }
            }
            catch(Exception $e)
            {
			       
                    $cnx->execute("rollback");
					return false;
            }
   }
   
}
?>