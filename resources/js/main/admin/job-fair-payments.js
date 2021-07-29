const isRtl = $("html").attr("data-textdirection") === "rtl";
const assetPath = $("body").attr("data-asset-path"); 
var id = $('input[name="job_fair_id"]').val();

$(window).on('load', function () {
    var table = $('#payment-list-table').DataTable({
        ajax: {
            "url": `${assetPath}api/v1/admin/job-fair/${id}/payments`,
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
        },
        columns: [            
            {
                orderable: true,
                render: function (data, type, full, meta) {
                    return meta.row + 1
                }
            },
            {
                data: 'company_name',
                orderable: true,
            },
            {
                data: 'job_fair_name',
                orderable: true
            },
            {
                data: 'amount',
                orderable: true
            },
            {
                data: 'status',
                orderable: true,
                render: (data, type, full, meta) => {
                    let response = '';
                    if (data == 'success') {
                        response = '<span class="badge badge-success">Success</span>';
                    } else {
                        response = '<span class="badge badge-danger">Failed</span>';
                    }
                    return response;
                }
            },

        ],
    });
});
