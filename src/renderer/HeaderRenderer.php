<?php

namespace JunkRoot\Pdf\renderer;

class HeaderRenderer {
    public function render($content, $x = 50, $y = 750) {
        $pdf_content = '';
        // Loop through header tags from <h1> to <h6>
        for ($i = 1; $i <= 6; $i++) {
            preg_match_all("/<h{$i}>(.*?)<\/h{$i}>/", $content, $matches);
            foreach ($matches[1] as $text) {
                // Adjust font size based on header level
                $font_size = 24 - ($i - 1) * 2; // Decrease font size for lower-level headers
                $pdf_content .= "BT\n/F1 $font_size Tf\n{$x} {$y} Td\n(" . htmlspecialchars($text) . ") Tj\nET\n";
                $y -= $font_size * 1.2; // Adjust vertical position based on font size
            }
        }
        return $pdf_content;
    }
}
