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

// ===================== autocomplete ==========================
window.autocomplete = function (inp, arr, clickCallBackFunc) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/

  inp.addEventListener("input", function (e) {
    var a,
        b,
        i,
        val = this.value;
    /*close any already open lists of autocompleted values*/

    closeAllLists();

    if (!val) {
      return false;
    }

    currentFocus = -1;
    /*create a DIV element that will contain the items (values):*/

    a = document.createElement("DIV");
    a.setAttribute("id", this.id + "autocomplete-list");
    a.setAttribute("class", "autocomplete-items");
    /*append the DIV element as a child of the autocomplete container:*/

    this.parentNode.appendChild(a);
    /*for each item in the array...*/

    for (i = 0; i < arr.length; i++) {
      /*check if the item starts with the same letters as the text field value:*/
      if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
        /*create a DIV element for each matching element:*/
        b = document.createElement("DIV");
        /*make the matching letters bold:*/

        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
        b.innerHTML += arr[i].substr(val.length);
        /*insert a input field that will hold the current array item's value:*/

        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
        /*execute a function when someone clicks on the item value (DIV element):*/

        b.addEventListener("click", function (e) {
          /*insert the value for the autocomplete text field:*/
          inp.value = this.getElementsByTagName("input")[0].value;

          if (clickCallBackFunc) {
            clickCallBackFunc();
          }
          /*close the list of autocompleted values,
          (or any other open lists of autocompleted values:*/


          closeAllLists();
        });
        a.appendChild(b);
      }
    }
  });
  /*execute a function presses a key on the keyboard:*/

  inp.addEventListener("keydown", function (e) {
    var x = document.getElementById(this.id + "autocomplete-list");
    if (x) x = x.getElementsByTagName("div");

    if (e.keyCode == 40) {
      /*If the arrow DOWN key is pressed,
      increase the currentFocus variable:*/
      currentFocus++;
      /*and and make the current item more visible:*/

      addActive(x);
    } else if (e.keyCode == 38) {
      //up

      /*If the arrow UP key is pressed,
      decrease the currentFocus variable:*/
      currentFocus--;
      /*and and make the current item more visible:*/

      addActive(x);
    } else if (e.keyCode == 13) {
      /*If the ENTER key is pressed, prevent the form from being submitted,*/
      e.preventDefault();

      if (x) {
        /*and simulate a click on the "active" item:*/
        x[currentFocus].click();
      }
    }
  });

  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/

    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = x.length - 1;
    /*add class "autocomplete-active":*/

    x[currentFocus].classList.add("autocomplete-active");
  }

  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }

  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");

    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/


  document.addEventListener("click", function (e) {
    closeAllLists(e.target);
  });
};

