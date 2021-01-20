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

/***/ "./resources/js/home/index.js":
/*!************************************!*\
  !*** ./resources/js/home/index.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// upload photo
$('#upload-profile-pic').click(function () {
  $('#input-profile-pic').click();
});
$("#input-profile-pic").change(function () {
  var fileInput = $(this)[0];
  var file = fileInput.files[0];
  var formData = new FormData();
  formData.append('profile-pic', file);
  JsLoadingOverlay.show(jsLoadingOverlayOptions);
  $.ajax({
    type: 'POST',
    url: $('#profile-pic-form').attr('action'),
    data: formData,
    contentType: false,
    processData: false,
    success: function success(data) {
      toastr.success('Successfully uploaded the image!');
      $('#profile-image').attr('src', storageUrl + data.imgUrl);
      $('.nav-right__profile-img').attr('src', storageUrl + data.imgUrl);
    },
    error: function error(_error) {
      toastr.error('The file you uploaded is either too large (should be smaller than 2MB) or not supported by our platform. Please try uploading another image again.');
      console.log(_error);
    },
    complete: function complete() {
      JsLoadingOverlay.hide();
    }
  });
}); // calendar

window.showAvailableTimeForm = function (startTime, endTime) {
  $('#availableTimeConfirmationModal input[name="start-time"]').val(moment(startTime).format("YYYY-MM-DD HH:mm:00"));
  $('#availableTimeConfirmationModal input[name="end-time"]').val(moment(endTime).format("YYYY-MM-DD HH:mm:00"));
  startTime = moment(startTime).format("HH:mm on MM/DD/YYYY dddd");
  endTime = moment(endTime).format("HH:mm on MM/DD/YYYY dddd");
  $('#availableTimeConfirmationModal .start-time').html(startTime);
  $('#availableTimeConfirmationModal .end-time').html(endTime);
  $('#availableTimeConfirmationModal').modal('show');
};

window.showAvailableTimeDeleteForm = function (startTime, endTime, availableTimeId) {
  $('#availableTimeDeleteConfirmationModal input[name="available-time-id"]').val(availableTimeId);
  startTime = moment(startTime).format("HH:mm on MM/DD/YYYY dddd");
  endTime = moment(endTime).format("HH:mm on MM/DD/YYYY dddd");
  $('#availableTimeDeleteConfirmationModal .start-time').html(startTime);
  $('#availableTimeDeleteConfirmationModal .end-time').html(endTime);
  $('#availableTimeDeleteConfirmationModal').modal('show');
};

$('.action-toggle').click(function () {
  $(this).next('.action-toggle__content').toggle();
}); // tutor request popup

$('.btn-view-request').click(function () {
  $('.home__tutor-request-modal .tutor-request-modal__content__profile .user-info .content').text($(this).closest('.info-box').find('.user-info .content').text());
  $('.home__tutor-request-modal .tutor-request-modal__content__profile .date .content').text($(this).closest('.info-box').find('.date .content').text());
  $('.home__tutor-request-modal .tutor-request-modal__content__profile .time .content').text($(this).closest('.info-box').find('.time .content').text());
  $('.home__tutor-request-modal .tutor-request-modal__content__profile .course .content').text($(this).closest('.info-box').find('.course .content').text());
  $('.home__tutor-request-modal .tutor-request-modal__content__profile .session-type .content').text($(this).closest('.info-box').find('.session-type .content').text());
  $('.home__tutor-request-modal .tutor-request-modal__content__profile .price .content').text($(this).closest('.info-box').find('.price .content').text());
  $('#btn-confirm-tutor-session').attr('data-tutorRequest-id', $(this).closest('.info-box').attr("data-tutorRequest-id"));
  $('#btn-decline-tutor-session').attr('data-tutorRequest-id', $(this).closest('.info-box').attr("data-tutorRequest-id"));
  $('.home__tutor-request-modal').toggle();
  var options = JSON.parse(JSON.stringify(calendarPopUpOptions));
  options.slotMinTime = $(this).closest('.info-box').attr('data-min-time');
  options.slotMaxTime = $(this).closest('.info-box').attr('data-max-time');
  var sessionTimeStart = $(this).closest('.info-box').attr('data-session-time-start');
  var sessionTimeEnd = $(this).closest('.info-box').attr('data-session-time-end');
  options.events.push({
    title: 'Current Tutor Request',
    classNames: ['tutor-request'],
    start: sessionTimeStart,
    end: sessionTimeEnd,
    description: "",
    type: "tutor-request"
  });
  options.height = 250;
  options.displayEventTime = false; // for the calendar in tutor request

  var calendarElPopUp = $('.tutor-request-modal__content__calendar .calendar')[0];
  calendarPopUp = new FullCalendar.Calendar(calendarElPopUp, options);
  calendarPopUp.render();
  calendarPopUp.gotoDate($(this).closest('.info-box').attr('data-date'));
});
$('.tutor-request-modal__close').click(function () {
  $('.home__tutor-request-modal').toggle();
});
$('.btn-view-all-notifications').click(function () {
  $(this).closest('.home__side-bar__notifications').find('.notifications--sidebar [data-to-hide="true"]').toggleClass("hidden");

  if ($(this).html().includes('View')) {
    $(this).html('Hide');
  } else {
    $(this).html('View All');
  }
});
$('.btn-view-all-bookmarked-users').click(function () {
  $('.home__side-bar__bookmarked-users').find('.bookmarked-users [data-to-hide="true"]').toggleClass("hidden");

  if ($(this).html().includes('View')) {
    $(this).html('Hide');
  } else {
    $(this).html('View All');
  }
});
$('#btn-confirm-tutor-session').click(function () {
  var tutorRequestId = $(this).attr("data-tutorRequest-id");
  JsLoadingOverlay.show(jsLoadingOverlayOptions);
  $.ajax({
    type: 'POST',
    url: "/tutor-request/accept/".concat(tutorRequestId),
    success: function success(data) {
      var successMsg = data.successMsg,
          errorMsg = data.errorMsg;

      if (successMsg) {
        toastr.success(successMsg);
        setTimeout(function () {
          window.location.reload();
        }, 1000);
      } else if (errorMsg) toastr.error(errorMsg);
    },
    error: function error(_error2) {
      console.log(_error2);
      toastr.error("Something went wrong when accepting the tutor request.");
    },
    complete: function complete() {
      JsLoadingOverlay.hide();
    }
  });
});
$('#btn-decline-tutor-session').click(function () {
  var tutorRequestId = $(this).attr("data-tutorRequest-id");
  JsLoadingOverlay.show(jsLoadingOverlayOptions);
  $.ajax({
    type: 'DELETE',
    url: "/tutor-request/".concat(tutorRequestId),
    success: function success(data) {
      var successMsg = data.successMsg,
          errorMsg = data.errorMsg;

      if (successMsg) {
        toastr.success(successMsg);
        setTimeout(function () {
          window.location.reload();
        }, 1000);
      } else if (errorMsg) toastr.error(errorMsg);
    },
    error: function error(_error3) {
      console.log(_error3);
      toastr.error("Something went wrong when declining the tutor request.");
    },
    complete: function complete() {
      JsLoadingOverlay.hide();
    }
  });
});
$('#btn-register-to-be-tutor').click(function () {
  $('.nav__item__svg--switch-account').click();
});
$('.side-bar__notification > *').click(function () {
  window.location.href = $(this).closest('.side-bar__notification').attr('data-route');
});

/***/ }),

/***/ 6:
/*!******************************************!*\
  !*** multi ./resources/js/home/index.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/luoshuaiqing/Desktop/TutorSpace/resources/js/home/index.js */"./resources/js/home/index.js");


/***/ })

/******/ });