const isRtl = $("html").attr("data-textdirection") === "rtl";
const assetPath = $("body").attr("data-asset-path");
var table = null;
$(window).on('load', function () {
    const url = "".concat(assetPath, "api/v1/recruiter/candidates");
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
                    let v = '<a href="/candidates/'+data.id+'" class="d-flex">';
                    if (data.img_path) {
                        v += '<img class="round mr-1" src="/'+data.img_path +"/"+data.image_name+'" alt="avatar" height="40" width="40">';
                    } else {
                        v += '<img class="round mr-1" src="/images/avatars/default_user.jpeg" alt="avatar" height="40" width="40">';
                    }
                    v += '<div> <p class="font-weight-bold" style="margin-bottom: 2px">'+data.first_name + ' ' + data.last_name+'</p> <p class="m-0 text-muted">' +
                        data.email+'</p></div></a>';
                    return v;
                }
            },
            {
                data: 'user.mobile_number',
                orderable: true,
                searchable: true,
            },
            {
                data: 'dateOfBirth',
                orderable: true,
                searchable: true,
            }
        ],
    });
});
