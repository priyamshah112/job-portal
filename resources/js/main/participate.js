const isRtl = $("html").attr("data-textdirection") === "rtl";
let nextButton = null;
const assetPath = $("body").attr("data-asset-path");
const job_fair_id = $('input[name="job_fair_id"]').val();

let table = $('.job-list-table').DataTable({
    ajax: {
        url: `${assetPath}api/v1/recruiter/job/participate/${job_fair_id}`
    },
    autoWidth: false,
    columns: [
        {
            data: null,
            orderable: false,
            searchable: false,
            render: function (data, type, full, meta) {
                return `<div class="custom-control custom-checkbox select-box">
                <input type="checkbox" class="custom-control-input checkbox" id="customCheck${meta.row}" job_fair_id="${full['id']}" />
                <label class="custom-control-label" for="customCheck${meta.row}"></label>
              </div>`;
            }
        },
        {
            className: 'control',
            orderable: false,
            responsivePriority: 0,
            render: function (data, type, full, meta) {
              return meta.row + 1
            }
        },
        {
            data: 'position',
        },
        {
            data: null,
            render: function(data, type, full, meta){
                return full['age_min'] +' - '+ full['age_max'];
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
            data: 'skills',
            render: function(data, type, full, meta){
                return data;
            }
        },
        {
            data: 'deadline'
        },
        {
            data: 'action',
            orderable: false,
            searchable: false
        }
    ],   
    dom:
          '<"row d-flex justify-content-between align-items-center"' +
          '<"col-lg-6 d-flex align-items-center"lf>' +
          '<"col-lg-6 d-flex align-items-center justify-content-end p-0"<"dt-action-buttons text-xl-right text-lg-left text-lg-right text-left mt-50"B>>' +
          '>t' +
          '<"d-flex justify-content-between mx-2 row"' +
          '<"col-sm-12 col-md-6"i>' +
          '<"col-sm-12 col-md-6"p>' +
          '>',
    language: {
        sLengthMenu: 'Show _MENU_',
        search: 'Search',
        searchPlaceholder: 'Search..'
    },
    buttons: [
        {
          text: 'Next',
          className: 'btn btn-primary btn-next ml-2 d-none ',
          action: function (e, dt, button, config) {
            disableNextButton(true);

            let job_fairs = [];  
            let checkboxes = $('.select-box input'); 
            checkboxes.each(function (){
                if($(this).is(':checked'))
                {
                    console.log($(this).attr("job_fair_id"));
                    job_fairs.push($(this).attr("job_fair_id"))
                }
            });

            let id = $('input[name="job_fair_id"]').val();
            $.ajax({
                url: `${assetPath}api/v1/recruiter/job-fair/order/${id}`,
                type: 'POST',
                data: {
                    job_fairs
                },               
                success: function (res) {
                    if(res.data.id !== undefined)
                    {
                        paymentGateWay(res.data);
                    }
                    else if(res.data.jobFair !== undefined)
                    {
                        Swal.fire({                            
                            title: 'Success!',
                            icon: 'success',
                            text: res.data.jobFair,
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                        window.location.href = "/future-events"
                    }
                    disableNextButton(false);
                },
                error: function (err) {
                    console.log('An error occurred.',err);    
                    if(err.status === 410)
                    {                
                        Swal.fire({                            
                            title: 'Warning!',
                            icon: 'warning',
                            text: err.responseJSON.message,
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                    else
                    {                    
                        Swal.fire({                            
                            title: 'Error!',
                            icon: 'error',
                            text: err.responseJSON.message,
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                    disableNextButton(false);
                },
            })
          }
        }
    ],
    fnDrawCallback: function() {   
        nextButton = $('.btn-next');     
        feather.replace();
        $('.select-box input').on('change', function(){
            let checkboxes = $('.select-box input');
            let check = false;
            checkboxes.each(function (){
              if($(this).is(':checked'))
              {
                check = true;
                return false;
              }
            });
            if (check) {
                $('.btn-next').removeClass('d-none');
            }
            else{
                $('.btn-next').addClass('d-none');
            }
        });
    }
});

function paymentGateWay(order)
{
    let options = {
        "key": "rzp_test_rlSV1yn8HI0l2u",
        "amount": order.amount,
        "currency": "INR",
        "name": "Job Portal",
        "description": "Job Portal to lead you to your success and dream job.",
        "image": "https://naukriwala.co.in/images/logo/job_portal_logo.png",
        "order_id": order.id, 
        "handler": function (response){
            verifyPayment(response);
        },
        "theme": {
            "color": "#3399cc"
        }
    };

    let rzp = new Razorpay(options);
    rzp.on('payment.failed', function (response){
            console.log(response.error);
    });
    rzp.open();
}

function verifyPayment(res) {
    $.ajax({
        url: `${assetPath}api/v1/recruiter/job-fair/payments`,
        type: 'POST',
        data: {
            razorpay_payment_id: res.razorpay_payment_id,
            razorpay_order_id: res.razorpay_order_id,
            razorpay_signature: res.razorpay_signature,
        },
        success: function (res) {
            Swal.fire({                            
                title: 'Success!',
                icon: 'success',
                text: res.data.jobFair,
                customClass: {
                    confirmButton: 'btn btn-success'
                }
            });
            window.location.href = "/future-events"
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
    });    
}

function disableNextButton(status){
    console.log(nextButton);
    if(status){
        nextButton.attr('disabled', 'disabled');
        nextButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ml-25 align-middle">Loading</span>');
    }
    else{
        nextButton.removeAttr('disabled');
        nextButton.html('Next');
    }
}
