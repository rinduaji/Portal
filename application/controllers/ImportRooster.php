<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH.'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ImportRooster extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_roosterfix');
		$this->load->model('m_notif');
        $this->load->model('m_notif_inbox');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

        $data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

		$jabatan_user = $this->session->userdata('jabatan');
        $jb_agent = explode(" ",$jabatan_user);
        if(isset($jb_agent[1])) {
            if($jb_agent[1] == 'LEADER') {
                $cekjabatan = ($jb_agent[0].' '.$jb_agent[1]);
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

        $this->load->view('header',$data);
		$this->load->view('admin/import_rooster_view',$data);
        $this->load->view('footer');
	}

    public function importExcelRooster() {
        $upload_file = $_FILES['file_rooster_excel']['name'];
        $extension = pathinfo($upload_file,PATHINFO_EXTENSION);

        if($extension == 'csv'){
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        }
        else if($extension == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        }
        else if($extension == 'xlsx') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet = $reader->load($_FILES['file_rooster_excel']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        $sheetCount = count($sheetData);
        $periode = $sheetData[0][1];
        $tahun = substr($periode,0,4);
        $bulan = substr($periode,4,2);
        $days=cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);
        $countColumn = $days + 4;
        $lup = date("Y-m-d h:i:s");
        $data = array();
        if($sheetCount > 1) {
            for ($i=3; $i < $sheetCount; $i++) { 
                $login = $sheetData[$i][1];
                $nama = $sheetData[$i][2];
                $area = $sheetData[$i][3];
                $jabatan = $sheetData[$i][4];
                for ($j=5; $j <= $countColumn; $j++) { 
                    if(isset($sheetData[2][$j])) {
                        
                        if($sheetData[2][$j] != '') {
                            $tanggal = $tahun.'-'.$bulan.'-'.$sheetData[2][$j];
                            $cekDataUploadRooster = $this->m_roosterfix->cekDataUploadRooster($login,$tanggal);
                            $pola = $sheetData[$i][$j];
                            if($cekDataUploadRooster == 0) {
                                // print_r($cekDataUploadRooster);
                                $data[] = array(
                                    'login' => $login,
                                    'nama' => $nama,
                                    'tgl_masuk' => $tanggal,
                                    'pola' => $pola,
                                    'jabatan' => $jabatan,
                                    'upd' => $this->session->userdata('username'),
                                    'lup' => $lup,
                                    'periode' => $periode,
                                    'area' => $area
                                );
                            }
                        }
                    }
                }
            }
            
            if(count($data)>0) {
                $uploadRoosterfix = $this->m_roosterfix->insertRoosterfixBatch($data);
                $uploadRoosterfixAsli = $this->m_roosterfix->insertRoosterfixAsliBatch($data);
                if($uploadRoosterfix && $uploadRoosterfixAsli) {
                    $this->session->set_flashdata('success', 'Data Berhasil diupload');
                }
                else {
                    $this->session->set_flashdata('gagal', 'Data Gagal diupload');
                }
            }
            else {
                print_r(count($data));
                $this->session->set_flashdata('gagal', 'Data Gagal diupload karena rooster sudah ada');
            }
        }
        redirect(site_url('ImportRooster/index'));
    }

    
}