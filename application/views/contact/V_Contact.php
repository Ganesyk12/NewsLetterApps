<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
   <?php $name = $this->session->userdata('name') ?>
   <div id="content">
      <!-- Load component navbar -->
      <?php $this->load->view('templates/navbar') ?>
      <div class="container-fluid">
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Contact Us</h1>
         </div>
         <div class="row">
            <div class="col-xl-6 col-md-6 mb-4">
               <div class="card border-left-info shadow h-100 py-2">
                  <div class="card-body">
                     <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                           <div class="h6 font-weight-bold text-black">HUBUNGI KAMI</div>
                        </div>
                        <div class="col-auto">
                           <i class="fas fa-phone fa-2x text-gray-300"></i>
                        </div>
                     </div>
                     <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                           <div class="h6 font-weight-bold text-black">DI JALAN PURWOREJO</div>
                        </div>
                     </div>
                     <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                           <div class="h6 font-weight-bold text-black">EMAIL : YUKBERBAGI@GMAIL.COM</div>
                        </div>
                     </div>
                     <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                           <div class="h6 font-weight-bold text-black">WA : 0857102345678</div>
                        </div>
                     </div>
                     <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                           <div class="h6 font-weight-bold text-black">IG : YUKBERBAGI</div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
         </div>
      </div>
   </div>