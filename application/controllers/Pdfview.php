<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdfview extends CI_Controller {
    function __construct(){
		parent::__construct();		
		$this->load->model('m_report_ccm');
	}

    public function konseling($id)
    {
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('Pdf');
        
        // title dari pdf
        $this->data['title_pdf'] = 'Form Berita Acara Konseling';
        $this->data['data_ccm'] = $this->m_report_ccm->get_id_ccm($id);
        
        // filename dari pdf ketika didownload
        $file_pdf = 'form_konseling';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";
        // $orientation = "landscape";
        
		// $html = $this->load->view('admin/laporan_pdf_konseling',$this->data, true);
        $html = $this->load->view('admin/laporan_pdf_konseling',$this->data, true);	    
        // run dompdf
        $this->pdf->generate($html, $file_pdf,$paper,$orientation);
        // $this->pdf->setPaper('A4', 'potrait');
		// $this->pdf->filename = "laporan-data-siswa.pdf";
		// $this->pdf->load_view('laporan_pdf', $data);
    }

    public function batl($id)
    {
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('Pdf');
        
        // title dari pdf
        $this->data['title_pdf'] = 'Form Berita Acara Teguran Lisan';
        $this->data['data_ccm'] = $this->m_report_ccm->get_id_ccm($id);  
        // filename dari pdf ketika didownload
        $file_pdf = 'form_batl';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";
        // $orientation = "landscape";
        
		$html = $this->load->view('admin/laporan_pdf_batl',$this->data, true);	    
        // run dompdf
        $this->pdf->generate($html, $file_pdf,$paper,$orientation);
        // $this->pdf->setPaper('A4', 'potrait');
		// $this->pdf->filename = "laporan-data-siswa.pdf";
		// $this->pdf->load_view('laporan_pdf', $data);
    }

    public function coaching($id)
    {
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('Pdf');
        
        // title dari pdf
        $this->data['title_pdf'] = 'Form Berita Acara Coaching';
        $this->data['data_ccm'] = $this->m_report_ccm->get_id_ccm($id);
        // filename dari pdf ketika didownload
        $file_pdf = 'form_coaching';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        // $orientation = "portrait";
        $orientation = "landscape";
        
		$html = $this->load->view('admin/laporan_pdf_coaching',$this->data, true);	    
        // run dompdf
        $this->pdf->generate($html, $file_pdf,$paper,$orientation);
        // $this->pdf->setPaper('A4', 'potrait');
		// $this->pdf->filename = "laporan-data-siswa.pdf";
		// $this->pdf->load_view('laporan_pdf', $data);
    }

    public function sp($id)
    {
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('Pdf');
        
        // title dari pdf
        $this->data['title_pdf'] = 'Form Berita Acara Kronologis';
        $this->data['data_ccm'] = $this->m_report_ccm->get_id_ccm($id);
        // filename dari pdf ketika didownload
        $file_pdf = 'form_sp';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";
        // $orientation = "landscape";
        
		$html = $this->load->view('admin/laporan_pdf_sp',$this->data, true);	    
        // run dompdf
        $this->pdf->generate($html, $file_pdf,$paper,$orientation);
        // $this->pdf->setPaper('A4', 'potrait');
		// $this->pdf->filename = "laporan-data-siswa.pdf";
		// $this->pdf->load_view('laporan_pdf', $data);
    }
}