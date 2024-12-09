<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
   <?php $name = $this->session->userdata('name') ?>
   <div id="content">
      <!-- Load component navbar -->
      <?php $this->load->view('templates/navbar') ?>
      <div class="container-fluid">
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
         </div>
         <div class="row">
            <div class="col-lg-12">
               <div class="card shadow mb-4">
                  <div class="card-header py-3">
                     <div class="col-md-3">
                        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#beritaModal">Add Data</button>
                     </div>
                  </div>
                  <div class="card-body">
                     <div class="table-responsive">
                        <table class="table table-bordered" id="berita-table" cellspacing="0" width="100%">
                           <thead class="text-center">
                              <tr>
                                 <th>No</th>
                                 <th>Judul</th>
                                 <th>Foto</th>
                                 <th>Aktif</th>
                                 <th>Diupload Pada</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody></tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- MODAL ADD -->
   <div class="modal fade" id="beritaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">FORM DATA</h5>
               <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
               <form class="user" id="quickForm" enctype="multipart/form-data">
                  <div class="form-group row" hidden>
                     <div class="col-sm-12 mb-3 mb-sm-0">
                        <input type="text" class="form-control form-control-user" id="id_berita" name="id_berita" placeholder="Id berita">
                     </div>
                  </div>
                  <div class="form-group row">
                     <div class="col-sm-12 mb-3 mb-sm-0">
                        <label for="judul" class="form-label">Judul Redaksi</label>
                        <input type="text" class="form-control form-control-user" id="judul" name="judul" placeholder="Masukkan Judul">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="foto" class="col-sm-12 col-form-label">Dokumentasi</label>
                     <div class="col-sm-12 mb-3 mb-sm-0">
                        <div class="col-sm-auto text-center">
                           <img id="v_image" width="200px" height="200px" class="mt-3 mb-2" style="justify-content:center; align-items:center;">
                           <div class="media-container d-flex justify-content-center mb-auto" style="margin: 0 auto;">
                              <input type="file" id="foto" name="foto" onchange="loadFile(event, 'v_image')">
                              <label class="input-group-text" for="foto" id="foto_label">Upload</label>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label class="col-sm-12 mb-3 col-form-label">Status</label>
                     <div class="container">
                        <div class="d-flex justify-content-left">
                           <div class="form-check mr-5">
                              <input class="form-check-input" type="radio" name="active" id="active1" value="Y">
                              <label class="form-check-label" for="active1">
                                 Active
                              </label>
                           </div>
                           <div class="form-check">
                              <input class="form-check-input" type="radio" name="active" id="active2" value="N">
                              <label class="form-check-label" for="active2">
                                 NO
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
            <div class="modal-footer">
               <a class="btn btn-primary" id="btnsubmit" onclick="Simpan_data('Add')">Simpan Data</a>
               <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
         </div>
      </div>
   </div>

   <!-- MODAL DELETE -->
   <div class="modal fade" id="modal-delete">
      <div class="modal-dialog">
         <div class="modal-content bg-danger text-white">
            <div class="modal-header">
               <h4 class="modal-title">Delete Modal</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <label id="iddelete2" hidden> </label>Apakah ingin delete <label id="iddelete"> </label> ?
            </div>
            <div class="modal-footer justify-content-right">
               <form action="#" method="post">
                  <button type="button" id="delete" onclick="Delete_data()" class="btn btn-outline-light">Yes</button>
               </form>
               <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
            </div>
         </div>
      </div>
   </div>