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
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, full, meta) {
                    return meta.row + 1;
                }
            },
            {
                data: 'position',
                orderable: false,
                render: function (data, type, full, meta) {
                    return data.name;
                }
            },
            {
                data: null,
                render: function(data, type, full, meta){
                    return full['age_min'] +' to '+ full['age_max'];
                }
            },
            {
                data: null,
                render: function(data, type, full, meta){
                    return full['salary_min'] +' - '+ full['salary_max'];
                }
            },
            {
                data: 'gender'
            }, 
            {
                data: null,
                render: function(data, type, full, meta){
                    return full['experience'] +' - '+ full['maxexperience'];
                }
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
            {className: 'status-cell', targets: [7]},
            {className: 'action-cell', targets: [8]}
        ]
    });
});
