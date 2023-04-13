(function ($) {
    'use strict';
    try {
        $('.js-datepicker').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "autoUpdateInput": false,
            locale: {
                format: 'DD/MM/YYYY'
            },
        });
        var myCalendar = $('.js-datepicker');
        var isClick = 0;
        $(window).on('click', function () {
            isClick = 0;
        });
        $(myCalendar).on('apply.daterangepicker', function (ev, picker) {
            isClick = 0;
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
        $('.js-btn-calendar').on('click', function (e) {
            e.stopPropagation();
            if (isClick === 1)
                isClick = 0;
            else if (isClick === 0)
                isClick = 1;
            if (isClick === 1) {
                myCalendar.focus();
            }
        });
        $(myCalendar).on('click', function (e) {
            e.stopPropagation();
            isClick = 1;
        });
        $('.daterangepicker').on('click', function (e) {
            e.stopPropagation();
        });
    } catch (er) {
        console.log(er);
    }
})(jQuery);

$('.featured-card-bg-small').slick({
    dots: false,
    vertical: true,
    infinite: true,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    verticalSwiping: true,
    prevArrow: '<div class="slick-prev d-flex justify-content-center pb-4"><i class="fa fa-angle-up" aria-hidden="true"></i></div>',
    nextArrow: '<div class="slick-next d-flex justify-content-center pt-4"><i class="fa fa-angle-down" aria-hidden="true"></i></div>',
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                vertical: false,
                slidesToShow: 3,
                slidesToScroll: 1,
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});

document.querySelectorAll(".featured-card").forEach(feature_card => {
    var big_img = feature_card.querySelector('.featured-card-bg')
    feature_card.querySelectorAll(".small-img").forEach(small_img => {
        var src = small_img.firstElementChild.getAttribute('src')
        small_img.addEventListener('mouseover', () => {
            big_img.src = src
        })
    })
})

function locate_signin() {
    window.location = '/index.php?page=login'
}

function locate_register() {
    window.location = '/index.php?page=register'
}