autocomplete(document.getElementById("first-major"), majors);
autocomplete(document.getElementById("second-major"), majors);
autocomplete(document.getElementById("minor"), minors);
autocomplete(document.getElementById("school-year"), schoolYears);
autocomplete(document.getElementById("gpa"), gpa);
autocomplete(document.getElementById("hourly-rate"), hourlyRate);
autocomplete(document.getElementById("course"), courses, profile_add_course);
autocomplete(document.getElementById("tag"), tags, profile_add_tag);
$('.home__panel__button__label').on('click', function () {
  bootbox.dialog({
    message: "\n            <div class=\"container\">\n                <svg class=\"d-block mx-auto my-3\" width=\"40\" height=\"40\" viewBox=\"0 0 40 40\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n                    <path d=\"M28.6788 14.6551C28.0288 14.0043 26.9721 14.0043 26.3221 14.6551L19.1671 21.8093L16.1788 18.8218C15.5288 18.171 14.4721 18.171 13.8221 18.8218C13.1713 19.4726 13.1713 20.5276 13.8221 21.1785L17.9888 25.3451C18.3138 25.671 18.7404 25.8335 19.1671 25.8335C19.5938 25.8335 20.0204 25.671 20.3454 25.3451L28.6788 17.0118C29.3296 16.361 29.3296 15.306 28.6788 14.6551Z\" fill=\"#6749DF\"/>\n                    <path d=\"M38.3333 18.3333C37.4133 18.3333 36.6667 19.08 36.6667 20C36.6667 29.19 29.19 36.6667 20 36.6667C10.81 36.6667 3.33333 29.19 3.33333 20C3.33333 10.81 10.81 3.33333 20 3.33333C24.4742 3.33333 28.6742 5.08167 31.8275 8.25667C32.475 8.91083 33.5308 8.91417 34.1842 8.265C34.8375 7.61667 34.8408 6.56167 34.1925 5.90833C30.4092 2.09833 25.3683 0 20 0C8.97167 0 0 8.97167 0 20C0 31.0283 8.97167 40 20 40C31.0283 40 40 31.0283 40 20C40 19.08 39.2533 18.3333 38.3333 18.3333Z\" fill=\"#6749DF\"/>\n                </svg>\n                <h4 class=\"w-100 text-center mb-5\">Become a Verified Tutor</h4>\n                <p class=\"text-dark mt-5\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Varius tellus ac fringilla enim ac etiam amet. Facilisi amet sit egestas id sit. Ac eget dui non ipsum gravida malesuada imperdiet feugiat in. Vulputate libero non elit luctus ipsum netus eget.</p>\n                \n                <h5 class=\"w-100 mt-5\">Submit Your Verification Request</h5>\n                <div class=\"profile__form-row flex-wrap\">\n                    <div class=\"autocomplete mb-3\">\n                        <label for=\"course-verification\" class=\"profile__label text-dark\">Courses you would like to tutor in *</label>\n                        <input type=\"text\" class=\"profile__input profile__input__courses form-control form-control-lg\" id=\"course-verification\">\n                    </div>\n                </div>\n                \n                <p class=\"text-dark\">Report Submission</p>\n                <div class=\"m-5 p-5\">\n                </div>\n                <p class=\"text-dark\">Questions? Email us at <span class=\"fc-theme-color\">tutorspaceusc@gmail.com</span></p>\n            </div>\n        ",
    size: 'medium',
    onEscape: true,
    backdrop: true,
    centerVertical: true,
    buttons: {
      Decline: {
        label: 'Decline',
        className: 'btn btn-outline-primary mr-2 p-3 px-5',
        callback: function callback() {}
      },
      Submit: {
        label: 'Submit',
        className: 'btn btn-primary p-3 px-5',
        callback: function callback() {}
      }
    }
  });
  autocomplete(document.getElementById("course-verification"), courses, profile_add_course_verification);
});
$('.profile__text__edit').on('click', function () {
  $(".profile__input").prop("readonly", false);
<<<<<<< HEAD
  $(".profile__buttons").removeClass("d-none");
=======
>>>>>>> a05bdf88221e6fa266e945e259888f119d0a1a45
});
$('.boxes__course').on('click', '.box .remove', function () {
  var courseId = $(this).siblings('.label').attr('data-course-id');
  $(this).parent().remove();
  ajaxAddRemoveCourse({
    courseId: courseId
  });
});
$('.boxes__forum').on('click', '.box .remove', function () {
  var tagId = $(this).siblings('.label').attr('data-tag-id');
  $(this).parent().remove();
  ajaxAddRemoveTag({
    tagId: tagId
  });
});

function profile_add_course() {
  var new_course_name = $('#course').val();

  if ($('.boxes__course .box .label').text().includes(new_course_name)) {
    toastr.error("The course is already selected ");
  } // checks if 7 courses have been added already
  else if ($('.boxes__course .box').length == 7) {
      toastr.error("You can add at most 7 courses.");
    } else {
      ajaxAddRemoveCourse({
        courseName: new_course_name,
        toAdd: true
      });
<<<<<<< HEAD
    } // clear input field


  $('.profile__input__courses').val("");
}

