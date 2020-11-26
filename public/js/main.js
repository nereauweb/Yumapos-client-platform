/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/coreui/main.js":
/*!*************************************!*\
  !*** ./resources/js/coreui/main.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/* eslint-disable object-shorthand */

/* global Chart, coreui, coreui.Utils.getStyle, coreui.Utils.hexToRgba */

/**
 * --------------------------------------------------------------------------
 * CoreUI Boostrap Admin Template (v3.0.0): main.js
 * Licensed under MIT (https://coreui.io/license)
 * --------------------------------------------------------------------------
 */

/* eslint-disable no-magic-numbers */

const mainChart = new Chart(document.getElementById('main-chart'), {
    type: 'line',
    options: {
        maintainAspectRatio: false,
        legend: {
            display: false
        },
        elements: {
            point: {
                radius: 0,
                hitRadius: 10,
                hoverRadius: 4,
                hoverBorderWidth: 3
            }
        }
    }
});
// Disable the on-canvas tooltip
Chart.defaults.global.pointHitDetectionRadius = 1;
Chart.defaults.global.tooltips.enabled = false;
Chart.defaults.global.tooltips.mode = 'index';
Chart.defaults.global.tooltips.position = 'nearest';
Chart.defaults.global.tooltips.custom = coreui.ChartJS.customTooltips;
Chart.defaults.global.defaultFontColor = '#646470';
Chart.defaults.global.responsiveAnimationDuration = 1;
document.body.addEventListener('classtoggle', function (event) {
  if (event.detail.className === 'c-dark-theme') {
    if (document.body.classList.contains('c-dark-theme')) {
      cardChart1.data.datasets[0].pointBackgroundColor = coreui.Utils.getStyle('--primary-dark-theme');
      cardChart2.data.datasets[0].pointBackgroundColor = coreui.Utils.getStyle('--info-dark-theme');
      Chart.defaults.global.defaultFontColor = '#fff';
    } else {
      cardChart1.data.datasets[0].pointBackgroundColor = coreui.Utils.getStyle('--primary');
      cardChart2.data.datasets[0].pointBackgroundColor = coreui.Utils.getStyle('--info');
      Chart.defaults.global.defaultFontColor = '#646470';
    }

    cardChart1.update();
    cardChart2.update();
    mainChart.update();
  }
});
// admin details
const totalsOperations = document.getElementById('operationsTotals');
const totalsGain = document.getElementById('gainTotals');
const totalsCost = document.getElementById('costTotals');
const totalsAmount = document.getElementById('amountTotals');


// user details
const totalsUserOperations = document.getElementById('operationsUserTotals');
const totalsUserGain = document.getElementById('gainUserTotals');
const totalsUserCost = document.getElementById('costUserTotals');
const totalsUserAmount = document.getElementById('amountUserTotals');


// shared variables
const filters = document.getElementsByName("filterSelected");
const country_filter = document.getElementById('country-selected');
const operator_filter = document.getElementById('operator-selected');

// to be taken note, not very secure way of passing the user
const user_identifier = document.getElementById('identifier-custom');
const agent_identifier = document.querySelector('#graph-selected');

let user_id;
if (user_identifier) {
    user_id = user_identifier.value;
}

let user_object = {
    isUser: '',
    user_id:''
};

