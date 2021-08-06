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
                data: 'posting_date',
                orderable: true,
            },
            {
                data: 'deadline',
                orderable: false,
                searchable: false,
            },
            {
                data: 'position_name',
                orderable: false,
            },
            {
                data: 'company_name',
                orderable: false,
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

            },
            {
                data: 'actions',
                orderable: false,
                searchable: false,
                render: (data, type, full, meta) => {
                    return `<div class="modal fade" id="view-job-modal-${full['id']}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                            <div class="modal-content p-0">
                                <div class="modal-header p-1">
                                    <h3 class="modal-title text-primary">${full['position_name']}</h3>
                                    <button type="button" class="close modal-close-button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body"> 
                                    <p class="card-text">
                                    <strong>Location:</strong>                  
                                    ${full['stateNames']}
                                    </p>
                                    <p class="card-text">
                                    <strong>Salary Expected:</strong> ${full['salary_min']} - ${full['salary_max']} Rupees
                                    </p>
                                    <p class="card-text">
                                    <strong>Role Description:</strong> ${full['description']}
                                    </p>
                                    <p class="card-text">
                                    <strong>Experience:</strong> ${full['experience']} - ${full['maxexperience']} Years
                                    </p>
                                    <p class="card-text">
                                    <strong>Age Criteria:</strong> ${full['age_min']} - ${full['age_max']} Years
                                    </p>
                                    <p class="card-text">
                                    <strong>Technical Skills:</strong> 
                                    ${full['skillNames']}
                                    </p>
                                    <div class="card-text">
                                    <strong>Deadline to Apply:</strong> ${full['deadline']}
                                    </div>
                                </div>
                                <div class="modal-footer p-1">
                                    <button type="button" class="btn btn-outline-secondary modal-close-button" data-dismiss="modal">
                                    Close
                                    </button>
                                </div>
                            </div>
                        </div>
                        </div>
                    <button type="button" class="btn p-0 m-0" data-toggle="modal" data-target="#view-job-modal-${full['id']}"><i data-feather="eye" class="text-primary ml-1 font-medium-5"></i></button>`
                }
            }
        ],        
        drawCallback: function (data) {
            feather.replace();
        },
    });
});
