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
                data: 'img_path',
                orderable: false,
                render: function(data, type, full, meta){
                    return data !== null ? `<div class="candidate-profile avatar">
                   <a href="${data}" target="_blank"><img class="round" src="${data}" /></a>
                    </div>` : '<div class="candidate-profile avatar"><img class="round" src="http://127.0.0.1:8000/images/portrait/small/avatar-s-11.jpg" /></div>';
                }
            },
            {
                data: 'full_name',
                orderable: false,
            },
            {
                data: 'gender',
                orderable: false,
            },
            {
                data: 'position',
                orderable: false,
            },
            {
                data: 'category',
                orderable: false,
            },
            {
                data: 'deadline',
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
                    `<select class="form-control job_status" data_id="${full['id']}">
                        <option value="">Select Option</option>
                        <option value="hire" ${full['job_status'] === 'hire' ? 'selected' : ''}>Hire</option>
                        <option value="shortlist" ${full['job_status'] === 'shortlist' ? 'selected' : ''}>Short List</option>
                        <option value="reject" ${full['job_status'] === 'reject' ? 'selected' : ''}>Reject</option>
                    </select>`
                    );
                }
            }
        ],
        fnDrawCallback: function() {  
            $('.job_status').on('change', function(){            
                let id = $(this).attr('data_id');
                let value = $(this).val();
                $.ajax({
                    url: `${assetPath}api/v1/recruiter/apllied-jobs/status/${id}?_method=PUT`,
                    type: 'POST',
                    data: {
                        'status' : value,
                    },
                    success: function (res) {
                    // console.log(res.data);
                        toastr['info']('👋 Successfully Updated Job Status', 'Updated!', {
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
        }
    });
});