function fetchData(url, type, country, operator, user_object = null) {
    let custom_data = {
        amounts: [],
        costs: [],
        operations: [],
        gains: [],
        labels: []
    };
    fetch(`${url}/${type}`, {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            'X-CSRF-TOKEN': document.getElementsByName('csrf-token')[0].getAttribute('content')
        },
        body: JSON.stringify({
            'country': country,
            'operator': operator,
            'user_id': user_object ? user_object.user_id : null,
            'isUser': user_object ? user_object.isUser : false
        })
    }).then(response => response.json()).then(response => {
        response.map(item => {
            custom_data.operations.push(item.operations);
            custom_data.amounts.push(item.amount_data);
            custom_data.gains.push(item.gain_data);
            custom_data.costs.push(item.cost);
            custom_data.labels.push(item.label);
        });
    }).then(res => {
        mainChart.data = {
            labels: custom_data.labels,
            datasets: [{
                lineTension: 0.05,
                label: 'Operations by hour',
                backgroundColor: coreui.Utils.hexToRgba(coreui.Utils.getStyle('--success'), 10),
                borderColor: coreui.Utils.getStyle('--success'),
                pointHoverBackgroundColor: '#fff',
                borderWidth: 2,
                data: custom_data.operations
            },
                {
                    lineTension: 0.05,
                    label: 'Amount by hour',
                    backgroundColor: coreui.Utils.hexToRgba(coreui.Utils.getStyle('--info'), 10),
                    borderColor: coreui.Utils.getStyle('--info'),
                    pointHoverBackgroundColor: '#fff',
                    borderWidth: 2,
                    data: custom_data.amounts
                },
                {
                    lineTension: 0.05,
                    label: 'Cost by hour',
                    backgroundColor: coreui.Utils.hexToRgba(coreui.Utils.getStyle('--warning'), 10),
                    borderColor: coreui.Utils.getStyle('--warning'),
                    pointHoverBackgroundColor: '#fff',
                    borderWidth: 2,
                    data: custom_data.costs
                },
                {
                    lineTension: 0.05,
                    label: 'Gain by hour',
                    backgroundColor: coreui.Utils.hexToRgba(coreui.Utils.getStyle('--danger'), 10),
                    borderColor: coreui.Utils.getStyle('--danger'),
                    pointHoverBackgroundColor: '#fff',
                    borderWidth: 2,
                    data: custom_data.gains
                },
            ]
        }
        mainChart.update();
    }).catch(error => {
        alert(error);
    });
}

const initialData = () => {
    fetchData('admin/internal/services', 'day', 0, 0, user_object);
}

const initialUserData = () => {
    fetchData('user/internal/services', 'day', 0, 0, user_object);
}

const initialAgentData = () => {
    fetchData('sales/reports/internal', 'day', 0, 0, user_object);
}

