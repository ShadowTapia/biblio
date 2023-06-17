<html>
<header class="clearfix">
    <div style="text-align: center;">
        <h3>Código <?php echo $titulo ?></h3>
    </div>
</header>
<main>
    <div id="showBarcode">
    </div>
    <div><?php echo $codigo ?></div>
    <div><?php echo $titulo ?></div>
</main>

</html> <!--This element id should be passed on to options-->
<?php

use barcode\barcode\BarcodeGenerator as BarcodeGenerator;

$optionsArray = array(
    'elementId' => 'showBarcode', /* div or canvas id*/
    'value' => $id, /* value for EAN 13 be careful to set right values for each barcode type */
    'type' => 'code128',/*supported types  ean8, ean13, upc, std25, int25, code11, code39, code93, code128, codabar, msi, datamatrix*/
    'settings' => array(
        'showHRI' => false,
    ),
);
echo BarcodeGenerator::widget($optionsArray);
?>