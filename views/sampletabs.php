<script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
</script>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- content table list mahasiswa -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-lg-4 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pasien</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">

                    <!-- Content here ! -->
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1">Pasien</a></li>
                            <li><a href="#tabs-2">Details</a></li>
                        </ul>
                        <div id="tabs-1">
                            <table id="list2"></table>
                            <div id="pager2"></div>
                        </div>
                        <div id="tabs-2">
                            <div id="tabsdt"></div>
                        </div>
                    </div>
                   
                </div>  
                <!-- end card body -->
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script type="text/javascript">
    $(document).ready(function(){
        $("#tabs ul li a").click(function (e) {
            if($(this).attr("href") == "#tabs-2"){
                // get elemet grid tab (1)
                var grid = $('#list2');   
                // get atribute dari selrow yang di select             
                var idpsn = grid.jqGrid('getGridParam', 'selrow');
                // get value field dari selrow yang di piliih , nama & id_p merupakan field
                // yang ada di jqgrid (merefer ke name nya)
                var nama = grid.jqGrid('getCell', idpsn, 'nama');
                var id_p = grid.jqGrid('getCell', idpsn, 'id_p');
                
                // load & get content detail untuk di put di tabs 2 
                $.ajax({
                    type: 'POST',
                    url: "<?= base_url();?>detailtab",
                    // data yang di kirim (method post) ke detail sebagai filter
                    // query data d detail, data dsini bisa di sesuaikan dengan kebutuhan
                    // tidak harus 2 (id_pasien & nama pasien) 
                    data: {id_pasien:id_p,
                           nama_pasien : nama
                          },
                    timeout: 10000,
                    success: function (data) {
                        $("#tabsdt").html(data);
                    }
                })  
                return false;
            }
        });
    });
</script>

<!-- tab1 -->
<script type="text/javascript">
    $(document).ready(function(){

        var grid_selector = "#list2";
        var pager_selector = "#pager2";

        //resize to fit page size
        $(window).on('resize.jqGrid', function () {
            $(grid_selector).jqGrid('setGridWidth', $(".ui-tabs .ui-tabs-panel").width());
        });

        jQuery("#list2").jqGrid({
                url: '<?php echo base_url('sampletab/dataPasien');?>',
                datatype: "json",
                mtype: "POST",
                colModel:[
                    {label:'ID', name:'id_p',index:'id_p', width:55, editable:true, hidden:false, editoptions:{readonly:"readonly"}},
                    {label:'Nama', name:'nama',index:'nama', width:90, editable:true},
                    {label:'Alamat', name:'alamat',index:'alamat', width:100, editable:true}        
                ],
                rowNum:10,
                rowList:[10,20,30],
                pager: '#pager2',
                sortname: 'id_p',
                viewrecords: true,
                shrinktofit:true,
                autowidth:true,
                sortorder: "desc",
                caption:"Data Pasien",
                jsonReader: {
                    root: 'rows',
                    id: 'id',
                    repeatitems: false,
                },
                loadComplete: function () {

                    $(window).on('resize.jqGrid', function () {
                        $(grid_selector).jqGrid('setGridWidth', $(".ui-tabs .ui-tabs-panel").width());
                    });
                
                    setTimeout(function(){
                        $("#list2").setSelection($("#list2").getDataIDs()[0],true);
                        // $("#grid-table").focus();
                    },500);

                },
                editurl:'<?php echo base_url('sampletab/crud');?>',
            });

            jQuery("#list2").jqGrid('navGrid','#pager2',{edit:true,add:true,del:true},
                {
                    // options for the Edit Dialog
                    closeAfterEdit: true,
                    width: 500,
                    errorTextFormat: function (data) {
                        return 'Error: ' + data.responseText
                    },
                    recreateForm: true,
                    afterShowForm: function (e) {
                        $('#birth_date').datepicker({
                        dateFormat: "yy-mm-dd"
                        })
                    }
                },
            {
                //new record form
                width: 500,
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                closeAfterAdd: true,
                recreateForm: true,
                viewPagerButtons: false,
                afterShowForm: function (e) {
                    $('#birth_date').datepicker({
                    dateFormat: "yy-mm-dd"
                    })
                }
            },
        );
    });

</script>
