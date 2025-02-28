<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class InvoiceController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('SalesModel');
    }

    public function generateInvoice($sale_id)
    {
        $sale = $this->SalesModel->getASaleById($sale_id);
        $sales_items = $this->SalesModel->getSaleItems($sale_id);

        if (!$sale) {
            show_error('Sale not found!', 404);
        }

        // Load HTML view for PDF
        $data['sale'] = $sale;
        $data['sales_items'] = $sales_items;
        $html = $this->load->view('billing_pdf', $data, true);

        // PDF Settings
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); 

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Show PDF in browser instead of direct download
        $dompdf->stream("invoice_{$sale_id}.pdf", ["Attachment" => false]);
    }
}
