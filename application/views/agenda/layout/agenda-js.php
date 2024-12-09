<script text="text/javascript">
   var mainTable = null;
   $(document).ready(function() {
      mainTable = $('#agenda-table').DataTable({
         "processing": true,
         "responsive": true,
         "serverSide": true,
         "ordering": true,
         "autoWidth": true,
         "order": [
            [2, 'asc']
         ],
         "ajax": {
            "url": "<?= base_url('C_Agenda/view_data_where'); ?>",
            "type": "POST",
            "data": function(data) {
               data.searchByFromdate = $('#search_fromdate').val();
               data.searchByTodate = $('#search_todate').val();
            }
         },
         "deferRender": true,
         "aLengthMenu": [
            [10, 100, 1000, 1000000000],
            [10, 100, 1000, "All"]
         ],
         "columns": [{
               "data": 'id_agenda',
               render: function(data, type, row, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
               }
            },
            {
               "data": "photo",
               render: function(data, type, row, meta) {
                  var baseUrl = "<?= base_url('assets/img/upload/') ?>";
                  var defaultImage = "<?= base_url('assets/img/upload/nopic.png') ?>";
                  return data ? '<img src="' + baseUrl + data + '" alt="Agenda Photo" width="80" height="80">' : '<img src="' + defaultImage + '" alt="Agenda Photo" width="80" height="80">';
               }
            },
            {
               "data": "id_agenda",
               "sortable": false,
               render: function(data, type, row, meta) {
                  mnu = '';
                  mnu = mnu + '<div class="btn btn-success btn-sm konfirmasiView" data-id="' + data + '" data-toggle="modal" data-target="#agendaModal" > <i class="fa fa-eye"></i></div>';
                  mnu = mnu + '<div class="btn btn-primary btn-sm konfirmasiEdit" data-id="' + data + '" data-toggle="modal" data-target="#agendaModal"> <i class="fa fa-edit"></i></div>';
                  mnu = mnu + '<div class="btn btn-danger btn-sm konfirmasiHapus" data-id="' + data + '" data-toggle="modal" data-target="#modal-delete" > <i class="fa fa-trash"></i></div>';
                  return mnu;
               }
            },
         ],
      })
   })

   var loadFile = function(event, imageId) {
      var image = document.getElementById(imageId);
      image.src = URL.createObjectURL(event.target.files[0]);
   };

   function Simpan_data($trigger) {
      var fdata = new FormData();
      var form_data = $('#quickForm').serializeArray();
      $.each(form_data, function(key, input) {
         fdata.append(input.name, input.value);
      });

      $('#quickForm input[type="file"]').each(function(i, e) {
         if ($('#' + e.getAttribute("name")).val()) {
            var file_data = $('#' + e.getAttribute("name")).prop('files')[0];
            fdata.append(e.getAttribute("name"), file_data);
         }
      });

      // Periksa jika ada foto yang sudah ada
      var existing_photo = $('#foto_label').text() !== 'No file | Upload' ? $('#foto_label').text() : null;
      if (existing_photo) {
         fdata.append('photo', existing_photo);
      }

      var url = null;
      if ($trigger === 'Add') {
         url = "<?= base_url('C_Agenda/ajax_add') ?>";
      } else {
         url = "<?= base_url('C_Agenda/ajax_update') ?>";
      }

      $.ajax({
         url: url,
         method: "post",
         processData: false,
         contentType: false,
         data: fdata,
         success: function(data) {
            $('#quickForm')[0].reset();
            $('#agendaModal').modal('hide');
            mainTable.draw();
            var toastMessage = $trigger === 'Add' ? 'Data berhasil disimpan!' : 'Data berhasil diperbarui!';
            location.reload();
            // Tampilkan pesan sukses
            Swal.fire({
               position: "center",
               icon: "success",
               title: toastMessage,
               showConfirmButton: false,
               timer: 1500
            });
         },
         error: function(e) {
            // Tampilkan pesan kesalahan
            Swal.fire({
               position: "center",
               icon: "error",
               title: "Data tidak berhasil disimpan",
               showConfirmButton: false,
               timer: 1500
            });
         },
      });
   }

   $(document).on("click", ".konfirmasiHapus", function() {
      $('#iddelete').text($(this).attr("data-id"));
   })
   $(document).on("click", ".konfirmasiEdit", function() {
      view_modal($(this).attr("data-id"), 'Edit');
   })
   $(document).on("click", ".konfirmasiView", function() {
      view_modal($(this).attr("data-id"), 'View');
   })
   // ID Rows selected
   $('#agenda-table').on('click', 'tr', function() {
      $('#iddelete2').text($('#agenda-table').DataTable().row(this).id());
   });


   function view_modal(id_agenda, status) {
      // Reset the form and clear image preview
      $('#quickForm')[0].reset();
      $('#v_image').attr('src', '<?= base_url('assets/img/upload/nopic.png') ?>');
      $('#foto_label').html('No file | Upload');

      if (status == "Add") {
         $('#exampleModalLabel').text('ADD DATA BERITA');
         $('#btnsubmit').attr('onclick', 'Simpan_data(\'Add\')');
         $('#btnsubmit').text('Submit');
         $('#v_image').attr('src', '<?= base_url('assets/img/upload/nopic.png') ?>');
         $('#foto_label').html('No file | Upload');
         document.getElementById("btnsubmit").style.visibility = "visible";
      } else if (status == "Edit" || status == "View") {
         if (status == "View") {
            document.getElementById("btnsubmit").style.visibility = "hidden";
            $('#exampleModalLabel').text('View Data');
         } else {
            $('#exampleModalLabel').text('Edit Data');
            $('#btnsubmit').attr('onclick', 'Simpan_data(\'Edit\')');
            $('#btnsubmit').text('Update');
            document.getElementById("btnsubmit").style.visibility = "visible";
         }

         $.ajax({
            url: "<?= base_url('C_Agenda/ajax_getbyhdrid') ?>",
            method: "get",
            dataType: "JSON",
            data: {
               id_agenda: id_agenda
            },
            success: function(data) {
               $('#id_agenda').val(data.id_agenda);
               if (data.photo === null) {
                  var image = "<?= base_url('assets/img/upload/nopic.png') ?>";
                  $("#v_image").attr("src", image);
               } else {
                  var image = "<?= base_url('assets/img/upload/') ?>";
                  $("#v_image").attr("src", image + data.photo);
               }
               document.getElementById('foto_label').innerHTML = data.photo ? data.photo : 'No file | Upload';
            },
            error: function(e) {
               alert(e);
            }
         });
      } else {
         $('#exampleModalLabel').text('View Data');
         document.getElementById("btnsubmit").style.visibility = "hidden";
      }
   }

   function Delete_data() {
      var fdata = new FormData();
      fdata.append('id_agenda', $('#iddelete').text());
      vurl = "<?= base_url('C_Agenda/ajax_delete') ?>";
      $.ajax({
         url: vurl,
         method: "post",
         processData: false,
         contentType: false,
         data: fdata,
         success: function(data) {
            $('#modal-delete').modal('hide');
            $('#agenda-table').DataTable().row("#" + $('#iddelete2').text()).remove().draw();
            // Show success message
            location.reload();
            Swal.fire({
               position: "center",
               icon: "success",
               title: "Success Deleted!",
               showConfirmButton: false,
               timer: 1500
            });
         },
         error: function(e) {
            // Show error message
            Swal.fire({
               position: "center",
               icon: "error",
               title: "Error deleted data!",
               showConfirmButton: false,
               timer: 1500
            });
         }
      });

   }
</script>