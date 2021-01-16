// ===================== autocomplete ==========================
window.autocomplete = function(inp, arr, clickCallBackFunc) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    var currentFocus;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false;}
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
                b.addEventListener("click", function(e) {
                /*insert the value for the autocomplete text field:*/
                inp.value = this.getElementsByTagName("input")[0].value;
                if(clickCallBackFunc){
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
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if(x) {
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
        if (currentFocus < 0) currentFocus = (x.length - 1);
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
}

$.ajax({
    type:'GET',
    url: '/autocomplete/data-source',
    data: {
        "majors": true,
        "minors": true,
        "courses": true,
        "tags": true,
        "schoolYears": true
    },
    success: (data) => {
        let { majors, minors, schoolYears, courses, tags } = data;
        autocomplete(document.getElementById("first-major"), majors);
        autocomplete(document.getElementById("second-major"), majors);
        autocomplete(document.getElementById("minor"), minors);
        autocomplete(document.getElementById("school-year"), schoolYears);
        autocomplete(document.getElementById("gpa"), gpa);
        autocomplete(document.getElementById("course"), courses, profile_add_course);
        autocomplete(document.getElementById("tag"), tags, profile_add_tag);

        if(hourlyRateInp = document.getElementById("hourly-rate")) autocomplete(hourlyRateInp, hourlyRate);
    }
});

$('.profile__text__edit').on('click', function() {
    $(".profile__input").prop("readonly", false);
    $(".profile__buttons").removeClass("d-none");
});


$('.boxes__course').on('click', '.box .remove', function() {
    var courseId = $(this).siblings('.label').attr('data-course-id');
    $(this).parent().remove();
    ajaxAddRemoveCourse({
        courseId: courseId
    });
});

$('.boxes__forum').on('click', '.box .remove', function() {
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
    }
    // checks if 7 courses have been added already
    else if ($('.boxes__course .box').length == 7) {
        toastr.error("You can add at most 7 courses.");
    }
    else {
        ajaxAddRemoveCourse({
            courseName: new_course_name,
            toAdd: true
        });
    }
    // clear input field
    $('.profile__input__courses').val("");
}

function profile_add_tag() {
    var new_tag_name = $('#tag').val();

    if ($('.boxes__forum .box .label').text().includes(new_tag_name)) {
        // error message
        toastr.error("The tag is already selected ");
    }
    // checks if 10 tags have been added already
    else if ($('.boxes__forum .box').length == 10) {
        toastr.error("You can add at most 10 tags.");
    }
    else {
        ajaxAddRemoveTag({
            tagName: new_tag_name,
            toAdd: true
        });
    }
    // clear input field
    $('.profile__input__forum').val("");
}

$('#btn-reset').click(function() {
    location.reload(true);
});

function appendNewBox(dataType, tagName, tagId, parentSelector) {
    if(dataType == 'data-course-id') {
        // todo: make ajax call to see whether the course is verified
        let isVerified = true;

        var svgVerify = isVerified ? `<svg class="p-absolute verify" width="1em" height="1em" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M256 0C114.836 0 0 114.836 0 256C0 397.164 114.836 512 256 512C397.164 512 512 397.164 512 256C512 114.836 397.164 0 256 0Z" fill="#FFCE00"/>
        <path d="M385.75 201.75L247.082 340.414C242.922 344.574 237.461 346.668 232 346.668C226.539 346.668 221.078 344.574 216.918 340.414L147.586 271.082C139.242 262.742 139.242 249.258 147.586 240.918C155.926 232.574 169.406 232.574 177.75 240.918L232 295.168L355.586 171.586C363.926 163.242 377.406 163.242 385.75 171.586C394.09 179.926 394.09 193.406 385.75 201.75V201.75Z" fill="#FAFAFA"/>
        </svg>` : '';
    }

    let ele = `<span class="box p-relative" style="background-color: #F59300; color: white;">
    ${svgVerify ?? ''}`
        +
        `<span class="label" ` + dataType  + `=` + tagId + `>` + tagName + `</span>
        <svg class="p-absolute remove" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
        </svg>
    </span>
    `;

    $(parentSelector).append(ele);
}


function ajaxAddRemoveCourse(courseInfo) {
    JsLoadingOverlay.show(jsLoadingOverlayOptions);
    $.ajax({
        type:'POST',
        url: '/course-add-remove',
        data: courseInfo,
        success: (data) => {
            // if for adding course
            if(courseInfo.toAdd) {
                let { courseId, courseName } = data;
                appendNewBox('data-course-id', courseName, courseId, '.boxes__course');
                toastr.success('Successfully addedd the course.')
            }
        },
        complete: () => {
            JsLoadingOverlay.hide();
        }
    });
}

function ajaxAddRemoveTag(tagInfo) {
    JsLoadingOverlay.show(jsLoadingOverlayOptions);
    $.ajax({
        type:'POST',
        url: '/tag-add-remove',
        data: tagInfo,
        success: (data) => {
            // if for adding tag
            if(tagInfo.toAdd) {
                let { tagId, tagName } = data;
                appendNewBox('data-tag-id', tagName, tagId, '.boxes__forum');
                toastr.success('Successfully addedd the tag.')
            }
        },
        complete: () => {
            JsLoadingOverlay.hide();
        }
    });
}
