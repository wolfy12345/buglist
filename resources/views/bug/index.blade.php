@extends('common.layout')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/js/vendor/chosen/css/chosen.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/js/vendor/chosen/css/chosen-bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/js/vendor/datatables/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/js/vendor/datatables/css/ColVis.css')}}">
    <link rel="stylesheet" href="{{asset('assets/js/vendor/datatables/css/TableTools.css')}}">
@endsection

@section('title', 'BugList')

@section('breadcrumb')
    <li>You are here</li>
    <li><a href="/bug">BugList</a></li>
    <li class="active">Bugs</li>
@endsection

@section('content')
    <section class="tile transparent">
        <!-- tile header -->
        <div class="tile-header transparent">
            <h1><strong>BugList</strong> Table </h1>
            <div class="controls">
                <button type="button" class="btn btn-primary margin-bottom-20" onclick="location.href='/bug/new'">
                    创建bug
                </button>
            </div>
        </div>
        <!-- /tile header -->

        <!-- tile body -->
        <div class="tile-body color transparent-black rounded-corners">

            <div class="table-responsive">
                <table class="table table-datatable table-custom" id="basicDataTable">
                    <thead>
                    <tr>
                        <th class="sort-alpha">URL地址</th>
                        <th class="sort-amount">标题</th>
                        <th class="sort-numeric">创建者</th>
                        <th class="sort-numeric">指定修复者</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bugs as $k=>$bug)
                        <tr class="@if($k % 2 == 0) odd @else even @endif gradeX">
                            <td>
                                {{$bug->url}}
                            </td>
                            <td>{{$bug->title}}</td>
                            <td class="text-center">{{$bug->creator_user_id}}</td>
                            <td class="text-center">{{$bug->fixer_user_id}}</td>
                            <td>
                                @role('RD')<a>指向我</a>|@endrole
                                <a href="{{url('/bug/show/'.$bug->id)}}">查看</a>|
                                <a href="{{url('/bug/edit/'.$bug->id)}}">修改</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </section>
@endsection

