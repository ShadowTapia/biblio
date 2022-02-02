<?php

function getPlantilla($profes)
{
    
    $plantilla = '<body>
    <header class="clearfix">
       <div style="text-align: center"><h1>Listado de Docentes</h1></div>      
    </header>
    <main>
          
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">#</th>
            <th class="desc">RUN</th>
            <th class="unit">NOMBRE</th>
            <th class="qty">EMAIL</th>
                        
          </tr>
        </thead>
        <tbody>';
        $contador=0;
        foreach ($profes as $docente){           
          $contador++;  
          $plantilla .= '<tr>
            <td class="no">'. $contador .'</td>
            <td class="desc">'. number_format($docente["rutdocente"],0,  ",",  ".") . "-". $docente["digito"].'</td>
            <td class="unit">'. strtoupper($docente["nombres"]) . " ". strtoupper($docente["paterno"]) . " ". strtoupper($docente["materno"]) . '</td>
            <td class="qty">'. $docente["email"] .'</td>
          </tr>';
        }
        
        $plantilla .= '</tbody>        
      </table>
      
    </main>
    <footer>';
        $plantilla .= "The Kingstown School - Fundación Educacional Bosques de Santa Julia 2019.".'
        
    </footer>
  </body>';

    return $plantilla;

}
