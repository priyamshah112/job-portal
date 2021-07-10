const isRtl = $("html").attr("data-textdirection") === "rtl";
const assetPath = $("body").attr("data-asset-path");

var $gainedChart = document.querySelector('#recruiters-chart');
var $orderChart = document.querySelector('#candidates-chart');
var $instructor = document.querySelector('#jobs-chart');
var $coursesDrafted = document.querySelector('#total-hired-chart');

var gainedChartOptions;
var orderChartOptions;
var instructorChartOptions;
var CoursesChartOptions;

var gainedChart;
var orderChart;
var instructorChart;

gainedChartOptions = {
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
gainedChart = new ApexCharts($gainedChart, gainedChartOptions);
gainedChart.render();

// Order Received Chart
// ----------------------------------

orderChartOptions = {
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

instructorChartOptions = {
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

CoursesChartOptions = {
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
orderChart = new ApexCharts($orderChart, orderChartOptions);
orderChart.render();

instructorChart = new ApexCharts($instructor, instructorChartOptions);
instructorChart.render();

instructorChart = new ApexCharts($coursesDrafted, CoursesChartOptions);
instructorChart.render();


$(window).on('load', function () {
    var table = $('#payment-list-table').DataTable({
        ajax: {
            "url": `${assetPath}api/v1/admin/payments`,
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
        },
        columns: [            
            {
                orderable: true,
                render: function (data, type, full, meta) {
                    return meta.row + 1
                }
            },
            {
                data: 'company_name',
                orderable: true,
            },
            {
                data: 'package_name',
                orderable: true
            },
            {
                data: 'amount',
                orderable: true
            },
            {
                data: 'status',
                orderable: true,
                render: (data, type, full, meta) => {
                    let response = '';
                    if (data == 'success') {
                        response = '<span class="badge badge-success">Success</span>';
                    } else {
                        response = '<span class="badge badge-danger">Failed</span>';
                    }
                    return response;
                }
            },

        ],
    });
});
