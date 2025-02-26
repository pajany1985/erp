/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./Resources/assets/js/dashboard/dashboard.js":
/*!****************************************************!*\
  !*** ./Resources/assets/js/dashboard/dashboard.js ***!
  \****************************************************/
/***/ ((module) => {

 // Class definition

var KTWidgets = function () {
  // Charts widgets
  var initChartsEmpCandid = function initChartsEmpCandid() {
    var element = document.getElementById("kt_charts_employer_candidate");
    var height = parseInt(KTUtil.css(element, 'height'));
    var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
    var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
    var baseColor = KTUtil.getCssVariableValue('--bs-primary');
    var secondaryColor = KTUtil.getCssVariableValue('--bs-gray-300');

    if (!element) {
      return;
    }

    var options = {
      series: [],
      title: {
        text: 'Last Six Months Data'
      },
      noData: {
        text: 'Loading...'
      },
      chart: {
        fontFamily: 'inherit',
        type: 'bar',
        height: height,
        toolbar: {
          show: false
        }
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: ['30%'],
          borderRadius: 4
        }
      },
      legend: {
        show: false
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        // categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: labelColor,
            fontSize: '12px'
          }
        }
      },
      yaxis: {
        labels: {
          style: {
            colors: labelColor,
            fontSize: '12px'
          }
        }
      },
      fill: {
        opacity: 1
      },
      states: {
        normal: {
          filter: {
            type: 'none',
            value: 0
          }
        },
        hover: {
          filter: {
            type: 'none',
            value: 0
          }
        },
        active: {
          allowMultipleDataPointsSelection: false,
          filter: {
            type: 'none',
            value: 0
          }
        }
      },
      tooltip: {
        style: {
          fontSize: '12px'
        },
        y: {
          formatter: function formatter(val) {
            return val;
          }
        }
      },
      colors: [baseColor, secondaryColor],
      grid: {
        borderColor: borderColor,
        strokeDashArray: 4,
        yaxis: {
          lines: {
            show: true
          }
        }
      }
    };
    var chart = new ApexCharts(element, options);
    chart.render();
    $.ajax({
      url: "/admin/dashboard/empcandidate",
      method: "GET",
      dataType: "json",
      success: function success(data) {
        chart.updateSeries([{
          name: 'Employers',
          data: data.employers
        }, {
          name: 'Candidates',
          data: data.candidates
        }]);
      }
    });
  };

  var initChartsTrans = function initChartsTrans() {
    var element = document.getElementById("kt_charts_trans_chart");
    var height = parseInt(KTUtil.css(element, 'height'));
    var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
    var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
    var baseColor = KTUtil.getCssVariableValue('--bs-primary');
    var lightColor = KTUtil.getCssVariableValue('--bs-light-primary');

    if (!element) {
      return;
    }

    var options = {
      series: [],
      title: {
        text: 'Last Six Months Data'
      },
      noData: {
        text: 'Loading...'
      },
      chart: {
        fontFamily: 'inherit',
        type: 'area',
        height: 350,
        toolbar: {
          show: false
        }
      },
      plotOptions: {},
      legend: {
        show: false
      },
      dataLabels: {
        enabled: false
      },
      fill: {
        type: 'solid',
        opacity: 1
      },
      stroke: {
        curve: 'smooth',
        show: true,
        width: 3,
        colors: [baseColor]
      },
      xaxis: {
        // categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: labelColor,
            fontSize: '12px'
          }
        },
        crosshairs: {
          position: 'front',
          stroke: {
            color: baseColor,
            width: 1,
            dashArray: 3
          }
        },
        tooltip: {
          enabled: true,
          formatter: undefined,
          offsetY: 0,
          style: {
            fontSize: '12px'
          }
        }
      },
      yaxis: {
        labels: {
          style: {
            colors: labelColor,
            fontSize: '12px'
          }
        }
      },
      states: {
        normal: {
          filter: {
            type: 'none',
            value: 0
          }
        },
        hover: {
          filter: {
            type: 'none',
            value: 0
          }
        },
        active: {
          allowMultipleDataPointsSelection: false,
          filter: {
            type: 'none',
            value: 0
          }
        }
      },
      tooltip: {
        style: {
          fontSize: '12px'
        },
        y: {
          formatter: function formatter(val) {
            return "$" + val;
          }
        }
      },
      colors: [lightColor],
      grid: {
        borderColor: borderColor,
        strokeDashArray: 4,
        yaxis: {
          lines: {
            show: true
          }
        }
      },
      markers: {
        strokeColor: baseColor,
        strokeWidth: 3
      }
    };
    var chart = new ApexCharts(element, options);
    chart.render();
    $.ajax({
      url: "/admin/dashboard/transactionschart",
      method: "GET",
      dataType: "json",
      success: function success(data) {
        chart.updateSeries([{
          name: 'Net Transaction',
          data: data.transaction
        }]);
      }
    });
  }; // Public methods


  return {
    init: function init() {
      // Charts widgets
      initChartsEmpCandid(); //

      initChartsTrans(); //          
    }
  };
}(); // Webpack support


if (true) {
  module.exports = KTWidgets;
} // On document ready


KTUtil.onDOMContentLoaded(function () {
  KTWidgets.init();
});

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module is referenced by other modules so it can't be inlined
/******/ 	var __webpack_exports__ = __webpack_require__("./Resources/assets/js/dashboard/dashboard.js");
/******/ 	
/******/ })()
;