const isRtl = $("html").attr("data-textdirection") === "rtl";
var table = null;
const assetPath = $("body").attr("data-asset-path");

$(window).on('load', function () {
    table = $('#pageTable').DataTable({
        ajax: {
            "url": `${assetPath}api/v1/jobs`,
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
                data: 'action',
                orderable: false,
                searchable: false,
                render: function (data, type, full, meta) {
                    return (
                    `<a href="javascript:;" class="apply btn btn-primary" data_id="${full['id']}">Apply</a>`
                    );
                }
            }
        ],
        fnDrawCallback: function() {  
            $('.apply').on('click', function(){            
                let id = $(this).attr('data_id');
                $.ajax({
                    url: `${assetPath}api/v1/candidate/job-apply/${id}`,
                    type: 'POST',
                    success: function (res) {
                    // console.log(res.data);
                        toastr['success']('👋 Successfully Applied For Job', 'Success!', {
                            closeButton: true,
                            tapToDismiss: false,
                            rtl: isRtl
                      });
                    },
                    error: function (err) {
                        console.log('An error occurred.',err);    
                        Swal.fire({                            
                        title: 'Error!',
                        icon: 'error',
                        text: err.statusText,
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                        });
                    },
                })
            });
        },
        columnDefs: [
            {className: 'status-cell', targets: [5]},
            {className: 'action-cell', targets: [6]}
        ]
    });
});
