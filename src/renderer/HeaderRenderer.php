<?php

namespace JunkRoot\Pdf\renderer;

class HeaderRenderer {
    public function render($content, $x = 50, $y = 750) {
        $pdf_content = '';
        preg_match_all('/<h1>(.*?)<\/h1>/', $content, $matches);
        foreach ($matches[1] as $text) {
            $pdf_content .= "BT\n/F1 24 Tf\n{$x} {$y} Td\n(" . htmlspecialchars($text) . ") Tj\nET\n";
            $y -= 30;
        }
        return $pdf_content;
    }
}
