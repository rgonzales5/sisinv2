<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ctrlContador
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
class ctrlcontador {
    //put your code here
    public static function codigoActual($cnx,$idtabla)
    {
        $sql = "SELECT codigoactual from tid_tablas where idtabla = $idtabla for update";
        $resultado = $cnx->execute($sql);
        $registro = $cnx->next($resultado);
        return $registro[0];
    }
    public static function incrementar($cnx,$idtabla)
    {
        $sql = "UPDATE tid_tablas set codigoactual = codigoactual + 1 where idtabla = $idtabla";
        $resultado = $cnx->execute($sql);
        $registro = $cnx->next($resultado);
        if($registro)
            return true;
        else
            return false;
    }
}
?>