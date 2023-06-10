<?php
require_once '../conexion.php';
require_once '../usuarios/sesiones.php';
//https://www.bootdey.com/snippets/view/social-network-dashboard-count
//https://www.w3schools.com/icons/icons_reference.asp

$mysqli = conectar();
$boton = $_POST['boton'];
$rucempresa = LoadSession();
switch ($boton) {

    case 'cuadro':
    $myquery = "SELECT   ucase(t4.detalle) as pago, 
    (select SUM(total) as totales from resumen as t1
    inner join numeracion as t2 on t2.id = t1.idnum
    where t2.cat1='01' and t1.idmon='PEN' AND t1.rucempresa='$rucempresa'
    ) as totalfac,
    (select SUM(total) as totales from resumen as t1
    inner join numeracion as t2 on t2.id = t1.idnum
    where t2.cat1='03' and t1.idmon='PEN' AND t1.rucempresa='$rucempresa'
    ) as totalbol,
    (select SUM(total) as totales from resumen as t1
    inner join numeracion as t2 on t2.id = t1.idnum
    where t2.cat1='08' and t1.idmon='PEN' AND t1.rucempresa='$rucempresa'
    ) as totalnd,
    (select SUM(total) as totales from resumen as t1
    inner join numeracion as t2 on t2.id = t1.idnum
    where t2.cat1='07' and t1.idmon='PEN' AND t1.rucempresa='$rucempresa'
    ) as devoluciones,
    (select SUM(total) as totales from resumen as t1
    where t1.estadocpe=1 and t1.idmon='PEN' AND t1.rucempresa='$rucempresa'
    ) as anulados
    from resumen as t1
    inner join tb_tipopago as t4 on t4.id = t1.idpago
    GROUP BY   ucase(t4.detalle)";

    
    $resultado = $mysqli->query($myquery);
    $row = mysqli_fetch_array($resultado);



    
    if($row[1]==null){
        $fa=0;
    }else{
        $fa=$row[1];
    }

    if($row[2]==null){
        $bo=0;
    }else{
        $bo=$row[2];
    }

    if($row[3]==null){
        $nd=0;
    }else{
        $nd=$row[3];
    }
    $tv=$fa+$bo+$nd;

    if($row[4]==null){
        $dv=0;
    }else{
        $dv=$row[4];
    }

    if($row[5]==null){
        $an=0;
    }else{
        $an=$row[5];
    }

    $lista = array(); //creamos un array
     $lista[] = array('tv' => str_replace(",","",number_format($tv,2)),
    'dv' => str_replace(",","",number_format($dv,2)),
    'an' => str_replace(",","",number_format($an,2)),
     );

     //Creamos el JSON
    $json_string = json_encode($lista);
    echo $json_string;


    break;

    case 'widget':

    //----------------- LISTAR ENVIADOS ---------------------//
    $myquery = "
    select DISTINCT (select count(t2.cat1) as tipo from resumen as t1
    inner join numeracion as t2 on t2.id = t1.idnum
    where t2.cat1='01'   AND t1.rucempresa='$rucempresa' ) as f,
    (select count(t2.cat1) as tipo from resumen as t1
    inner join numeracion as t2 on t2.id = t1.idnum
    where t2.cat1='03'   AND t1.rucempresa='$rucempresa') as b,
    (select count(t2.cat1) as tipo from resumen as t1
    inner join numeracion as t2 on t2.id = t1.idnum
    where t2.cat1='07'   AND t1.rucempresa='$rucempresa') as nc,
    (select count(t2.cat1) as tipo from resumen as t1
    inner join numeracion as t2 on t2.id = t1.idnum
    where t2.cat1='08'   AND t1.rucempresa='$rucempresa') as nd
    from resumen ";

    $resultado = $mysqli->query($myquery);
    $row = mysqli_fetch_array($resultado);

    $lista = array(); //creamos un array
    $lista[] = array('f' => $row[0],
        'b' => $row[1],
        'nc' => $row[2],
        'nd' => $row[3],
    );

    //Creamos el JSON
    $json_string = json_encode($lista);
    echo $json_string;

    break;


    case 'consulta':
        $myquery="SELECT  t3.detalle, ucase(t4.detalle) as pago, 
        (select count(idnum) as enviadas from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='01' and t1.cdr=1 AND t1.rucempresa='$rucempresa'
        ) as enviados,
        (select count(idnum) as enviadas from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='01' and t1.cdr=0 AND t1.rucempresa='$rucempresa'
        ) as noenviados,
        (select count(idnum) as enviadas from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='01' and t1.cdr=2 AND t1.rucempresa='$rucempresa'
        ) as errores,
        (select count(idnum) as enviadas from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='01'  AND t1.rucempresa='$rucempresa'
        ) as registrados,
        (select count(estadocpe) as estado from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where estadocpe='01' and estadocpe=1   AND t1.rucempresa='$rucempresa'
        ) as estado
        from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        inner join catalogo_01 as t3 on t3.id = t2.cat1
        inner join tb_tipopago as t4 on t4.id = t1.idpago
        where t2.cat1='01'  
        GROUP BY  t3.detalle, ucase(t4.detalle)
        UNION
        SELECT  t3.detalle, ucase(t4.detalle) as pago, 
        (select count(idnum) as enviadas from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='03' and t1.cdr=1 AND t1.rucempresa='$rucempresa'
        ) as enviados,
        (select count(idnum) as enviadas from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='03' and t1.cdr=0 AND t1.rucempresa='$rucempresa'
        ) as noenviados,
        (select count(idnum) as enviadas from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='03' and t1.cdr=2 AND t1.rucempresa='$rucempresa'
        ) as errores,
        (select count(idnum) as enviadas from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='03'  AND t1.rucempresa='$rucempresa'
        ) as registrados,
        (select count(estadocpe) as estado from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where estadocpe='03' and estadocpe=1   AND t1.rucempresa='$rucempresa'
        ) as estado
        from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        inner join catalogo_01 as t3 on t3.id = t2.cat1
        inner join tb_tipopago as t4 on t4.id = t1.idpago
        where t2.cat1='03' 
        GROUP BY  t3.detalle, ucase(t4.detalle)
        UNION
        SELECT  t3.detalle, ucase(t4.detalle) as pago, 
        (select count(idnum) as enviadas from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='07' and t1.cdr=1 AND t1.rucempresa='$rucempresa'
        ) as enviados,
        (select count(idnum) as enviadas from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='07' and t1.cdr=0 AND t1.rucempresa='$rucempresa'
        ) as noenviados,
        (select count(idnum) as enviadas from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='07' and t1.cdr=2 AND t1.rucempresa='$rucempresa'
        ) as errores,
        (select count(idnum) as enviadas from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='07'  AND t1.rucempresa='$rucempresa'
        ) as registrados,
        (select count(estadocpe) as estado from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where estadocpe='07' and estadocpe=1   AND t1.rucempresa='$rucempresa'
        ) as estado
        from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        inner join catalogo_01 as t3 on t3.id = t2.cat1
        inner join tb_tipopago as t4 on t4.id = t1.idpago
        where t2.cat1='07'  
        GROUP BY  t3.detalle, ucase(t4.detalle)
        UNION
        SELECT  t3.detalle, ucase(t4.detalle) as pago, 
        (select count(idnum) as enviadas from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='08' and t1.cdr=1 AND t1.rucempresa='$rucempresa'
        ) as enviados,
        (select count(idnum) as enviadas from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='08' and t1.cdr=0 AND t1.rucempresa='$rucempresa'
        ) as noenviados,
        (select count(idnum) as enviadas from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='08' and t1.cdr=2 AND t1.rucempresa='$rucempresa'
        ) as errores,
        (select count(idnum) as enviadas from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='08'  AND t1.rucempresa='$rucempresa'
        ) as registrados,
        (select count(estadocpe) as estado from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where estadocpe='08' and estadocpe=1   AND t1.rucempresa='$rucempresa'
        ) as estado
        from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        inner join catalogo_01 as t3 on t3.id = t2.cat1
        inner join tb_tipopago as t4 on t4.id = t1.idpago
        where t2.cat1='08'  
        GROUP BY  t3.detalle, ucase(t4.detalle)
        ";

        $resultado = $mysqli->query($myquery);
        $enviados=0;
        $noenviados=0;
        $conerrores=0;
        $registrados=0;
        $anulados=0;

        echo '<thead>
          <tr>
           <th  >Comprobante</th>
           <th  style="text-align: center;">Enviados</th>
           <th  style="text-align: center;">No Enviados</th>
           <th  style="text-align: center;">Con Errores</th>
           <th  style="text-align: center;">Total Registrados</th>
           <th  style="text-align: center;">Anulados</th>
          </tr>
        </thead>
        <tbody id="detalle-lista">';
        if ($resultado->num_rows > 0) {
            while ($mostrar = $resultado->fetch_array()) {
                $i = 1;


                echo '<tr>
                      <td >' . $mostrar['detalle'] . '</td>      
                      <td style="text-align: center;">' . $mostrar['enviados'] . '</td>';
                echo '<td style="text-align: center;">' . $mostrar['noenviados'] . '</td>';

                      if($mostrar['errores'] >0){
                echo '<td style="text-align: center;">
                     <h2 class="label label-danger">'.$mostrar['errores'] .'</h2></td>';
                      }else{
                echo '<td style="text-align: center;">' . $mostrar['errores'] . '</td>';
                      }
                echo '<td style="text-align: center;">' . $mostrar['registrados'] . '</td>
                      <td style="text-align: center;">' . $mostrar['estado'] . '</td>
                     </tr> ';

                $enviados+=$mostrar['enviados'];
                $noenviados+=$mostrar['noenviados'];    
                $conerrores+=$mostrar['errores'];    
                $registrados+=$mostrar['registrados'];  
                $anulados+=$mostrar['estado'];           
                $i = $i + 1;
            }
        } else {
            echo '
         <tbody id="detalle-lista">
            <tr>
                        <td ></td>
                        <td ></td>
                        <td ></td>
                        <td ></td>
                        <td ></td>
                        <td ></td>
                  </tr>';
        }
        echo '</tbody>';
        echo '<tfoot>
                <tr>
                   <th >TOTALES:</th>
                   <th style="text-align: center;font-weight: bold;">' . $enviados . '</th>
                   <th style="text-align: center;font-weight: bold;">' . $noenviados . '</th>
                   <th style="text-align: center;font-weight: bold;">' . $conerrores. '</th>
                   <th style="text-align: center;font-weight: bold;">' . $registrados . '</th>
                   <th style="text-align: center;font-weight: bold;">' . $anulados . '</th>
                </tr>
               </tfoot>';

    break;


    case 'inicio':

        //----------------- LISTAR ENVIADOS ---------------------//
        $myquery = "select DISTINCT (select count(t2.cat1) as tipo from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='01' and t1.cdr=1    AND t1.rucempresa='$rucempresa') as f,
        (select count(t2.cat1) as tipo from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='03' and t1.cdr=1    AND t1.rucempresa='$rucempresa') as b,
        (select count(t2.cat1) as tipo from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='07' and t1.cdr=1   AND t1.rucempresa='$rucempresa') as nc,
        (select count(t2.cat1) as tipo from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='08' and t1.cdr=1   AND t1.rucempresa='$rucempresa') as nd
          from resumen ";

        $resultado = $mysqli->query($myquery);
        $row = mysqli_fetch_array($resultado);

        //----------------- LISTAR NO ENVIADOS ---------------------//
        $myquery2 = "select DISTINCT (select count(t2.cat1) as tipo from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='01' and t1.cdr=0   AND t1.rucempresa='$rucempresa') as fn,
        (select count(t2.cat1) as tipo from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='03' and t1.cdr=0   AND t1.rucempresa='$rucempresa') as bn,
        (select count(t2.cat1) as tipo from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='07' and t1.cdr=0  AND t1.rucempresa='$rucempresa') as ncn,
        (select count(t2.cat1) as tipo from resumen as t1
        inner join numeracion as t2 on t2.id = t1.idnum
        where t2.cat1='08' and t1.cdr=0   AND t1.rucempresa='$rucempresa') as ndn
        from resumen ";

        $resultado2 = $mysqli->query($myquery2);
        $row2 = mysqli_fetch_array($resultado2);

        //----------------- LISTAR CON ERRORES ---------------------//
        $myquery3 = "select DISTINCT (select count(t2.cat1) as tipo from resumen as t1
                inner join numeracion as t2 on t2.id = t1.idnum
                where t2.cat1='01' and t1.cdr=2  AND t1.rucempresa='$rucempresa') as fe,
                (select count(t2.cat1) as tipo from resumen as t1
                inner join numeracion as t2 on t2.id = t1.idnum
                where t2.cat1='03' and t1.cdr=2  AND t1.rucempresa='$rucempresa') as be,
                (select count(t2.cat1) as tipo from resumen as t1
                inner join numeracion as t2 on t2.id = t1.idnum
                where t2.cat1='07' and t1.cdr=2  AND t1.rucempresa='$rucempresa') as nce,
                (select count(t2.cat1) as tipo from resumen as t1
                inner join numeracion as t2 on t2.id = t1.idnum
                where t2.cat1='08' and t1.cdr=2  AND t1.rucempresa='$rucempresa') as nde
                from resumen ";

        $resultado3 = $mysqli->query($myquery3);
        $row3 = mysqli_fetch_array($resultado3);

        $lista = array(); //creamos un array
        $lista[] = array('f' => $row[0],
            'b' => $row[1],
            'nc' => $row[2],
            'nd' => $row[3],
            'fn' => $row2[0],
            'bn' => $row2[1],
            'ncn' => $row2[2],
            'ndn' => $row2[3],
            'fe' => $row3[0],
            'be' => $row3[1],
            'nce' => $row3[2],
            'nde' => $row3[3]
        );
        //Creamos el JSON
        $json_string = json_encode($lista);
        echo $json_string;

        break;
}

mysqli_close($mysqli);
