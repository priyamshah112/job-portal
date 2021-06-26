const isRtl = $("html").attr("data-textdirection") === "rtl";
var table = null;
const assetPath = $("body").attr("data-asset-path");
function enable(id, dom) {
    const url = `${assetPath}api/v1/jobs/status/${id}`;
    Pace.track(()=> {
        $.post( url, {status: "0"})
            .done(function(response) {
                response = JSON.parse(response);
                console.log(response)
                if (response.status != 1) {
                    toastr["error"]("👋 " + response.msg, "Error!", {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: isRtl,
                    });
                    return;
                }
                toastr["success"]("👋 " + response.msg, "Updated!", {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl,
                });
                continueED(0, id, dom, true);
            })
            .fail(function(error) {
                toastr["error"]("👋 " + response.msg, "Error!", {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl,
                });
                console.log(error);
            })
    })
}
function continueED(data, id, dom, isEnable) {
    const statusTd = $(dom).closest('tr').find('.status-cell')[0];
    const actionTd = $(dom).closest('tr').find('.action-cell')[0];
    if (!statusTd || !actionTd) {
        return;
    }
    const colIndexStatus = table.cell(statusTd).index().column;
    const rowIndexStatus = table.cell(statusTd).index().row;
    var colIndexAction = table.cell(actionTd).index().column;
    var rowIndexAction = table.cell(actionTd).index().row;
    table.cell(rowIndexStatus, colIndexStatus).data(data)
    let d = '<div class="btn-group">' +
        '                              <button type="button" class="btn p-0 m-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
        '                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">' +
        '                                  <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>' +
        '                                </svg>' +
        '                              </button>' +
        '                              <div class="dropdown-menu dropdown-menu-right">';

    d += '<a href="/jobs/view/'+id+'" class="dropdown-item w-100" type="button">View</a>' +
        '<a href="/jobs/edit/'+id+'" class="dropdown-item w-100" type="button">Edit</a>'+

        '                              </div>' +
        '                             </div>';

    table.cell(rowIndexAction, colIndexAction).data(d);
}
function disable(id, dom) {
    const url = `${assetPath}api/v1/jobs/status/${id}`;
    const statusTd = $(dom).closest('tr').find('.status-cell')[0];
    const actionTd = $(dom).closest('tr').find('.action-cell')[0];
    if (!statusTd || !actionTd) {
        return;
    }
    Pace.track(()=> {
        $.post( url, {status: "1"})
            .done(function(response) {
                response = JSON.parse(response);
                console.log(response)
                if (response.status != 1) {
                    toastr["error"]("👋 " + response.msg, "Error!", {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: isRtl,
                    });
                }
                toastr["success"]("👋 " + response.msg, "Updated!", {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl,
                });
                continueED(1, id, dom, false);
            })
            .fail(function(error) {
                toastr["error"]("👋 " + response.msg, "Error!", {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl,
                });
                console.log(error);
            })
    })
}
function deleteJob(id, dom) {
    const _token = $('#pageScript').attr('data-token');
    const url = $('#pageScript').attr('data-delete');
    Swal.fire({
        title: 'Do you want remove this job?',
        showCancelButton: true,
        confirmButtonText: `Yeah`,
    }).then((result) => {
        if (!result.isConfirmed) {
            return
        }
        Pace.track(()=>{
            $.post( url, {id, _token})
                .done((response)=>{
                    response = JSON.parse(response);
                    if (response.status != 1) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.msg,
                        });
                        return;
                    }
                    console.log(response);
                    table.ajax.reload();
                })
                .fail((error)=>{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something wrong, Please try again!',
                    });
                    console.log(error)
                });
        })
    })
}
$(window).on('load', function () {
    const url = "".concat(assetPath, "api/v1/recruiter/list-jobs");
    table = $('#pageTable').DataTable({
        serverSide: true,
        order: [[5, 'desc']],
        ajax: {
            url: url
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
                data: 'draft',
                orderable: false,
                render: (data, type, full, meta) => {
                    return data == 0 ? '<span class="badge badge-success">Saved</span>' : `<span class="badge badge-danger">Drafted</span>`;
                }
            },
            {
                data: 'action',
                orderable: false,
                searchable: false
            }
        ],
        drawCallback: function (data) {
            feather.replace();
        },
        columnDefs: [
            {className: 'status-cell', targets: [5]},
            {className: 'action-cell', targets: [6]}
        ]
    });
});
