<?php

namespace JunkRoot\Pdf;

class PDFGenerator {
    protected $content;
    protected $filename;

    public function __construct($filename) {
        $this->filename = $filename;
        $this->content = '';
    }

    public function addContent($html) {
        $this->content .= $html;
    }

    public function generatePDF() {
        $pdf_content = $this->generatePdfContent();
        $this->writeToFile($pdf_content);
        echo "PDF generated successfully!";
    }

    private function generatePdfContent() {
        $pdf_content = "%PDF-1.4\n";
        $pdf_content .= $this->generateCatalogObject();
        $pdf_content .= $this->generatePagesObject();
        $pdf_content .= $this->generatePageObject();
        $pdf_content .= $this->generateFontObject();
        $pdf_content .= $this->generatePageContentObject();
        $pdf_content .= $this->generateCrossReferenceTable();
        $pdf_content .= $this->generateTrailer();
        return $pdf_content;
    }

    private function generateCatalogObject() {
        return "1 0 obj\n<< /Type /Catalog\n/Pages 2 0 R\n>>\nendobj\n";
    }

    private function generatePagesObject() {
        return "2 0 obj\n<< /Type /Pages\n/Kids [3 0 R]\n/Count 1\n>>\nendobj\n";
    }

    private function generatePageObject() {
        return "3 0 obj\n<< /Type /Page\n/Parent 2 0 R\n/Resources << /Font << /F1 4 0 R >> >>\n/MediaBox [0 0 595 842]\n/Contents 5 0 R\n>>\nendobj\n";
    }

    private function generateFontObject() {
        return "4 0 obj\n<< /Type /Font\n/Subtype /Type1\n/BaseFont /Helvetica\n>>\nendobj\n";
    }

    private function generatePageContentObject() {
        $html_content = $this->content;
        $pdf_content = '';

        $dom = new \DOMDocument();
        $dom->loadHTML($html_content);

        $pdf_content .= $this->renderDom($dom);

        return "5 0 obj\n<< /Length " . strlen($pdf_content) . " >>\nstream\n$pdf_content\nendstream\nendobj\n";
    }

    private function renderDom(\DOMDocument $dom, $x = 50, $y = 750) {
        $pdf_content = '';

        $xpath = new \DOMXPath($dom);

        // Render headers
        for ($i = 1; $i <= 6; $i++) {
            $headers = $xpath->query("//h$i");
            foreach ($headers as $header) {
                $font_size = 24 - ($i - 1) * 2;
                $pdf_content .= "BT\n/F1 $font_size Tf\n{$x} {$y} Td\n(" . htmlspecialchars($header->nodeValue) . ") Tj\nET\n";
                $y -= $font_size * 1.2;
            }
        }

        // Render paragraphs
        $paragraphs = $xpath->query("//p");
        foreach ($paragraphs as $paragraph) {
            $pdf_content .= "BT\n/F1 12 Tf\n{$x} {$y} Td\n(" . htmlspecialchars($paragraph->nodeValue) . ") Tj\nET\n";
            $y -= 15;
        }

        // Render lists
        $lists = $xpath->query("//ul/li");
        foreach ($lists as $list) {
            $pdf_content .= "BT\n/F1 12 Tf\n{$x} {$y} Td\n• " . htmlspecialchars($list->nodeValue) . "\nET\n";
            $y -= 15;
        }

        return $pdf_content;
    }

    private function generateCrossReferenceTable() {
        return "xref\n0 6\n0000000000 65535 f\n0000000009 00000 n\n0000000050 00000 n\n0000000104 00000 n\n0000000158 00000 n\n0000000236 00000 n\n";
    }

    private function generateTrailer() {
        return "trailer\n<< /Size 6\n/Root 1 0 R\n>>\nstartxref\n317\n%%EOF";
    }

    private function writeToFile($pdf_content) {
        file_put_contents($this->filename, $pdf_content);
    }

    public function renderPDF() {
        header('Content-Type: application/pdf; charset=utf-8');
        echo mb_convert_encoding($this->generatePdfContent(), 'UTF-8', 'UTF-8');
    }


}
