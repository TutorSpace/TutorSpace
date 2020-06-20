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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/admin/register.js":
/*!****************************************!*\
  !*** ./resources/js/admin/register.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

//  ========================= for all register page ===========================
$('input').on('input', function () {
  if ($(this).val()) {
    $(this).next().addClass('fill-color-blue-secondary');
  } else {
    $(this).next().removeClass('fill-color-blue-secondary');
  }
});
$('input').filter('[required]').on('input', function () {
  var allFilled = true;
  $.each($('input').filter('[required]'), function (idx, el) {
    if (!$(el).val()) allFilled = false;
  });

  if (allFilled) {
    $('.btn-next').addClass('btn-next-animation');
    if (isStudent) $('.btn-next').addClass('btn-student');else $('.btn-next').addClass('btn-tutor');
    $('.btn-next').removeClass('bg-grey');
  } else {
    $('.btn-next').removeClass('btn-next-animation');
    if (isStudent) $('.btn-next').removeClass('btn-student');else $('.btn-next').removeClass('btn-tutor');
    $('.btn-next').addClass('bg-grey');
  }
}); //  ========================= register student 1 ===========================

(function () {
  $('#btn-google-signup').click(function (e) {
    e.preventDefault();
  }); // ===================== Google Admin ==========================

  var googleBtnWidth = 240,
      googleBtnHeight = 50;
  adjustGoogleBtnSize();
  renderButton();
  $(window).resize(function () {
    adjustGoogleBtnSize();
    renderButton();
  });

  function renderButton() {
    gapi.signin2.render('btn-google-signup', {
      'scope': 'profile email',
      'width': googleBtnWidth,
      'height': googleBtnHeight,
      'longtitle': true,
      'theme': 'dark',
      'onsuccess': onSuccess,
      'onfailure': onFailure
    });
  }

  function adjustGoogleBtnSize() {
    if ($(window).width() < 400) {
      googleBtnWidth = 165;
      googleBtnHeight = 36;
    } else if ($(window).width() < 576) {
      googleBtnWidth = 200;
      googleBtnHeight = 40;
    } else {
      googleBtnWidth = 240;
      googleBtnHeight = 50;
    }
  }

  function onSuccess(googleUser) {
    console.log('Logged in as: ' + googleUser.getBasicProfile().getName()); // Useful data for your client-side scripts:

    var profile = googleUser.getBasicProfile();
    console.log("======================== User Profile =======================");
    console.log(profile);
    console.log("==============================================="); // Do not use the Google IDs returned by getId() or the user's profile information to communicate the currently signed in user to your backend server. Instead, send ID tokens, which can be securely validated on the server.

    console.log("ID: " + profile.getId());
    console.log('Full Name: ' + profile.getName());
    console.log('Given Name: ' + profile.getGivenName());
    console.log('Family Name: ' + profile.getFamilyName());
    console.log("Image URL: " + profile.getImageUrl());
    console.log("Email: " + profile.getEmail()); // The ID token you need to pass to your backend:

    var id_token = googleUser.getAuthResponse().id_token;
    console.log("ID Token: " + id_token);
  }

  function onFailure(error) {
    console.log(error);
  }

  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance(); // if not signed in

    if (!auth2.isSignedIn.get()) {
      var profile = auth2.currentUser.get().getBasicProfile();
      alert("You are not signed in!");
    } else {
      var auth2 = gapi.auth2.getAuthInstance();
      auth2.signOut().then(function () {
        console.log('User signed out.');
      });
    }
  }
})(); //  ========================= register student 2 ===========================


(function () {
  var totalSeconds = 30;
  var currentTimeInterval; // adjusting email input size
  // $(window).resize(function() {
  //     adjustInputEmailSize();
  // });
  // let adjustInputEmailSize = () => {
  //     $.each($('.form-group-4 input'), (idx, el) => {
  //         // alert($(el).height());
  //         $(el).height($(el).width() + 'px');
  //     });
  // };

  $('#resend-code').click(function () {
    // TODO: using ajax to send the email
    if (!currentTimeInterval) {
      $('#timeLabel').html(pad(totalSeconds));
      currentTimeInterval = setInterval(setTime, 1000);
      $(this).prop('disabled', true);
    }
  });

  function setTime() {
    --totalSeconds;
    if (totalSeconds > 0) $('#timeLabel').html(pad(totalSeconds));else {
      totalSeconds = 30;
      $('#timeLabel').html('');
      clearInterval(currentTimeInterval);
      currentTimeInterval = null;
      $('#resend-code').prop('disabled', false);
    }
  }

  function pad(val) {
    var pre = " in ";
    var suffix = ' s';
    var valString = val + "";

    if (valString.length < 2) {
      return pre + "0" + valString + suffix;
    } else {
      return pre + valString + suffix;
    }
  }
})(); // ======================== register student 3 ====================


(function () {})(); // // The tags should be always be the same as in the school_year table! Need to manully update the fields/array!
// $(function () {
//     $("#major").autocomplete({
//         source: majorTags
//     });
//     $("#schoolYear").autocomplete({
//         source: schoolYearTags
//     });
// });
// $("input[type=file]").change(function() {
//     var fileInput = $(this)[0];
//     var filename = fileInput.files[0].name;
//     $('#file-input-text').html(filename);
// });

/***/ }),

/***/ 2:
/*!**********************************************!*\
  !*** multi ./resources/js/admin/register.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/luoshuaiqing/Desktop/TutorSpace/resources/js/admin/register.js */"./resources/js/admin/register.js");


/***/ })

/******/ });