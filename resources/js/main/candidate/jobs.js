const isRtl = $("html").attr("data-textdirection") === "rtl";
const assetPath = $("body").attr("data-asset-path");

$('.apply').on('click', function(){  
    $this = $(this);          
    let id = $(this).attr('data-id');
    $.ajax({
        url: `${assetPath}api/v1/candidate/job-apply/${id}`,
        type: 'POST',
        success: function (res) {
        // console.log(res.data);
            toastr['success']('👋 Successfully Applied For Job', 'Success!', {
                closeButton: true,
                tapToDismiss: false,
                rtl: isRtl
          });
          $this.parents(`.job-item[data-id="${res.data.job_id}"]`).remove();
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
});
