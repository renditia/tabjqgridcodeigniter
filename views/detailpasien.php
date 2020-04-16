<!-- Begin Page Content -->
<div id="cntdetail">
            <table id="list2dt"></table>
            <div id="pager2dt"></div>
        </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script type="text/javascript">
    $(document).ready(function(){

    var grid_selector = "#list2dt";
    var pager_selector = "#pager2dt";

    // resize to fit page size
    $(window).on('resize.jqGrid', function () {
        $(grid_selector).jqGrid('setGridWidth', $(".ui-tabs .ui-tabs-panel").width());
    });

    jQuery("#list2dt").jqGrid({
            url: '<?php echo base_url();?>detailtab/dataPasien',
            postData: { id_pasien : '<?= $id_pasien; ?>' },
            datatype: "json",
            mtype: "POST",
            colModel:[
                {label:'ID', name:'id_p',index:'id_p', width:55, editable:true, hidden:false, editoptions:{readonly:"readonly"}},
                {label:'Nama', name:'nama',index:'nama', width:90, editable:true},
                {label:'Alamat', name:'alamat',index:'alamat', width:100, editable:true}        
            ],
            rowNum:10,
            rowList:[10,20,30],
            pager: '#pager2dt',
            sortname: 'id_p',
            viewrecords: true,
            shrinktofit:true,
            autowidth:true,
            sortorder: "desc",
            caption:"Detail Pasien",
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
                      $("#list2dt").setSelection($("#list2dt").getDataIDs()[0],true);
                },500);

            },
            editurl:'<?php echo base_url();?>detailtab/crud',
        });

        jQuery("#list2dt").jqGrid('navGrid','#pager2dt',{edit:true,add:true,del:true},
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




