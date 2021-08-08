const isRtl = $("html").attr("data-textdirection") === "rtl";
var table = null;
const assetPath = $("body").attr("data-asset-path");
function preview(data) {
    $("#previewimg").attr('src', '/storage/feedbacks/'+data);
    $("#previewmodal").modal('show');
}
function continueED(data, id, dom, isEnable) {
    const actionTd = $(dom).closest('tr').find('.action-cell')[0];
    if ( !actionTd) {
        return;
    }
    var colIndexAction = table.cell(actionTd).index().column;
    var rowIndexAction = table.cell(actionTd).index().row;
    table.cell(rowIndexStatus, colIndexStatus).data(data)
    let d = '';
        d += '<buton title="Delete" onclick="deleter('+id+', this)"><i data-feather="trash-2" class="text-danger ml-1 font-medium-5"></i></buton>';
    console.log(d);
    table.cell(rowIndexAction, colIndexAction).data(d);
    feather.replace();
}
var table = null;
$(window).on('load', function () {
    const url = "".concat(assetPath, "api/v1/admin/feedback");
     table = $('#pageTable').DataTable({
       ajax: {
           url: url
       },
        columns: [
            {
                data: 'user',
                orderable: true,
                searchable: true,
                render: (data, type, full, meta)=>{
                    let v = '<div class="d-flex">';
                    if (data.img_path) {
                        v += '<img class="round mr-1" src="'+'/'+data.img_path+'/'+data.image_name+'" alt="avatar" height="40" width="40">';
                    } else {
                        v += '<img class="round mr-1" src="/images/avatars/default_user.jpeg" alt="avatar" height="40" width="40">';
                    }
                    v += '<div> <p class="font-weight-bold" style="margin-bottom: 2px">'+data.first_name + ' ' + data.last_name+'</p> <p class="m-0 text-muted">' +
                        data.email+'</p></div></div>';
                    return v;
                }
            },

            {
                data: 'subject',
                orderable: true,
                searchable: true,
            },
            {
                data: 'message',
                orderable: true,
                searchable: true,
            },
            {
                data:'file_path',
                render: function(data, type, full, meta){
                    let v = '<div class="d-flex">';
                    if (data) {
                        let s = ''+data;
                        v += '<button onclick=preview("'+s+'") class="badge border-0 badge-primary">View</button></div>';
                    } else {
                        v = '-';
                    }
                    return v;
                }

            },
            {
                data: 'created_at',
                orderable: true,
                searchable: true,
                render:(data, type, full,meta)=>{
                    return new Date(data).toLocaleDateString("en-US");
                }
            },
            {
                data: 'action',
                orderable: false,
                searchable: false
            }
        ],
        order: [[5, 'desc']],
        drawCallback: function (data) {
           feather.replace();
            console.log('>>',data);
        },
        columnDefs: [
            {className: 'action-cell', targets: [5]}
        ],
        render: (data, type, row) => {
            console.log(row);
            return data;
        }
    });

});

function deleter(id, dom) {

    Swal.fire({
        title: 'Do you want remove this feedback?',
        showCancelButton: true,
        confirmButtonText: `Yeah`,
    }).then((result) => {
        if (!result.isConfirmed) {
            return
        }
        const url = "".concat(assetPath, "api/v1/admin/feedback/delete");
        Pace.track(()=>{
            $.ajax({
                method: "POST",
                url: url,
                data: {
                    id: id,
                }
            }).done((response)=>{
                    response = JSON.parse(response);
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
                    console.log(response);
                    table.ajax.reload();
                })
                .fail((error)=>{
                    toastr["error"]("👋 " + response.msg, "Error!", {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: isRtl,
                    });
                    console.log(error)
                });
        })
    })
}
