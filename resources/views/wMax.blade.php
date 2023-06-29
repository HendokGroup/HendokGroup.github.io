<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" /> <!-- put on blades -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajax Crud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.light.css" rel="stylesheet"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.light.css" rel="stylesheet">

    <style>
         .dx-button-content {
            color: black;
        }
    </style>

</head>

<body>
    <div class="container">
        <h1>wMax Dashboard</h1>
        <div id="wMax"></div>
    </div>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script>
    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $(document).ready(function() {
            var wMax = {!!json_encode($wMax) !!};
            var disncDep = {!!json_encode($disncDep) !!};

            $("#wMax").dxDataGrid({
                dataSource: wMax,
                showBorders: true,
                hoverStateEnabled: true,
                filterRow: {
                    visible: true
                },
                filterPanel: {
                    visible: true
                },
                headerFilter: {
                    visible: true
                },
                allowColumnResizing: true,
                columnAutoWidth: true,
                scrolling: {
                    rowRenderingMode: 'infinite',
                },
                paging: {
                    pageSize: 5,
                },
                pager: {
                    visible: true,
                    allowedPageSizes: [5, 10, 20, 50, 'all'],
                    showPageSizeSelector: true,
                    showInfo: true,
                    showNavigationButtons: true,
                },
                selection: {
                    mode: 'single',
                },
                columns: [
                    {
                        dataField: "ID",
                        caption: "ID",
                        allowEditing: false,
                    },
                    {
                        dataField: "DateTime",
                        caption: "Date & Time",
                        cellTemplate: function(container, options) {
                            if (options.rowType === "data" && options.column.allowEditing) {
                                $('<div>')
                                    .text(options.data.DateTime)
                                    .appendTo(container);
                            }
                        },
                        editCellTemplate: function(container, options) {
                            if (options.rowType === "data" && options.column.allowEditing) {
                                $('<div>')
                                    .dxTextBox({
                                        value: options.data.DateTime,
                                        onValueChanged: function(e) {
                                            options.setValue(e.value);
                                        }
                                    })
                                    .appendTo(container);
                            }
                        },
                    },
                    {
                        dataField: "DepartmentScrap",
                        caption: "Department Scrap",
                        lookup: {
                            dataSource: disncDep,
                            valueExpr: "DepartmentScrap",
                            displayExpr: "DepartmentScrap",
                        },
                    },
                    {
                        dataField: "Mass",
                        caption: "Mass",
                    },
                    {
                        dataField: "Operator",
                        caption: "Operator",
                    },
                    {
                        dataField: "ScaleName",
                        caption: "Scale Name",
                    },
                ],
                editing: {
                    allowUpdating: true, // Enable editing
                    allowAdding: true,
                    allowDeleting: true,
                    mode: "popup" // Specify the editing mode (cell, row, batch)
                },
                onRowUpdating: function(e) {
                    var ID = e.oldData.ID;
                    var DateTime = e.newData.DateTime || e.oldData.DateTime;
                    var DepartmentScrap = e.newData.DepartmentScrap || e.oldData.DepartmentScrap;
                    var Mass = e.newData.Mass || e.oldData.Mass;
                    var Operator = e.newData.Operator || e.oldData.Operator;
                    var ScaleName = e.newData.ScaleName || e.oldData.ScaleName;

                    $.ajax({
                        url: '{!!url("/wMaxCRUD")!!}',
                        type: "POST",
                        data: {
                            ID: ID,
                            DateTime: DateTime,
                            DepartmentScrap: DepartmentScrap,
                            Mass: Mass,
                            Operator: Operator,
                            ScaleName: ScaleName,
                            prompt: 'Update',
                        },
                        success: function(data) {
                            alert(data[0]['Response']);
                            location.reload();
                        }
                    });
                },
                onRowRemoving: function(e) {
                    var ID = e.data.ID;

                    $.ajax({
                        url: '{!!url("/wMaxCRUD")!!}',
                        type: "POST",
                        data: {
                            ID: ID,
                            prompt: 'Delete',
                        },
                        success: function(data) {
                            alert(data[0]['Response']);
                            location.reload();
                        }
                    });
                },
                onRowInserting: function(e) {
                    var DateTime = e.data.DateTime;
                    var DepartmentScrap = e.data.DepartmentScrap;
                    var Mass = e.data.Mass;
                    var Operator = e.data.Operator;
                    var ScaleName = e.data.ScaleName;

                    $.ajax({
                        url: '{!!url("/wMaxCRUD")!!}',
                        type: "POST",
                        data: {
                            DateTime: DateTime,
                            DepartmentScrap: DepartmentScrap,
                            Mass: Mass,
                            Operator: Operator,
                            ScaleName: ScaleName,
                            prompt: 'Create',
                        },
                        success: function(data) {
                            alert(data[0]['Response']);
                            location.reload();
                        }
                    });
                },
            });
        });
    </script>
</body>

</html>
