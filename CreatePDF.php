<?php

class CreatePDF
{
    function ClientPDF($header, $headerWidth, $data){

        define ('K_PATH_IMAGES', 'images/');
        $PDF_HEADER_LOGO = "Famox.png";
        $PDF_HEADER_LOGO_WIDTH = "50";

        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true);

        $pdf->SetHeaderData($PDF_HEADER_LOGO, $PDF_HEADER_LOGO_WIDTH, "Famox Client List", "");

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 30));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED, '', 12);

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->AddPage();
        $pdf->Ln();

        $table = '<table cell padding="5" cellspacing="5" border="0">';
        $table.= '<tr bgcolor = "#336888">';
        for ($i = 0; $i < sizeOf($header); ++$i) {
            $table .= '<td class= "heading" width="'.$headerWidth[$i].'>' . $header[$i] . '</td>';
            }
            $table.='</tr>';

            $rowCount = 0;

            foreach($data as $row) {
                if ($rowCount % 2 == 0) {

                    $table .= '<tr valign="top" bgcolor="#ACC5D3">';
                } else {
                    $table .= '<tr valign="top">';
                }
                $table .= "<td>$row[client_id]</td>";
                $table .= "<td>$row[client_gname].' '.$row[client_fname]</td>";
                $table .= "<td>$row[client_email]</td>";
                $table .= "<td>$row[client_phone]</td>";
                $table .= "<td>$row[client_mobile]</td>";
                $table .= "<td>$row[client_mlist]</td>";
                $table .= "<td>$row[address_street]</td>";
                $table .= "<td>$row[address_suburb]</td>";
                $table .= "<td>$row[address_state]</td>";
                $table .= "<td>$row[address_postcode]</td>";
                $table .= "</tr>";
                $rowCount++;
            }
            $table.= "</table>";

            $pdf->writeHTML($table, true, true, true, true, '');
            $saveDir = dirname($_SERVER["SCRIPT_FILENAME"])."/PDFS/";

            if($pdf->Output($saveDir.'Client.pdf','F')){
                return $table;
            }
            exit();

    }

}