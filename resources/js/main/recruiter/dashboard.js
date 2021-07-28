const assetPath = $("body").attr("data-asset-path"),
      isRtl = $("html").attr("data-textdirection") === "rtl",
      buyNowButton = $('.buy-button');
let razorpay_order_id = null;

var $firstChart = document.querySelector('#jobs-chart');
var $secondChart = document.querySelector('#candidates-chart');
var $third = document.querySelector('#selected-chart');
var $fourthChart = document.querySelector('#amount-spent-chart');

var firstChartOptions;
var secondChartOptions;
var thirdChartOptions;
var fourthChartOptions;

var firstChart;
var secondChart;
var thirdChart;

firstChartOptions = {
chart: {
    height: 100,
    type: 'area',
    toolbar: {
    show: false
    },
    sparkline: {
    enabled: true
    },
    grid: {
    show: false,
    padding: {
        left: 0,
        right: 0
    }
    }
},
colors: [window.colors.solid.primary],
dataLabels: {
    enabled: false
},
stroke: {
    curve: 'smooth',
    width: 2.5
},
fill: {
    type: 'gradient',
    gradient: {
    shadeIntensity: 0.9,
    opacityFrom: 0.7,
    opacityTo: 0.5,
    stops: [0, 80, 100]
    }
},
series: [
    {
    name: 'Subscribers',
    data: [28, 40, 36, 52, 38, 60, 55]
    }
],
xaxis: {
    labels: {
    show: false
    },
    axisBorder: {
    show: false
    }
},
yaxis: [
    {
    y: 0,
    offsetX: 0,
    offsetY: 0,
    padding: { left: 0, right: 0 }
    }
],
tooltip: {
    x: { show: false }
}
};
firstChart = new ApexCharts($firstChart, firstChartOptions);
firstChart.render();

// Order Received Chart
// ----------------------------------

secondChartOptions = {
chart: {
    height: 100,
    type: 'area',
    toolbar: {
    show: false
    },
    sparkline: {
    enabled: true
    },
    grid: {
    show: false,
    padding: {
        left: 0,
        right: 0
    }
    }
},
colors: [window.colors.solid.warning],
dataLabels: {
    enabled: false
},
stroke: {
    curve: 'smooth',
    width: 2.5
},
fill: {
    type: 'gradient',
    gradient: {
    shadeIntensity: 0.9,
    opacityFrom: 0.7,
    opacityTo: 0.5,
    stops: [0, 80, 100]
    }
},
series: [
    {
    name: 'Orders',
    data: [10, 15, 8, 15, 7, 12, 8]
    }
],
xaxis: {
    labels: {
    show: false
    },
    axisBorder: {
    show: false
    }
},
yaxis: [
    {
    y: 0,
    offsetX: 0,
    offsetY: 0,
    padding: { left: 0, right: 0 }
    }
],
tooltip: {
    x: { show: false }
}
};

thirdChartOptions = {
chart: {
    height: 100,
    type: 'area',
    toolbar: {
    show: false
    },
    sparkline: {
    enabled: true
    },
    grid: {
    show: true,
    padding: {
        left: 0,
        right: 0
    }
    }
},
colors: [window.colors.solid.success],
dataLabels: {
    enabled: false
},
stroke: {
    curve: 'smooth',
    width: 3.5
},
fill: {
    type: 'gradient',
    gradient: {
    shadeIntensity: 0.9,
    opacityFrom: 0.7,
    opacityTo: 0.5,
    stops: [0, 80, 100]
    }
},
series: [
    {
    name: 'Instructors',
    data: [10, 15, 8, 15, 7, 12, 8]
    }
],
xaxis: {
    labels: {
    show: false
    },
    axisBorder: {
    show: false
    }
},
yaxis: [
    {
    y: 0,
    offsetX: 0,
    offsetY: 0,
    padding: { left: 0, right: 0 }
    }
],
tooltip: {
    x: { show: false }
}
};

fourthChartOptions = {
chart: {
    height: 100,
    type: 'area',
    toolbar: {
    show: false
    },
    sparkline: {
    enabled: true
    },
    grid: {
    show: true,
    padding: {
        left: 0,
        right: 0
    }
    }
},
colors: [window.colors.solid.danger],
dataLabels: {
    enabled: false
},
stroke: {
    curve: 'smooth',
    width: 4.5
},
fill: {
    type: 'gradient',
    gradient: {
    shadeIntensity: 0.9,
    opacityFrom: 0.7,
    opacityTo: 0.5,
    stops: [0, 80, 100]
    }
},
series: [
    {
    name: 'Instructors',
    data: [10, 15, 8, 15, 7, 12, 8]
    }
],
xaxis: {
    labels: {
    show: false
    },
    axisBorder: {
    show: false
    }
},
yaxis: [
    {
    y: 0,
    offsetX: 0,
    offsetY: 0,
    padding: { left: 0, right: 0 }
    }
],
tooltip: {
    x: { show: false }
}
};
secondChart = new ApexCharts($secondChart, secondChartOptions);
secondChart.render();

thirdChart = new ApexCharts($third, thirdChartOptions);
thirdChart.render();

thirdChart = new ApexCharts($fourthChart, fourthChartOptions);
thirdChart.render();

$('.buy-button').on('click', function() {
    disableBuyNowButton(true);
    let $id = $(this).attr('data-id');
    $.ajax({
        url: `${assetPath}api/v1/recruiter/order/${$id}`,
        type: 'POST',
        success: function (res) {
            if(res.data.id !== undefined)
            {
                paymentGateWay(res.data);
            }
            else if(res.data.plan_name !== undefined)
            {
                Swal.fire({                            
                    title: 'Success!',
                    icon: 'success',
                    text: res.data.plan_name,
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            }
            disableBuyNowButton(false);
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
                    text: err.statusText,
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            }
            disableBuyNowButton(false);
        },
    })
})

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
        url: `${assetPath}api/v1/recruiter/payments`,
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
                text: res.data.plan_name,
                customClass: {
                    confirmButton: 'btn btn-success'
                }
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

function disableBuyNowButton(status){
    if(status){
        buyNowButton.attr('disabled', 'disabled');
        buyNowButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ml-25 align-middle">Loading</span>');
    }
    else{
        buyNowButton.removeAttr('disabled');
        buyNowButton.html('Buy Now');
    }
}