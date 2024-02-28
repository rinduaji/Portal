<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title_pdf;?></title>
        <style>
            #table {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #table td, #table th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            #table tr:nth-child(even){background-color: #f2f2f2;}

            #table tr:hover {background-color: #ddd;}

            #table th {
                padding-top: 10px;
                padding-bottom: 10px;
                text-align: left;
                background-color: #4CAF50;
                color: white;
            }
        </style>
    </head>
    <body>
        <img src="<?=base_url('assets/img/infomedia_logo.png')?>" width="100px" width="200px"></img>
        <div style="text-align:center">
            <h3> <u>BERITA ACARA TEGURAN LISAN</u> </h3>
        </div>
        <div style="border: 1px solid black;padding: 10px 10px">
            <table>
                <tbody>
                    <tr>
                        <td scope="row">NAMA</td>
                        <td>:</td>
                        <td><?=$data_ccm->name?></td>
                    </tr>
                    <tr>
                        <td scope="row">UNIT KERJA</td>
                        <td>:</td>
                        <td><?=$data_ccm->user3?></td>
                    </tr>
                    <tr>
                        <td scope="row">PEMBERI TEGURAN</td>
                        <td>:</td>
                        <td><?=$data_ccm->nama_tl?></td>
                    </tr>
                    <tr>
                        <td scope="row">TANGGAL TEGURAN</td>
                        <td>:</td>
                        <td><?=date("d F Y",strtotime($data_ccm->tgl_mulai))?> - <?=date("d F Y",strtotime($data_ccm->tgl_akhir))?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <div style="border: 1px solid black;padding: 10px 10px">
            <table>
                <tbody>
                    <tr>
                        <td scope="row">ISI TEGURAN LISAN</td>
                        <td>:</td>
                        <td><?=$data_ccm->pelanggaran?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <div style="border: 1px solid black;padding: 10px 10px">
            <table>
                <tbody>
                    <tr>
                        <td scope="row">KOMITMEN</td>
                        <td>:</td>
                        <td><?=$data_ccm->komitmen?></td>
                    </tr>
                    <tr>
                        <td scope="row">VERIFIKASI</td>
                        <td>:</td>
                        <td><?=$data_ccm->verifikasi?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br><br><br>
        <table style="text-align:left">
                <tbody>
                    <tr>
                        <td colspan="5"><?=ucfirst(strtolower($data_ccm->user5))?>, <?=date("d F Y")?></td>
                    </tr>
                    <tr>
                        <td colspan="5"><br></td>
                    </tr>
                    <tr>
                        <td colspan="5">Mengetahui,</td>
                    </tr>
                    <tr>
                        <td width="175px" style="text-align:left">Atasan Penegur</td>
                        <td width="75px"></td>
                        <td width="175px" style="text-align:center">Pegawai yang ditegur</td>
                        <td width="75px"></td>
                        <td width="175px" style="text-align:center">Pemberi Teguran Lisan</td>
                    </tr>
                    <tr>
                        <td scope="row" style="text-align:center" height="100px"></td>
                        <td></td>
                        <td style="text-align:center" height="100px"></td>
                        <td></td>
                        <td style="text-align:center" height="100px"></td>
                    </tr>
                    <tr>
                        <td scope="row" style="text-align:center">( <?=$data_ccm->nama_spv?> )</td>
                        <td></td>
                        <td style="text-align:center">( <?=$data_ccm->nama_anak?> )</td>
                        <td></td>
                        <td style="text-align:center">( <?=$data_ccm->nama_tl?> )</td>
                    </tr>
                </tbody>
        </table>
        <div style="position: absolute; bottom: 0px;">
            <h6>IN.HSC.TELK.F-04.Rev.00 / 19-06-2019</h6>
        </div>
    </body>
</html>