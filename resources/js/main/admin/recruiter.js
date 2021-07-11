"use strict";
const isRtl = $("html").attr("data-textdirection") === "rtl";
var table = null;
const assetPath = $("body").attr("data-asset-path");

function enable(id, dom) {
    Swal.fire({
        title: "Do you want Enable this recruiter?",
        showCancelButton: true,
        confirmButtonText: `Yeah`,
    }).then((result) => {
        if (!result.isConfirmed) {
            return;
        }
        const url = "".concat(assetPath, "api/v1/admin/recruiters/enable");
        Pace.track(() => {
            $.ajax({
                method: "POST",
                url: url,
                data: {
                    id: id,
                },
            })
                .done(function (response) {
                    response = JSON.parse(response);
                    console.log(response);
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
                    continueED(1, id, dom, true);
                })
                .fail(function (error) {
                    toastr["error"]("", "Something wrong, Please try again!", {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: isRtl,
                    });
                });
        });
    });
}

function disable(id, dom) {
    Swal.fire({
        title: "Do you want Block this recruiter?",
        showCancelButton: true,
        confirmButtonText: `Yeah`,
    }).then((result) => {
        if (!result.isConfirmed) {
            return;
        }
        const url = "".concat(assetPath, "api/v1/admin/recruiters/disable");
        Pace.track(() => {
            $.ajax({
                method: "POST",
                url: url,
                data: {
                    id: id,
                }
            })
                .done(function (response) {
                    response = JSON.parse(response);
                    if (response.status != 1) {
                        toastr["info"]("👋 " + response.msg, "Error!", {
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
                    continueED(2, id, dom, false);
                })
                .fail(function (error) {
                    toastr["error"]("", "Something wrong, Please try again!", {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: isRtl,
                    });
                });
        });
    });
}

function deleter(id, dom) {
    Swal.fire({
        title: "Do you want remove this recruiter?",
        showCancelButton: true,
        confirmButtonText: `Yeah`,
    }).then((result) => {
        if (!result.isConfirmed) {
            return;
        }
        const url = "".concat(assetPath, "api/v1/admin/recruiters/delete");
        Pace.track(() => {
            $.ajax({
                method: "POST",
                url: url,
                data: {
                    id: id,
                }
            }).done((response) => {
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
                    table.ajax.reload();
                })
                .fail((error) => {
                    toastr["error"]("👋 " + response.msg, "Error!", {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: isRtl,
                    });
                    console.log(error);
                });
        });
    });
}

function continueED(data, id, dom, isEnable) {
    const statusTd = $(dom).closest("tr").find(".status-cell")[0];
    const actionTd = $(dom).closest("tr").find(".action-cell")[0];
    if (!statusTd || !actionTd) {
        return;
    }
    const colIndexStatus = table.cell(statusTd).index().column;
    const rowIndexStatus = table.cell(statusTd).index().row;
    var colIndexAction = table.cell(actionTd).index().column;
    var rowIndexAction = table.cell(actionTd).index().row;
    table.cell(rowIndexStatus, colIndexStatus).data(data);
    let d = "";
    if (isEnable == true) {
        d +=
            '<buton title="Change Status" onclick="disable(' +
            id +
            ', this)" class="btn p-0 m-0"><i data-feather="toggle-right" class="text-success font-large-1"></i></buton>';
    } else {
        d +=
            '<buton title="Change Status" onclick="enable(' +
            id +
            ', this)" class="btn p-0 m-0"><i data-feather="toggle-left" class="text-danger font-large-1"></i></buton>';
    }
    d +=
        '<a title="View" href="/recruiters/view' +
        id +
        '" class="btn p-0 m-0"><i data-feather="eye" class="text-primary ml-1 font-medium-5"></i></a>';
    d +=
        '<a title="Edit" href="/recruiters/edit/' +
        id +
        '" class="btn p-0 m-0"><i data-feather="edit" class="text-warning ml-1 font-medium-5"></i></a>';
    d +=
        '<buton title="Delete" onclick="deleter(' +
        id +
        ', this)"><i data-feather="trash-2" class="text-danger ml-1 font-medium-5"></i></buton>';
    table.cell(rowIndexAction, colIndexAction).data(d);
    feather.replace();
}

$(window).on("load", function () {
    const url = "".concat(assetPath, "api/v1/admin/recruiters");
    table = $("#pageTable").DataTable({
        serverSide: true,
        ajax: {
            url: url
        },
        columns: [
            {
                data: "user",
                orderable: false,
                searchable: false,
                render: (data, type, full, meta) => {
                    let v = '<a href="/recruiters/' + data.id + '" class="d-flex">';
                    if (data.img_path) {
                        v +=
                            '<img class="round mr-1" src="/' +
                            data.img_path +
                            "/" +
                            data.image_name +
                            '" alt="avatar" height="40" width="40">';
                    } else {
                        v +=
                            '<img class="round mr-1" src="/images/avatars/default_user.jpeg" alt="avatar" height="40" width="40">';
                    }
                    v +=
                        '<div> <p class="font-weight-bold" style="margin-bottom: 2px">' +
                        data.first_name +
                        " " +
                        data.last_name +
                        '</p> <p class="m-0 text-muted">' +
                        data.email +
                        "</p></div></a>";
                    return v;
                },
            },
            {
                data: "user.mobile_number",
                orderable: false,
            },
            {
                data: "company_name",
                orderable: false,
            },
            {
                data: "package",
                orderable: false,
                searchable: false,
                render: (data, type, full, meta) => {
                    return data ? data.plan_name : "";
                },
            },
            {
                data: "user.active",
                orderable: false,
                render: (data, type, full, meta) => {
                    let response = "";
                    if (data == 2) {
                        response = '<span class="badge badge-danger">Blocked</span>';
                    } else if (data == 1) {
                        response = `<span class="badge badge-success">Active</span>`;
                    } else {
                        response = '<span class="badge badge-warning">InActive</span>';
                    }
                    return response;
                },
            },
            {
                data: "action",
                orderable: false,
                searchable: false,
            },
        ],
        drawCallback: function (data) {
            feather.replace();
        },
        columnDefs: [
            {className: "status-cell", targets: [4]},
            {className: "action-cell", width: 180, targets: [5]},
        ],
    });
});
