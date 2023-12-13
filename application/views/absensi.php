 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
 integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
 crossorigin=""/>
 <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />

 <style type="text/css">
 #map { height: 400px; }

</style>
<div class="main">
    <div class="main-content">
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Absensi</h3>
                    <a  class="btn btn-danger" href="<?php echo base_url(); ?>home"><span> Home</span></a><br>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">

                        <input type="hidden" id="time_absen" value="<?php echo date('H:i:s') ?>">
                        <input type="hidden" id="jarak" >

                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Informasi</h3>
                            </div>
                            <div class="panel-body" style="background:#DCDCDC">
                                <p>Anda Absen Pada Hari ini Jam ( <?php echo date('H:i'); ?> wib ) dan </p>
                                <p>Berada pada ( <span id="info_jarak"></span> .Km ) dari titik lokasi absensi</p>
                            </div>
                        </div>

                        <?php if ($type == 'in') { ?>
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Pilih</h3>
                            </div>
                            <div class="panel-body">
                                    <select class="form-control" id="kategori">
                                        <option value="" selected="">-pilih-</option>
                                        <option value="wfh">WFH</option>
                                        <option value="wfo">WFO</option>
                                        <option value="dl">DL</option>
                                    </select>
                            </div>
                        </div>
                        <?php }?>

                        <?php if ($type == 'in') { ?>
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Ambil Foto</h3>
                            </div>
                            <div class="panel-body">
                                <div id="my_camera"></div>
                                <div id="results"></div>
                            </div>
                        </div>
                        <?php }?>

                    </div>
                    <div class="col-md-8">
                        <div class="panel panel-headline">
                            <div class="panel-body">
                                <h4>Maps</h4>
                                <div id="map"></div>
                                <input type="hidden" id="myLoc">
                                <!-- <div class="text-right"><a onclick="load_maps()" class="btn btn-primary btn-sm">refresh</a></div> -->
                            </div>
                        </div>
                        <div class="panel panel-headline">
                            <div class="panel-body">
                                <h4>Informasi Kegiatan / Pekerjaan Hari Ini</h4>
                                <textarea class="form-control" placeholder="Input disini..." rows="4" id="note"></textarea>
                            </div>
                        </div>
                        <?php if ($type == 'in') { ?>
                            <div class="text-right"><button type="button" class="btn btn-primary btn-lg" onclick="cek_absen()">Absen Masuk</button></div>
                        <?php }else{ ?>
                            <div class="text-right"><button type="button" class="btn btn-danger btn-lg" onclick="cek_absen()">Absen Keluar</button></div>
                        <?php }?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<footer>
    <div class="container-fluid">
      <p class="copyright">&copy; <?php echo date('Y'); ?> ~ Sri Wahyuni</p>
  </div>
</footer>


<script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
   integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
   crossorigin=""></script>
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/jquery/webcam.js"></script>
<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<script type="text/javascript">
    var kategori = '<?php echo $kategori; ?>';
    var tipe = '<?php echo $type; ?>';
    $(document).ready(function() {
        if (tipe == 'in') {
            get_camera();
            get_maps();
        }else{
            get_maps();
        }
    });

    function get_camera(){
        Webcam.set({
            width: 400,
            height: 300,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach( '#my_camera' );
    }

    function get_maps(){
        navigator.geolocation.getCurrentPosition(function(position) {
            let lat = position.coords.latitude;
            let long = position.coords.longitude;
            var myPosition = [lat,long];
            $('#myLoc').val(myPosition);

            var tujuan = [<?php echo $latLong; ?>];

            var map = L.map('map').setView(myPosition, 18);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker(myPosition).addTo(map);

            var circle = L.circle(tujuan, {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 40
            }).addTo(map);

            var dis = L.latLng(myPosition).distanceTo(tujuan) / 1000;
            $('#info_jarak').text(dis.toFixed(1));
            $('#jarak').val(dis);
        });
    }

    function cek_absen(){
        if ($('#time_absen').val() == '' || $('#jarak').val() == '' || $('#note').val() == '' || $('#latLong').val() == '') {
            swal("Warning!", "Data Belum Lengkap !", "warning");
            return false;
        }
        if (tipe == 'in') {
            if ($('#kategori').val() == '' ) {
                swal("Warning!", "Data Belum Lengkap !", "warning");
                return false;
            }
            if ($('#kategori').val() == 'wfo') {
                var nilai_jarak = $('#jarak').val();
                if (nilai_jarak > 0.5) {
                    swal("Warning!", "Lokasi absen berada diluar radius lokasi absen !", "warning");
                    return false;
                }
            }
        }else{
            if (kategori == 'wfo') {
                var nilai_jarak = $('#jarak').val();
                if (nilai_jarak > 0.5) {
                    swal("Warning!", "Anda Sedang WFO, Lokasi absen berada diluar radius lokasi absen !", "warning");
                    return false;
                }
            }
        }
        absen();
    }

    function absen(){
        if (tipe == 'in') {
            Webcam.snap(function (data_uri) {
                Webcam.upload( data_uri, '<?php echo site_url('absensi/upload');?>/' + tipe, function(code, text) {
                    document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
                });
            });
        }
        if (tipe == 'in') {
            var title = 'Selamat Datang !';
        }else{
            var title = 'Selamat Pulang !';
        }
        $.ajax({
            url : "<?php echo site_url('absensi/simpan')?>",
            type: "POST",
            data: {
                "time": $('#time_absen').val(),
                "latLong": $('#myLoc').val(),
                "type": tipe,
                "note": $('#note').val(),
                "jarak": $('#jarak').val(),
                "kategori": $('#kategori').val()
            },
            dataType: "JSON",
            success: function(data){
                if(data.status == true){
                    swal({
                        title: title,
                        text: "Terimakasih Telah Absen",
                        icon: "success",
                        dangerMode: true,
                    })
                    .then(willDelete => {
                        if (willDelete) {
                            location.replace("<?php echo base_url()?>home");  
                        }
                    });
                }else{
                    swal("Erorr !",data.msg, "error");
                }
            },
            error: function (jqXHR, textStatus, errorThrown){
                swal('Error Save!');
            }
        });
    }
</script>