@section('js')
    <script src="{{asset('assets/js/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/datatables/ColReorderWithResize.js')}}"></script>
    <script src="{{asset('assets/js/vendor/datatables/colvis/dataTables.colVis.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/datatables/tabletools/ZeroClipboard.js')}}"></script>
    <script src="{{asset('assets/js/vendor/datatables/tabletools/dataTables.tableTools.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/datatables/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('assets/js/vendor/chosen/chosen.jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/minimal.min.js')}}"></script>
    <script>
        $(function () {

            // Add custom class to pagination div
            $.fn.dataTableExt.oStdClasses.sPaging = 'dataTables_paginate paging_bootstrap paging_custom';

            /*************************************************/
            /**************** BASIC DATATABLE ****************/
            /*************************************************/

            /* Define two custom functions (asc and desc) for string sorting */
            jQuery.fn.dataTableExt.oSort['string-case-asc'] = function (x, y) {
                return ((x < y) ? -1 : ((x > y) ? 1 : 0));
            };

            jQuery.fn.dataTableExt.oSort['string-case-desc'] = function (x, y) {
                return ((x < y) ? 1 : ((x > y) ? -1 : 0));
            };

            /* Add a click handler to the rows - this could be used as a callback */
            $("#basicDataTable tbody tr").click(function (e) {
                if ($(this).hasClass('row_selected')) {
                    $(this).removeClass('row_selected');
                }
                else {
                    oTable01.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                }

                // FadeIn/Out delete rows button
                if ($('#basicDataTable tr.row_selected').length > 0) {
                    $('#deleteRow').stop().fadeIn(300);
                } else {
                    $('#deleteRow').stop().fadeOut(300);
                }
            });

            /* Build the DataTable with third column using our custom sort functions */
            var oTable01 = $('#basicDataTable').dataTable({
                "sDom": "R<'row'<'col-md-6'l><'col-md-6'f>r>" +
                "t" +
                "<'row'<'col-md-4 sm-center'i><'col-md-4'><'col-md-4 text-right sm-center'p>>",
                "oLanguage": {
                    "sSearch": ""
                },
                "aaSorting": [[0, 'asc'], [1, 'asc']],
                "aoColumns": [
                    null,
                    null,
                    {"sType": 'string-case'},
                    null,
                    null
                ],
                "fnInitComplete": function (oSettings, json) {
                    $('.dataTables_filter input').attr("placeholder", "Search");
                }
            });

            // Append delete button to table
            var deleteRowLink = '<a href="#" id="deleteRow" class="btn btn-red btn-xs delete-row">Delete selected row</a>'
            $('#basicDataTable_wrapper').append(deleteRowLink);

            /* Add a click handler for the delete row */
            $('#deleteRow').click(function () {
                var anSelected = fnGetSelected(oTable01);
                if (anSelected.length !== 0) {
                    oTable01.fnDeleteRow(anSelected[0]);
                    $('#deleteRow').stop().fadeOut(300);
                }
            });

            /* Get the rows which are currently selected */
            function fnGetSelected(oTable01Local) {
                return oTable01Local.$('tr.row_selected');
            };

            /*******************************************************/
            /**************** INLINE EDIT DATATABLE ****************/
            /*******************************************************/

            function restoreRow(oTable02, nRow) {
                var aData = oTable02.fnGetData(nRow);
                var jqTds = $('>td', nRow);

                for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                    oTable02.fnUpdate(aData[i], nRow, i, false);
                }

                oTable02.fnDraw();
            };

            function editRow(oTable02, nRow) {
                var aData = oTable02.fnGetData(nRow);
                var jqTds = $('>td', nRow);
                jqTds[0].innerHTML = '<input type="text" value="' + aData[0] + '">';
                jqTds[1].innerHTML = '<input type="text" value="' + aData[1] + '">';
                jqTds[2].innerHTML = '<input type="text" value="' + aData[2] + '">';
                jqTds[3].innerHTML = '<input type="text" value="' + aData[3] + '">';
                jqTds[4].innerHTML = '<input type="text" value="' + aData[4] + '">';
                jqTds[5].innerHTML = '<a class="edit save" href="#">Save</a><a class="delete" href="#">Delete</a>';
            };

            function saveRow(oTable02, nRow) {
                var jqInputs = $('input', nRow);
                oTable02.fnUpdate(jqInputs[0].value, nRow, 0, false);
                oTable02.fnUpdate(jqInputs[1].value, nRow, 1, false);
                oTable02.fnUpdate(jqInputs[2].value, nRow, 2, false);
                oTable02.fnUpdate(jqInputs[3].value, nRow, 3, false);
                oTable02.fnUpdate(jqInputs[4].value, nRow, 4, false);
                oTable02.fnUpdate('<a class="edit" href="#">Edit</a><a class="delete" href="#">Delete</a>', nRow, 5, false);
                oTable02.fnDraw();
            };


            var oTable02 = $('#inlineEditDataTable').dataTable({
                "sDom": "R<'row'<'col-md-6'l><'col-md-6'f>r>" +
                "t" +
                "<'row'<'col-md-4 sm-center'i><'col-md-4'><'col-md-4 text-right sm-center'p>>",
                "oLanguage": {
                    "sSearch": ""
                },
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': ["no-sort"]}
                ],
                "fnInitComplete": function (oSettings, json) {
                    $('.dataTables_filter input').attr("placeholder", "Search");
                }
            });

            // Append add row button to table
            var addRowLink = '<a href="#" id="addRow" class="btn btn-green btn-xs add-row">Add row</a>'
            $('#inlineEditDataTable_wrapper').append(addRowLink);

            var nEditing = null;

            // Add row initialize
            $('#addRow').click(function (e) {
                e.preventDefault();

                // Only allow a new row when not currently editing
                if (nEditing !== null) {
                    return;
                }

                var aiNew = oTable02.fnAddData(['', '', '', '', '', '<a class="edit" href="">Edit</a>', '<a class="delete" href="">Delete</a>']);
                var nRow = oTable02.fnGetNodes(aiNew[0]);
                editRow(oTable02, nRow);
                nEditing = nRow;

                $(nRow).find('td:last-child').addClass('actions text-center');
            });

            // Delete row initialize
            $(document).on("click", "#inlineEditDataTable a.delete", function (e) {
                e.preventDefault();

                var nRow = $(this).parents('tr')[0];
                oTable02.fnDeleteRow(nRow);
            });

            // Edit row initialize
            $(document).on("click", "#inlineEditDataTable a.edit", function (e) {
                e.preventDefault();

                /* Get the row as a parent of the link that was clicked on */
                var nRow = $(this).parents('tr')[0];

                if (nEditing !== null && nEditing != nRow) {
                    /* A different row is being edited - the edit should be cancelled and this row edited */
                    restoreRow(oTable02, nEditing);
                    editRow(oTable02, nRow);
                    nEditing = nRow;
                }
                else if (nEditing == nRow && this.innerHTML == "Save") {
                    /* This row is being edited and should be saved */
                    saveRow(oTable02, nEditing);
                    nEditing = null;
                }
                else {
                    /* No row currently being edited */
                    editRow(oTable02, nRow);
                    nEditing = nRow;
                }
            });

            /******************************************************/
            /**************** DRILL DOWN DATATABLE ****************/
            /******************************************************/

            var anOpen = [];

            var oTable03 = $('#drillDownDataTable').dataTable({
                "sDom": "R<'row'<'col-md-6'l><'col-md-6'f>r>" +
                "t" +
                "<'row'<'col-md-4 sm-center'i><'col-md-4'><'col-md-4 text-right sm-center'p>>",
                "oLanguage": {
                    "sSearch": ""
                },
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': ["no-sort"]}
                ],
                "aaSorting": [[1, "asc"]],
                "bProcessing": true,
                "sAjaxSource": "{{asset('assets/js/vendor/datatables/ajax/sources/objects.txt')}}",
                "aoColumns": [
                    {
                        "mDataProp": null,
                        "sClass": "control text-center",
                        "sDefaultContent": '<a href="#"><i class="fa fa-plus"></i></a>'
                    },
                    {"mDataProp": "engine"},
                    {"mDataProp": "browser"},
                    {"mDataProp": "grade"}
                ],
                "fnInitComplete": function (oSettings, json) {
                    $('.dataTables_filter input').attr("placeholder", "Search");
                }
            });

            $(document).on('click', '#drillDownDataTable td.control', function () {
                var nTr = this.parentNode;
                var i = $.inArray(nTr, anOpen);

                $(anOpen).each(function () {
                    if (this !== nTr) {
                        $('td.control', this).click();
                    }
                });

                if (i === -1) {
                    $('i', this).removeClass().addClass('fa fa-minus');
                    $(this).parent().addClass('drilled');
                    var nDetailsRow = oTable03.fnOpen(nTr, fnFormatDetails(oTable03, nTr), 'details');
                    $('div.innerDetails', nDetailsRow).slideDown();
                    anOpen.push(nTr);
                }
                else {
                    $('i', this).removeClass().addClass('fa fa-plus');
                    $(this).parent().removeClass('drilled');
                    $('div.innerDetails', $(nTr).next()[0]).slideUp(function () {
                        oTable03.fnClose(nTr);
                        anOpen.splice(i, 1);
                    });
                }

                return false;
            });

            function fnFormatDetails(oTable03, nTr) {
                var oData = oTable03.fnGetData(nTr);
                var sOut =
                        '<div class="innerDetails">' +
                        '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                        '<tr><td>Rendering engine:</td><td>' + oData.engine + '</td></tr>' +
                        '<tr><td>Browser:</td><td>' + oData.browser + '</td></tr>' +
                        '<tr><td>Platform:</td><td>' + oData.platform + '</td></tr>' +
                        '<tr><td>Version:</td><td>' + oData.version + '</td></tr>' +
                        '<tr><td>Grade:</td><td>' + oData.grade + '</td></tr>' +
                        '</table>' +
                        '</div>';
                return sOut;
            };

            /****************************************************/
            /**************** ADVANCED DATATABLE ****************/
            /****************************************************/

            var oTable04 = $('#advancedDataTable').dataTable({
                "sDom": "<'row'<'col-md-4'l><'col-md-4 text-center sm-left'T C><'col-md-4'f>r>" +
                "t" +
                "<'row'<'col-md-4 sm-center'i><'col-md-4'><'col-md-4 text-right sm-center'p>>",
                "oLanguage": {
                    "sSearch": ""
                },
                "oTableTools": {
                    "sSwfPath": "{{asset('assets/js/vendor/datatables/tabletools/swf/copy_csv_xls_pdf.swf')}}",
                    "aButtons": [
                        "copy",
                        "print",
                        {
                            "sExtends": "collection",
                            "sButtonText": 'Save <span class="caret" />',
                            "aButtons": ["csv", "xls", "pdf"]
                        }
                    ]
                },
                "fnInitComplete": function (oSettings, json) {
                    $('.dataTables_filter input').attr("placeholder", "Search");
                },
                "oColVis": {
                    "buttonText": '<i class="fa fa-eye"></i>'
                }
            });

            $('.ColVis_MasterButton').on('click', function () {
                var newtop = $('.ColVis_collection').position().top - 45;

                $('.ColVis_collection').addClass('dropdown-menu');
                $('.ColVis_collection>li>label').addClass('btn btn-default')
                $('.ColVis_collection').css('top', newtop + 'px');
            });

            $('.DTTT_button_collection').on('click', function () {
                var newtop = $('.DTTT_dropdown').position().top - 45;
                $('.DTTT_dropdown').css('top', newtop + 'px');
            });

            //initialize chosen
            $('.dataTables_length select').chosen({disable_search_threshold: 10});

        })

    </script>
@endsection