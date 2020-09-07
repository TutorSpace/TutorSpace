<div>
    <div class="info-box tutor-request">
        @if(isset($isNotification) && $isNotification)
        <svg class="notification-indicator" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="7.5" cy="7.5" r="7.5" fill="#FFBC00"/>
        </svg>
        @endif
        <div class="user-info">
            <img src="{{ Storage::url($user->profile_pic_url) }}" alt="profile-img">
            <a class="content" href="#">
                Shuaiqing Luo
            </a>
        </div>
        <div class="date">
            <span class="title">Date</span>
            <span class="content">08/02<span class="info-box__year">/2020</span> Wednesday</span>
        </div>
        <div class="time">
            <span class="title">Time</span>
            <span class="content">13:30PM - 15:00PM</span>
        </div>
        <div class="course">
            <span class="title">Course</span>
            <span class="content">BUAD 304</span>
        </div>
        <div class="session-type">
            <span class="title">Type</span>
            <span class="content">In Person</span>
        </div>
        @if ($forTutor)
        <div class="action">
            <button class="btn btn-lg btn-animation-y-sm btn-view-request">View</button>
        </div>
        @else
        <div class="status">
            <span class="title">Status</span>
            @if (isset($approved) && $approved)
            <span class="content approved">Approved</span>
            @elseif(isset($approved) && !$approved)
            <span class="content declined">Declined</span>
            @elseif(isset($pending) && $pending)
            <span class="content pending">Pending</span>
            @endif
        </div>
        <div class="action @unless(isset($pending) && $pending) invisible @endunless">
            <button class="btn btn-lg btn-animation-y-sm btn-cancel">Cancel</button>
        </div>
        @endif


    </div>

    <div class="tutor-request__modal">
        <!-- Modal content -->
        <div class="tutor-request__modal__content__close">
            <div class="tutor-request__modal__close">
                <svg width="22" height="24" viewBox="0 0 22 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <rect width="22" height="24" fill="url(#pattern0)"/>
                <defs>
                <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                <use xlink:href="#image0" transform="translate(-0.0454545) scale(0.00213068 0.00195312)"/>
                </pattern>
                <image id="image0" width="512" height="512" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAAIACAMAAADDpiTIAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAADAFBMVEUAAABtSdtqR9xmSt9mR+BnSd5oSN9oSd5nSeBoSuBmSd9oSuBnSd9nSd9nSd9nSd9nSd9nSd9nSd9oSd9nSd5nSeBnSd9nSt9oSt5oSt1lS+BqS+BiTthgUN9mSt1nSt9mSd5mSOBnSd9mSeBnSd9nSeBmSd9nSd5nSd9oSd5pSN5gQN9mM8xpSN5nSt9mSN5oSOBnSt9oSd9nSd9nSd9nSN9nSd9oSOBlR+FmR+BlSeBnSt9nSd9nSd5nSd9nSt9nSuBmSd5rSt5nSd9oSt9nSd9nSd9nSN9kTt5VVf9nSd9nSt9nSd9nSeBnSd9mSN1xVeNnSOFoSd9mSN9pR95VVdVpS+FnSd9nSd9nSd5nSd9lR91iReJmSt5nSd9nSeBnSd9mSN9hSdtnSd8AAP9oSN9mSt9nSd9oSeCAgP9mS+BnSd9nSd9oSd9lSN1mSd9nSt5lSd9oSeBnSeBlSt1mSN5jR+NmRN1nSd9nR95nSeBoSN9qQNVoSt9oSd5oSt9nSeFoSd9nSd9nSd9lSt9nSd9mR+BnSt9nSN9qRtxmRt9oRtxnSd9nSt6AQL9nSt9mTeZnSd5kRuBnSd5mSeBpSN5mSd9nSt1nSeBnSOBtSdtoR95nSd9nSN5mTd1nSd9kSdtnSd9mSuBmSeBnSd9dRuhnSd9oS9xnSN9nSN5oTONnSd9nSt5nSt9mSd9nSt9nSeBoSN9mSd9pS+FnSOBmSuBmSeBnSd9qSt9nSd9mSeJnSd9nSd9pSd9nSd9nSt5nSd9nSOBoSeBnSd9rQ+RnSd9nSuBoSd5oSN9nSd9mSd9oSeFnSd9nSd5nSN9mSd9nSt9nSd9nSd9oSeBnSeBmTdlnSt9nTN1mSN9oSt5nSd9nSd9pS+FnSd5nSuBoSN9nSN5nSt9nSd9nSOBmSd5mSN9mSd5nSd9nSN5nSd9nSOBoSd9oSN9nSd9nSd9nSt5oSd9oSd9nSd9nSOBnSN9oSeBnSd9oSN9nSeBoSeBmSd9oSuBmSt9mSd9nSd8AAAB93LP9AAAA/nRSTlMADiQ3S15xhZqqsbvIzt3k7vXMtqSSgW9dTDopDRAtaISiv9v489a8oWxOCAUnT3Wbwur+4r6ZUSsZSXnZ+/nQo0YfV4e46IYXA2be5rN3PAlDwH89BiLy9sSIRBpkqOvwXxX9AUCOl0ICQezpljXllT+C4yZVEg/0L8NYDICMkSqg+q4w/DKtqR0oFpCcBNcKTSFtei7RNIuDBzbUjR69HO1ak54L2CxZlBvHPkidpsvF4DNSa3OyGM8j4e848UX3SjHcE9WKZWffpzvnVLdpyc1+e9MUnyVuVsbSEXRyIFxhjzmseH25fNpjdmCvurTKpcFqsGK1R6tbiVOYcJ4gPjgAAAABYktHRACIBR1IAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAB3RJTUUH5AYTEzoMvpJxngAAGwFJREFUeNrt3XlcVlX+B/DrHkOhUEmuucC0iGZghKWMmplgIpWouSQpOWGKC5pWkkqDaSaSZiaWWy6lqaUtjhpqaWZaZllNZTnVr71f6/ymZprf8xoRyQd4lvu955z7Offe7/vvwvNdnvs8996zGAZjjDHGGGOMMcYYY4wxxhhjjDHGGGOMMcYYY4wxxhhjjDHGGGOMMcaYPmrVrlO3Xv0GZ0T8IfLMs6IaNmoU7avQqFFUVExM5NnnnNs49rwmTZs1R4+UydSiZZPzW7Vu0zbOZ1r8Hy+4sMFFF7dshx47E5HQvsMlHS9NNF/3GpI6XZZ8yeUpCehIGFXnK66M6NJVoPRVpP6p2yXdO6NjYub0uKrn1b1kld5fYuQ1HXqjo2OhpKWkt+6jovanXds3o18mOk4WQLvrWrWJFi+wGXHX39A/Cx0v8zcgPWKgPcWvNOjGwUO4CbQwdNhNw+0tfqXsiJtHoKP3ugGxNyZhql9hZMzgfjnoJHhV2i2jopDFr9Twz7emoXPhPbmjO96GrvxpY8aO5h6wU96oceiaV9dr/IRcdFo8otnEtuhqB5bfYBI6N+7XbnIkus6hxMTejs6Qq+Ul23y7Txfd7Tq+LVBjSvpZ6Oqa0zaDLwPypSQPQhfWvKnJd6Dz5S65TSKhz3ssuPMuflIsy7T0P6LLaUWvghbozLnC0Luz0aW0KrsnzyIR1WO6g776a0ptPQOdQUdrP7MQXUJRI+/5CzqLjtWydRG6fDIk9Z2FzqQjNbvXaT/8gxo5ewY6m44zJ1nanF4djIy4D51RR5l7P2EVhzMUzRuKzqpjTMtw7I1fKNGDa6Ez6wi59ZTM6tfB8NhidHb1V+dMdJlUmj8ZnV/N9ZiNLpFqZ9dG51hjJRnx6PqoVzh9GjrPuurQCV0ce/R5AJ1pLXVujS6MffouQGdbO2kLtZ/sJdOgB/l+oIpFrv7tH8hDi9E510jmw6567mtO4ZJSdN51sXQ+uhgYj9RBZ14LCRM9+PGvUPRoJjr7eCkx6DIgzff6VIHcWNe99qMpLPD0isJld6ILgLd8BboKOB1WorOvg+xV6DqAlD7mmjlfglavQdcCYZJDVvrZYe06dDXsV88DL/7Mi38cXQ+blc5Dp1w3T3hqKeH6Deh86yfGQ28In3TtrD8Rt21E18Uu6anoXOspqQBdGVuUbkInWl+bM9HVUa/zU+gs6+xp1+9H33ILOsd6a7gVXSG1urtyzY9MU59B10ilZ12x3lutpOfQVVImbTA6uc4w3aVviEueR2fWKW5y5WzBFvzu37Q2U9DVkm/bX9FZdZJH5qDrJdv2KHROnWVHM3TF5EppiM6o0yS6anOxpRqd7uEUO19AV02e62w60M9dyvqh6ybLLkdv9okTvQtdOTm6c/0tiuuArp0MG3ej8+hcqS7oAK6/iNQ96PqJquvxpV+iop9EV1DMrfz5F1SWh66hiKWe2vdFjZ0voqto3Tp+/iNBomOfCg/Q7nxXZ8p36IqBoVHozLnFS47caHzvI+i8uce+vehq0rXj+R8S3em4OUI556Bz5i6znXYg8cvojLnNRHRFafaj8+U+r6BrSnGFZ7f+U6dwCLqq5s3i3T8UKGuJrqtZ2/LRuXKnAw5ZOZpwKTpTbvWUM3YTOwOdJ/d6FV1bM55FZ8nNFqKrG97BVHSS3KywP7q+4Swbg86Rux3S/L1QKW8Ao1gbvQ8begydH/d7GV3jUF5DZ8cDkjQ+fXY77wBkg/gZ6DoHU+rp01/ss0/X50FPoDPjFcnoSgfGPwBso+Xhw+v5/BfbJG5DV7umnNfRWfGSq/WbIRaLzom3HEbXu7r7eBMAW0Xfh654VcVvoDPiNUf0OmJmCTof3tMKXXN/S3kSqO2KmqKrflox7wIK0KUduu6/exOdC2+6AV33Su15GxCI1BnoylfI5WWgIJfq8ThoIToP3rUfXftyy3gfIJhsHWYI9kVnwctuQlffMJqgc+Bt8BfDWV3QKfC2HdPADfAWOgNe1wBb/xVT0Qnwut09oA0QgY6fbUbWv38SOnyWBDxYJO0oOnrm823APQ8cho6dlXscVf/MTujQWbn8ElAD8C2gJh7E1P9tXgmoifjOkAaYjo6bVToDUf8FfBqQNgoHABpgMzpqdtpq++vfbCQ6aHZa0STbG+BVdMzM3zt8AfA22y8B/AtAMzPtrf+7ReiAWVVF7W1tAD4QRjut7ax/e74AaMfWS0BHdLSsJht/BczltWAaKlxvWwO0QsfKAlliV/1L+ExoLa20awPJv6EjZYHZdLJc2kvoQFlgXXJtaYD30HGyYPbY0gDvo8NkwUTaUf870FGy4O6woQGS0UGy4GyYGFKLj4XVWNxe5Q3AxwJWF98nqpM2+yTGKm+AD9Ah+sG/kur12AMnd24vnrG/byp6MOUeUl3/fugIT8nudtesY0bxsUWHNzeCDWLfqgS/1GxroMNa+cWKG0CPiQBrJ/ttlbxmYRRkELs/rH6E3woN9ksaq7b+U3R4D9jocLXMF78J+A7eMqtmenI+gk+V3JmptAH2o+M74cjxmuOqY/vj6bVzAiZoMvzn4N+VNoAGm4Je3zzQwDrPt3cU84Mtx/sYnZ/LVNZ/O35HkCPNAw/N3g6YH3w55lhwgpJULhMrAAd34ituQbCx9X7EvlF0CbFDZ2YfcIoUzgvJwb8IDnFYkn3XgPkhl2Oj35Z2UvdSGP8QYG2ow9Pt6oDQ9Tdybf45UsNBZQ2Afw8U+uRsezpgfrjtGJ4DJ+kTVfVPSwRH5ssOc1SWHR0Qtv5GD3CWOqnaNuxWcGA+X7dwQ1TfAeHrbxhtwWn6VFEDjAfH5fPdFXaMqjvATP2N/wGn6VE19c+9FhyXzzcr/CjVdoCp+hsvg9O0Q813AP4ewHfMxDBVdoC5+hufofNUR0kDfIIOy1doapzqOsBk/Y3G6ETdraL+OTvQYfl8CaZGquqZYBezJ/SgnwaruQ9YjI7qhNvNDVXNNcDs51+HTfSXKmgAHY4HbWlyrCo6wHz9jX3oPPkaK2iADeigfCHfBKjuAEL9R8BnhfjOlF//t/EzMCmnY8juAEL9dZg1U2Tyy5JgFTqmco3ML4CW2wGU+htvoNN0wnvSG0CP2aALzQ9YZgeQ6o9/Yn7CJtn1zx2ODumkqGLzQ5bXAaT6p52FTlK5fNkN8AI6olNuIIxZ1vMA0/f/J32OTlGFFMkNoElYvq6UO1w51wDS59/oDp8WXOEjyQ2wHB1QpZco5ZDRAbT655WhE3TKF3LrnxWNDuh3pAuy+LcA7fq/dSU6PZV2l0htAA3eBP6O9JEUvQbQPv9Ny9DJOW2X1Ab4Eh2OPxuvAbTP/8GB6NT4KZDaAJHocKqwrQNo9e+nU/3l/ghI0GHhsx+bOoBW//567Z1SliaxAZqio6nOlg6g1X+CXvX3+RZJbIBL0MHUYMMvQeL9/yB0SqqTuW8oepprAMqvAbTP/0YdNk6o6kKJDaDBbLAaFHcArf5X6Fd/31fy6j8XHUtASjuAVv+6Wp6i2ltaAzyADiUwhR1Aq38TLevv6yCtASaiQwlCWQfQ6v9aIToRgQ2W1gBno0MJRtG9AO33/1WavP+r4QJZ9c/R94QQJdcA2udf2/r7EmU1AHq5cygKrgG0z/95OkyWDULWr8C66EBCkX4NoH3+V2lcf9+tkhogAx1ISJI7gFb/r/FLAEKQtXN0a3QgoUntAFr9h2ldf19HSQ1wBB1IGBI7gFb/dL3rL2t9UK5m74JrktYBtPqfj982M7SpcjaMq42OIzxJHUCrf33d6+/zydk0tAM6DBOkdACt/ujN4My4WEoDXIkOwwwJzwNo9/8Z6IjNeEtKA8xDh2GK8DWA9vn/Bh2vKe9IaYDL0GGYI9gBtPpnoKM1p42UBjiADsMkoQ6g1R+/a7o5B2TUP0Hnh51VCHQArf66vh6voSthMXVQDrgLrGS5A2j1b4WO07weEhqgOzoIAosdQKv/NegoCSZIaIBX0EFQWOoA0v+Ug98vk+BmCQ0wGB0EiYXnAaT/JecxdIQklP00gumGDoKGfA2gff6dVX8pp4lfgA6CiNgBtPrjd8ynkXGG3FF0EFS0bwHKf5y7CR0bVR8JDaDvjNBgaD/qzUt7Bx0Z2SDxqLP0f+lZg5oOSLsQHZcFmcJhz0GHYIWKDkhz2K/hCiuE485Dh2CJ/A5I02OrVKo7hAPXdF1gOLI7IOFedETWiM8M/xYdgkW06R3hZP0vOh6LJguHHosOwSqZ1wDH1t93vnDsOhwUYo28Dsj6AzoWy8QnhT2MDsE6WR1Q+jw6EutGCUd/BjoEAXI6IPM7dBwCxDcKugkdgggZvwRLnPYypIrvheN/HR2CEPFrQIk2+6RbIj4t9Gl0CGJEO2CNQ+ZEB/O0cAN8gA5BkNi3QPMb0eMXFCPcAGvRIYgSuQZMeR89elEfCDdAFDoEYdY7YMqZ6LGLBy/cAJ3QIUhIgsUOaKHDAYCCxJeGHEKHIIG1Djj2A3rcElwr3AB6nBcoyEoHHHsKPWoZbhNugGx0CFLQO2DEQ+gxSxEv3AD6HBcmhNoBc51++3tKqnADpKJDkITWAb0dNxc6mBxugApfcQNY45KvgLbraWHzV0Ald/wI3HKcGjf/CDzFFbeBOxbQA+fbwApueBDUydJ+eS34QVA5FzwKzt9uLfQWzn8VIOFRcBQ6BGH5ta3GPmUDeuzCxF8GOf51cK9m1oPn18HOnxByqL1I9DwhxOlTwsakiIXPU8K0PTHMlMR1ovE7e1KwhEmhr6JDEDFcwgnazu4A8WnhTl4YsnOreP0No7QvOg4BM4XDd/DSsJ15Murv7KVhjwpH/zk6BMuyl8qpv6MXhz4oHLxjl4eX1ZFVfycvD39FOHanbhAx8FN59XdwB4hvENEEHYI10TK2SfaT9iM6ImtGC0e+GB2CJdHigVfvAEduEuYTvw9ejw7BimhZp+b6d4DmB6gGRpwIFUCx5qdjBjLoOvn1P9EBM9FxWZApHnciOgay1Loq6m8Yuc7bKjZaQtiOex0Yt5EQ3TbeLDqc79BBEKVSjsucS9wu/gl0dETLJTSAw377FHYgxDbiqMsPjNgkoQF6ooMgKbycENrbJ7/e+MiY0Bx1aFTRXYTIWsRU/E98aFRIu9BBEBStotT/94n/tHWDDdBREsh4HrodHYR5RX8nxDXFb/8PWgcsQcdpnoyDI51zdOzI8whh1aoy6Z/WAY3RkZol5ehYxxwenZROCGrNT1X/Z3ceHi3jMYBhOGSrzCTKzuhrrq/+v/Px8UHNQ4dhStLPhJBK2tT8A7QO+AYdrynvSGmAz9BhmJF0WLD+1D1FM9ARmyE+IaxcB3QYJiQtJASUGWSiN+0a8BE6ZhMoT8WDc8J94DeEeEq/D/ZXaB1wvv4nKlrYFiGA3KnoOML6jBBOVohp/rQOeEX3DogX3iCoQgw6kHAoX3VZISf50zpgv+aTZTbIqb+h+5GpXxJiSfhH6L9F64BhendAR0kNoPktz5uU+oed3k3rgP/TugNiJTVAXXQgIRUQIkkzsdSV1gGP6/ygXNbU2GXoQEJpQAikeLaZv0h7HnCexh0wV1IDGGPQkQRHWfxodmo/7RrwXld0DoLpJav+xj/RoQR1t4L6U68BV+naARdIawBtX37dTwgiJ9n836VdA14rROchsGukNcAedChBnEF40JHzZ8pfpnVA3Th0JgJ6QFoDjECHElhHSv3H0v42rQP27EbnIoCkEdIaQM85IZtyCfUnT+indcAVGnaA+B6Rp0WggwlgNaX+FiZz0zrgF/06QM5kgAofooMJEB6h/sb9Vv4F2r1A90HojFRHmSEXzgvoYGqYnUYYvsW1LbRrwJPx6JxUI7xFop/igehoqomgTHe1PJGf1gH99eqAMsolMqwv0OFU9Sul/gLT+Gkd0E+rj8nrMutvPIgOp4p7EwhDnyjyL9E64GAZOjN+KC9JTYSGDsffPZT63yD2b9F+CTYtQ+fmtCFSGyBLo2lhZ5cSBi58/0K7Bmxdic5Opd2ZUhvA0GfH5O+zCMPOEP/3aNeAvJ3o/Jxytdz6G1+iA6r0na2f/3K0DvhUk3uB+pIbYCk6oFOOTCMMur6cf5PWAZP1mCsseFBGDbl6bBZWRjkAbKGsUtA6QIuldPmS628YemyU+TfCiH+W91EkdcDtOvwQnCe9AR5Hh1SuLeEBkNRlG6QOeAudphPek94Ae3WY/EhYAfy13K9iSge8nYrOk6/odukNYGhwhN5I89Ncv5U9YZ/SAfgTRmStCfL3Jjoon+9904O9Sv71ivBE6CJ0okiLJczaig6K8Hh7lYrvK/PXAPwW+5JOS6oiZws6Kt+/TA5Vwee/nOkOqIVO1AFJy4KrGoUOy+xSp2dUTdQ3/S2QCk7Uyyrqr8EbwZbm6q9umr7ZawB6YoDE87L85I4Dh+UzdQ5UB5XLNMx1QA54zfAWJd8AhgHfJ9nMRtAb1S7SMPUtgD5mh7JgjuIWcFxmngNdoXqRjplrAHp75RcUNUDuIXBgm8OnXv30fBPXgFbYNHVS9A1gGKTldQo0CvcqYIgdk/PDXwMewqZplKr64+8Dbgk9vtHRtowiXAfMAmepqbIGyGkLDu3XkMObYNfExTAdAF5It0PZNwD+fUDRiyEG18++yVghO+AF8E3gEnX1Nxagpzu9H3xFWFM7n76E6IDMo9gUJQ1Q2ADGT+IDFNM42MjqlNk6juAdgD5dUsZJccENA0fnSwpyDNKLds/DCnY3CD9RyOwbM2tq2fM7O4Si/YHGNTrb9oH0eTfAOHIGo/OTXaK0ATSYG5r0SY2VITnPpQIGMrxJjeyMwO+nNlZt/fGPAk6Y/0vVMS2+ETOOpB/nVBlH8X4N5s4vVtwA6KdcFX74uEXleDJfuxo3jtQLR/9+W7Liwz7otJzwkOr6G4fRIVboumFs/fSPY6e3Qe/Ns7Pvvy/6OP3K1fvQd8gVKAsnrGmOnuzAQojbq7wB4G+EWAjyFwTVtAgdJAtukQ0NYIB+c7PwvrOj/sZv6DBZMBttaYBc9EthFsRaqTvDBfcsOlAW2H7x2ppSMhwdKQskMdOmBjAao0NlgUy0q/7GXO02RmY+XxxpIxsxhNNXmF1kbg8fzrs6bBfCqiiaZGMDGK3R4bLqLrSz/kZtXY9K86yi9rY2gAYzg1gVdv4CKPcuXwK0Yu8vgHLnoENm/lbbXX++EdBKodLVIIHxrwCNbLK//sZxPc9L9STEBUCHXcPYKcmI+hvHdNgVm50w0Ma3AP4y0IGzCp9h6m+024GOnJXrVAJqAONbdOisnPyzAcxK02KdmNc9rXBLmHD66bEeytOS1O0JZcKr6PBZN2T9jfWanJLnXYOWQRvAuBKdAK9rLF5DIVlr0Rnwti2UgzSVQG+M7HFNxCso6h/oHHhZ+O2z1Ruqy3nZHrSyN7r65X5Gp8G7vkbX/qTcO9F58KqfgM8A/bVHb9TkUXHN0JWv9Dk6Fd5k+hxN5YrPQufCi9aWout+Wh6vErBdkalD9OxSgE6H96CfAVdVfCY6H14Tk4CueVXb+bWgrabavBY0PN45ylbp6HrXkIPfKt9DztbkEZC/obehs+IdiVq8A6jucp4gaJOkuuhaB3Y/OjFeMR5d6SCyfkBnxhuOlqArHcwyXi1og4HavAOqqQn/DFAu6Td0lUPhnwHK9UTXOKSsN9D5cbvlaeJVUqnzOHSG3C1/BLrC4XzKO8coVHgQXd/weM24Qj+jq2sGnyunTDd0bU1JuB6dJ7d6qgRdW3N6d0Jnyp2i5qIra9a6bHSu3KhsHbqu5m3kSaLSFV6HrirF1+h0uU7Szeia0vREJ8xtCtAVJcrhQ2WkuknDOWChZS1H58xNLtVoFZBZxz5AZ809HrkdXU0r5vL2QZK0HYqupTVzeC9hKfKPoytp1aRe6Ny5wZj70HW07g7eP0jYzhfRVRTRdCo6f05XloeuoZhfePsYIdFPoisoahcfNS8gdQ+6ftwBSKkd0NWT4UneOsCiuIvRtZOjP3eAJVOHoCsnyy18L2BBtgNmAJuVNxydTedpVAddNZma5aPz6TRjFqFrJtfxr9AZdZYD2m0CJao37yZKcHQFul7yTYtEZ9U5LpuCrpYKmfeg8+oUm7PQtVIjhzeUNWV6LrpSyrzC6wXCGlkfXSWVhvCaoTDiL0fXSK2ULegM6y1/FrpCqm3jTWRCuFT7DUDElXZEZ1lf81z687+a9FR0ovVUlIGujF0OXovOtY4SXfP2N7wRbdDZ1s9Tjp39b0UWbyRUzf2aHQGj3G+8ZMDPwKvQ9bBfj/fRWdfH/BR0NRCyRvHW0hU6lqBrAbKL1w6esPMudB1wVvCWgr7vHLr2W46c9Gh0AbDiMtz77tecZp4+Z2bfX9D5xyt+sxBdBpSuPduhs6+Fln9FVwLjqMNXfstTeo0HLwKpN3jt2V8o6zz3VOhPrp/5QZN72FOTxaIvKUZnXDvbPLS3aF9PvfkzrYlH5gu2vQKdaV1lZgxEF0e9QQV87xfcis1uf0H0/AJ0jjWX5+r7gX2aHvyuk5x6h9BlUmVcuubHfmpiTYYrZwtNHdwcnVnH2Hu36/aX7Jq8DZ1VR1mR7Kp1pCMjJqEz6jjtI1xzQzDyR9dt+GKLlNauuAok9eWX/la9u8nxrwmLZjvovEcNLZvu6K2G41rzxV/Utn879qZw5RLHnPartXb19qFLacWhAlfu9QWRM6Sv024JYurxhB+pUpId9GNg4HhPrvVSbEr6EXRhzemScQydK7da/J8ydHXDiZ85wXHH/DpJu8mROv8aiEnnFz7K9ciYj65zYA0H10bnxiu23q3d+QPjzu3n9VV+tsqd8B+NTiEZd25/rr7t0vo/3BZd+XIHuPo4A2IjoW8Mi2IKtvKPfqxtH/84BlP9lZtX7UVHz04akB5RZm/xp0Zm9ONnvTopHT1xuU0HVEZHPvgpL+3TUVpKemvFLw6vjYjtV4qOk4Uy9JklfRuqqP2hL5Y08cBu7u4wYtc3r+5LlVX63TGr6w/h2jtOce09H/3nMpGrQVHUF+P/v+4kXs/jaGtm/DKs8cwLuhDmE9x29J/zCvbvae+N8xs8Y9rxvI3/ip04/sdfI3+KWdun0SmD4hvlRx2NuTPy+ZmjPn/28V+WDshEj5QxxhhjjDHGGGOMMcYYY4wxxhhjjDHGGGOMMcYYY4wxxhhjjDHGGGPMz38BIHvrL0mW80YAAAAldEVYdGRhdGU6Y3JlYXRlADIwMjAtMDYtMTlUMTk6NTg6MTIrMDA6MDDosr7jAAAAJXRFWHRkYXRlOm1vZGlmeQAyMDIwLTA2LTE5VDE5OjU4OjEyKzAwOjAwme8GXwAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAAASUVORK5CYII="/>
                </defs>
                </svg>
            </div>
            <div class="tutor-request__modal__content">
                <div class="tutor-request__modal__content__header">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <rect width="30" height="30" fill="url(#pattern1)"/>
                    <defs>
                    <pattern id="pattern1" patternContentUnits="objectBoundingBox" width="1" height="1">
                    <use xlink:href="#image1" transform="scale(0.00195312)"/>
                    </pattern>
                    <image id="image1" width="512" height="512" xlink:href="data:image/png;base64,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"/>
                    </defs>
                    </svg>
                    <p class="tutor-request__modal__content__header--title">New Tutor Request</p>
                </div>
                <div class="tutor-request__modal__content__profile">
                    <div class="tutor-request__modal__content__profile info-box tutor-request">
                        <div class="user-info">
                            <img src="{{ Storage::url($user->profile_pic_url) }}" alt="profile-img">
                            <a class="content" href="#">
                                <span>Shuaiqing Luo</span>
                            </a>
                        </div>
                    </div>
                    <div class="tutor-request__modal__content__profile info-box tutor-request">
                        <div class="date">
                            <span class="title">Date</span>
                            <span class="content">08/02<span class="info-box__year">/2020</span> Wednesday</span>
                        </div>
                        <div class="time">
                            <span class="title">Time</span>
                            <span class="content">13:30PM - 15:00PM</span>
                        </div>
                        <div class="course">
                            <span class="title">Course</span>
                            <span class="content">BUAD 304</span>
                        </div>
                        <div class="session-type">
                            <span class="title">Type</span>
                            <span class="content">In Person</span>
                        </div>
                    </div>
                </div>
                <div class="tutor-request__modal__content__calendar">
                </div>
                <div class="tutor-request__modal__content__policy">
                    <p><span style="font-weight: bold">Cancellation Policy:</span> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <p><span style="font-weight: bold">Refund Policy:</span> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                </div>
                <div class="tutor-request__modal__content__confirm">
                    <p class="tutor-request__modal__content__confirm--decline">Decline</p>
                    <p class="tutor-request__modal__content__confirm--confirm">Confirm Tutor Session</p>
                </div>
            </div>
        </div>
    </div>

</div>


<script>
    // Get the modal
    var modal = document.getElementsByClassName("tutor-request__modal")[0];

    // Get the button that opens the modal
    var btn = document.getElementsByClassName("btn-view-request")[0];

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("tutor-request__modal__close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>