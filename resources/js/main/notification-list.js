$(function () {
  'use strict';

  var dtOrderTable = $('.notification-list-table');
  var assetPath = $('body').attr('data-asset-path');
  // orders List datatable
  if (dtOrderTable.length) {
    var dtOrderTableInit = dtOrderTable.DataTable({
      pageLength: 10,
      ajax: {
        "url": `${assetPath}api/v1/notifications`,
        "type": "GET",
        "error": function(err) {
          // console.log(err);
          Swal.fire({                            
            title: 'Error!',
            icon: 'error',
            text: err.statusText,
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
      }, // JSON file to add data
      columns: [
        // columns according to JSON
        { data: null },
        { data: null },
        { data: 'notification_type' },
        { data: 'title' },
        { data: 'description'},
        { data: 'created_at' },
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          orderable: false,
          responsivePriority: 0,
          targets: 0,
          render: function (data, type, full, meta) {
            return ''
          }

        },
        {
          orderable: false,
          responsivePriority: 1,
          targets: 1,
          render: function (data, type, full, meta) {
            return meta.row + 1
          }
        },
        {
          orderable: false,
          responsivePriority: 1,
          targets: 2,
          render: function (data, type, full, meta) {
            return (
              '<img class="img-fluid img-rounded notification_type_image" src='+ data.image_path +' />'
            );
          }
        },
        {
          searchable: true,
          orderable: false,
          responsivePriority: 1,
          targets: 3,
          render: function (data, type, full, meta) {
            return data
          }
        },
        {
          orderable: false,
          responsivePriority: 1,
          targets: 4,
          render: function (data, type, full, meta) {
            return data
          }
        },
        {
          orderable: false,
          responsivePriority: 1,
          targets: 5,
          render: function (data, type, full, meta) {
            const months = ["JAN", "FEB", "MAR","APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
            let date = new Date(data);
            return date.getDate() + " " + months[date.getMonth()] + " " + date.getFullYear()
          }
        },
      ],
      order: [[1, 'asc']],
      dom:
          '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
          '<"col-lg-12 col-xl-6" l>' +
          '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
          '>t' +
          '<"d-flex justify-content-between mx-2 row mb-1"' +
          '<"col-sm-12 col-md-6"i>' +
          '<"col-sm-12 col-md-6"p>' +
          '>',
      language: {
        sLengthMenu: 'Show _MENU_',
        search: 'Search',
        searchPlaceholder: 'Search Notification Title'
      },
      // Buttons with Dropdown
      buttons: [],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of Notification';
            }
          }),
          type: 'column',
          renderer: $.fn.dataTable.Responsive.renderer.tableAll({
            tableClass: 'table',
          })
        }
      },
      language: {
        paginate: {
          // remove previous & next text from pagination
          previous: '&nbsp;',
          next: '&nbsp;'
        }
      },
    });
  }
});
