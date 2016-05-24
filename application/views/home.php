<style type="text/css">
    .ico-rounded hover{
        background-color: #DDD;
        cursor: pointer;
    }
    </style>
<br>
<div class="alert alert-block alert-success">
    <button data-dismiss="alert" class="close" type="button">
        <i class="ace-icon fa fa-times"></i>
    </button>

    <i class="ace-icon fa fa-check green"></i>

    Selamat datang di aplikasi
    <strong class="green">
        E VOTING
        <small>(v1)</small>
    </strong>
</div>

<br>
<div class="row">
    <div class="col-xs-12">
        <div class="col-md-4 col-xs-6">
            <div class="text-center">
                <i class="ico-color ico-lg ico-rounded ico-hover et-profile-male big_menu" data-module="1"></i>
                <h4>Data Penduduk</h4>
                <p class="font-lato size-20">Menu edit,tambah dan hapus data penduduk.</p>
            </div>
        </div>
        <div class="col-md-4 col-xs-6">
            <div class="text-center">
                <i class="ico-color ico-lg ico-rounded ico-hover et-profile-female big_menu" id="kandidat" data-module="2"></i>
                <h4>Data Kandidat</h4>
                <p class="font-lato size-20">Menu edit,tambah dan hapus data kandidat.</p>
            </div>
        </div>
        <div class="col-md-4 col-xs-6">
            <div class="text-center">
                <i class="ico-color ico-lg ico-rounded ico-hover et-profile-male big_menu" id="setting" data-module="3"></i>
                <h4>RT / RW</h4>
                <p class="font-lato size-20">Data RT dan RW</p>
            </div>
        </div>
        
    </div>
    &nbsp;
    &nbsp;
    <div class="col-xs-12">
        <div class="col-md-4 col-xs-6">
            <div class="text-center">
                <i class="ico-color ico-lg ico-rounded ico-hover et-chat big_menu" id="kritik_saran" data-module="4"></i>
                <h4>Kritik & Saran</h4>
                <p class="font-lato size-20">Daftar kritik dan saran dari user.</p>
            </div>
        </div>

        <div class="col-md-4 col-xs-6">
            <div class="text-center">
                <i class="ico-color ico-lg ico-rounded ico-hover et-key big_menu" id="admin" data-module="5"></i>
                <h4>Admin</h4>
                <p class="font-lato size-20">Halaman data admin.</p>
            </div>
        </div>
        <div class="col-md-4 col-xs-6">
            <div class="text-center">
            <i class="ico-color ico-lg ico-rounded ico-hover et-trophy big_menu" id="voting" data-module="6"></i></a>
                <h4>Data Voting</h4>
                <p class="font-lato size-20">Menu buat voting dan hasil voting.</p>
            </div>
        </div>
        
    </div>
</div>
<script type="text/javascript">
    $(".big_menu").click(function(){
        var module_id = $(this).attr('data-module');

       $.post( "<?php echo site_url('home/set_module'); ?>",
        {
            module_id:module_id
        }, 
        function( data ) {
            if(data.success == true){
                 $(location).attr('href','<?php echo site_url("apps/index");?>');

            }
         
        },'json');
    })
</script>