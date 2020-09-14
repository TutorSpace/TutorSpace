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
/******/ 	return __webpack_require__(__webpack_require__.s = 7);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/home/profile.js":
/*!**************************************!*\
  !*** ./resources/js/home/profile.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$('.boxes__course .box').click(function () {
  var _this = this;

  var new_course_id = 1;
  $.ajax({
    type: 'POST',
    url: '/course_add_remove',
    data: {
      new_course_id: new_course_id
    },
    success: function success(data) {
      $(_this).remove();
      var successMsg = data.successMsg;
      toastr.success(successMsg);
    },
    error: function error(_error) {
      toastr.error(_error);
    }
  });
});
$('.boxes__forum .box').click(function () {
  var _this2 = this;

  var new_tag_id = 1;
  $.ajax({
    type: 'POST',
    url: '/tag_add_remove',
    data: {
      new_tag_id: new_tag_id
    },
    success: function success(data) {
      $(_this2).remove();
      var successMsg = data.successMsg;
      toastr.success(successMsg);
    },
    error: function error(_error2) {
      toastr.error(_error2);
    }
  });
});
$('.autocomplete .profile__input__courses').on("keydown", function (e) {
  if (e.which == 13) {
    var new_tag = $('.profile__input__courses').val().toUpperCase(); // checks if a duplicate tag is being added

    if ($('.boxes__course .box .label').text().includes(new_tag)) {} // error message
    // checks if 7 tags have been added already
    else if ($('.boxes__course .box').length == 7) {
        toastr.error("You can add at most 7 courses.");
      } else {
        // create new tag
        $clone = $('.boxes__course .box:first').clone(true);
        $('.label', $clone).text(new_tag);
        $('.boxes__course').append($clone);
      } // clear input field


    $('.profile__input__courses').val("");
  }
});

window.profile_add_course_tag_tutor = function () {
  var new_tag = $('#course').val();

  if ($('.boxes__course .box .label').text().includes(new_tag)) {
    toastr.error("The course is already selected ");
  } // checks if 7 tags have been added already
  else if ($('.boxes__course .box').length == 7) {
      toastr.error("You can add at most 7 courses.");
    } else {
      // create new tag
      //todo: remove this once the fix is made to use ids instead of course name
      var new_course_id = 1;
      $clone = $('.boxes__course .box:first').clone(true);
      $('.label', $clone).text(new_tag);
      $.ajax({
        type: 'POST',
        url: '/course_add_remove',
        data: {
          new_course_id: new_course_id
        },
        success: function success(data) {
          $('.boxes__course').append($clone);
          var successMsg = data.successMsg;
          toastr.success(successMsg);
        },
        error: function error(_error3) {
          toastr.error(_error3);
        }
      });
    } // clear input field


  $('.profile__input__courses').val("");
};

$('.autocomplete .profile__input__forum').on("keydown", function (e) {
  if (e.which == 13) {
    var new_tag = $('.profile__input__forum').val().toUpperCase(); // checks if a duplicate tag is being added

    if ($('.boxes__forum .box .label').text().includes(new_tag)) {} // error message
    // checks if 7 tags have been added already
    else if ($('.boxes__forum .box').length == 10) {
        toastr.error("You can add at most 10 tags."); // error message
      } else {
        // create new tag
        $clone = $('.boxes__forum .box:first').clone(true);
        $('.label', $clone).text(new_tag);
        $('.boxes__forum').append($clone);
      } // clear input field


    $('.profile__input__forum').val("");
  }
});

window.profile_add_forum_tag_tutor = function () {
  var new_tag = $('#tag').val();

  if ($('.boxes__forum .box .label').text().includes(new_tag)) {
    // error message
    toastr.error("The tag is already selected ");
  } // checks if 7 tags have been added already
  else if ($('.boxes__forum .box').length == 10) {
      toastr.error("You can add at most 10 tags.");
    } else {
      // create new tag
      //todo: remove this once the fix is made to use ids instead of tag name
      var new_tag_id = 2;
      $clone = $('.boxes__forum .box:first').clone(true);
      $('.label', $clone).text(new_tag);
      $.ajax({
        type: 'POST',
        url: '/tag_add_remove',
        data: {
          new_tag_id: new_tag_id
        },
        success: function success(data) {
          $('.boxes__course').append($clone);
          var successMsg = data.successMsg;
          toastr.success(successMsg);
        },
        error: function error(_error4) {
          toastr.error(_error4);
        }
      });
    } // clear input field


  $('.profile__input__forum').val("");
};

/***/ }),

/***/ 7:
/*!********************************************!*\
  !*** multi ./resources/js/home/profile.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/anuragunnikrishnan/Desktop/Tutorspace/code/TutorSpace/resources/js/home/profile.js */"./resources/js/home/profile.js");


/***/ })

/******/ });