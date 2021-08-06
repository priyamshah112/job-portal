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
                data: null,
                orderable: false,
                render: (data, type, full, meta)=>{
                    let v = '<a href="'+assetPath+'recruiter/candidates/'+full["user_id"]+'" class="d-flex">';
                    if (full["img_path"]) {
                        v += '<img class="round mr-1" src="/'+full["img_path"] +"/"+full["image_name"]+'" alt="avatar" height="40" width="40">';
                    } else {
                        v += '<img class="round mr-1" src="/images/avatars/default_user.jpeg" alt="avatar" height="40" width="40">';
                    }
                    v += '<div> <p class="font-weight-bold" style="margin-bottom: 2px">'+full["first_name"] + ' ' + full["last_name"]+'</p> <p class="m-0 text-muted">' +
                        full["email"]+'</p></div></a>';
                    return v;
                }
            },
            {
                data: 'gender',
                orderable: false,
            },
            {
                data: 'position_name',
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
                        <option value="reject" ${full['job_status'] === 'reject' ? 'selected' : ''}>Reject</option>
                        <option value="shortlist" ${full['job_status'] === 'shortlist' ? 'selected' : ''}>Short List</option>
                        <option value="hire" ${full['job_status'] === 'hire' ? 'selected' : ''}>Hire</option>
                    </select>`
                    );
                }
            }
        ],
        fnDrawCallback: function() {  
            $('.job_status').on('change', function(){  
                let $this = $(this);
                let id = $this.attr('data_id');
                let value = $this.val();
                if(value !== '' && value !== undefined)
                {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to send mail and won't able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, send it!',
                        customClass: {
                          confirmButton: 'btn btn-success',
                          cancelButton: 'btn btn-outline-danger ml-1'
                        },
                        buttonsStyling: false
                      }).then(function (result) {
                        if (result.value) {
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
                                    text: err.responseJSON.message,
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                    });
                                    $this.val("")
                                },
                            })
                        }
                        else
                        {
                            $this.val("");
                        }
                    });
                }
            });
        }
    });
});
