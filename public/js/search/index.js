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
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/search/index.js":
/*!**************************************!*\
  !*** ./resources/js/search/index.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var picker = new Pikaday({
  field: $('#start-date')[0],
  minDate: moment().toDate(),
  onSelect: function onSelect() {
    if ($('#end-date').val()) {
      $('.filter__checkboxes--available-time').show(300);
    }
  }
});
var picker = new Pikaday({
  field: $('#end-date')[0],
  minDate: moment().toDate(),
  onSelect: function onSelect() {
    if ($('#start-date').val()) {
      $('.filter__checkboxes--available-time').show(300);
    }
  }
});
$('#start-time').timepicker({
  'scrollDefault': 'now',
  'setp': 15,
  'minTime': '6:00am',
  'maxTime': '12:00am'
});
$('#end-time').timepicker({
  'scrollDefault': 'now',
  'setp': 15,
  'minTime': '6:00am',
  'maxTime': '12:00am'
});
$('#checkbox-specify-detail-time').change(function () {
  if ($(this).is(':checked')) {
    $('#select-detail-time').removeClass('hidden');
    $('.checkbox-range').prop('checked', false);
    $('#checkbox-any-time').prop('checked', false);
  } else {
    $('#select-detail-time').addClass('hidden');
  }
});
$('#checkbox-any-time').change(function () {
  if ($(this).is(':checked')) {
    $('#select-detail-time').addClass('hidden');
    $('#checkbox-specify-detail-time').prop('checked', false);
    $('.checkbox-range').prop('checked', false);
  }
});
$('.checkbox-range').change(function () {
  if ($(this).is(':checked')) {
    $('#select-detail-time').addClass('hidden');
    $('#checkbox-any-time').prop('checked', false);
    $('#checkbox-specify-detail-time').prop('checked', false);
  }
});
$("#price-range-input").slider({
  min: 10,
  max: 50,
  value: [15, 35],
  tooltip: "hide",
  labelledby: ['price-low', 'price-high']
}).on('slide', function (slideEvt) {
  $('#price-low').val(slideEvt.value[0]);
  $('#price-high').val(slideEvt.value[1]);
});
$('#price-low, #price-high').on('input', function () {
  $("#price-range-input").slider('setValue', [parseInt($('#price-low').val()), parseInt($('#price-high').val())]);
});
$('#price-low, #price-high').change(function () {
  if ($(this).val() < 10) {
    $(this).val(10);
  }

  if ($(this).val() > 50) {
    $(this).val(50);
  }

  if ($('#price-low').val() && $('#price-high').val() && $('#price-low').val() > $('#price-high').val()) {
    var temp = $('#price-low').val();
    $('#price-low').val($('#price-high').val());
    $('#price-high').val(temp);
  }
});
$(window).resize(function () {
  if ($(window).width() >= 992 && $('.flex__content').is(":hidden")) {
    $('.flex__content').show();
    $('.filter .btn-hide').html('hide');
  }
});
$('.filter .btn-hide').click(function () {
  if ($(this).html() == 'show') {
    $('.flex__content').toggle(300);
    $(this).html('hide');
  } else {
    $('.flex__content').toggle(300);
    $(this).html('show');
  }
});
$('form.filter').submit(function () {
  $('#search-content').val($('#nav-search-content').val());
});
$('.nav__form').submit(function (e) {
  e.preventDefault();
  $('#search-content').val($('#nav-search-content').val());
  $('form.filter').submit();
});
$('.btn-clear').click(function () {
  if ($('#checkbox-specify-detail-time').prop('checked')) {
    $('#select-detail-time').addClass('hidden');
  }

  $('input[tpye=text], input[type=number]').val('');
  $('input:checkbox').prop('checked', false);
  $("#price-range-input").slider('setValue', [parseInt(15), parseInt(35)]);
  $('input[name=available-start-date]').val('');
  $('input[name=available-end-date]').val('');
  $('input[name=available-start-time]').val('');
  $('input[name=available-end-time]').val('');
});

if ($('#checkbox-specify-detail-time').prop('checked')) {
  $('#select-detail-time').addClass('hidden');
}

/***/ }),

/***/ 6:
/*!********************************************!*\
  !*** multi ./resources/js/search/index.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/luoshuaiqing/Desktop/TutorSpace/resources/js/search/index.js */"./resources/js/search/index.js");


/***/ })

/******/ });