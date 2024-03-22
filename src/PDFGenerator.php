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
        // PDF header
        $pdf_content = "%PDF-1.4\n";

        // Object 1: Catalog
        $pdf_content .= "1 0 obj\n";
        $pdf_content .= "<< /Type /Catalog\n";
        $pdf_content .= "   /Pages 2 0 R\n";
        $pdf_content .= ">>\n";
        $pdf_content .= "endobj\n";

        // Object 2: Pages
        $pdf_content .= "2 0 obj\n";
        $pdf_content .= "<< /Type /Pages\n";
        $pdf_content .= "   /Kids [3 0 R]\n";
        $pdf_content .= "   /Count 1\n";
        $pdf_content .= ">>\n";
        $pdf_content .= "endobj\n";

        // Object 3: Page
        $pdf_content .= "3 0 obj\n";
        $pdf_content .= "<< /Type /Page\n";
        $pdf_content .= "   /Parent 2 0 R\n";
        $pdf_content .= "   /Resources << /Font << /F1 4 0 R >> >>\n";
        $pdf_content .= "   /MediaBox [0 0 595 842]\n";
        $pdf_content .= "   /Contents 5 0 R\n";
        $pdf_content .= ">>\n";
        $pdf_content .= "endobj\n";

        // Object 4: Font
        $pdf_content .= "4 0 obj\n";
        $pdf_content .= "<< /Type /Font\n";
        $pdf_content .= "   /Subtype /Type1\n";
        $pdf_content .= "   /BaseFont /Helvetica\n";
        $pdf_content .= ">>\n";
        $pdf_content .= "endobj\n";

        // Object 5: Page content
        $pdf_content .= "5 0 obj\n";
        $pdf_content .= "<< /Length 55 >>\n";
        $pdf_content .= "stream\n";
        $pdf_content .= "BT\n";
        $pdf_content .= "/F1 12 Tf\n";
        $pdf_content .= "50 750 Td\n";
        $pdf_content .= "(" . utf8_decode($this->content) . ") Tj\n"; // Render HTML content
        $pdf_content .= "ET\n";
        $pdf_content .= "endstream\n";
        $pdf_content .= "endobj\n";

        // Cross-reference table
        $xref_table = "xref\n";
        $xref_table .= "0 6\n";
        $xref_table .= "0000000000 65535 f \n";
        $xref_table .= "0000000009 00000 n \n";
        $xref_table .= "0000000050 00000 n \n";
        $xref_table .= "0000000104 00000 n \n";
        $xref_table .= "0000000158 00000 n \n";
        $xref_table .= "0000000236 00000 n \n";

        // Trailer
        $trailer = "trailer\n";
        $trailer .= "<< /Size 6\n";
        $trailer .= "   /Root 1 0 R\n";
        $trailer .= ">>\n";
        $trailer .= "startxref\n";
        $trailer .= "317\n";
        $trailer .= "%%EOF";

        // Combine PDF parts
        $pdf_content .= $xref_table . $trailer;

        // Write content to file
        file_put_contents($this->filename, $pdf_content);

        // Output success message
        echo "PDF generated successfully!";
    }
}