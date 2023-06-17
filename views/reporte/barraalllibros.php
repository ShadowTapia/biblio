<?php

use yii\helpers\Html;
use barcode\barcode\BarcodeGenerator as BarcodeGenerator;

?>
<html>

<body>
  <header class="clearfix">
    <div style="text-align: center;">
      <h1>Códigos de Barra Ejemplares</h1>
    </div>
  </header>
  <main>
    <table>
      <tbody>
        <table>
          <?php
          $contador = 0;
          foreach ($ejemplares as $ejemplar) {
            $contador++;
          ?>
            <?php
            if (($contador % 5) == 0) { ?>
              <tr>
              <?php
            }
              ?>
              <td style="padding-left: 15px;padding-right:15px;">
                <div id="barcode-div<?php echo $contador ?>"></div>
                <div><?= $ejemplar->norden ?></div>
                <div><?= $ejemplar->idLibros0->titulo ?></div>
              </td>
              <?php
              $optionsArray = array(
                'elementId' => 'barcode-div' . $contador, /* div or canvas id*/
                'value' => $ejemplar["idejemplar"], /* value for EAN 13 be careful to set right values for each barcode type */
                'type' => 'code128',/*supported types  ean8, ean13, upc, std25, int25, code11, code39, code93, code128, codabar, msi, datamatrix*/
                'settings' => array(
                  'showHRI' => false,
                ),
              );
              echo BarcodeGenerator::widget($optionsArray);
              ?>
              <?php
              if (($contador % 5) == 0) { ?>
              </tr>
            <?php
              }
            ?>
          <?php
          }
          ?>


        </table>
      </tbody>
    </table>
  </main>
  <footer>
    <?php
    Html::encode("The Kingstown School - Fundación Educacional Bosques de Santa Julia 2023.");
    ?>
  </footer>
</body>

</html>