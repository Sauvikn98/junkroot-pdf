<?php

require_once 'vendor/autoload.php';

$generator = new JunkRoot\Pdf\PDFGenerator('example.pdf');
$generator->addContent(
'<h1>Hello, World!</h1>
 <p>Hello, World</p>
<ul>
 <li> Item1 </li>
 <li> Item2 </li>
 <li> Item3 </li>
 <li> Item4 </li>
 <li> Item5 </li>
</ul>

');
$generator->generatePDF();