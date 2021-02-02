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
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/forum/forum.js":
/*!*************************************!*\
  !*** ./resources/js/forum/forum.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$('#tags').select2({
  placeholder: "Add post tags here...",
  ajax: {
    url: '/autocomplete/data-source/tags',
    dataType: 'json',
    processResults: function processResults(data) {
      return {
        results: data
      };
    }
  }
});
$('.forum-left__list-item').click(function () {
  var href = $(this).attr('data-location-href');
  window.location.href = href;
});

function isInViewPort(elem) {
  var distance = elem.getBoundingClientRect();
  return distance.top >= 0 && distance.left >= 0 && distance.bottom <= (window.innerHeight || document.documentElement.clientHeight) && distance.right <= (window.innerWidth || document.documentElement.clientWidth);
}

;

function adjustScrollBtnVisibility() {
  if (!isInViewPort(addPostBtn[0]) || addPostBtn.is(":hidden")) {
    $('.btn-add-post-scroll').show();
  } else {
    $('.btn-add-post-scroll').hide();
  }

  if ($(document).scrollTop() > 400) {
    $('.btn-go-top').show();
  } else {
    $('.btn-go-top').hide();
  }
}

var addPostBtn = $('.btn-add-post');
adjustScrollBtnVisibility();
$(window).scroll(function () {
  adjustScrollBtnVisibility();
});
$(window).resize(function () {
  adjustScrollBtnVisibility();

  if ($(window).width() <= 1200) {
    $('#tags').select2({
      placeholder: "Add post tags here...",
      ajax: {
        url: '/autocomplete/data-source/tags',
        dataType: 'json',
        processResults: function processResults(data) {
          return {
            results: data
          };
        }
      }
    });
  }
});
$('.forum-content__search__search-by').change(function () {
  var val = $(this).find("option:selected").attr('value');

  if (val == 'tags') {
    $('.forum-content__search .tags-container').removeClass('hidden');
    $('.keyword-search').addClass('hidden');
    $('#tags').select2({
      placeholder: "Add post tags here...",
      ajax: {
        url: '/autocomplete/data-source/tags',
        dataType: 'json',
        processResults: function processResults(data) {
          return {
            results: data
          };
        }
      }
    });
  } else {
    $('.forum-content__search .tags-container').addClass('hidden');
    $('.keyword-search').removeClass('hidden');
  }
});
$('#forum__input-search-keyword').keypress(function (e) {
  if (e.keyCode == 13) {
    $('.forum-content__search').submit();
  }
});
$('#svg-tags, #svg-keyword').click(function () {
  $('.forum-content__search').submit();
});
$('.btn-filter').click(function () {
  $('.filter-container__content').toggleClass('hidden');
});

/***/ }),

/***/ 3:
/*!*******************************************!*\
  !*** multi ./resources/js/forum/forum.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/luoshuaiqing/Desktop/TutorSpace/resources/js/forum/forum.js */"./resources/js/forum/forum.js");


/***/ })

/******/ });