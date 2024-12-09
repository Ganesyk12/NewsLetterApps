<div class="container">
   <!-- Outer Row -->
   <div class="row justify-content-center">
      <div class="col-md-5">
         <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
               <div class="row">
                  <div class="col-md-12">
                     <div class="p-5">
                        <div class="text-center">
                           <h1 class="h4 text-gray-900 mb-4">Login to your session</h1>
                        </div>
                        <form class="user" method="post" action="<?= base_url('auth/login'); ?>">
                           <div class=" form-group">
                              <input type="text" class="form-control form-control-user" id="username" name="username" aria-describedby="username" placeholder="Enter Name...">
                           </div>
                           <div class="form-group">
                              <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                           </div>
                           <div class="col-md-12">
                              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                           </div>
                        </form>
                        <hr>
                        <div class="text-center">
                           <a class="small" data-toggle="modal" data-target="#registModal">Create an Account!</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="registModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create New Account</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form class="user" id="form-regist">
               <div class="form-group row" hidden>
                  <div class="col-sm-12 mb-3 mb-sm-0">
                     <input type="text" class="form-control form-control-user" id="id_user" name="id_user" placeholder="Id user">
                  </div>
               </div>
               <div class="form-group row" hidden>
                  <div class="col-sm-12 mb-3 mb-sm-0">
                     <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username">
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-sm-12 mb-3 mb-sm-0">
                     <input type="text" class="form-control form-control-user" id="nama" name="nama" placeholder="Full Name">
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-sm-12 mb-3 mb-sm-0">
                     <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-sm-12 mb-3 mb-sm-0">
                     <select class="form-control" aria-label="Select Role" id="role_id" name="role_id">
                        <option selected>Select Role</option>
                        <?php
                        foreach ($roles as $value) {
                           echo "<option value='$value->role_id'>$value->role_name</option>";
                        }
                        ?>
                     </select>
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button class="btn btn-primary btn-user" type="button" onclick="regist()">Regist</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">
   function regist() {
      var fdata = new FormData
      var form_data = $('#form-regist').serializeArray();
      $.each(form_data, function(key, input) {
         fdata.append(input.name, input.value);
      });
      var vurl = "<?= base_url('auth/regist') ?>";

      $.ajax({
         url: vurl,
         method: "post",
         processData: false,
         contentType: false,
         data: fdata,
         success: function(data) {
            $('#form-regist')[0].reset();
            $('#role_id').select().val('');
            $('#registModal').modal('hide');
            // Show success message
            Swal.fire({
               position: "center",
               icon: "success",
               title: "Your work has been saved",
               showConfirmButton: false,
               timer: 1500
            });
         },
         error: function(e) {
            // Show error message
            Swal.fire({
               position: "center",
               icon: "error",
               title: "Your work has not saved",
               showConfirmButton: false,
               timer: 1500
            });
         },
      })
   }
</script>