function profile_add_course_verification() {
  var new_course_name = $('#course-verification').val();

  if ($('.boxes__course .box .label').text().includes(new_course_name)) {
    toastr.error("The course is already selected ");
  } // checks if 7 courses have been added already
  else if ($('.boxes__course .box').length == 7) {
      toastr.error("You can add at most 7 courses.");
    } else {
      ajaxAddRemoveCourse({
        courseName: new_course_name,
        toAdd: true
      });
=======
>>>>>>> a05bdf88221e6fa266e945e259888f119d0a1a45
    } // clear input field


  $('.profile__input__courses').val("");
}

function profile_add_tag() {
  var new_tag_name = $('#tag').val();

  if ($('.boxes__forum .box .label').text().includes(new_tag_name)) {
    // error message
    toastr.error("The tag is already selected ");
  } // checks if 10 tags have been added already
  else if ($('.boxes__forum .box').length == 10) {
      toastr.error("You can add at most 10 tags.");
    } else {
      ajaxAddRemoveTag({
        tagName: new_tag_name,
        toAdd: true
      });
    } // clear input field


  $('.profile__input__forum').val("");
}

$('#btn-reset').click(function () {
  location.reload(true);
}); // appendNewBox('data-course-id', courseName, courseId, '.boxes__course');

function appendNewBox(dataType, tagName, tagId, parentSelector) {
  if (dataType == 'data-course-id') {
    // todo: make ajax call to see whether the course is verified
    var isVerified = true;
    var svgVerify = isVerified ? "<svg class=\"p-absolute verify\" width=\"1em\" height=\"1em\" viewBox=\"0 0 512 512\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n        <path d=\"M256 0C114.836 0 0 114.836 0 256C0 397.164 114.836 512 256 512C397.164 512 512 397.164 512 256C512 114.836 397.164 0 256 0Z\" fill=\"#FFCE00\"/>\n        <path d=\"M385.75 201.75L247.082 340.414C242.922 344.574 237.461 346.668 232 346.668C226.539 346.668 221.078 344.574 216.918 340.414L147.586 271.082C139.242 262.742 139.242 249.258 147.586 240.918C155.926 232.574 169.406 232.574 177.75 240.918L232 295.168L355.586 171.586C363.926 163.242 377.406 163.242 385.75 171.586C394.09 179.926 394.09 193.406 385.75 201.75V201.75Z\" fill=\"#FAFAFA\"/>\n        </svg>" : '';
  }

  var ele = "<span class=\"box p-relative\" style=\"background-color: rgb(83, 150, 172); color: rgb(0, 0, 0);\">\n    ".concat(svgVerify !== null && svgVerify !== void 0 ? svgVerify : '') + "<span class=\"label\" " + dataType + "=" + tagId + ">" + tagName + "</span>\n        <svg class=\"p-absolute remove\" width=\"1em\" height=\"1em\" viewBox=\"0 0 16 16\" fill=\"currentColor\" xmlns=\"http://www.w3.org/2000/svg\">\n            <path fill-rule=\"evenodd\" d=\"M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z\"/>\n        </svg>\n    </span>\n    ";
  console.log(ele);
  $(parentSelector).append(ele);
}

function ajaxAddRemoveCourse(courseInfo) {
  $.ajax({
    type: 'POST',
    url: '/course-add-remove',
    data: courseInfo,
    success: function success(data) {
      // if for adding course
      if (courseInfo.toAdd) {
        var courseId = data.courseId,
            courseName = data.courseName;
        appendNewBox('data-course-id', courseName, courseId, '.boxes__course');
        toastr.success('Successfully addedd the course.');
      }
    }
  });
}

function ajaxAddRemoveTag(tagInfo) {
  $.ajax({
    type: 'POST',
    url: '/tag-add-remove',
    data: tagInfo,
    success: function success(data) {
      // if for adding tag
      if (tagInfo.toAdd) {
        var tagId = data.tagId,
            tagName = data.tagName;
        appendNewBox('data-tag-id', tagName, tagId, '.boxes__forum');
        toastr.success('Successfully addedd the tag.');
      }
    }
  });
}

/***/ }),

/***/ 7:
/*!********************************************!*\
  !*** multi ./resources/js/home/profile.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/luoshuaiqing/Desktop/TutorSpace/resources/js/home/profile.js */"./resources/js/home/profile.js");


/***/ })

/******/ });