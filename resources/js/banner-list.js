/*=========================================================================================
    File Name: banner-list.js
    Description: Banner List page
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
$(function () {
  'use strict';

  var dtCategoryTable = $('.category-list-table'),
      newCategorySidebar = $('.new-category-modal'),
      newCategoryForm = $('.add-new-category');
 
  var editForm = false;
  var selectedRowDataId = null;
  var token = $('meta[name="csrf-token"]').attr('content');
  var isRtl = $('html').attr('data-textdirection') === 'rtl';
  var submitBtn = $('.data-submit');
  var assetPath = $('body').attr('data-asset-path');
  var dataCreate = $('.app-category-list').attr('data-create');
  var dataWrite = $('.app-category-list').attr('data-write');
  var dataDelete = $('.app-category-list').attr('data-delete');
  // categorys List datatable
  if (dtCategoryTable.length) {
    var dtCategoryTableInit = dtCategoryTable.DataTable({
      ajax: {
        "url": `${assetPath}api/v1/banners`,
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
        { data: 'image_path' },
        { data: 'title'},
        { data: 'preference'},
        { data: null}
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          orderable: true,
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
          orderable: true,
          responsivePriority: 2,
          targets: 2,
          render: function (data, type, full, meta) {
            return (
              '<img class="img-fluid img-rounded" src='+ full['image_path'] +' />'
            );
          }
        },
        {
          orderable: true,
          responsivePriority: 2,
          targets: 3,
        },
        {
          // Actions
          targets: -1,
          title: 'Actions',
          orderable: false,
          responsivePriority: 3,
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
      order: [[1, 'asc']],
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
      buttons: dataCreate ? [
        {
          text: 'Add New Banner',
          className: 'add-new btn btn-primary mt-50',
          attr: {
            'data-toggle': 'modal',
            'data-target': '#modals-slide-in'
          },
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
          }
        }
      ] : [],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['name'];
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
      fnDrawCallback: function() {
        // For Edit Data
        $('.formEdit').on('click', function(){ 
          clearForm()
          editForm = true  
          if(editForm){            
            $('#exampleModalLabel').text('Edit Banner');  
          }        
          let id = $(this).attr('category_id');
          selectedRowDataId = id;
          $('#modals-slide-in').modal('show');
          $.ajax({
            url: `${assetPath}api/v1/banners/${id}`,
            type: 'GET',
            data: {
              _token: token
            },
            success: function (res) {
              // console.log(res.data);
              // $("input[name=image_name]").val(res.data.image_name);
              $("input[name=title]").val(res.data.title);
              $("input[name=description]").val(res.data.description);
              $("input[name=button_text]").val(res.data.button_text);
              $(`option[value=${res.data.preference}]`).attr('selected', 'selected');
              $("input[name=url]").val(res.data.url);
            },
            error: function (err) {
                console.log('An error occurred.',err);
                newCategorySidebar.modal('hide');
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
        // Delete Row
        $('.delete-record').on('click', function(){
          let id = $(this).attr('category_id');
          let $row = $(this).closest('tr');
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
                url: `${assetPath}api/v1/banners/${id}`,
                type: 'DELETE',
                data: {
                  _token: token
                },
                success: function (res) {
                  dtCategoryTableInit.row($row).remove().draw();
                  toastr['warning']('👋 Banner Deleted Successfully', 'Deleted!', {
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
            }
          });               
        })
      }
    });
  }

  // Form Validation
  if (newCategoryForm.length) {
    let validator = newCategoryForm.validate({
      errorClass: 'error',
      rules: {
        'title': {
          required: true
        },
        'description': {
          required: true
        },
        'button_text': {
          required: true
        },
        'preference': {
          required: true
        },
        'url': {
          required: true
        },
      }
    });

    newCategoryForm.on('submit', function (e) {
      var isValid = newCategoryForm.valid();
      e.preventDefault();
      if (isValid) {        
        disableSubmitButton(true);
        if(editForm){
          $.ajax({
            url: `${assetPath}api/v1/banners/${selectedRowDataId}?_method=PUT`,
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
              dtCategoryTableInit.ajax.reload();
              clearForm()
              toastr['info']('👋 Banner Updated Successfully.', 'Updated!', {
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
        else{
          $.ajax({
            url: `${assetPath}api/v1/banners`,
            type: 'post',
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
              dtCategoryTableInit.ajax.reload();
              newCategoryForm.trigger('reset');
              newCategorySidebar.modal('hide');
              toastr['success']('👋 Banner Created Successfully.', 'Success!', {
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

  $('[data-dismiss="modal"]').on('click', function(){      
    if(editForm){            
      $('#exampleModalLabel').text('New Banner');  
      editForm = false;      
      newCategoryForm.trigger('reset');
      selectedRowDataId = null;
    }  
  });

  function clearForm(){ 
    $('#exampleModalLabel').text('New Banner');  
    editForm = false;       
    newCategoryForm.trigger('reset');
    newCategorySidebar.modal('hide');
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