if (!user_identifier) {
    user_object.isUser = false;
    initialData();
    loadTotals('admin','day', 0, 0, 0);
    let checkedFilter = document.querySelector('input[name="filterSelected"]:checked');
    checkedFilter.parentElement.classList.add('active');

    filters.forEach(filter => {
        filter.onchange = (e) => {
            e.preventDefault();
            let  countrified = country_filter.value;
            let  operatorField = operator_filter.value;
            switch (filter.value) {
                case 'day':
                    fetchData('/admin/internal/services', 'day', countrified, operatorField);
                    loadTotals('admin','day', countrified, operatorField);
                    break;
                case 'yesterday':
                    fetchData('/admin/internal/services', 'yesterday', countrified, operatorField);
                    loadTotals('admin','yesterday', countrified, operatorField);
                    break;
                case 'week':
                    fetchData('/admin/internal/services', 'week', countrified, operatorField);
                    loadTotals('admin','week', countrified, operatorField);
                    break;
                case 'month':
                    fetchData('/admin/internal/services', 'month', countrified, operatorField);
                    loadTotals('admin','month', countrified, operatorField);
                    break;
                default:
                    alert('coding error!');
            }
        }
    });

    country_filter.onchange = () => {
        fetchData('/admin/internal/services', document.querySelector('input[name="filterSelected"]:checked').value, country_filter.value, operator_filter.value);
        loadTotals('admin',document.querySelector('input[name="filterSelected"]:checked').value, country_filter.value, operator_filter.value);
    }

    operator_filter.onchange = () => {
        fetchData('/admin/internal/services', document.querySelector('input[name="filterSelected"]:checked').value, country_filter.value, operator_filter.value);
        loadTotals('admin',document.querySelector('input[name="filterSelected"]:checked').value, country_filter.value, operator_filter.value);
    }

} else if (user_identifier && !agent_identifier) {
    user_object.isUser = true;
    user_object.user_id = user_id;
    initialUserData();
    loadTotals('user','day', 0, 0, 0);
    let checkedFilter = document.querySelector('input[name="filterSelected"]:checked');
    checkedFilter.parentElement.classList.add('active');

    filters.forEach(filter => {
        filter.onchange = (e) => {
            e.preventDefault();
            // let countrified = country_filter.value;
            // let operatorField = operator_filter.value;
            switch (filter.value) {
                case 'day':
                    fetchData('/user/internal/services', 'day', 0, 0, user_object);
                    loadTotals('user','day', 0, 0, user_object);
                    break;
                case 'yesterday':
                    fetchData('/user/internal/services', 'yesterday', 0, 0, user_object);
                    loadTotals('user','yesterday', 0, 0);
                    break;
                case 'week':
                    fetchData('/user/internal/services', 'week', 0, 0, user_object);
                    loadTotals('user','week', 0, 0, user_object);
                    break;
                case 'month':
                    fetchData('/user/internal/services', 'month', 0, 0, user_object);
                    loadTotals('user','month', 0, 0, user_object);
                    break;
                default:
                    alert('coding error!');
            }
        }

        // operator_filter.onchange = () => {
        //     fetchData('/user/internal/services', document.querySelector('input[name="filterSelected"]:checked').value, country_filter.value, operator_filter.value);
        //     loadTotals(document.querySelector('input[name="filterSelected"]:checked').value, country_filter.value, operator_filter.value);
        // }


        // country_filter.onchange = () => {
        //     fetchData('/user/internal/services', document.querySelector('input[name="filterSelected"]:checked').value, country_filter.value, operator_filter.value);
        //     loadTotals(document.querySelector('input[name="filterSelected"]:checked').value, country_filter.value, operator_filter.value);
        // }
    });

} else if (user_identifier && agent_identifier) {
    user_object.isUser = true;
    user_object.user_id = user_id;
    initialUserData();
    loadTotals('user','day', 0, 0, 0);
    let checkedFilter = document.querySelector('input[name="filterSelected"]:checked');
    checkedFilter.parentElement.classList.add('active');
    agent_identifier.onchange = () => {
        switch (agent_identifier.value) {
            case '1':
                user_object.isUser = true;
                user_object.user_id = user_id;
                initialUserData();
                loadTotals('user','day', 0, 0, 0);
                checkedFilter.parentElement.classList.add('active');

                filters.forEach(filter => {
                    filter.onchange = (e) => {
                        e.preventDefault();
                        // let countrified = country_filter.value;
                        // let operatorField = operator_filter.value;
                        switch (filter.value) {
                            case 'day':
                                fetchData('/user/internal/services', 'day', 0, 0, user_object);
                                loadTotals('user','day', 0, 0, user_object);
                                break;
                            case 'yesterday':
                                fetchData('/user/internal/services', 'yesterday', 0, 0, user_object);
                                loadTotals('user','yesterday', 0, 0);
                                break;
                            case 'week':
                                fetchData('/user/internal/services', 'week', 0, 0, user_object);
                                loadTotals('user','week', 0, 0, user_object);
                                break;
                            case 'month':
                                fetchData('/user/internal/services', 'month', 0, 0, user_object);
                                loadTotals('user','month', 0, 0, user_object);
                                break;
                            default:
                                alert('coding error!');
                        }
                    }

                    // operator_filter.onchange = () => {
                    //     fetchData('/user/internal/services', document.querySelector('input[name="filterSelected"]:checked').value, country_filter.value, operator_filter.value);
                    //     loadTotals(document.querySelector('input[name="filterSelected"]:checked').value, country_filter.value, operator_filter.value);
                    // }
                    //
                    // country_filter.onchange = () => {
                    //     fetchData('/user/internal/services', document.querySelector('input[name="filterSelected"]:checked').value, country_filter.value, operator_filter.value);
                    //     loadTotals(document.querySelector('input[name="filterSelected"]:checked').value, country_filter.value, operator_filter.value);
                    // }
                });
                break;
            case '2':
                user_object.isUser = false;
                user_object.user_id = null;
                initialAgentData();
                loadAgentTotals('day', 0, 0);
                checkedFilter.parentElement.classList.add('active');

                filters.forEach(filter => {
                    filter.onchange = (e) => {
                        e.preventDefault();
                        // let countrified = country_filter.value;
                        // let operatorField = operator_filter.value;
                        switch (filter.value) {
                            case 'day':
                                fetchData('/sales/reports/internal', 'day', 0, 0, user_object);
                                loadAgentTotals('day', 0, 0, user_object);
                                break;
                            case 'yesterday':
                                fetchData('/sales/reports/internal', 'yesterday', 0, 0, user_object);
                                loadAgentTotals('yesterday', 0, 0, user_object);
                                break;
                            case 'week':
                                fetchData('/sales/reports/internal', 'week', 0, 0, user_object);
                                loadAgentTotals('week', 0, 0, user_object);
                                break;
                            case 'month':
                                fetchData('/sales/reports/internal', 'month', 0, 0, user_object);
                                loadAgentTotals('month', 0, 0, user_object);
                                break;
                            default:
                                alert('coding error!');
                        }
                    }

                    // operator_filter.onchange = () => {
                    //     fetchData('/sales/reports/internal', document.querySelector('input[name="filterSelected"]:checked').value, country_filter.value, operator_filter.value);
                    //     loadAgentTotals(document.querySelector('input[name="filterSelected"]:checked').value, country_filter.value, operator_filter.value);
                    // }
                    //
                    // country_filter.onchange = () => {
                    //     fetchData('/sales/reports/internal', document.querySelector('input[name="filterSelected"]:checked').value, country_filter.value, operator_filter.value);
                    //     loadAgentTotals(document.querySelector('input[name="filterSelected"]:checked').value, country_filter.value, operator_filter.value);
                    // }
                });
                break;
            default:
                console.log('error');
        }
    }
}

