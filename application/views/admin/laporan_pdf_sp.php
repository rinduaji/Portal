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
            <h3> FORM KRONOLOGIS </h3>
        </div>
        <div style="border: 5px solid black;padding: 10px 10px">
            <br>
            Berikut ini adalah Pekerja yang dikembalikan ke Infomedia atau melakukan pelanggaran (Surat Peringatan) :
            <br><br>
            <table>
                <tbody>
                    <tr>
                        <td scope="row">Nama</td>
                        <td>:</td>
                        <td><?=$data_ccm->name?></td>
                    </tr>
                    <tr>
                        <td scope="row">Jabatan</td>
                        <td>:</td>
                        <td><?=$data_ccm->user3?></td>
                    </tr>
                    <tr>
                        <td scope="row">Layanan</td>
                        <td>:</td>
                        <td><?=$data_ccm->user6?></td>
                    </tr>
                    <tr>
                        <td scope="row">Kronologis</td>
                        <td>:</td>
                        <td><?=$data_ccm->kronologis?></td>
                    </tr>
                    <tr>
                        <td scope="row">Pertimbangan</td>
                        <td>:</td>
                        <td><?=$data_ccm->penyuluhan?></td>
                    </tr>
                    <tr>
                        <td scope="row">Tindakan</td>
                        <td>:</td>
                        <td><?=$data_ccm->kode?> <?=$data_ccm->level?></td>
                    </tr>
                </tbody>
            </table>
            <br>
        </div>
        <br><br><br>
        <table style="text-align:center">
                <tbody>
                    <tr>
                        <td width="230px">Mengetahui,</td>
                        <td width="230px"></td>
                        <td width="230px"><?=ucfirst(strtolower($data_ccm->user5))?>, <?=date("d F Y")?></td>
                    </tr>
                    <tr>
                        <td scope="row"><?=$data_ccm->jabatan_tl?></td>
                        <td></td>
                        <td><?=$data_ccm->user3?></td>
                    </tr>
                    <tr>
                        <td scope="row" height="100px"></td>
                        <td></td>
                        <td height="100px"></td>
                    </tr>
                    <tr>
                        <td scope="row"><?=$data_ccm->nama_tl?></td>
                        <td></td>
                        <td><?=$data_ccm->nama_anak?></td>
                    </tr>
                    <tr>
                        <td scope="row"><hr></td>
                        <td></td>
                        <td><hr></td>
                    </tr>
                </tbody>
        </table>
        <div style="position: absolute; bottom: 0px;">
            <h6>IN.HSC.TELK.F-02.Rev.00 / 19-06-2019</h6>
        </div>
    </body>
</html>