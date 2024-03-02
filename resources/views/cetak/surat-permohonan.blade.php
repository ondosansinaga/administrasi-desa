<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Surat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
    @media print {
        @page {
            size: letter;
        }
    }

    body {
        width: 22cm;
        height: 28cm;
    }

    .row-kop-surat {
        border-bottom: solid 3px #000;
        position: relative;
    }
    .row-kop-surat::after {
        content: "";
        display: block;
        border-bottom: double 1px #000;
        position: absolute;
        left: 0;
        bottom: -6px;
        width: 100%;
    }
    #logoKopSurat {
        height: 0.8in;
        width: auto;
        margin-bottom: 10px;
    }
    .heading-kop-surat {
        font-size: 14pt;
        font-weight: bold;
    }
    h5 {
        font-weight: bold;
        text-underline-position: below;
        text-decoration: underline;
        font-size: 12pt;
    }
    p {
        font-size: 12pt;
        text-align: justify;
    }
    </style>
</head>
<body style="font-family: 'Times New Roman', Times, serif; font-size: 12pt; background-color: white;">

    <div class="container-fluid">
        <div class="row row-kop-surat">
            <div class="col-2 p-0 m-0 d-flex justify-content-end">
                <img src="{{ asset('assets/ic_logo.png') }}" alt="Logo Kop Surat" id="logoKopSurat">
            </div>
            <div class="col-8">
                <h4 class="text-center m-0 heading-kop-surat">PEMERINTAH PEKON RINGIN SARI
                    <br>KECAMATAN SUOH
                    <br>KABUPATEN LAMPUNG BARAT
                </h4>
                <p class="text-center fw-medium fst-italic" style="font-size: 9pt;">Jl. Sukabumi – Sanggi Pekon Ringin Sari Kec,Suoh Kab.Lampung Barat Kode Pos 34882</p>
            </div>
            <div class="col-2 p-0 m-0">
            </div>
        </div>
    
        <div class="row">
            <div class="col-12">
                <h5 class="text-center mt-4 mb-3 text-uppercase">{{$reqLetterValue->getLetter()->getTitle()}}</h5>
    
                <p>Yang bertandatangan dibawah ini, Pj. Peratin Ringin Sari Kecamatan Suoh Kabupaten Lampung Barat, menerangkan dengan sebenarnya bahwa:</p>
    
                <div class="w-75 m-auto" style="font-size: 12pt;">
                    <table>
                        <tr>
                            <td>Nama</td>
                            <td> :</td>
                            <td class="text-capitalize">{{$reqLetterValue->getUser()->getName()}}</td>
                        </tr>
                        <tr>
                            <td>NIK</td>
                            <td>:</td>
                            <td>{{$reqLetterValue->getUser()->getNik()}}</td>
                        </tr>
                        <tr>
                            <td>Tempat, Tanggal Lahir</td>
                            <td>:</td>
                            <td>{{$reqLetterValue->getUser()->getBirthInfo()}}</td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td>{{$reqLetterValue->getUser()->getGender() == 1 ? 'Pria' : 'Wanita'}}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>{{$reqLetterValue->getUser()->getAddress() == null ? 'Alamat belum diisi' : $reqLetterValue->getUser()->getAddress()}}</td>
                        </tr>
                    </table>
                </div>
    
                <p>Menerangkan bahwa orang tersebut diatas benar-benar berdomisili di Pekon Ringin Sari.</p>
                <p>Demikian Surat Keterangan ini kami buat dengan sebenarnya dan dapat dipergunakan sebagaimana mestinya.</p>
    
                <div class="row mt-5">
                    <div class="col-7"></div>
                    <div class="col-5">
                        <p>
                            Ringin Sari, {{ $formatDate }} <br>
                            Pj. Peratin Ringin Sari
                        </p>
    
                        <br>
                        <br>
    
                        <p class="mb-0" style="text-decoration: underline; font-weight: bold;">HERI SETIYAWAN ABDULLAH, A.Md</p>
                        <p>NIP. 19800302 200604 1 005</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        window.print();
    </script>
</body>
</html>