// agent services graph

// loads the items below chart when initialized
function loadTotals(path,type, country, operator, user_object) {
    fetch(`/${path}/internal/services/operations/totals/${type}`, {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            'X-CSRF-TOKEN': document.getElementsByName('csrf-token')[0].getAttribute('content')
        },
        body: JSON.stringify({
            'country': country,
            'operator': operator,
            'user_id': user_object ? user_object.user_id : null,
            'isUser': user_object ? user_object.isUser : false
        })
    }).then(response => response.json()).then(response => {
        totalsOperations.innerText = `${response.totalsForOperations}`;
        totalsGain.innerText = `${response.totalsForGain.gainSumPerDay}`;
        totalsCost.innerText = `${response.totalsForCost.costSumPerDay}`;
        totalsAmount.innerText = `${response.totalsForAmount}`;
    });
}

function loadAgentTotals(type, country, operator) {
    fetch(`/sales/reports/internal/agent-totals/${type}`, {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            'X-CSRF-TOKEN': document.getElementsByName('csrf-token')[0].getAttribute('content')
        },
        body: JSON.stringify({
            'isUser': false,
            'user_id': null,
            'country': country,
            'operator': operator,
        })
    }).then(response => response.json()).then(response => {
        totalsOperations.innerText = `${response.totalsForOperations}`;
        totalsGain.innerText = `${response.totalsForGain.gainSumPerDay}`;
        totalsCost.innerText = `${response.totalsForCost.costSumPerDay}`;
        totalsAmount.innerText = `${response.totalsForAmount}`;
    });
}

// api reloadly cached values
let reloadlyValues = [];
let labelsForReloadly = [];
fetch('/admin/api/reloadly/graph').then(data => data.json()).then(data => {
    for (const [key, value] of Object.entries(data['graph_data'])) {
        labelsForReloadly.push(key);
        reloadlyValues.push(parseInt(value));
    }

}).then(item => {
    var cardChart1 = new Chart(document.getElementById('card-chart1'), {
        type: 'line',
        data: {
            labels: labelsForReloadly,
            datasets: [{
                label: 'Balance',
                backgroundColor: 'transparent',
                borderColor: 'rgba(255,255,255,.55)',
                pointBackgroundColor: coreui.Utils.getStyle('--primary'),
                data: reloadlyValues
            }]
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        color: 'transparent',
                        zeroLineColor: 'transparent'
                    },
                    ticks: {
                        fontSize: 2,
                        fontColor: 'transparent'
                    }
                }],
                yAxes: [{
                    display: false,
                    ticks: {
                        display: false,
                        // min: 35,
                        // max: 89
                    }
                }]
            },
            elements: {
                line: {
                    borderWidth: 1
                },
                point: {
                    radius: 4,
                    hitRadius: 10,
                    hoverRadius: 4
                }
            }
        }
    });
}).catch(e => {
    console.log(e);
});


