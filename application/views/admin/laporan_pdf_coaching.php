<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title_pdf;?></title>
        <style>
            #tabel, #baris, #kolom {
                /* font-family: "Trebuchet MS", Arial, Helvetica, sans-serif; */
                border: 1px solid black;
                border-collapse: collapse;
                /* width:100%; */
            }
        </style>
    </head>
    <body>
        <img src="<?=base_url('assets/img/infomedia_logo.png')?>" width="100px" width="100px"></img>
        <div>
            <table id="tabel">
                <tbody>
                    <tr id="baris">
                        <td style="text-align:right" colspan="4" width="60%"><h3>FORM COACHING</h3></td>
                        <td style="text-align:left;padding-left:100px;" width="20%">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div style="width:50px;height50px;border:1px solid; margin:auto;">
                                                &nbsp;
                                                </div>
                                            </td>
                                            <td>
                                                Success
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                        </td>
                        <td width="20%">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div style="width:50px;height50px;border:1px solid; margin:auto;">
                                                &nbsp;
                                                </div>
                                            </td>
                                            <td>
                                                Improvement
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                    
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">Tanggal</td>
                        <td colspan="2">: <?=date("d F Y",strtotime($data_ccm->tgl_mulai))?> - <?=date("d F Y",strtotime($data_ccm->tgl_akhir))?></td>
                        <td scope="row">Nama Pekerja</td>
                        <td colspan="2">: <?=$data_ccm->name?></td>
                    </tr>
                    <tr>
                        <td scope="row">Departemen/Layanan</td>
                        <td colspan="2">: <?=$data_ccm->user6?></td>
                        <td scope="row">Paraf Pekerja yang di coaching Atasan Langsung</td>
                        <td colspan="2">:</td>
                    </tr>
                    <tr>
                        <td scope="row">Lokasi</td>
                        <td colspan="2">: <?=$data_ccm->user5?></td>
                        <td scope="row">Paraf Atasan Langsung</td>
                        <td colspan="2">:</td>
                    </tr>
                    <tr id="baris">
                        <td scope="row" colspan="3" style="text-align:center" id="kolom"><h5>PERMASALAHAN</h5></td>
                        <td colspan="3" style="text-align:center" id="kolom"><h5>PENYULUHAN</h5></td>
                    </tr>
                    <tr id="baris">
                        <td scope="row" colspan="3" rowspan="2" id="kolom" height="150px"><?=$data_ccm->pelanggaran?></td>
                        <td colspan="3" id="kolom" height="75px"><?=$data_ccm->penyuluhan?></td>
                    </tr>
                    <tr id="baris">
                        <td scope="row" colspan="3" id="kolom" height="75px">Action Plan : <?=$data_ccm->komitmen?></td>
                    </tr>
                    <tr>
                        <td scope="row" colspan="2"  style="text-align:center" id="kolom"><h5>JENIS COACHING</h5></td>
                        <td style="text-align:center" id="kolom"><h5>BATAS WAKTU VERIFIKASI</h5></td>
                        <td >Tgl. Verifikasi</td>
                        <td colspan="2" >: <?=($data_ccm->tgl_verifi != "") ? date("d F Y",strtotime($data_ccm->tgl_verifi)) : ''?></td>
                    </tr>
                    <tr>
                        <td scope="row" id="kolom">
                            <div style="width:50px;height50px;border:1px solid; margin:auto;">
                            &nbsp;
                            </div>
                        </td>
                        <td scope="row" id="kolom">Tidak memenuhi Target Stafftime, Aux time, Receive Call</td>
                        <td id="kolom" style="text-align:center">Bulanan</td>
                        <td>Paraf Atasan Langsung</td>
                        <td colspan="2">:</td>
                    </tr>
                    <tr>
                        <td scope="row" id="kolom">
                            <div style="width:50px;height50px;border:1px solid; margin:auto;">
                            &nbsp;
                            </div>
                        </td>
                        <td scope="row" id="kolom">Gagal Tes Perbaikan target nilai PnP</td>
                        <td id="kolom" style="text-align:center">Bulanan</td>
                        <td>Paraf Pegawai Subjek Coaching</td>
                        <td colspan="2">:</td>
                    </tr>
                    <tr id="baris">
                        <td scope="row" id="kolom">
                            <div style="width:50px;height50px;border:1px solid; margin:auto;">
                            &nbsp;
                            </div>
                        </td>
                        <td scope="row" id="kolom">Tidak mencapai target Kinerja Agent</td>
                        <td id="kolom" style="text-align:center">Bulanan</td>
                        <td colspan="3"  style="text-align:center" id="kolom"><h5>HASIL PERBAIKAN COACHING (VERIFIKASI)</h5></td>
                    </tr>
                    <tr id="baris">
                        <td scope="row" id="kolom">
                            <div style="width:50px;height50px;border:1px solid; margin:auto;">
                            &nbsp;
                            </div>
                        </td>
                        <td scope="row" id="kolom">Kesalahan pembuatan Ticket ( Handling / Complaint / Request )*</td>
                        <td id="kolom" style="text-align:center">10 Harian</td>
                        <td colspan="3" id="kolom" rowspan="7"><?=$data_ccm->verifikasi?></td>
                    </tr>
                    <tr id="baris">
                        <td scope="row" id="kolom">
                            <div style="width:50px;height50px;border:1px solid; margin:auto;">
                            &nbsp;
                            </div>
                        </td>
                        <td scope="row" id="kolom">LOG IN terlambat (maksimal 10 menit akumulasi 25 hari)</td>
                        <td id="kolom" style="text-align:center">Bulanan</td>
                        <!-- <td colspan="3" id="kolom"></td> -->
                    </tr>
                    <tr id="baris">
                        <td scope="row" id="kolom">
                            <div style="width:50px;height50px;border:1px solid; margin:auto;">
                            &nbsp;
                            </div>
                        </td>
                        <td scope="row" id="kolom">Tidak hadir ( Training / Sosialisasi / Meeting )*</td>
                        <td id="kolom" style="text-align:center">Bulanan</td>
                        <!-- <td colspan="3" id="kolom"></td> -->
                    </tr>
                    <tr id="baris">
                        <td scope="row" id="kolom">
                            <div style="width:50px;height50px;border:1px solid; margin:auto;">
                            &nbsp;
                            </div>
                        </td>
                        <td scope="row" id="kolom">Pelanggaran Sopan santun / Komitmen Agent (Performance)</td>
                        <td id="kolom" style="text-align:center">Bulanan</td>
                        <!-- <td colspan="3" id="kolom"></td> -->
                    </tr>
                    <tr id="baris">
                        <td scope="row" id="kolom">
                            <div style="width:50px;height50px;border:1px solid; margin:auto;">
                            &nbsp;
                            </div>
                        </td>
                        <td scope="row" id="kolom">Softskills</td>
                        <td id="kolom" style="text-align:center">2 Mingguan</td>
                        <!-- <td colspan="3" id="kolom"></td> -->
                    </tr>
                    <tr id="baris">
                        <td scope="row" id="kolom">
                            <div style="width:50px;height50px;border:1px solid; margin:auto;">
                            &nbsp;
                            </div>
                        </td>
                        <td scope="row" id="kolom">Product Knowledge</td>
                        <td id="kolom" style="text-align:center">2 Mingguan</td>
                        <!-- <td colspan="3" id="kolom"></td> -->
                    </tr>
                    <tr id="baris">
                        <td scope="row" id="kolom">
                            <div style="width:50px;height50px;border:1px solid; margin:auto;">
                            &nbsp;
                            </div>
                        </td>
                        <td scope="row" id="kolom">Lainnya …………………………….</td>
                        <td id="kolom" style="text-align:center"></td>
                        <!-- <td colspan="3" id="kolom"></td> -->
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <div>
        <div>* coret yang tidak perlu</div>
         <br><br>
        <div style="position: absolute; bottom: 0px;">
            <h6>IN.HSC.TELK.F-04.Rev.00 / 19-06-2019</h6>
        </div>
    </body>
</html>