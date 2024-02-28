<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportCCM extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_report_ccm');
		$this->load->model('m_notif');
		$this->load->model('m_notif_inbox');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$user_id = $this->session->userdata("user_id");
		$username = $this->session->userdata("username");
		$jabatan = $this->session->userdata("jabatan");
		$jb_agent = explode(" ",$jabatan);
        if(isset($jb_agent[0])) {
            if($jb_agent[0] == 'TL') {
                $cekjabatan = ($jb_agent[0]);
            }
            else {
                $cekjabatan = ($jb_agent[0]);
            }
        }
        else {
            $cekjabatan = ($jb_agent[0]);
        }
		$data['jabatan_user'] = $cekjabatan;
		// print_r($user_id);
		$jabatan_user = $this->session->userdata('jabatan');
        $jb_agent = explode(" ",$jabatan_user);
		// print_r($jb_agent);

		$this->load->library('pagination');

		if($this->input->post('cari')) {
			$data['cari'] = $this->input->post('cari');
			// $this->session->set_userdata('cari',$data['cari']);
		}
		else {
			$data['cari'] = null;
			// $data['cari'] = $this->session->userdata('cari');
		}

		if($this->input->post('date_awal')) {
			$data['date_awal'] = $this->input->post('date_awal');
		}
		else {
			$data['date_awal'] = null;
		}

		if($this->input->post('date_akhir')) {
			$data['date_akhir'] = $this->input->post('date_akhir');
		}
		else {
			$data['date_akhir'] = null;
		}

		if($this->input->post('jabatan')) {
			$data['jabatan'] = $this->input->post('jabatan');
		}
		else {
			$data['jabatan'] = null;
		}

		if($this->input->post('btnSearch')) {
			$data['btnSearch'] = $this->input->post('btnSearch');
			// print_r($data['btnSearch']);
		}
		else {
			$data['btnSearch'] = null;
		}

		if($this->input->post('approve_ver')) {
			$data['approve_ver'] = $this->input->post('approve_ver');
			// print_r($data['approve_ver']);
		}
		else {
			$data['approve_ver'] = null;
		}

		if($this->input->post('exportExcel') !== NULL) {
			// $periode = date('Y',strtotime($data['date_awal'])).''.date('m',strtotime($data['date_awal']));
			// print_r($periode);
			$this->createExcel($user_id,$jb_agent[0],$data['cari'],$data['date_awal'],$data['date_akhir'],$username,$data['jabatan'],$data['approve_ver']);
		}
		else {
			if($this->input->post('btnSearch')) {
				$jumlah_data = $this->m_report_ccm->jumlah_data($user_id,$jb_agent[0],$data['cari'],$data['date_awal'],$data['date_akhir'],$username,$data['jabatan'],$data['approve_ver']);

				// $config['base_url'] = base_url('index.php/ReportCCM/index');
				// $config['total_rows'] = $jumlah_data;
				// $config['per_page'] = 7;
				$data['total_data'] = $jumlah_data;

				$data['start'] = $this->uri->segment(3);
				// $this->pagination->initialize($config);	

				// $data['data_list_ccm'] = $this->m_report_ccm->data_list_ccm($user_id,$jb_agent[0],$config['per_page'],$data['start'],$data['cari'],$data['date_awal'],$data['date_akhir'],$username);
				$data['data_list_ccm'] = $this->m_report_ccm->data_list_ccm($user_id,$jb_agent[0],$data['start'],$data['cari'],$data['date_awal'],$data['date_akhir'],$username,$data['jabatan'],$data['approve_ver']);
				// print_r($this->db->last_query());
				// $data['nama_list_ccm_kategori'] = $this->m_report_ccm->nama_list_ccm_kategori();
			}
			$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
			$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));
			
			$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
			$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

			$data['cek_verifikasi'] = $this->m_report_ccm->cek_verifikasi($user_id);
			// print_r($data['cek_verifikasi']);
			$data['list_jabatan'] = $this->m_report_ccm->getJabatan();
			if(isset($jb_agent[0])) {
				if($jb_agent[0] == 'TL') {
					$cekjabatan = ($jb_agent[0]);
					if($jb_agent[1] == 'QCO') {
						$cekjabatan = ($jb_agent[0].' '.$jb_agent[1].' '.$jb_agent[2]); 
					}
				}
				else {
					$cekjabatan = ($jb_agent[0]);
					
				}
			}
			else {
				$cekjabatan = ($jb_agent[0]);
			}
			
			$data['hasil_jabatan'] = $cekjabatan;
			
			$this->load->view('header',$data);
			$this->load->view('admin/report_ccm_view',$data);
			$this->load->view('footer');
		}
	}

	public function createExcel($user_id,$jb_agent, $cari = NULL, $date_awal = NULL, $date_akhir = NULL, $username = NULL, $jabatan = NULL, $approve_ver = NULL) {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = [
		  'font' => ['bold' => true], // Set font nya jadi bold
		  'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ],
		  'borders' => [
			'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
		  ]
		];
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = [
		  'alignment' => [
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ],
		  'borders' => [
			'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
		  ]
		];

		// $bulan = date('Y-m-d', strtotime($date_awal));
		// $bulan_format = $date->format('m');
		// $tahun = DateTime::createFromFormat('Y-m-d', $date_awal);
		// $tahun_format = $date->format('Y');

		$sheet->setCellValue('A1', "DATA CCM"); // Set kolom A1 dengan tulisan "DATA SISWA"
		// $sheet->setCellValue('A2', "PERIODE : ");
		// $sheet->setCellValue('B2', $periode);  // Set kolom A1 dengan tulisan "DATA SISWA"
		$sheet->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
		// $sheet->mergeCells('AM4:AO4');
		// $sheet->getStyle('AM4')->getFont()->setBold(true);
		$sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
		$sheet->getStyle('A3')->getFont()->setBold(true);
		$sheet->getStyle('B3')->getFont()->setBold(true);
		$sheet->getStyle('C3')->getFont()->setBold(true);
		$sheet->getStyle('D3')->getFont()->setBold(true);
		$sheet->getStyle('E3')->getFont()->setBold(true);
		$sheet->getStyle('F3')->getFont()->setBold(true);
		$sheet->getStyle('G3')->getFont()->setBold(true);
		$sheet->getStyle('H3')->getFont()->setBold(true);
		$sheet->getStyle('I3')->getFont()->setBold(true);
		$sheet->getStyle('J3')->getFont()->setBold(true);
		$sheet->getStyle('K3')->getFont()->setBold(true);
		$sheet->getStyle('L3')->getFont()->setBold(true);
		// Buat header tabel nya pada baris ke 3
		$sheet->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('B3', "USERNAME"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('C3', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('D3', "JABATAN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('E3', "AREA"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('F3', "Nama Pen CCM"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('G3', "Tanggal Mulai"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('H3', "Tanggal Akhir"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('I3', "Pelanggaran"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('J3', "Status"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('K3', "Status Pelanggaran"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('L3', "Keterangan"); // Set kolom E3 dengan tulisan "ALAMAT"

		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$sheet->getStyle('A3')->applyFromArray($style_col);
		$sheet->getStyle('B3')->applyFromArray($style_col);
		$sheet->getStyle('C3')->applyFromArray($style_col);
		$sheet->getStyle('D3')->applyFromArray($style_col);
		$sheet->getStyle('E3')->applyFromArray($style_col);
		$sheet->getStyle('F3')->applyFromArray($style_col);
		$sheet->getStyle('G3')->applyFromArray($style_col);
		$sheet->getStyle('H3')->applyFromArray($style_col);
		$sheet->getStyle('I3')->applyFromArray($style_col);
		$sheet->getStyle('J3')->applyFromArray($style_col);
		$sheet->getStyle('K3')->applyFromArray($style_col);
		$sheet->getStyle('L3')->applyFromArray($style_col);
				// Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
		$report_ccm = $this->m_report_ccm->export_data_list_ccm($user_id,$jb_agent,$cari,$date_awal,$date_akhir,$username,$jabatan,$approve_ver);
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
		// print_r($this->db->last_query());
		foreach($report_ccm as $data){ // Lakukan looping pada variabel siswa
			if($data->status == 0) {
				$status = "NEED APPROVE BY AGENT";
			  }
			  elseif($data->status == 1) {
				$status = "NEED APPROVE BY TL";
			  }
			  elseif($data->status == 2) {
				$status = "NEED APPROVE BY SPV";
			  }
			  elseif($data->status == 3) {
				$status = "NEED APPROVE BY MANAGER";
			  }
			  elseif($data->status == 4) {
				$status = "NEED VERIFIKASI";
			  }
			  elseif($data->status == 5) {
				$status = "DONE";
			  }

			  if($data->status < 5) {
				$status_pelanggaran = "AKTIF";
			  }
			  elseif($data->status == 5) {
				$status_pelanggaran = "TIDAK AKTIF";
			  }

		  $sheet->setCellValue('A'.$numrow, $no);
		  $sheet->setCellValue('B'.$numrow, $data->username);
		  $sheet->setCellValue('C'.$numrow, $data->name);
		  $sheet->setCellValue('D'.$numrow, $data->user3);
		  $sheet->setCellValue('E'.$numrow, $data->user5);
		  $sheet->setCellValue('F'.$numrow, $data->nama_tl);
		  $sheet->setCellValue('G'.$numrow, $data->tgl_mulai);
		  $sheet->setCellValue('H'.$numrow, $data->tgl_akhir);
		  $sheet->setCellValue('I'.$numrow, $data->kode);
		  $sheet->setCellValue('J'.$numrow, $status);
		  $sheet->setCellValue('K'.$numrow, $status_pelanggaran);
		  $sheet->setCellValue('L'.$numrow, $data->kode.' '.$data->level);
		  
		  // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
		  $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('E'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('F'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('G'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('H'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('I'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('J'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('K'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('L'.$numrow)->applyFromArray($style_row);
		  
		  $no++; // Tambah 1 setiap kali looping
		  $numrow++; // Tambah 1 setiap kali looping
		}
		// Set width kolom
		$sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$sheet->getColumnDimension('B')->setWidth(10); // Set width kolom B
		$sheet->getColumnDimension('C')->setWidth(40); // Set width kolom C
		$sheet->getColumnDimension('D')->setWidth(25); // Set width kolom D
		$sheet->getColumnDimension('E')->setWidth(20); // Set width kolom E
		$sheet->getColumnDimension('F')->setWidth(40);
		$sheet->getColumnDimension('G')->setWidth(20);
		$sheet->getColumnDimension('H')->setWidth(20);
		$sheet->getColumnDimension('I')->setWidth(15);
		$sheet->getColumnDimension('J')->setWidth(20);
		$sheet->getColumnDimension('K')->setWidth(20);
		$sheet->getColumnDimension('L')->setWidth(20);
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$sheet->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$sheet->setTitle("Laporan Data CCM");
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Data CCM.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');		   
    }

	public function detailCCM($id) {
		$cekJabatanIdCCM = $this->m_report_ccm->cekJabatanIdCCM($id)->user3;
		$cekJabatanIdKaryawan = $this->m_report_ccm->cekJabatanIdKaryawan($id)->user3;
		// print_r($cekJabatanIdKaryawan);
		$cekId = $this->m_report_ccm->cekJabatanIdCCM($id)->spv;
		$jb_agent = explode(" ",$cekJabatanIdCCM);
        if(isset($jb_agent[0])) {
            if($jb_agent[0] == 'TL') {
                $cekjabatan = ($jb_agent[0]);
                // if($jb_agent[2] == 'QCO') {
                //     $cekjabatan = ($jb_agent[0].' '.$jb_agent[1].' '.$jb_agent[2]); 
                // }
            }
            else {
                $cekjabatan = ($jb_agent[0]);
                
            }
        }
        else {
            $cekjabatan = ($jb_agent[0]);
        }
		$data['hasil_jabatan'] = $cekjabatan;
		$data['data_nama_groupmail'] = $this->m_report_ccm->getNamaGroupmail($cekId,$cekjabatan);
		$data['data_detail_ccm'] = $this->m_report_ccm->data_ccm_detail($id,$cekJabatanIdKaryawan);
		// print_r($this->db->last_query());

		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));
		
		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

		$this->load->view('header',$data);
		$this->load->view('admin/detail_ccm_view',$data);
        $this->load->view('footer');
    }

    public function ApproveAgent($id) {
		$jabatan_user = $this->session->userdata('jabatan');
        $jb_user = explode(" ",$jabatan_user);
		$cekJabatanIdCCM = $this->m_report_ccm->cekJabatanIdCCM($id)->user3;
		$cekId = $this->m_report_ccm->cekJabatanIdCCM($id)->spv;
		// print_r($cekId);
        $jb_agent = explode(" ",$cekJabatanIdCCM);
        if(isset($jb_agent[0])) {
            if($jb_agent[0] == 'AGENT' || $jb_agent[0] == 'INPUTER') {
                $cekjabatan = ($jb_agent[0]);
                // if($jb_agent[2] == 'QCO') {
                //     $cekjabatan = ($jb_agent[0].' '.$jb_agent[1].' '.$jb_agent[2]); 
                // }
            }
            else {
                $cekjabatan = ($jb_agent[0]);
                
            }
        }
        else {
            $cekjabatan = ($jb_agent[0]);
        }
		$data['hasil_jabatan'] = $cekjabatan;
		$data['data_nama_groupmail'] = $this->m_report_ccm->getNamaGroupmail($cekId,$jb_user[0]);
		$data['data_approve_agent'] = $this->m_report_ccm->data_ccm_approve_agent($id);

		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

		$this->load->view('header',$data);
		$this->load->view('admin/approve_agent_view',$data);
        $this->load->view('footer');
    }

    public function ApproveTL($id) {
		$jabatan_user = $this->session->userdata('jabatan');
        $jb_user = explode(" ",$jabatan_user);
		$cekJabatanIdCCM = $this->m_report_ccm->cekJabatanIdCCM($id)->user3;
		$cekId = $this->m_report_ccm->cekJabatanIdCCM($id)->spv;
		$jb_agent = explode(" ",$cekJabatanIdCCM);
        if(isset($jb_agent[0])) {
            if($jb_agent[0] == 'AGENT' || $jb_agent[0] == 'INPUTER') {
                $cekjabatan = ($jb_agent[0]);
                // if($jb_agent[2] == 'QCO') {
                //     $cekjabatan = ($jb_agent[0].' '.$jb_agent[1].' '.$jb_agent[2]); 
                // }
            }
            else {
                $cekjabatan = ($jb_agent[0]);
                
            }
        }
        else {
            $cekjabatan = ($jb_agent[0]);
        }
		$data['hasil_jabatan'] = $cekjabatan;
		$data['data_nama_groupmail'] = $this->m_report_ccm->getNamaGroupmail($cekId,$jb_user[0]);
		$data['data_approve_tl'] = $this->m_report_ccm->data_ccm_approve_tl($id);

		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

		$this->load->view('header',$data);
		$this->load->view('admin/approve_tl_view',$data);
        $this->load->view('footer');
    }

    public function ApproveSpv($id) {
		$jabatan_user = $this->session->userdata('jabatan');
        $jb_user = explode(" ",$jabatan_user);
		// print_r($jb_user);
		$cekJabatanIdCCM = $this->m_report_ccm->cekJabatanIdCCM($id)->user3;
		$cekId = $this->m_report_ccm->cekJabatanIdCCM($id)->spv;
		$jb_agent = explode(" ",$cekJabatanIdCCM);
        if(isset($jb_agent[0])) {
            if($jb_agent[0] == 'AGENT' || $jb_agent[0] == 'INPUTER') {
                $cekjabatan = ($jb_agent[0]);
                if($jb_agent[2] == 'QCO') {
                    $cekjabatan = ($jb_agent[0].' '.$jb_agent[1].' '.$jb_agent[2]); 
                }
            }
            else {
                $cekjabatan = ($jb_agent[0]);
                
            }
        }
        else {
            $cekjabatan = ($jb_agent[0]);
        }
		$data['hasil_jabatan'] = $cekjabatan;
		$data['data_nama_groupmail'] = $this->m_report_ccm->getNamaGroupmail($cekId,$jb_user[0]);
		$data['data_approve_spv'] = $this->m_report_ccm->data_ccm_approve_spv($id);

		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

		$this->load->view('header',$data);
		$this->load->view('admin/approve_spv_view',$data);
        $this->load->view('footer');
    }

	public function ApproveManager($id) {
		$jabatan_user = $this->session->userdata('jabatan');
        $jb_user = explode(" ",$jabatan_user);
		$cekJabatanIdCCM = $this->m_report_ccm->cekJabatanIdCCM($id)->user3;
		$cekId = $this->m_report_ccm->cekJabatanIdCCM($id)->spv;
		$jb_agent = explode(" ",$cekJabatanIdCCM);
        if(isset($jb_agent[0])) {
            if($jb_agent[0] == 'AGENT' || $jb_agent[0] == 'INPUTER') {
                $cekjabatan = ($jb_agent[0]);
                if($jb_agent[2] == 'QCO') {
                    $cekjabatan = ($jb_agent[0].' '.$jb_agent[1].' '.$jb_agent[2]); 
                }
            }
            else {
                $cekjabatan = ($jb_agent[0]);
                
            }
        }
        else {
            $cekjabatan = ($jb_agent[0]);
        }
		$data['hasil_jabatan'] = $cekjabatan;
		$data['data_nama_groupmail'] = $this->m_report_ccm->getNamaGroupmail($cekId,$jb_user[0]);
		$data['data_approve_manager'] = $this->m_report_ccm->data_ccm_approve_manager($id);

		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

		$this->load->view('header',$data);
		$this->load->view('admin/approve_manager_view',$data);
        $this->load->view('footer');
    }

    public function Verifikasi($id) {
		$jabatan_user = $this->session->userdata('jabatan');
        $jb_user = explode(" ",$jabatan_user);
		$cekJabatanIdCCM = $this->m_report_ccm->cekJabatanIdCCM($id)->user3;
		$cekId = $this->m_report_ccm->cekJabatanIdCCM($id)->spv;
		$jb_agent = explode(" ",$cekJabatanIdCCM);
        if(isset($jb_agent[0])) {
            if($jb_agent[0] == 'AGENT' || $jb_agent[0] == 'INPUTER') {
                $cekjabatan = ($jb_agent[0]);
                if($jb_agent[2] == 'QCO') {
                    $cekjabatan = ($jb_agent[0].' '.$jb_agent[1].' '.$jb_agent[2]); 
                }
            }
            else {
                $cekjabatan = ($jb_agent[0]);
                
            }
        }
        else {
            $cekjabatan = ($jb_agent[0]);
        }
		$data['hasil_jabatan'] = $cekjabatan;
		$data['data_nama_groupmail'] = $this->m_report_ccm->getNamaGroupmail($cekId,$jb_user[0]);
		$data['data_approve_verifikasi'] = $this->m_report_ccm->data_ccm_approve_verifikasi($id);

		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

        $this->load->view('header',$data);
		$this->load->view('admin/verifikasi_view',$data);
        $this->load->view('footer');
    }

	public function updateApproveAgent() {
		$id = $this->input->post('id');
		$komitmen = $this->input->post('komitmen');
		$lup_agn = $this->input->post('lup_agent');
		$id_tl = $this->input->post('id_tl');
		$data = array(
			'komitmen' => $komitmen,
			'lup_agn' => $lup_agn,
			'status' => '1',
		);
		$data_notif = array(
			'status_aktif' => '1',
			'send_upd' => $id_tl,
			'status' => '1',
		);
        if ($komitmen != "" AND $lup_agn != "") {
			$this->m_report_ccm->updateApprove($id,$data);
			$this->m_report_ccm->updateApproveNotif($id,$data_notif);
			$this->session->set_flashdata('success', 'Data Berhasil diubah');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal diubah');
		}
		redirect(site_url('ReportCCM/index'));
	}

	public function updateApproveTl() {
		$id = $this->input->post('id');
		$lup_tl = $this->input->post('lup_tl');
		$id_spv = $this->input->post('id_spv');
		if($this->input->post('penyuluhan')) {
			$data = array(
				'lup_krd' => $lup_tl,
				'status' => '2',
				'penyuluhan' => $this->input->post('penyuluhan')
			);
		} 
		else {
			$data = array(
				'lup_krd' => $lup_tl,
				'status' => '2',
			);
		}
		$data_notif = array(
			'status_aktif' => '1',
			'send_upd' => $id_spv,
			'status' => '2',
		);

        if ($lup_tl != "") {
			$this->m_report_ccm->updateApprove($id,$data);
			$this->m_report_ccm->updateApproveNotif($id,$data_notif);
			$this->session->set_flashdata('success', 'Data Berhasil diubah');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal diubah');
		}
		redirect(site_url('ReportCCM/index'));
	}

	public function updateApproveSpv() {
		$id = $this->input->post('id');
		$lup_spv = $this->input->post('lup_spv');
		$id_manager = $this->input->post('id_manager');
		if($this->input->post('penyuluhan')) {
			$data = array(
				'lup_spv' => $lup_spv,
				'status' => '3',
				'penyuluhan' => $this->input->post('penyuluhan')
			);
		}
		else {
			$data = array(
				'lup_spv' => $lup_spv,
				'status' => '3',
			);
		}

		$data_notif = array(
			'status_aktif' => '1',
			'send_upd' => $id_manager,
			'status' => '3',
		);

        if ($lup_spv != "") {
			$this->m_report_ccm->updateApprove($id,$data);
			$this->m_report_ccm->updateApproveNotif($id,$data_notif);
			$this->session->set_flashdata('success', 'Data Berhasil diubah');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal diubah');
		}
		redirect(site_url('ReportCCM/index'));
	}

	public function updateApproveManager() {
		$id = $this->input->post('id');
		$lup_mgr = $this->input->post('lup_mgr');
		$data = array(
			'lup_mgr' => $lup_mgr,
			'status' => '4',
		);

        if ($lup_mgr != "") {
			$this->m_report_ccm->updateApproveManager($id,$data);
			// $this->m_report_ccm->updateApproveManagerNotif($id,$data_notif);
			$this->session->set_flashdata('success', 'Data Berhasil diubah');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal diubah');
		}
		redirect(site_url('ReportCCM/index'));
	}

	public function updateApproveVerifikasi() {
		$id = $this->input->post('id');
		$verifikasi = $this->input->post('verifikasi');
		$tgl_verifi = $this->input->post('tgl_verifi');
		$data = array(
			'verifikasi' => $verifikasi,
			'tgl_verifi' => $tgl_verifi,
			'status' => '5',
		);

        if($verifikasi != "" AND $tgl_verifi != "") {
			$this->m_report_ccm->updateApprove($id,$data);
			$this->session->set_flashdata('success', 'Data Berhasil diubah');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal diubah');
		}
		redirect(site_url('ReportCCM/index'));
	}

	public function add(){
		$dokumen = $this->m_report_ccm;
		$data = array(
            'id_item' => $this->input->post('id_item'),
			'judul_dokumen' => $this->input->post('judul_dokumen'),
            'deskripsi' => $this->input->post('deskripsi'),
			'kode_dokumen' => $this->input->post('kode_dokumen'),
            'tanggal_berlaku' => $this->input->post('tanggal_berlaku'),
			'tanggal_verifikasi' => $this->input->post('tanggal_verifikasi'),
		);

		$config['upload_path']          = FCPATH.'/uploads/dokumen/';
		$config['allowed_types']        = 'xlsx|xls|doc|docx|pdf';
		$config['file_name']            = $_FILES['file_dokumen']['name'];
		$config['overwrite']            = true;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file_dokumen')) {
			$error = $this->upload->display_errors();
            $this->session->set_flashdata('gagal', 'Gagal Upload File ('.$error.')');
		} else {
			$uploaded_data = $this->upload->data();
            $data['file_dokumen'] = $uploaded_data['file_name'];
        }

        $validation = $this->form_validation;
		$validation->set_rules($dokumen->rules());

        if ($validation->run()) {
			$this->m_report_ccm->insert($data);
			$this->session->set_flashdata('success', 'Data Berhasil disimpan');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal disimpan');
		}

        redirect(site_url('Dokumen'));
	}

	public function edit(){
		$ccm = $this->m_report_ccm;
		$id = $this->input->post('id');
		$data = array(
            'id' => $this->input->post('id'),
			'tgl_mulai' => $this->input->post('tgl_mulai'),
            'tgl_akhir' => $this->input->post('tgl_akhir'),
			'kode' => $this->input->post('kode'),
            'level' => $this->input->post('level'),
		);
        		
        $validation = $this->form_validation;
		$validation->set_rules($ccm->rules());

        if ($validation->run()) {
			$this->m_report_ccm->update($id,$data);
			$this->session->set_flashdata('success', 'Data Berhasil diubah');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal diubah');
		}
		redirect(site_url('ReportCCM'));
	}

	public function get_by_id($id) {
		$data = $this->m_report_ccm->get_id($id);
		echo json_encode($data);
	}

	public function hapus() {
		$id= $this->input->post('id');
		if($this->m_report_ccm->delete($id)) {
			$this->session->set_flashdata('success', 'Data Berhasil dihapus');
		}
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal dihapus');
		}
		redirect(site_url('Dokumen'));
	}
}