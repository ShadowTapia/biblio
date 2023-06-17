<?php

use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 29-04-2020
 * Time: 0:28
 */

function getPlantilla($alumnos, $curso)
{

  $plantilla = '<body>
    <header class="clearfix">
       <div style="text-align: center"><h1>Listado ' . $curso . '</h1></div>      
    </header>
    <main>
          
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">#</th>
            <th class="unit">RUN</th>
            <th class="qty">PATERNO</th>
            <th class="qty">MATERNO</th>
            <th class="qty">NOMBRE</th>            
          </tr>
        </thead>
        <tbody>';
  $contador = 0;
  foreach ($alumnos as $pupils) {
    $contador++;
    $plantilla .= '<tr>
            <td class="no">' . $contador . '</td>
            <td class="unit">' . number_format($pupils["rutalumno"], 0, ",", ".") . "-" . $pupils["digrut"] . '</td>    
            <td class="qty">' . $pupils["paternoalu"] . '</td>
            <td class="qty">' . $pupils["maternoalu"] . '</td>
            <td class="qty">' . $pupils["nombrealu"] . '</td>
          </tr>';
  }

  $plantilla .= '</tbody>        
      </table>
      
    </main>
    <footer>';
  $plantilla .= Html::encode("The Kingstown School - Fundación Educacional Bosques de Santa Julia 2020.") . '
        
    </footer>
  </body>';

  return $plantilla;
}
