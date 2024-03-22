<?php

namespace JunkRoot\Pdf\renderer;

class ParagraphRenderer {
    public function render($content, $x = 50, $y = 720) {
        $pdf_content = '';
        preg_match_all('/<p>(.*?)<\/p>/', $content, $matches);
        foreach ($matches[1] as $text) {
            $pdf_content .= "BT\n/F1 12 Tf\n{$x} {$y} Td\n(" . htmlspecialchars($text) . ") Tj\nET\n";
            $y -= 15;
        }
        return $pdf_content;
    }
}