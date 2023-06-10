<?php
require_once '../conexion.php';
require_once '../usuarios/sesiones.php';
date_default_timezone_set('America/Lima');

$mysqli = conectar();
$boton = $_POST['boton'];
switch ($boton) {

    //https://fontawesome.com/v3.2.1/icons/
    //https://fontawesome.com/v4.7.0/icons/

    case 'tipo-comp':

        $myquery = "SELECT * FROM catalogo_01 where estado=1";
        $resultado = $mysqli->query($myquery);

        while ($fila = $resultado->fetch_assoc()) {
            echo '<option value="' . $fila['id'] . '">' . $fila['detalle'] . '</option>';
        }

        break;

    case 'cat7':

        $myquery = "SELECT * FROM catalogo_07 where estado=1";
        $resultado = $mysqli->query($myquery);

        while ($fila = $resultado->fetch_assoc()) {
            echo '<option value="' . $fila['id'] . '">' . $fila['detalle'] . '</option>';
        }

        break;

    case 'cat6':

        $myquery = "SELECT * FROM catalogo_06 where estado=1";
        $resultado = $mysqli->query($myquery);

        while ($fila = $resultado->fetch_assoc()) {
            echo '<option value="' . $fila['id'] . '">' . $fila['detalle'] . '</option>';
        }

        break;

    case 'dpt':

        $myquery = "SELECT * FROM catalogo_13_dpt where estado=1";
        $resultado = $mysqli->query($myquery);

        while ($fila = $resultado->fetch_assoc()) {
            echo '<option value="' . $fila['id'] . '">' . $fila['detalle'] . '</option>';
        }

        break;

    case 'series':
        $codigo = $_POST['codigo'];
        $rucemisor = LoadSession();
        $myquery = "SELECT * FROM numeracion where cat1='$codigo' and nruc='$rucemisor'";
        $resultado = $mysqli->query($myquery);

        while ($fila = $resultado->fetch_assoc()) {
            echo '<option value="' . $fila['id'] . '">' . $fila['serie'] . '</option>';
        }

        break;

    case 'moneda':

        $myquery = "SELECT * FROM catalogo_02  where estado=1";
        $resultado = $mysqli->query($myquery);

        while ($fila = $resultado->fetch_assoc()) {
            echo '<option value="' . $fila['id'] . '">' . $fila['simbolo'] . '</option>';
        }

        break;

    case 'tipo-pago':

        $myquery = "SELECT * FROM tb_tipopago where estado=1";
        $resultado = $mysqli->query($myquery);

        while ($fila = $resultado->fetch_assoc()) {
            echo '<option value="' . $fila['id'] . '">' . $fila['detalle'] . '</option>';
        }

        break;

    case 'print':

        $myquery = "SELECT * FROM tipoimpresion  where estado=1";
        $resultado = $mysqli->query($myquery);

        while ($fila = $resultado->fetch_assoc()) {
            echo '<option value="' . $fila['id'] . '">' . $fila['detalle'] . '</option>';
        }

        break;

    case 'dir-empresa':
        $codigo = $_POST['codigo'];
        $myquery = "SELECT * FROM direccion_empresa  where rucempresa='$codigo'";
        $resultado = $mysqli->query($myquery);

        while ($fila = $resultado->fetch_assoc()) {
            echo '<option value="' . $fila['id'] . '">' . $fila['dir'] . '</option>';
        }

        break;

    case 'n-credito':

        $myquery = "SELECT * FROM catalogo_09 where estado=1 ";
        $resultado = $mysqli->query($myquery);

        while ($fila = $resultado->fetch_assoc()) {
            echo '<option value="' . $fila['id'] . '">' . $fila['detalle'] . '</option>';
        }

        break;

    case 'n-debito':

        $myquery = "SELECT * FROM catalogo_10 where estado=1 ";
        $resultado = $mysqli->query($myquery);

        while ($fila = $resultado->fetch_assoc()) {
            echo '<option value="' . $fila['id'] . '">' . $fila['detalle'] . '</option>';
        }

        break;

    case 'lista-dir-cli':
        $codigo = $_POST['codigo'];
        $myquery = "SELECT t1.id,t1.dir, t6.detalle as dpt,t5.detalle as prov,t4.detalle as dist
       FROM direccion_cliente AS t1
		INNER JOIN catalogo_13_dist as t4 on t4.id =t1.idubigeo
		INNER JOIN catalogo_13_prov as t5 on t5.id =t4.idprov
		INNER JOIN catalogo_13_dpt as t6 on t6.id =t5.iddpt
      WHERE t1.idcliente='$codigo' and t1.tipo ='S'";
        $resultado = $mysqli->query($myquery);

        if ($resultado->num_rows > 0) {
            while ($mostrar = $resultado->fetch_array()) {
                $i = 1;

                echo '
                    <tr>

                      <td >' . $mostrar['id'] . '</td>
                      <td style="text-align: left;">
                      <div class="btn-group">
                      <div  class="dropdown">
                       <button  class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-bars"></i> <span class="caret"></span></button>
                         <ul class="dropdown-menu" >
                          <li><a href="javascript:eddocumento(/' . $mostrar['id'] . '/);"><span class="fa fa-edit"></span>  Editar</a></li>
                          <li><a href="javascript:deldocumento(/' . $mostrar['id'] . '/);"><span class="fa fa-trash-o"></span>  Eliminar</a></li>
                          </ul>
                      </div>
                      </div>

                      </td>

                      <td >' . $mostrar['dir'] . '</td>
                      <td >' . $mostrar['dpt'] . '</td>
                      <td >' . $mostrar['prov'] . '</td>
                      <td >' . $mostrar['dist'] . '</td>

                     </tr>';
                $i = $i + 1;
            }
        } else {
            echo '<tr>
                        <td ></td>
                        <td ></td>
                        <td ></td>
                        <td ></td>
                        <td ></td>
                        <td ></td>
                  </tr>';
        }

        break;

    case 'lista-dir-emp':
        $codigo = $_POST['codigo'];
        $myquery = "SELECT t1.id,t1.dir, t6.detalle as dpt,t5.detalle as prov,t4.detalle as dist
             FROM direccion_empresa AS t1
              INNER JOIN catalogo_13_dist as t4 on t4.id =t1.idubigeo
              INNER JOIN catalogo_13_prov as t5 on t5.id =t4.idprov
              INNER JOIN catalogo_13_dpt as t6 on t6.id =t5.iddpt
            WHERE t1.rucempresa='$codigo' and t1.tipo ='S'";
        $resultado = $mysqli->query($myquery);

        if ($resultado->num_rows > 0) {
            while ($mostrar = $resultado->fetch_array()) {
                $i = 1;

                echo '
                          <tr>

                            <td >' . $mostrar['id'] . '</td>
                            <td style="text-align: left;">
                            <div class="btn-group">
                            <div  class="dropdown">
                             <button  class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-bars"></i> <span class="caret"></span></button>
                               <ul class="dropdown-menu" >
                                <li><a href="javascript:eddocumento(/' . $mostrar['id'] . '/);"><span class="fa fa-edit"></span>  Editar</a></li>
                                <li><a href="javascript:deldocumento(/' . $mostrar['id'] . '/);"><span class="fa fa-trash-o"></span>  Eliminar</a></li>
                                </ul>
                            </div>
                            </div>

                            </td>
                            <td >' . $mostrar['dir'] . '</td>
                            <td >' . $mostrar['dpt'] . '</td>
                            <td >' . $mostrar['prov'] . '</td>
                            <td >' . $mostrar['dist'] . '</td>

                           </tr>';
                $i = $i + 1;
            }
        } else {
            echo '<tr>
                  <td ></td>
                  <td ></td>
                  <td ></td>
                  <td ></td>
                  <td ></td>
                  <td ></td>
                          </tr>';
        }

        break;

    case 'lista-cab':
        $rucempresa= $_POST['rucempresa'];
        $myquery = "SELECT t1.id, t1.llave, t1.fechaem, t1.idcliente,t2.doc, t2.nom, t1.idmon, t1.tc,
        t3.detalle as detpago, t1.total,
        if(t1.cdr=2,'<h2 class=" . '"label label-danger"' . ">CPE con errores</h2>',
         if(t1.cdr=1,'<h2 class=" . '"label label-success"' . ">Enviado a SUNAT</h2>',
         '<h2 class=" . '"label label-primary"' . ">Xml Generado y Firmado</h2>')) AS estado,
         if(t1.estadoemail=1,'<h2 class=" . '"label label-success"' . ">Correo Enviado</h2>',
         '<h2 class=" . '"label label-danger"' . ">Correo no Enviado</h2>') AS estadoemail,
          if(t1.estadocpe=0,'<h2 class=" . '"label label-success"' . ">Activo</h2>',
          '<h2 class=" . '"label label-danger"' . ">Anulado</h2>') AS estadocpe,
          t1.cdr as es_cdr, t1.estadoemail as es_em, t1.estadocpe as es_cpe,t2.email,t1.nticket
         from resumen as t1
          inner join clientes as t2 on t2.id = t1.idcliente
           inner join tb_tipopago as t3 on t3.id = t1.idpago".
          " WHERE rucempresa ='$rucempresa' order by fechaem,llave asc";
        $resultado = $mysqli->query($myquery);

        if ($resultado->num_rows > 0) {
            while ($mostrar = $resultado->fetch_array()) {
                $i = 1;

                if ($mostrar['es_cdr'] == 1) {
                    $icon = "fa fa-check";
                    $color = "btn btn-icon btn-round btn-success btn-xs";
                } else {
                    $icon = "fa fa-times";
                    $color = "btn btn-icon btn-round btn-danger btn-xs";
                }

                echo '
                          <tr>

                            <td >' . $mostrar['id'] . '</td>
                            <td style="text-align: left;">
                            <div class="btn-group">
                            <div  class="dropdown">
                             <button  class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-bars"></i> <span class="caret"></span></button>
                               <ul class="dropdown-menu" >
                                <li><a href="javascript:eddocumento(/' . $mostrar['llave'] . '/,' . $mostrar['es_cdr'] . ');"><span class="fa fa-edit"></span>  Editar</a></li>
                                <li><a href="javascript:deldocumento(/' . $mostrar['llave'] . '/,' . $mostrar['es_cdr'] . ');"><span class="fa fa-trash-o"></span>  Eliminar</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="javascript:envdocumento(/' . $mostrar['llave'] . '/,' . $mostrar['es_cdr'] . ');"><span class="fa fa fa-cloud"></span>  Enviar a Sunat</a></li>
                                <li><a href="javascript:anuldocumento(/' . $mostrar['llave'] . '/,' . $mostrar['es_cdr'] . ',' . $mostrar['es_cpe'] . ',' . $mostrar['nticket'] . ');"><span class="fa fa fa-clone"></span>  Anular Comprobante</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="javascript:errdocumento(/' . $mostrar['llave'] . '/);"><span class="fa fa-trash"></span>  Ver Errores</a></li>
                                </ul>
                            </div>
                            </div>
                            <button onclick="AbrirCorreo_2(/' . $mostrar['llave'] . $mostrar['email'] . '/);" type="button" class="btn btn-icon btn-round btn-info btn-xs">
                            <i class="fa fa-envelope-o"></i>
                           </button>
                            <button onclick="ver_Pdf(/' . $mostrar['llave'] . '/);" type="button" class="btn btn-icon btn-round btn-warning btn-xs">
                             <i class="fa fa-file-pdf-o"></i>
                            </button>
                            <button onclick="ver_Xml(/' . $mostrar['llave'] . '/);" type="button" class="btn btn-icon btn-round btn-primary btn-xs">
                             <i class="fa fa-file-code-o"></i>
                            </button>
                            <button id="a"  onclick="ver_Cdr(/' . $mostrar['llave'] . '/);" type="button" class="' . $color . '">
                             <i class="' . $icon . '"></i>
                            </button>

                            </td>

                            <td style="text-align: center;">' . $mostrar['llave'] . '</td>
                            <td style="text-align: center">' . $mostrar['fechaem'] . '</td>
                            <td style="text-align: center;">' . $mostrar['doc'] . '</td>
                            <td style="text-align: center;">' . $mostrar['nom'] . '</td>
                            <td style="text-align: center;">' . $mostrar['idmon'] . '</td>
                            <td style="text-align: center;">' . $mostrar['tc'] . '</td>
                            <td style="text-align: center;">' . $mostrar['detpago'] . '</td>
                            <td style="text-align: right;">' . $mostrar['total'] . '</td>
                            <td style="text-align: center;">' . $mostrar['estado'] . '</td>
                            <td style="text-align: center;">' . $mostrar['estadoemail'] . '</td>
                            <td style="text-align: center;">' . $mostrar['estadocpe'] . '</td>

                           </tr>';
                $i = $i + 1;
            }
        } else {
            echo '<tr>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td ></td>
                          </tr>';
        }

        echo '</table>';

        break;

    case 'lista-nota':
        $codigo = $_POST['codigo'];
        $rucempresa= $_POST['rucempresa'];
        $myquery = "SELECT t1.id, t1.llave, t1.fechaem, t2.doc, t1.total , t2.nom, mid(t1.llave,13,2) as tipo, t1.cdr
        from resumen as t1
         inner join clientes as t2 on t2.id = t1.idcliente
         where mid(t1.llave,13,2)='$codigo' and t1.cdr=1 and  rucempresa='$rucempresa'  order by id desc";
        $resultado = $mysqli->query($myquery);

        if ($resultado->num_rows > 0) {
            while ($mostrar = $resultado->fetch_array()) {
                $i = 1;

                echo '
                    <tr>


                      <td style="text-align: left;">

                      <button onclick="add_referencia(/' . $mostrar['llave'] . '/);" type="button" class="btn btn-icon btn-round btn-success btn-xs">
                       <i class="fa fa-check-square-o"></i>
                      </button>

                      </td>
                      <td style="text-align: center;">' . $mostrar['llave'] . '</td>
                      <td style="text-align: center">' . $mostrar['fechaem'] . '</td>
                      <td style="text-align: center;">' . $mostrar['doc'] . '</td>
                      <td style="text-align: center;">' . $mostrar['nom'] . '</td>
                      <td style="text-align: right;">' . $mostrar['total'] . '</td>

                     </tr>';
                $i = $i + 1;
            }
        } else {
            echo 'error';
        }

        break;

    case 'lista-editar':
        $codigo = $_POST['codigo'];
        $myquery = "SELECT t2.idprod, t3.idunidad, t3.detalle, t3.cat7, t2.cantidad
        ,t2.punitario,t2.vunitario,t2.igv,t2.preciototal,t2.valortotal
        ,t3.cod,t3.idsunat,t2.porc,t3.impuesto
        from resumen as t1
        inner join detalle as t2 on t2.idllave = t1.llave
       inner join items as t3 on t3.id = t2.idprod
        where t1.llave='$codigo' ";

        $resultado = $mysqli->query($myquery);

        if ($resultado->num_rows > 0) {
            while ($mostrar = $resultado->fetch_array()) {
                $i = 1;

                echo '
                 <tr>
                   <td><button  type="button" class="btn-xs btn-info btn-edit"><span class="glyphicon glyphicon-pencil"></span></button></td>
                   <td><button type="button" class="btn-xs btn-danger btn-delete"><span class="glyphicon glyphicon-remove"></button></td>
                   <td style="display:none;" >' . $mostrar['idprod'] . '</td>
                   <td class="text-left">' . $mostrar['idunidad'] . '</td>
                   <td class="text-left">' . $mostrar['detalle'] . '</td>
                   <td class="text-center">' . $mostrar['cat7'] . '</td>
                   <td class="text-center">' . $mostrar['cantidad'] . '</td>
                   <td class="text-right">' . $mostrar['punitario'] . '</td>
                   <td class="text-right">' . $mostrar['vunitario'] . '</td>
                   <td class="text-right">' . $mostrar['igv'] . '</td>
                   <td class="text-right">' . $mostrar['preciototal'] . '</td>
                   <td style="display:none;">' . $mostrar['valortotal'] . '</td>
                   <td style="display:none;">' . $mostrar['cod'] . '</td>
                   <td style="display:none;">' . $mostrar['idsunat'] . '</td>
                   <td style="display:none;">' . $mostrar['porc'] . '</td>
                   <td style="display:none;">' . $mostrar['impuesto'] . '</td>

                  </tr>';
                $i = $i + 1;
            }
        } else {
            echo 'error';
        }

        break;

    default:
        # code...
        break;
}

mysqli_close($mysqli);
