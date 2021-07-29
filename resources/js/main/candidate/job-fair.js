const isRtl = $("html").attr("data-textdirection") === "rtl";
const assetPath = $("body").attr("data-asset-path");
var applyBtn = $('.apply');

applyBtn.on('click', function(){  
    blockPage(true)
    $this = $(this);          
    let id = $(this).attr('data-id');
    $.ajax({
        url: `${assetPath}api/v1/candidate/job-fair/apply/${id}`,
        type: 'POST',
        success: function (res) {
        // console.log(res.data);
            toastr['success']('👋 Successfully Applied For Job Fair', 'Success!', {
                closeButton: true,
                tapToDismiss: false,
                rtl: isRtl
          });
          $this.parents(`.job-fair-item[data-id="${res.data.job_fair_id}"]`).remove();
          blockPage(false);
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
            blockPage(false);
        },
    })
});

function blockPage(status) {
    if (status) {
        $.blockUI({
            message:
              '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-0">Please wait...</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
            css: {
              backgroundColor: 'transparent',
              color: '#fff',
              border: '0'
            },
            overlayCSS: {
              opacity: 0.5
            }
          });
    } else {
        $('.blockUI').remove();
    }
}