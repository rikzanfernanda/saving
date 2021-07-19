@extends('layout.home')
@section('content')

<section id="hero" class="d-flex align-items-center">
    <div class="container position-relative" data-aos="fade-up" data-aos-delay="500">
        <h1>WELCOME TO SAVING</h1>
        <h2>Grow to be Rich</h2>
        <a href="" class="btn-get-started scrollto" data-toggle="modal" data-target="#modalRegistrasi">Get Started</a>
    </div>
</section>

<main id="main">
    <section id="fitur" class="services">
        <div class="container">

            <div class="section-title">
                <span>Fitur</span>
                <h2>Fitur</h2>
                <p>
                    Saving adalah sebuah aplikasi untuk mengelola keuangan pribadi. Segala aktifitas pemasukan
                    dan pengeluaran dapat dicatat dalam satu aplikasi ini.
                </p>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up">
                    <div class="icon-box w-100">
                        <div class="icon"><i class="bx bx-bar-chart"></i></div>
                        <h4>Grafik</h4>
                        <p>Grafik pemasukan dan pengeluaran setiap bulan yang dapat Anda kontrol</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="150">
                    <div class="icon-box w-100">
                        <div class="icon"><i class="bx bx-file"></i></div>
                        <h4>Laporan</h4>
                        <p>Laporan pemasukan dan pengeluaran serta jumlah uang yang Anda simpan. Buat lebih mudah tanpa ribet</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon-box w-100">
                        <div class="icon"><i class="bx bx-download"></i></div>
                        <h4>Download Laporan</h4>
                        <p>Download laporan yang telah Anda buat agar dapat Anda simpan</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="fade-up" data-aos-delay="450">
                    <div class="icon-box w-100">
                        <div class="icon"><i class="bx bx-calculator"></i></div>
                        <h4>Plan</h4>
                        <p>Buat rencana anggaran Anda dan evaluasi hasilnya</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="icon-box w-100">
                        <div class="icon"><i class="bx bx-coin-stack"></i></div>
                        <h4>Bank</h4>
                        <p>Cek berapa uang yang Anda simpan dalam bank Anda</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="fade-up" data-aos-delay="750">
                    <div class="icon-box w-100">
                        <div class="icon"><i class="bx bx-archive-out"></i></div>
                        <h4>Anggaran</h4>
                        <p>Buat pengeluaran Anda lebih terkontrol dengan membuat beberapa anggaran</p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <section id="cta" class="cta">
        <div class="container" data-aos="zoom-in">

            <div class="text-center">
                <h4 class="text-white">"Uang tidak pernah membodohi siapa pun, melainkan hanya menunjukkan siapa kita." </h4>
                <p>Kelola keuangan Anda di saving untuk menuju kesuksesan finansial. Aplikasi ini gratis dan pengguna juga terbatas.</p>
                <p><b>Yuk registrasi sekarang</b></p>
                <a class="cta-btn" href="" data-toggle="modal" data-target="#modalRegistrasi">REGISTRASI</a>
            </div>

        </div>
    </section>
    
    <section id="contact" class="contact">
        <div class="container">

            <div class="section-title">
                <span>Contact</span>
                <h2>Contact</h2>
            </div>

            <div class="row" data-aos="fade-up">
                <div class="col-lg-6">
                    <div class="info-box mb-4">
                        <i class="bx bx-map"></i>
                        <h3>Our Address</h3>
                        <p>Pemalang, Jawa Tengah, Indonesia</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="info-box  mb-4">
                        <i class="bx bx-envelope"></i>
                        <h3>Email Us</h3>
                        <p>rikzanfernanda@gmail.com</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="info-box  mb-4">
                        <i class="bx bx-phone-call"></i>
                        <h3>Call Us</h3>
                        <p>+62 8515 7660 753</p>
                    </div>
                </div>

            </div>

        </div>
    </section>

</main>


@endsection

