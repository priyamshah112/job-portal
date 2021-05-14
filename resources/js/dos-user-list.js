/*=========================================================================================
    File Name: app-user-list.js
    Description: User List page
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
$(function () {
  'use strict';

  var dtUserTable = $('.user-list-table'),
      newUserSidebar = $('.new-user-modal'),
      newUserForm = $('.add-new-user'),
      statusObj = {
        0: { title: 'Inactive', class: 'badge-light-secondary' },
        1: { title: 'Active', class: 'badge-light-success' },
        2: { title: 'Pending', class: 'badge-light-warning' },
      };

  var editForm = false;
  var selectedRowDataId = null;
  var token = $('meta[name="csrf-token"]').attr('content');
  var isRtl = $('html').attr('data-textdirection') === 'rtl';
  var submitBtn = $('.data-submit');
  var assetPath = $('body').attr('data-asset-path');
  var dataCreate = $('.app-user-list').attr('data-create');
  var dataWrite = $('.app-user-list').attr('data-write');
  var dataDelete = $('.app-user-list').attr('data-delete');
  // Users List datatable
  if (dtUserTable.length) {
    var dtDataTableInit = dtUserTable.DataTable({
      ajax: {
        "url": `${assetPath}api/v1/dosUsers`,
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
      }, // JSON file to add data
      columns: [
        // columns according to JSON
        { data: 'id' },
        { data: null },
        { data: 'full_name' },
        { data: 'email' },
        { data: 'mobile_number' },
        { data: 'role' },
        { data: 'active' },
        { data: '' }
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          orderable: false,
          responsivePriority: 0,
          targets: 0
        },
        {
          orderable: false,
          responsivePriority: 3,
          targets: 1,
          render: function (data, type, full, meta) {
            return meta.row + 1
          }
        },
        {
          // User full name and username
          targets: 2,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $name = `${full['first_name']} ${full['last_name']}`,
                $image = full['img_path'];
            if ($image) {
              // For Avatar image
              var $output =
                  '<img src="' + assetPath + $image + '" alt="Avatar" height="32" width="32">';
            } else {
              // For Avatar badge
              var stateNum = Math.floor(Math.random() * 6) + 1;
              var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
              var $state = states[stateNum];
              var $initials = $name.match(/\b\w/g) || [];
              $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
              $output = '<span class="avatar-content">' + $initials + '</span>';
            }
            var colorClass = $image === '' ? ' bg-light-' + $state + ' ' : '';
            // Creates full output for row
            var $row_output =
            '<div class="d-flex justify-content-left align-items-center">' +
            '<div class="avatar-wrapper">' +
            '<div class="avatar ' +
            colorClass +
            ' mr-1">' +
            $output +
            '</div>' +
            '</div>' +
            '<div class="d-flex flex-column">' +
            '<a href="javascript:;" class="user_name text-truncate"><span class="font-weight-bold">' +
            $name +
            '</span></a>' +
            '</div>' +
            '</div>';
            return $row_output;
          }
        },
        {
          // User Role
          targets: 5,
          render: function (data, type, full, meta) {
            var $role = full['role'];
            var roleBadgeObj = {
              instructor: feather.icons['user'].toSvg({ class: 'font-medium-3 text-primary mr-50' }),
              manager: feather.icons['settings'].toSvg({ class: 'font-medium-3 text-warning mr-50' }),
              advisor: feather.icons['database'].toSvg({ class: 'font-medium-3 text-success mr-50' }),
              student: feather.icons['book-open'].toSvg({ class: 'font-medium-3 text-primary mr-50' }),
              admin: feather.icons['slack'].toSvg({ class: 'font-medium-3 text-danger mr-50' })
            };
            let $icon = roleBadgeObj[$role] ? roleBadgeObj[$role] : roleBadgeObj['student'];
            return "<span class='text-truncate align-middle'>" + $icon + $role + '</span>';
          }
        },
        {
          // User Status
          targets: 6,
          render: function (data, type, full, meta) {
            var $status = full['active'];
            return (
              '<span class="badge badge-pill ' +
                statusObj[$status].class +
                '" text-capitalized>' +
                statusObj[$status].title +
                '</span>'
            );
          }
        },
        {
          // Actions
          targets: -1,
          title: 'Actions',
          orderable: false,
          render: function (data, type, full, meta) {
            if(dataWrite || dataDelete){
              return (
                `<div class="btn-group"><a class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">${feather.icons['more-vertical'].toSvg({ class: 'font-small-4' })}</a><div class="dropdown-menu dropdown-menu-right">${ dataWrite ? `<a href="javascript:;" class="dropdown-item formEdit" category_id='${full['id']}'>${feather.icons['archive'].toSvg({ class: 'font-small-4 mr-50' })} Edit</a>`: '' }${dataDelete ? `<a href="javascript:;" class="dropdown-item delete-record" category_id='${full['id']}'>${feather.icons['trash-2'].toSvg({ class: 'font-small-4 mr-50' })} Delete</a>`: ''}</div></div></div>`
              );
            }
            else{
              return '';
            }
          }
        }
      ],
      order: [[0, 'asc']],
      dom:
          '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
          '<"col-lg-12 col-xl-6" l>' +
          '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
          '>t' +
          '<"d-flex justify-content-between mx-2 row mb-1"' +
          '<"col-sm-12 col-md-6"i>' +
          '<"col-sm-12 col-md-6"p>' +
          '>',
      language: {
        sLengthMenu: 'Show _MENU_',
        search: 'Search',
        searchPlaceholder: 'Search..'
      },
      // Buttons with Dropdown
      buttons: [
      ],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['first_name'] +" "+ data['last_name'];
            }
          }),
          type: 'column',
          renderer: $.fn.dataTable.Responsive.renderer.tableAll({
            tableClass: 'table',
          })
        }
      },
      language: {
        paginate: {
          // remove previous & next text from pagination
          previous: '&nbsp;',
          next: '&nbsp;'
        }
      },
      initComplete: function () {
        // Adding role filter once table initialized
        this.api()
            .columns(5)
            .every(function () {
              var column = this;
              var select = $(
                  '<select id="UserRole" class="form-control text-capitalize mb-md-0 mb-2"><option value=""> Select Role </option></select>'
              )
                  .appendTo('.user_role')
                  .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                  });

              column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    if(d){
                      select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>')
                    }
                  });
            });
        // Adding status filter once table initialized
        this.api()
            .columns(6)
            .every(function () {
              var column = this;
              var select = $(
                  '<select id="FilterTransaction" class="form-control text-capitalize mb-md-0 mb-2xx"><option value=""> Select Status </option></select>'
              )
                  .appendTo('.user_status')
                  .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                  });

              column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    select.append(
                        '<option value="' +
                        statusObj[d].title +
                        '" class="text-capitalize">' +
                        statusObj[d].title +
                        '</option>'
                    );
                  });
            });
      },
      fnDrawCallback: function() {   
        //list Permissions
        $('.formEdit').on('click', function(){
          // $.ajax({
          //   url: `${assetPath}api/v1/frontEndRoles`,
          //   type: 'GET',
          //   data: {
          //     _token: token
          //   },
          //   success: function (res) {
          //     // console.log(res.data);
          //     $('#user-role option').remove();
          //     res.data.forEach((item,index) => {             
          //       $('#user-role').append(
          //         '<option value="'+ item.name +'">'+ item.name +'</option>'
          //       )
          //     });
          //   },
          //   error: function (err) {              
          //     newUserSidebar.modal('hide');
          //     Swal.fire({                            
          //       title: 'Error!',
          //       icon: 'error',
          //       text: err.statusText,
          //       customClass: {
          //         confirmButton: 'btn btn-success'
          //       }
          //     });
          //   },
          // });
          $.ajax({
            url: `${assetPath}api/v1/countries`,
            type: 'GET',
            data: {
              _token: token
            },
            success: function (res) {
              // console.log(res.data);
              $('#user-country option').remove();
              res.data.forEach((item,index) => {             
                $('#user-country').append(
                  '<option value="'+ item.id +'">'+ item.name +'</option>'
                )
              });
            },
            error: function (err) {
                Swal.fire({                            
                  title: 'Fetching!',
                  icon: 'error',
                  text: 'Something Went Wrong !! 😟',
                  customClass: {
                    confirmButton: 'btn btn-success'
                  }
                });
            },
          });
        });     
        // For Edit Data
        $('.formEdit').on('click', function(){ 
          clearForm()
          editForm = true  
          if(editForm){            
            $('#exampleModalLabel').text('Edit User');  
          }        
          let id = $(this).attr('category_id');
          selectedRowDataId = id;
          $('#modals-slide-in').modal('show');
          $.ajax({
            url: `${assetPath}api/v1/dosUsers/${id}`,
            type: 'GET',
            data: {
              _token: token
            },
            success: function (res) {
              console.log(res.data);
              $("input[name=first_name]").val(res.data.first_name);
              $("input[name=last_name]").val(res.data.last_name);
              $("input[name=email]").val(res.data.email);
              $("input[name=mobile_number]").val(res.data.mobile_number);
              // $(`#user-role option[value=${res.data.roles[0].name}]`).attr('selected', 'selected');
              $(`#user-country option[value=${res.data.country_id}]`).attr('selected', 'selected');
              $(`#user-status option[value=${res.data.active}]`).attr('selected', 'selected');
            },
            error: function (err) {
                Swal.fire({                            
                  title: 'Fetching!',
                  icon: 'error',
                  text: 'Something Went Wrong !! 😟',
                  customClass: {
                    confirmButton: 'btn btn-success'
                  }
                });
            },
          })
        });
        // Delete Row
        $('.delete-record').on('click', function(){
          let id = $(this).attr('category_id');
          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            customClass: {
              confirmButton: 'btn btn-primary',
              cancelButton: 'btn btn-outline-danger ml-1'
            },
            buttonsStyling: false
          }).then(function (result) {
            if (result.value) {
              $.ajax({
                url: `${assetPath}api/v1/dosUsers/${id}`,
                type: 'DELETE',
                data: {
                  _token: token
                },
                success: function (res) {
                  dtDataTableInit.ajax.reload();
                  toastr['warning']('👋 User Deleted Successfully', 'Deleted!', {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl
                  });
                },
                error: function (err) {                    
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
            }
          });               
        });
      }
    });
  }

  // Check Validity
  function checkValidity(el) {
    if (el.validate().checkForm()) {
      submitBtn.attr('disabled', false);
    } else {
      submitBtn.attr('disabled', true);
    }
  }

  // Form Validation
  if (newUserForm.length) {
    let validator = newUserForm.validate({
      errorClass: 'error',
      rules: {
        'first_name': {
          required: true
        },
        'last_name': {
          required: true
        },
        'country_id': {
          required: true
        },
        'active': {
          required: true
        },
      }
    });

    newUserForm.on('submit', function (e) {
      var isValid = newUserForm.valid();
      e.preventDefault();
      if (isValid) {
        disableSubmitButton(true);
        if(editForm){
          $.ajax({
            url: `${assetPath}api/v1/dosUsers/${selectedRowDataId}?_method=PUT`,
            type: 'POST',
            headers: {'X-CSRF-TOKEN': token },
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (res) {
              if(!res.data){
                Swal.fire({                            
                  title: 'Cancelled!',
                  icon: 'error',
                  text: 'Something Went Wrong !! 😟',
                  customClass: {
                    confirmButton: 'btn btn-success'
                  }
                });
              }
              dtDataTableInit.ajax.reload();
              clearForm()
              toastr['info']('👋 User Updated Successfully.', 'Updated!', {
                closeButton: true,
                tapToDismiss: false,
                rtl: isRtl
              });
              disableSubmitButton(false)
            },
            error: function (err) {
              if (err.status === 422) {
                let errors = err.responseJSON.message;
                let showErrors = {}
                Object.keys(errors).forEach((key) => {
                  showErrors = {
                    ...showErrors,
                    [key]: errors[key]
                  }
                });
                validator.showErrors(showErrors);
              }
              else {
                Swal.fire({                            
                  title: 'Error!',
                  icon: 'error',
                  text: err.statusText,
                  customClass: {
                    confirmButton: 'btn btn-success'
                  }
                });
              }
              disableSubmitButton(false)
            },
          })
        }
      }
    });
  }

  function clearForm(){ 
    $('#exampleModalLabel').text('New User');  
    editForm = false;       
    newUserForm.trigger('reset');
    newUserSidebar.modal('hide');
    selectedRowDataId = null;
  }

  function disableSubmitButton(status){
    if(status){
      submitBtn.attr('disabled', 'disabled');
      submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ml-25 align-middle">Loading</span>');
    }
    else{
      submitBtn.removeAttr('disabled');
      submitBtn.html('Submit');
    }
  }
  
  // To initialize tooltip with body container
  $('body').tooltip({
    selector: '[data-toggle="tooltip"]',
    container: 'body'
  });
});
