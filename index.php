<?php

require_once 'vendor/autoload.php';

$pdf = new JunkRoot\Pdf\PDFGenerator('example.pdf');


$html = '
<!DOCTYPE html>
<html>
<head>
    <title>Sample PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            color: blue;
        }
    </style>
</head>
<body>
    <h1>Sample PDF Document</h1>
    <p>This is a sample PDF generated using PHP without any external libraries.</p>
</body>
</html>
';

$pdf->addContent($html);
$pdf->generatePDF();