const assetPath = $("body").attr("data-asset-path"),
      isRtl = $("html").attr("data-textdirection") === "rtl";
let razorpay_order_id = null;

$('.buy-button').on('click', function() {
    $id = $(this).attr('data-id');
    $.ajax({
        url: `${assetPath}api/v1/recruiter/order/${$id}`,
        type: 'POST',
        data: {
            "amount": 1000
        },
        success: function (res) {
            console.log(res.data);
            if(res.data.id !== undefined)
            {
                paymentGateWay(res.data);
            }
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
})

function paymentGateWay(order)
{
    let options = {
        "key": "rzp_test_rlSV1yn8HI0l2u",
        "amount": order.amount,
        "currency": "INR",
        "name": "Job Portal Corp",
        "description": "Test Transaction",
        "image": "https://example.com/your_logo",
        "order_id": order.id, 
        "handler": function (response){
            verifyPayment(response);
        },
        "prefill": {
            "name": "Gaurav Kumar",
            "email": "gaurav.kumar@example.com",
            "contact": "9999999999"
        },
        "notes": {
            "address": "Razorpay Corporate Office"
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
        url: `${assetPath}api/v1/recruiter/payments`,
        type: 'POST',
        data: {
            razorpay_payment_id: res.razorpay_payment_id,
            razorpay_order_id: res.razorpay_order_id,
            razorpay_signature: res.razorpay_signature,
        },
        success: function (res) {
            toastr['success']('👋 Payment Done', 'Success!', {
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
    });    
}
