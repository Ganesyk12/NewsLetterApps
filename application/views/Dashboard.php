<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
   <?php $name = $this->session->userdata('name') ?>
   <div id="content">
      <!-- Load component navbar -->
      <?php $this->load->view('templates/navbar') ?>
      <div class="container-fluid">
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
         </div>
         <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
               <div class="card border-left-warning shadow h-100 py-2">
                  <div class="card-body">
                     <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                           <div class="h6 font-weight-bold text-danger">SELAMAT <br> DATANG</div>
                        </div>
                        <div class="col-auto">
                           <i class="fas fa-laugh-wink fa-2x text-gray-300"></i>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
               <div class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">
                     <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                           <div class="text-md font-weight-bold text-success text-uppercase mb-1">Anggota</div>
                           <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                        </div>
                        <div class="col-auto">
                           <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
               <div class="card border-left-info shadow h-100 py-2">
                  <div class="card-body">
                     <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                           <div class="text-sm font-weight-bold text-info text-uppercase mb-1">Berita
                           </div>
                           <div class="row no-gutters align-items-center">
                              <div class="col-auto">
                                 <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"></div>
                              </div>
                           </div>
                        </div>
                        <div class="col-auto">
                           <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
               <div class="card border-left-warning shadow h-100 py-2">
                  <div class="card-body">
                     <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                           <div class="text-sm font-weight-bold text-warning text-uppercase mb-1">
                              Agenda</div>
                           <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                        </div>
                        <div class="col-auto">
                           <i class="fas fa-tasks fa-2x text-gray-300"></i>
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