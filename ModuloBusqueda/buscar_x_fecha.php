<?php
session_start();
if(isset($_SESSION['busqueda']))
{
require_once 'Model/conexion.class.php';
$link = new conexionclass();
$link->conectarse();

$dia=$_REQUEST['dia'];
$mes=$_REQUEST['mes'];
$year=$_REQUEST['year'];

if($dia <> "" and $mes <> "" and $year <> "" ){
    $fecha=$year."-".$mes."-".$dia;
    $consulta123 = "SELECT cod_sct, cod_not, num_sct, cod_dst, fec_doc, cod_sub, nom_bie, can_fol, cod_pro, obs_sct, num_fol FROM dbarp.escrituras1 WHERE fec_doc ='$fecha' LIMIT 0, 150";
    $result=mysql_query($consulta123);
    $cons_total = "SELECT COUNT(*) FROM dbarp.escrituras1 WHERE fec_doc LIKE '$fecha'";
    $Res_Total = mysql_query($cons_total); $total=mysql_fetch_array($Res_Total) ;
    
    $num = mysql_num_rows($result);
}

if($dia == ""){
        $fecha=$year."-".$mes."-"."%";
        $consulta123 = "SELECT cod_sct, cod_not, num_sct, cod_dst, fec_doc, cod_sub, nom_bie, can_fol, cod_pro, obs_sct, num_fol FROM dbarp.escrituras1 WHERE fec_doc LIKE '$fecha' LIMIT 0,150";
        $cons_total = "SELECT COUNT(*) FROM dbarp.escrituras1 WHERE fec_doc LIKE '$fecha'";
        $Res_Total = mysql_query($cons_total); $total=mysql_fetch_array($Res_Total) ;

        $result=mysql_query($consulta123);
        $num = mysql_num_rows($result);
        
}

if($dia == "" and $mes == 0){
        $fecha=$year."-"."%"."-"."%";
        $consulta123 = "SELECT cod_sct, cod_not, num_sct, cod_dst, fec_doc, cod_sub, nom_bie, can_fol, cod_pro, obs_sct, num_fol FROM dbarp.escrituras1 WHERE fec_doc LIKE '$fecha' LIMIT 0, 200";
        $cons_total = "SELECT COUNT(*) FROM dbarp.escrituras1 WHERE fec_doc LIKE '$fecha'";
        $Res_Total = mysql_query($cons_total); $total=mysql_fetch_array($Res_Total) ;
        $result=mysql_query($consulta123);
        $num = mysql_num_rows($result);
}

if($num > 0){
}
else
{
	$error="La Fecha colocada, no Existen en la Base de Datos.  Intente con otra fecha.\n El Administrador.";
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="css/busquedas2.css" />
<title>Busqueda - Archivo Regional de Puno</title>
</head>
<body>
<form id="form1" name="form1" method="post" action="">
  <table>
  	<caption><?php echo "Se han encontrado :".$total[0]." escrituras, Mostrandose <span id='error'>".$num."</span> coincidencias con la fecha \"".$fecha."\"."?></caption>
    <thead>
    <tr>
      <th width="33">Dia</th>
      <th width="79">Mes</th>
      <th width="38">A&ntilde;o</th>
      <th width="705">
          <input name="regresar" type="button" onClick="javascript:location.href='./index_old.php'" value="Salir" /> <input name="btnsalir" type="button" class="boton" id="btnsalir" onClick="javascript:location.href='./buscar_index.php'" value="Salir de Busqueda" /></th>
    </tr>
    </thead>
    <tr>
      <td><input name="dia" type="text" id="dia" size="2" maxlength="2" /></td>
      <td><select name="mes" id="mes">
        <option value="0">--</option>
        <option value="01">Ene</option>
        <option value="02">Feb</option>
        <option value="03">Mar</option>
        <option value="04">Abr</option>
        <option value="05">May</option>
        <option value="06">Jun</option>
        <option value="07">Jul</option>
        <option value="08">Ago</option>
        <option value="09">Set</option>
        <option value="10">Oct</option>
        <option value="11">Nov</option>
        <option value="12">Dic</option>
      </select></td>
      <td><input name="year" type="text" id="year" size="4" maxlength="4" /></td>
      <td><input name="buscar" type="submit" id="buscar" value="Buscar" /></td>
    </tr>
  </table>
</form>
<table width="1705" border="1">
  <tr>
    <td width="35">Num</td>
    <td width="75">Notario</td>
    <td width="123">Protocolo</td>
    <td width="139">Fecha </td>
    <td width="164">Sub Serie</td>
    <td width="360">Nombre Predio </td>
    <td width="324">Otorgante</td>
    <td width="362">Favorecido</td>
    <td width="65">&nbsp;</td>
  </tr>
  <?php
    $i=1;
  while(@$fila=mysql_fetch_array($result)){
  $datosEscritura=array("cod_sct"=>$fila[0],"notario"=>$fila[1],"escritura"=>$fila[2],"distrito"=>$fila[3],"fecha"=>$fila[4],"subserie"=>$fila[5],"bien"=>$fila[6],"cantFolios"=>$fila[7],"protocolo"=>$fila[8],"obs"=>$fila[9],"numFolios"=>$fila[10]);
  $Escritura=$datosEscritura["cod_sct"];
  ?>
  <tr>
    <td><?php echo $i;?></td>
    <td><?php echo $datosEscritura["notario"];?></td>
    <td><?php echo $datosEscritura["protocolo"];?></td>
    <td><?php echo $datosEscritura["fecha"];?></td>
    <td><?php $sub=$datosEscritura["subserie"];
      /* @var $datosEscritura <type> */
	  $Sis="SELECT des_sub FROM subseries WHERE cod_sub = '$sub'";
	  $Sis1 = mysql_query($Sis);
	  $Sto = mysql_fetch_array($Sis1);
	  echo $Sto[0];
	  ?></td>
    <td><?php echo $datosEscritura["bien"];?></td>
    <td><?php
        
        $con_15="SELECT cod_sct,cod_inv,cod_inv_ju FROM escriotor1 WHERE cod_sct = '$Escritura'";
	$q15=mysql_query($con_15);
	$a15=mysql_fetch_array($q15);
	$array_o= array("cod_sct"=>$a15[0],"cod_inv"=>$a15[1],"codInvJur"=>$a15[2]);
        $var1=$array_o["cod_inv"];
        $var2=$array_o["codInvJur"];
        $q_oto="SELECT a.Cod_inv, CONCAT(a.Nom_inv,' ',a.Pat_inv,' ',a.Mat_inv),b.Cod_inv, b.Raz_inv FROM involucrados1 as a, involjuridicas1 as b WHERE a.cod_inv = '$var1'";

        $query1=mysql_query($q_oto) or die (mysql_error()." Error Buscado otorgante");
	$r1=mysql_fetch_array($query1);
	echo $r1[1];
        if($var2<>0){
            $RESULT = "SELECT Cod_inv, Raz_inv FROM involjuridicas1 WHERE Cod_inv = '$var2'";
            $QUERY=mysql_query($RESULT);
            $FILA=mysql_fetch_array($QUERY);
            echo $FILA[1];
        }
    ?></td>
    <td><?php
        $con_2="SELECT cod_sct,cod_inv,cod_inv_ju FROM escrifavor1 WHERE cod_sct ='$Escritura'";
	$q2=mysql_query($con_2);
	$a2=mysql_fetch_array($q2);
        $array_f= array("cod_sct"=>$a2[0],"cod_inv"=>$a2[1],"codInvJur"=>$a2[2]);
        $var3=$array_f["cod_inv"];
        $var4=$array_f["codInvJur"];
        $q_fav="SELECT a.Cod_inv, CONCAT(a.Nom_inv,' ',a.Pat_inv,' ',a.Mat_inv), b.Cod_inv, b.Raz_inv FROM involucrados1 as a, involjuridicas1 as b WHERE a.cod_inv = '$var3'";

        $query2=mysql_query($q_fav) or die (mysql_error()." Error Buscado Favorecido");
	$r2=mysql_fetch_array($query2);
	echo $r2[1];
        if($var4<>0){
            $RESULT2 = "SELECT Cod_inv, Raz_inv FROM involjuridicas1 WHERE Cod_inv = '$var4'";
            $QUERY2=mysql_query($RESULT2);
            $FILA2=mysql_fetch_array($QUERY2);
            echo $FILA2[1];
        }
    ?></td>
    <td><a href="./buscarSct_x_Fecha.php?cod_otor=<?php echo $var1;?>&cod_favor=<?php echo $var3;?>&cod_otor_ju=<?php echo $var2;?>&cod_favor_ju=<?php echo $var4;?>&cod_sct=<?php echo $Escritura;?>">Detalles</a></td>
  </tr>
  <?php
  $i=$i+1;
  }
  ?>
</table>
<?php
if ($error == ""){
}
else
	{
	echo $error;
	}
?>
</body>
</html>
<?php
}
else
{
   header("Location: ../arpweb/index.htm");
}
?>