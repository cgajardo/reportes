<html>
    <script>
        function asd(x){
            location.href(x);
        }
    </script>
<h1>Bienvenido</h1>
<p>Prueba ingresando como:</p>
<h4>Alumnos:</h4>
<select onchange="asd(this.value)">
    <option>SELECT</option>
    <?php 
        foreach ($alumnos as $alumno) {
            $aux = explode('_', $alumno->identificadorMoodle);
            echo '<option value="'.$encrypter->encode('platform='.$aux[0].'&user='.$alumno->usuario).'">'.$alumno->nombre.' '.$alumno->apellido.'</option>';
        }
    ?>
</select>
<br/>
<h4>Profesores:</h4>
<select onchange="function(){this.value);}">
    <option>SELECT</option>
    <?php 
        foreach ($profesores as $profesor) {
            $aux = explode('_', $profesor->identificadorMoodle);
            echo '<option value=enrutador/index?"'.$encrypter->encode('platform='.$aux[0].'&user='.$profesor->usuario).'">'.$profesor->nombre.' '.$profesor->apellido.'</option>';
        }
    ?>
</select>
<ul>
	<!--leonelo.iturriaga-->
  <li><a href="./enrutador/index?params=lnFtbVjp2gnQMUkAa_1qgT64fPt6LOGcDIfDzlsT7tmoCymvCIzWgw">Instituto-IPCHILE</a></li>
</ul>
<h4>Rectores:</h4>
<ul>
  <li><a href="./enrutador/index?params=lnFtbVjp2gnQMUkAa_1qgT64fPt6LOGcb16Nv4HV34APu_S5T6CYJg">Instituto-IPCHILE</a></li>
</ul>
</html>
