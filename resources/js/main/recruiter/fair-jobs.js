const isRtl = $("html").attr("data-textdirection") === "rtl";
var table = null;
const assetPath = $("body").attr("data-asset-path");
var id = $('input[name="job_fair_id"]').val();

$(window).on('load', function () {
    table = $('#pageTable').DataTable({
        order: [[5, 'desc']],
        ajax: {
            url: `${assetPath}api/v1/recruiter/job-fair/${id}/jobs`
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
            {className: 'status-cell', targets: [4]},
            {className: 'action-cell', targets: [5]}
        ]
    });
});
