@extends('layout.user')
@section('content')

<div class="container-fluid">
    <h5 class="mb-3">LANGKAH 1</h5>
    <div class="card mb-4">
        <div class="card-body">
            <h6>Buat Bank</h6>
            <p>
                Sebagai pengguna baru, Anda belum memiliki bank apapun didaftar bank. Untuk membuat bank, 
                Anda pergi kemenu <span class="text-primary">Bank</span>, kemudian klik <span class="text-primary"><i class="fas fa-plus"></i> Tambah Bank</span>
                , setelah itu akan muncul sebuah form dan bisa Anda isi nama bank dan saldo yang Anda inginkan. Setelah 
                selesai, klik <span class="text-primary">Buat Bank</span>. Jika berhasil, maka akan muncul nama bank dan saldo 
                yang telah Anda buat di tabel bank. Anda juga dapat mengeditnya dengan klik <i class="fas fa-edit text-green"></i> 
                atau menghapusnya dengan klik <i class="fas fa-trash text-red"></i>.
            </p>
        </div>
    </div>
    
    <h5 class="mb-3">LANGKAH 2</h5>
    <div class="card mb-4">
        <div class="card-body">
            <h6>Buat Anggaran</h6>
            <p>
                Sama halnya dengan bank, Anda juga belum memiliki anggaran apapun didaftar anggaran. Untuk membuat anggaran, 
                Anda pergi kemenu <span class="text-primary">Anggaran</span>, kemudian klik <span class="text-primary"><i class="fas fa-plus"></i> Tambah Anggaran</span>
                , setelah itu akan muncul sebuah form dan bisa Anda isi nama anggaran yang Anda inginkan (misal: listrik, makan, uang jajan, dll.). Setelah 
                selesai, klik <span class="text-primary">Buat Anggaran</span>. Jika berhasil, maka akan muncul nama anggaran 
                yang telah Anda buat di tabel anggaran. Anda juga dapat mengeditnya dengan klik <i class="fas fa-edit text-green"></i> 
                atau menghapusnya dengan klik <i class="fas fa-trash text-red"></i>.
            </p>
        </div>
    </div>
    
    <h5 class="mb-3">LANGKAH 3</h5>
    <div class="card mb-4">
        <div class="card-body">
            <h6>Input Pemasukan</h6>
            <p>
                Setelah Anda membuat bank dan anggaran, Anda sudah dapat menginputkan pemasukan dan pengeluaran Anda untuk 
                mengelola keuangan pribadi Anda. Ada dua cara untuk input pemasukan/pengeluaran. Cara pertama, dibagian 
                <span class="text-primary">Dashboard</span> Anda tepatnya diatas grafik pemasukan dan pengeluaran, klik 
                <span class="text-primary">Buat Pemasukan</span>, kemudian akan muncul sebuah form. Isi nominal uang yang
                yang anda inginkan untuk jumlah uang, lalu pilih bank. Bank tersebut berfungsi untuk menyimpan data uang Anda
                dan nilainya akan bertambah jika Anda melakukan input pemasukan. Pastikan Anda memilih bank yang sesuai.
                Untuk cara yang kedua, Anda pergi kemenu <span class="text-primary">Bank</span>. Dibawah tabel bank ada dua form,
                yaitu buat pemasukan dan buat pengeluaran. Pilih <span class="text-primary">Buat Pemasukan</span>, isi nominal uang
                dan bank yang Anda inginkan, lalu klik <span class="text-primary">Buat</span>. Jika berhasil, saldo uang yang ada di
                bank Anda akan bertambah.
            </p>
        </div>
    </div>
    
    <h5 class="mb-3">LANGKAH 4</h5>
    <div class="card mb-4">
        <div class="card-body">
            <h6>Input Pengeluaran</h6>
            <p>
                Sama halnya dengan input pemasukan, ada dua cara untuk input pengeluaran. Cara pertama, dibagian 
                <span class="text-primary">Dashboard</span> Anda tepatnya diatas grafik pemasukan dan pengeluaran, klik 
                <span class="text-primary">Buat Pengeluaran</span>, kemudian akan muncul sebuah form. Isi nominal uang yang
                yang anda inginkan untuk jumlah uang, lalu pilih bank. Bank tersebut berfungsi untuk menyimpan data uang Anda
                dan nilainya akan berkurang jika Anda melakukan input pengeluaran. Lalu pilih anggaran yang Anda inginkan, jika
                tidak ada, Anda dapat membuatnya dimenu <span class="text-primary">Anggaran</span>, caranya seperti LANGKAH 2.
                Untuk cara yang kedua, Anda pergi kemenu <span class="text-primary">Bank</span>. Dibawah tabel bank ada dua form,
                yaitu buat pemasukan dan buat pengeluaran. Pilih <span class="text-primary">Buat Pengeluaran</span>, isi nominal uang
                dan bank yang Anda inginkan, serta anggarannya, lalu klik <span class="text-primary">Buat</span>. Jika berhasil, saldo uang yang ada di
                bank Anda akan berkurang.
            </p>
        </div>
    </div>
    
    <h5 class="mb-3">LAIN-LAIN</h5>
    <div class="card mb-4">
        <div class="card-body">
            <h6>History</h6>
            <p>
                Dibagian history ini Anda dapat melihat pemasukan dan pengeluaran yang telah Anda lakukan. Anda dapat
                mengevaluasi arus keuangan Anda yang akan memudahkan Anda dalam mengelola keuangan.
            </p>
            
            <h6>Laporan</h6>
            <p>
                Dibagian laporan berisi data-data pemasukan dan pengeluaran Anda selama satu bulan. Secara default, laporan
                disesuaikan pada bulan sebelumnya, namun Anda juga dapat menyetelnya dengan memilih bulan dan tahun yang Anda
                inginkan. Lalu klik <span class="text-primary">Buat Laporan</span>. Jika berhasil, data-data laporan akan
                sesuai dengan bulan dan tahun yang Anda inginkan. Anda dapat mendownload laporan ini dalam bentuk file pdf dengan mengeklik 
                <span class="text-primary"><i class="fas fa-download"></i> Download</span>.
            </p>
            
            <h6>Bantuan</h6>
            <p>
                Jika Anda memiliki pertanyaan atau kesulitan dalam menggunakan aplikasi, Anda dapat mengajukan pertanyaan dengan mengeklik
                <span class="text-primary">Ajukan Pertanyaan</span>
                , setelah itu akan muncul sebuah form dan bisa Anda isi dengan pertanyaan yang Anda inginkan. Setelah 
                selesai, klik <span class="text-primary">Kirim</span>. Anda juga dapat mengeditnya dengan klik <i class="fas fa-edit"></i> 
                atau menghapusnya dengan klik <i class="fas fa-trash"></i>. Admin akan menanggapi pertanyaan Anda.
            </p>
            
            <h6>Feedback</h6>
            <p>
                Feedback Anda sangat berarti untuk pengembangan aplikasi saving, kritik dan masukan Anda melalui feedback ini akan kami 
                terima dengan baik demi kemajuan aplikasi saving. Kami sebagai pengembang aplikasi saving meminta Anda memberikan feedback Anda, 
                apa saja fitur yang harus ditambahkan ataupun fitur mana yang harus diperbaiki. Anda juga bisa memberikan feedback kepada kami 
                berisi kesan dan pesan Anda selama menggunakan aplikasi saving ini. Anda dapat mengirim feedback Anda dengan
                mengeklik <span class="text-primary">Kirim Feedback</span>.
            </p>
            
            <h6>Akun</h6>
            <p>
                Dibagian akun, Anda dapat mengeditnya dengan klik <i class="fas fa-edit"></i> 
                atau menghapusnya dengan klik <i class="fas fa-trash"></i>. Jika Anda mengeklik <i class="fas fa-trash"></i>
                maka akun Anda akan terhapus dan Anda akan keluar dari aplikasi. Anda tidak dapat login kembali dengan email dan 
                password Anda sebelumnya karena akun Anda sudah terhapus.
            </p>
        </div>
    </div>
</div>

@endsection