function login() {
    const setError = (message) => {
        error_message.innerHTML = '*' + message;
        if (error_message.classList.contains('hide') && success_message.classList.contains('hide')) {
            error_message.classList.remove('hide')
        } else {
            error_message.classList.remove('hide')
            success_message.classList.add('hide')
        }
    }

    const setSucess = (message) => {
        success_message.innerHTML = '*' + message;
        if (error_message.classList.contains('hide') && success_message.classList.contains('hide')) {
            success_message.classList.remove('hide')
        } else {
            error_message.classList.add('hide')
            success_message.classList.remove('hide')
        }
    }

    const error_message = document.getElementById('form-error');
    const success_message = document.getElementById('form-success');

    const username = document.getElementById('username');
    const password = document.getElementById('password');

    data = {
        "username": username.value,
        "password": password.value,
    }

    $.ajax({
        url: "index.php?page=login",
        data: data,
        type: 'POST',
        dataType: "json",
        success: function (data) {
            if (data.success) {
                setSucess(`Login successful.`)
                window.location = "/index.php?page=home"
            } else {
                setError(null, data.error)
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
    });
}

function register() {
    const validate = (value, typ) => {
        const string_regex = /^[a-zA-Z0-9 ]*$/
        const birth_day_regex = /^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[1-2][0-9]{3}$/gm
        const email_regex = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/g;
        const phone_regex = /^[0-9]{9,12}$/
        const username_regex = /^[a-zA-Z][a-zA-Z0-9-_]{3,32}$/gi
        const password_regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/gm

        // return 0 for ok, 1 for empty, 2 for typemismatch
        if (value === "") {
            return 1
        } else {
            switch (typ) {
                case "string":
                    if (!string_regex.test(value)) {
                        return 2
                    }
                    break;
                case "birthday":
                    if (!birth_day_regex.test(value)) {
                        return 2
                    }
                    break;
                case "email":
                    if (!email_regex.test(value)) {
                        return 2
                    }
                    break;
                case "phone":
                    if (!phone_regex.test(value)) {
                        return 2
                    }
                    break;
                case "username":
                    if (!username_regex.test(value)) {
                        return 2
                    }
                    break;

                case "password":
                    if (!password_regex.test(value)) {
                        return 2
                    }
                    break;
            }
        }
        return 0
    }

    const setError = (formField, message) => {
        error_message.innerHTML = '*' + message;
        if (error_message.classList.contains('hide')) {
            error_message.classList.remove('hide')
        }
        if (formField) {
            formField.setCustomValidity(message)
            formField.reportValidity()
        }
    }

    const setSucess = (message) => {
        success_message.innerHTML = '*' + message;
        if (error_message.classList.contains('hide') & success_message.classList.contains('hide')) {
            success_message.classList.remove('hide')
        } else {
            error_message.classList.add('hide')
            success_message.classList.remove('hide')
        }
    }

    const error_handling = (formField, typ) => {
        state = validate(formField.value, typ);
        if (state == 1 && (typ == "email" || typ == "phone")) {
            return state
        } else if (state == 1) {
            setError(formField, "Can't be empty")
        } else if (state == 2) {
            switch (typ) {
                case "string":
                    setError(formField, "Only contains alphabetic characters, numbers and space")
                    break
                case "birthday":
                    setError(formField, "Must follow day format DD/MM/YYYY")
                    break
                case "email":
                    setError(formField, "Must have @, after @ must be a hostname, cannot contain any spaces.")
                    break
                case "phone":
                    setError(formField, "Only numbers with length of 9 to 12")
                    break
                case "username":
                    setError(formField, "Username must have between 3 to 32 characters with alphabetic, numeric and underscores")
                    break
                case "password":
                    msg = `- Must have at least 8 characters
- Must contain at least 1 uppercase letter, 1 lowercase letter, and 1 number
- Can contain special characters`
                    setError(formField, msg)
                    break
            }

        }
        return state
    }
    const first_name = document.getElementById('first-name');
    const last_name = document.getElementById('last-name');


    const birth_day = document.getElementById('b-day');
    const gender = document.getElementById('male').checked ? "male" : "female";

    const email = document.getElementById('email');
    const phone = document.getElementById('phone');

    const username = document.getElementById('username');

    const password = document.getElementById('password');
    const re_password = document.getElementById('password_repeat');

    const error_message = document.getElementById('form-error');
    const success_message = document.getElementById('form-success');

    if (error_handling(first_name, "string") !== 0) {
        return
    }
    if (error_handling(last_name, "string") !== 0) {
        return
    }
    if (error_handling(birth_day, "birthday") !== 0) {
        return
    }
    phone_state = error_handling(phone, "phone")
    mail_state = error_handling(email, "email")
    if (mail_state === 2) {
        return
    }
    if (phone_state === 2) {
        return
    }
    if (mail_state === 1) {
        if (phone_state === 1) {
            setError(email, "Either email or phone number must be filled")
            return
        }
    }
    if (error_handling(username, "username") !== 0) {
        return
    }
    if (error_handling(password, "password") !== 0) {
        return
    }
    if (error_handling(re_password, "password") !== 0) {
        return
    }
    if (password.value !== re_password.value) {
        setError(re_password, "Your re-entered password is not the same with the above")
        return
    }


    if (!error_message.classList.contains('hide')) {
        error_message.classList.add('hide')
    }
    data = {
        "first_name": first_name.value,
        "last_name": last_name.value,
        "birth_day": birth_day.value,
        "gender": gender,
        "email": email.value,
        "phone": phone.value,
        "username": username.value,
        "password": password.value,
    }

    $.ajax({
        url: "index.php?page=register",
        data: data,
        type: 'POST',
        dataType: "json",
        success: function (data) {
            if (data.success) {
                setSucess(`Register successful. Welcome ${first_name.value} ${last_name.value}`)
                window.location = "/index.php?page=home"
            } else {
                setError(null, data.error)
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
    });
}