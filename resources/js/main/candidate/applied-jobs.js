const isRtl = $("html").attr("data-textdirection") === "rtl";
var table = null;
const assetPath = $("body").attr("data-asset-path");

$(window).on('load', function () {
    table = $('#pageTable').DataTable({
        ajax: {
            "url": `${assetPath}api/v1/candidate/applied-jobs`,
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
                data: 'position',
                orderable: false,
            },
            {
                data: 'num_position',
                orderable: false,
            },
            {
                data: 'experience',
                orderable: false,
            },
            {
                data: 'deadline',
                orderable: false,
                searchable: false,
            },
            {
                data: 'created_at',
                render:(data, type, full,meta)=>{
                    return new Date(data).toLocaleDateString("en-US");
                }
            },
            {
                data: 'score',
                orderable: false,
                render: (data, type, full, meta) => {
                    return data + '%';
                }
            },
            {
                data: 'job_status',
                orderable: false,
                render: (data, type, full, meta) => {
                    if (data === 'hire') {
                        response = '<span class="badge badge-success">Hire</span>';
                    } else if (data === 'shortlist') {
                        response = `<span class="badge badge-warning">Shortlist</span>`;
                    } else if (data === 'reject') {
                        response = '<span class="badge badge-danger">Reject</span>';
                    }
                    else{
                        response = '<span class="badge badge-info">Pending</span>';
                    }

                    return response;
                }

            }
        ],
    });
});
