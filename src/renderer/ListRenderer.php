<?php

namespace JunkRoot\Pdf\renderer;

class ListRenderer {
    public function render($content, $x = 50, $y = 700) {
        $pdf_content = '';
        preg_match_all('/<ul>(.*?)<\/ul>/', $content, $matches);
        foreach ($matches[1] as $list) {
            preg_match_all('/<li>(.*?)<\/li>/', $list, $listItems);
            foreach ($listItems[1] as $item) {
                $pdf_content .= "BT\n/F1 12 Tf\n{$x} {$y} Td\n• " . htmlspecialchars($item) . "\nET\n";
                $y -= 15;
            }
        }
        return $pdf_content;
    }
}
