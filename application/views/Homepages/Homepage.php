<header class="masthead">
   <div class="container position-relative">
      <div class="row justify-content-center">
         <div class="col-xl-6">
            <div class="text-center text-white">
               <img src="<?= base_url('assets') ?>/img/berbagi2.jpg" class="card-img-top" height="auto" width="max" alt="berita">
               <!-- Page heading-->
               <h1 class="mb-5">Selamat Datang di Web Kami</h1>
               <h5>Tempat Sharing berbagai berita terkini</h5>
            </div>
         </div>
      </div>
   </div>
</header>
<section class="testimonials bg-light">
   <div class="container">
      <h2 class="mb-5 text-center">Berita Terkini</h2>
      <div class="row">
         <?php foreach ($berita as $key => $value) { ?>
            <div class="col-lg-4">
               <div class="card" style="width: auto;">
                  <img src="<?= base_url('assets/img/upload/' . $value->foto) ?>" class="card-img-top" alt="berita">
                  <div class="card-body">
                     <p class="card-text"><?= $value->judul ?></p>
                  </div>
                  <div class="card-footer">
                     <p>Diunggah pada : <?= $value->tgl_upload ?></p>
                  </div>
               </div>
            </div>
         <?php } ?>
      </div>
   </div>
</section>