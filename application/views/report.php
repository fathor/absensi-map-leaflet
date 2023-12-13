
<!-- MAIN -->
<div class="main">
  <!-- MAIN CONTENT -->
  <div class="main-content">
    <div class="container-fluid">


      <div class="col-md-6">
        <div class="panel panel-headline">
          <div class="panel-heading">
            <h3 class="panel-title">Laporan Absen</h3>
            <p class="panel-subtitle">Period: <?php echo date('d-F-Y'); ?></p>
          </div>
          <div class="panel-body">

            <div class="form-group">
              <label for="account">Pegawai</label>
              <select class="form-control select2" id="filter_emp" name="filter_emp" style="width: 100%;"></select>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label >Mulai Tanggal</label>
                  <div class="position-relative has-icon-left">
                    <input type="text" class="form-control datepicker" id="filter_first_date" name="filter_first_date" value="<?php echo date('Y-m-01'); ?>">
                    <div class="form-control-position">
                      <i class="la la-caret-square-o-left"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label >Sampai Tanggal</label>
                  <div class="position-relative has-icon-left">
                    <input type="text" class="form-control datepicker" name="filter_last_date" id="filter_last_date" value="<?php echo date('Y-m-d'); ?>">
                    <div class="form-control-position">
                      <i class="la la-caret-square-o-right"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <div class="form-footer">
              <div class="text-right">
                <button type="button" class="btn btn-primary btn-xs" onclick="view_data()"><i class="fa fa-search"></i> Lihat </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- OVERVIEW -->
      <div class="col-md-12">
        <div class="panel panel-headline">
          <div class="panel-body">
           <div class="row">

            <div class="box-body">
              <div class="table-responsive">
                <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th rowspan="2" style="text-align: center;">No</th>
                      <th rowspan="2" style="text-align: center;">Nama Pegawai</th>
                      <th rowspan="2" style="text-align: center;">Nip</th>
                      <th rowspan="2" style="text-align: center;">Lokasi Kerja</th>
                      <th rowspan="2" style="text-align: center;">Kategori Absen</th>
                      <th rowspan="2" style="text-align: center;">Tanggal</th>
                      <th colspan="3" style="text-align: center;">Absen Masuk</th>
                      <th colspan="3" style="text-align: center;">Absen Keluar</th>
                      <th rowspan="2" style="text-align: center;">Action</th>
                    </tr>
                    <tr>
                      <th style="text-align: center;">Jam</th>
                      <th style="text-align: center;">Jarak</th>
                      <th style="text-align: center;">status</th>
                      <th style="text-align: center;">Jam</th>
                      <th style="text-align: center;">Jarak</th>
                      <th style="text-align: center;">status</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <!-- END OVERVIEW -->
  </div>
</div>
<!-- END MAIN CONTENT -->
</div>
<!-- END MAIN -->
<div class="clearfix"></div>
<footer>
  <div class="container-fluid">
    <p class="copyright">&copy; 2017 <a href="https://www.themeineed.com" target="_blank">Theme I Need</a>. All Rights Reserved.</p>
  </div>
</footer>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" id="modal-detil" role="dialog">
  <div class="modal-dialog modal-lg" role="document" style="width: 100%;">
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title lead">DETAIL ABSEN </h4>
      </div>
      <div class="modal-body form" >
        <form action="#" id="form_update" class="form-horizontal" id="from-detil">
          <div class="form-body">

            <!-- <div id="balikans"></div> -->
            <div class="row">
              <div class="col-md-12">
                <div class="panel">
                  <div class="col-md-4">
                    <div class="panel-body">
                      <div class="profile-main">
                        <img class="img" alt="Trulli" width="400" height="270" id="myImg">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="panel-body">
                      <h4 class="heading" style="color: blue;"><b>Masuk</b></h4>
                      <p id="note_in"><b>Informasi Kegiatan / Pekerjaan Hari Ini : </b></p><br><hr>
                      <h4 class="heading" style="color: red;"><b>Keluar</b></h4>
                      <p id="note_out"><b>Informasi Kegiatan / Pekerjaan Hari Ini : </b></p><hr>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </form>
      </div>
      <div class="modal-footer" style="background-color: #ecf0f5">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<script>
  var table;
  $(document).ready(function() {
    $('#filter_emp').load("<?php echo site_url('report/getEmp'); ?>");
    $('.datepicker').datepicker({
      autoclose: true,
      format: "yyyy-mm-dd",
      todayHighlight: true,
      orientation: "top auto",
      todayBtn: true,
      todayHighlight: true,
    });
  });


  function view_data(){
    load_table();
  }

  function load_table(){
    table = $('#table').DataTable({
      "destroy": "true",
      "order": [],
      "dom" : 'Bfrtip',
      "buttons" : ['pageLength','copyHtml5','excelHtml5'],
      "pageLength": 1000,
      "lengthMenu": [[5, 10, 50, 100, 1000, -1 ], ['5 Rows', '10 Rows', '50 Rows', '100 Rows', '1000 Rows', 'Show All']],
      "ajax": {
        "url": "<?php echo site_url('report/load_data')?>",
        "type": "POST",
        "data": function ( data ) {
          data.filter_first_date = $('#filter_first_date').val();
          data.filter_last_date = $('#filter_last_date').val();
          data.filter_emp = $('#filter_emp').val();
        },
      },
    });
  }

  function detil(id){
    $('#modal-detil').modal('show');
    var img = document.getElementById("myImg");
    $.ajax({
      url : "<?php echo site_url('report/getData/')?>"+id,
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        if (data) {
          $('#id').val(id);
          $('#note_in').text(data.note_in);
          $('#note_out').text(data.note_out);
          img["src"] = "<?php echo base_url('upload/absensi/')?>"+data.img_in+"?t="+ new Date().getTime();
        }else{
          swal("Error!", "Error Get Data !", "error");
        }
      },
      error: function (jqXHR, textStatus, errorThrown ){
        swal("Error!", "Error get data from ajax !", "error");
      }
    });

  }
</script>