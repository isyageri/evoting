<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <div id="jqgrid_wrapper">
                <table id="grid"></table>
                <div id="pager"></div>
            </div>
        </div>
        &nbsp;
        <div class="col-xs-12">
            <div id="identity">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var grid = $("#grid");
        var pager = $("#pager");

        var parent_column = grid.closest('[class*="col-"]');
        $(window).on('resize.jqGrid', function () {
            grid.jqGrid('setGridWidth', $("#jqgrid_wrapper").width());
            pager.jqGrid('setGridWidth', $("#jqgrid_wrapper").width());
        });

        $(document).on('settings.ace.jqGrid', function (ev, event_name, collapsed) {
            if (event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed') {
                grid.jqGrid('setGridWidth', parent_column.width());
                pager.jqGrid('setGridWidth', parent_column.width());
            }
        });

        var width = $("#jqgrid_wrapper").width();
        grid.jqGrid({
            url: '<?php echo site_url('penduduk/gridClient');?>',
            datatype: "json",
            mtype: "POST",
            caption: "Data Penduduk",
            colModel: [
                {label: 'ID', name: 'penduduk_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {
                    label: 'NIK',
                    name: 'penduduk_id',
                    width: 140,
                    align: "left",
                    editable: true,
                    editrules: {required: true},
                    editoptions: {size: 40}
                },
                {
                    label: 'Nama',
                    name: 'penduduk_name',
                    width: 190,
                    align: "left",
                    editable: true,
                    editrules: {required: true},
                    editoptions: {size: 40}
                },
                {
                    label: 'RW',
                    name: 'rw_code',
                    width: 90,
                    align: "left",
                    editable: true,
                    editrules: {required: true},
                    edittype: 'select',
                    editoptions: {dataUrl: '<?php echo site_url('penduduk/listRW');?>',
                                    dataEvents: [
                                        { type: 'change', fn: function(e) {
                                               var rw_id = $('#rw_code option:selected').val();
                                                alert(rw_id);
                                            } 
                                        },
                                                
                                        ],
                                    postData: function (rowid, value, cmName) {
                                        var rw_id = $('#rw_code option:selected').val();
        
                                        return {
                                            rw_id: rw_id
                                        }
                                    }
                                }
                },
                {
                    label: 'RT',
                    name: 'rt_code',
                    width: 90,
                    align: "left",
                    editable: true,
                    editrules: {required: true},
                    edittype: 'select',
                    editoptions: {dataUrl: '<?php echo site_url('penduduk/listRT');?>'}
                },
                {
                    label: 'Jenis Kelamin',
                    name: 'gender',
                    width: 100,
                    align: "center",
                    editable: true,
                    editrules: {required: true},
                    formatter : function(celValue){
                        if(celValue == "L"){
                            return "Laki-Laki";
                        }else{
                            return "Perempuan";
                        }
                    },
                    edittype: 'select',
                    editoptions: {value: {'L': 'Laki-Laki', 'P': 'Perempuan'}}
                },
                {
                    label: 'Tgl Lahir',
                    name: 'date_of_birth',
                    width: 150,
                    align: "left",
                    editable: true,
                    editoptions: {
                        // dataInit is the client-side event that fires upon initializing the toolbar search field for a column
                        // use it to place a third party control to customize the toolbar
                        dataInit: function (element) {
                            $(element).datepicker({
                                autoclose: true,
                                format: 'yyyy-mm-dd',
                                orientation: 'bottom'
                            });
                        }
                    },
                },
                {
                    label: 'Email',
                    name: 'email',
                    width: 205,
                    align: "left",
                    editable: true,
                    editoptions: {size: 30},
                    editrules: {required: true, email: true}
                },
                {
                    label: 'HP',
                    name: 'hp',
                    width: 205,
                    align: "left",
                    editable: true,
                    editoptions: {size: 30},
                    editrules: {required: true}
                },
                {
                    label: 'Telp',
                    name: 'telp',
                    width: 205,
                    align: "left",
                    editable: true,
                    editoptions: {size: 30}
                },
                {
                    label: 'Address',
                    name: 'address',
                    width: 300,
                    align: "left",
                    editable: true,
                    edittype: 'textarea',
                    editoptions: {
                        rows: "2",
                        cols: "40"
                    }
                }
            ],
            width: width,
            height: '100%',
            rowNum: 10,
            viewrecords: true,
            rowList: [10, 20, 50],
            sortname: 'penduduk_name',
            rownumbers: true,
            rownumWidth: 35,
            sortorder: 'asc',
            altRows: true,
            shrinkToFit: false,
            multiboxonly: true,
            onSelectRow: function (rowid) {
            },
            pager: '#pager',
            jsonReader: {
                root: 'Data',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function () {
                var table = this;
                setTimeout(function () {
                    //  styleCheckbox(table);

                    //  updateActionIcons(table);
                    updatePagerIcons(table);
                    enableTooltips(table);
                }, 0);
            },
            onSelectRow: function (rowid) {
               /* var celValue = grid.jqGrid('getCell', rowid, 'IdentificationDoc');
                if (rowid != null) {
                    var img = '<img src="../../' +celValue + ' " height="300px;">';
                    $('#identity').html(img);
                }*/
            },

            editurl: '<?php echo site_url('penduduk/crudPenduduk');?>'


        });
        //navButtons grid master
        grid.jqGrid('navGrid', '#pager',
            { 	//navbar options
                edit: true,
                excel: true,
                editicon: 'ace-icon fa fa-pencil blue',
                add: true,
                addicon: 'ace-icon fa fa-plus-circle purple',
                del: true,
                delicon: 'ace-icon fa fa-trash-o red',
                search: true,
                searchicon: 'ace-icon fa fa-search orange',
                refresh: true,
                refreshicon: 'ace-icon fa fa-refresh green',
                view: true,
                viewicon: 'ace-icon fa fa-search-plus grey'
            },
            {
                // options for the Edit Dialog
                closeAfterEdit: true,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                    style_edit_form(form);
                    form.css({"height": 0.515 * screen.height + "px"});
                    form.css({"width": 0.45 * screen.width + "px"});
                }
            },
            {
                //new record form
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                closeAfterAdd: true,
                recreateForm: true,
                viewPagerButtons: false,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
                        .wrapInner('<div class="widget-header" />')
                    style_edit_form(form);
                    form.css({"height": 0.515 * screen.height + "px"});
                    form.css({"width": 0.45 * screen.width + "px"});
                }
            },
            {
                //delete record form
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    if (form.data('styled')) return false;

                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                    style_delete_form(form);

                    form.data('styled', true);
                },
                onClick: function (e) {
                    //alert(1);
                }
            },
            {
                //search form
                // closeAfterSearch: true,
                recreateForm: true,
                afterShowSearch: function (e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                    style_search_form(form);
                },
                afterRedraw: function () {
                    style_search_filters($(this));
                }

            },
            {
                //view record form
                width: 600,
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                }
            }
        )

        function style_edit_form(form) {
            //enable datepicker on "sdate" field and switches for "stock" field
            form.find('input[name=sdate]').datepicker({format: 'yyyy-mm-dd', autoclose: true})

            form.find('input[name=stock]').addClass('ace ace-switch ace-switch-5').after('<span class="lbl"></span>');
            //don't wrap inside a label element, the checkbox value won't be submitted (POST'ed)
            //.addClass('ace ace-switch ace-switch-5').wrap('<label class="inline" />').after('<span class="lbl"></span>');


            //update buttons classes
            var buttons = form.next().find('.EditButton .fm-button');
            buttons.addClass('btn btn-sm').find('[class*="-icon"]').hide();//ui-icon, s-icon
            buttons.eq(0).addClass('btn-primary').prepend('<i class="ace-icon fa fa-check"></i>');
            buttons.eq(1).prepend('<i class="ace-icon fa fa-times"></i>')

            buttons = form.next().find('.navButton a');
            buttons.find('.ui-icon').hide();
            buttons.eq(0).append('<i class="ace-icon fa fa-chevron-left"></i>');
            buttons.eq(1).append('<i class="ace-icon fa fa-chevron-right"></i>');
        }

        function style_delete_form(form) {
            var buttons = form.next().find('.EditButton .fm-button');
            buttons.addClass('btn btn-sm btn-white btn-round').find('[class*="-icon"]').hide();//ui-icon, s-icon
            buttons.eq(0).addClass('btn-danger').prepend('<i class="ace-icon fa fa-trash-o"></i>');
            buttons.eq(1).addClass('btn-default').prepend('<i class="ace-icon fa fa-times"></i>')
        }

        function style_search_filters(form) {
            form.find('.delete-rule').val('X');
            form.find('.add-rule').addClass('btn btn-xs btn-primary');
            form.find('.add-group').addClass('btn btn-xs btn-success');
            form.find('.delete-group').addClass('btn btn-xs btn-danger');
        }

        function style_search_form(form) {
            var dialog = form.closest('.ui-jqdialog');
            var buttons = dialog.find('.EditTable')
            buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'ace-icon fa fa-retweet');
            buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'ace-icon fa fa-comment-o');
            buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'ace-icon fa fa-search');
        }

        function beforeDeleteCallback(e) {
            var form = $(e[0]);
            if (form.data('styled')) return false;

            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
            style_delete_form(form);

            form.data('styled', true);
        }

        function beforeEditCallback(e) {
            var form = $(e[0]);
            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
            style_edit_form(form);
        }


        //replace icons with FontAwesome icons like above
        function updatePagerIcons(table) {
            var replacement =
            {
                'ui-icon-seek-first': 'ace-icon fa fa-angle-double-left bigger-140',
                'ui-icon-seek-prev': 'ace-icon fa fa-angle-left bigger-140',
                'ui-icon-seek-next': 'ace-icon fa fa-angle-right bigger-140',
                'ui-icon-seek-end': 'ace-icon fa fa-angle-double-right bigger-140'
            };
            $('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function () {
                var icon = $(this);
                var $class = $.trim(icon.attr('class').replace('ui-icon', ''));

                if ($class in replacement) icon.attr('class', 'ui-icon ' + replacement[$class]);
            })
        }

        function enableTooltips(table) {
            $('.navtable .ui-pg-button').tooltip({container: 'body'});
            $(table).find('.ui-pg-div').tooltip({container: 'body'});
        }

    });

</script>