// api reloadly cached values
            let dingValues = [];
            let labelsForDing = [];
            fetch('/admin/api/ding/graph').then(data => data.json()).then(data => {
                for (const [key, value] of Object.entries(data['graph_data'])) {
                    labelsForDing.push(key);
                    dingValues.push(parseInt(value));
                }

            }).then(item => {
                var cardChart2 = new Chart(document.getElementById('card-chart2'), {
                    type: 'line',
                    data: {
                        labels: labelsForDing,
                        datasets: [{
                            label: 'Balance',
                            backgroundColor: 'transparent',
                            borderColor: 'rgba(255,255,255,.55)',
                            pointBackgroundColor: coreui.Utils.getStyle('--info'),
                            data: dingValues
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        legend: {
                            display: false
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    color: 'transparent',
                                    zeroLineColor: 'transparent'
                                },
                                ticks: {
                                    fontSize: 2,
                                    fontColor: 'transparent'
                                }
                            }],
                            yAxes: [{
                                display: false,
                                ticks: {
                                    display: false,
                                    // min: -4,
                                    // max: 39
                                }
                            }]
                        },
                        elements: {
                            line: {
                                tension: 0.00001,
                                borderWidth: 1
                            },
                            point: {
                                radius: 4,
                                hitRadius: 10,
                                hoverRadius: 4
                            }
                        }
                    }
                }); // eslint-disable-next-line no-unused-vars
            }).catch(e => {
                console.log(e);
            });

 // eslint-disable-next-line no-unused-vars

            // var cardChart1 = new Chart(document.getElementById('card-chart1'), {
            //     type: 'line',
            //     data: {
            //         labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            //         datasets: [{
            //             label: 'My First dataset',
            //             backgroundColor: 'transparent',
            //             borderColor: 'rgba(255,255,255,.55)',
            //             pointBackgroundColor: coreui.Utils.getStyle('--primary'),
            //             data: [65, 59, 84, 84, 51, 55, 40]
            //         }]
            //     },
            //     options: {
            //         maintainAspectRatio: false,
            //         legend: {
            //             display: false
            //         },
            //         scales: {
            //             xAxes: [{
            //                 gridLines: {
            //                     color: 'transparent',
            //                     zeroLineColor: 'transparent'
            //                 },
            //                 ticks: {
            //                     fontSize: 2,
            //                     fontColor: 'transparent'
            //                 }
            //             }],
            //             yAxes: [{
            //                 display: false,
            //                 ticks: {
            //                     display: false,
            //                     min: 35,
            //                     max: 89
            //                 }
            //             }]
            //         },
            //         elements: {
            //             line: {
            //                 borderWidth: 1
            //             },
            //             point: {
            //                 radius: 4,
            //                 hitRadius: 10,
            //                 hoverRadius: 4
            //             }
            //         }
            //     }
            // }); // eslint-disable-next-line no-unused-vars



/***/ }),

/***/ "./resources/sass/style.scss":
/*!***********************************!*\
  !*** ./resources/sass/style.scss ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!***********************************************************************!*\
  !*** multi ./resources/js/coreui/main.js ./resources/sass/style.scss ***!
  \***********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /var/www/html/resources/js/coreui/main.js */"./resources/js/coreui/main.js");
module.exports = __webpack_require__(/*! /var/www/html/resources/sass/style.scss */"./resources/sass/style.scss");


/***/ })

/******/ });
