"use strict";
$(function ($) {

    // Uploaded Image Preview Start
    $('.img-input').on('change', function (event) {
        let file = event.target.files[0];
        let reader = new FileReader();

        reader.onload = function (e) {
            $('.uploaded-img').attr('src', e.target.result);
        };

        reader.readAsDataURL(file);
    });
    // Uploaded Image Preview End


    // Uploaded Background Image Preview Start
    $('.background-img-input').on('change', function (event) {
        let file = event.target.files[0];
        let reader = new FileReader();

        reader.onload = function (e) {
            $('.uploaded-background-img').attr('src', e.target.result);
        };

        reader.readAsDataURL(file);
    });
    // Uploaded Background Image Preview End

    // Form Pre Populate After Click The Edit Button(Lesson) Start
    $('.lessonEditBtn').on('click', function (event) {
        event.preventDefault();

        let datas = $(this).data();

        for (const key in datas) {
            $('#lesson_' + key).val(datas[key]);
        }

        $('#viewLessonModal-' + datas.module_id).modal('hide');
        $('#lessonEditModal').modal('show');
    });
    // Form Prepopulate After Click The Edit Button(Lesson) End


    // Lesson Update with AJAX Request Start
    $('#lessonUpdateBtn').on('click', function () {
        $('.request-loader').addClass('show');

        let form = $('#lessonEditForm')[0];
        let fd = new FormData(form);
        let url = $('#lessonEditForm').attr('action');
        let type = $('#lessonEditForm').attr('method');

        $.ajax({
            url: url,
            type: type,
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $('.request-loader').removeClass('show');

                $('.em').each(function () {
                    $(this).html('');
                });

                if (data == 'success') {
                    location.reload();
                }
            },
            error: function (error) {
                $('.em').each(function () {
                    $(this).html('');
                });

                for (let x in error.responseJSON.errors) {
                    $('#lessonEdit_error_' + x).text(error.responseJSON.errors[x][0]);
                }

                $('.request-loader').removeClass('show');
            }
        });
    });
    // Lesson Update with AJAX Request End


    // Lesson Delete Using AJAX Request Start
    $('.lessonDeleteBtn').on('click', function (event) {
        event.preventDefault();
        $('.request-loader').addClass('show');
        let $this = $(this);
    
        swal({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          buttons: {
            confirm: {
              text: 'Yes, delete it',
              className: 'btn btn-success'
            },
            cancel: {
              visible: true,
              className: 'btn btn-danger'
            }
          }
        }).then((Delete) => {
          if (Delete) {
            $this.parents('.lessonDeleteForm').submit();
          } else {
            swal.close();
            $('.request-loader').removeClass('show');
          }
        });
      });
    // Lesson Delete Using AJAX Request End


    // Store Lesson's Video Using AJAX Request Start
    $('#videoSubmitBtn').on('click', function (event) {
        event.preventDefault();
        $('.request-loader').addClass('show');

        let videoForm = $('#videoForm')[0];
        let fd = new FormData(videoForm);
        let url = $('#videoForm').attr('action');
        let type = $('#videoForm').attr('method');

        $.ajax({
            url: url,
            type: type,
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $('.request-loader').removeClass('show');

                $('.em').each(function () {
                    $(this).html('');
                });

                if (data == 'success') {
                    location.reload();
                }
            },
            error: function (errRes) {
                $('.em').each(function () {
                    $(this).html('');
                });
                for (let x in errRes.responseJSON.errors) {
                    $('#err_' + x).text(errRes.responseJSON.errors[x][0]);
                }
                $('.request-loader').removeClass('show');
            }
        });
    });
    // Store Lesson's Video Using AJAX Request End


    // Store Lesson's File Using AJAX Request Start
    $('#fileSubmitBtn').on('click', function (event) {
        event.preventDefault();
        $('.request-loader').addClass('show');

        let fileForm = $('#fileForm')[0];
        let fd = new FormData(fileForm);
        let url = $('#fileForm').attr('action');
        let type = $('#fileForm').attr('method');

        $.ajax({
            url: url,
            type: type,
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $('.request-loader').removeClass('show');
                $('.em').each(function () {
                    $(this).html('');
                });

                if (data == 'success') {
                    location.reload();
                }
            },
            error: function (errRes) {
                $('.em').each(function () {
                    $(this).html('');
                });

                for (let x in errRes.responseJSON.errors) {
                    $('#err_' + x).text(errRes.responseJSON.errors[x][0]);
                }

                $('.request-loader').removeClass('show');
            }
        });
    });
    // Store Lesson's File Using AJAX Request End


    // Store Lesson's Text Using AJAX Request Start
    $('#textSubmitBtn').on('click', function (event) {
        event.preventDefault();
        $('.request-loader').addClass('show');

        let textForm = $('#textForm')[0];
        let fd = new FormData(textForm);
        let url = $('#textForm').attr('action');
        let type = $('#textForm').attr('method');

        $.ajax({
            url: url,
            type: type,
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $('.request-loader').removeClass('show');

                $('.em').html('');

                if (data == 'success') {
                    location.reload();
                }
            },
            error: function (errRes) {
                $('.em').html('');

                $('#err_text').text(errRes.responseJSON.error['text'][0]);

                $('.request-loader').removeClass('show');
            }
        });
    });
    // Store Lesson's Text Using AJAX Request End


    // Update Lesson's Text Using AJAX Request Start
    $('#textUpdateBtn').on('click', function (event) {
        event.preventDefault();
        $('.request-loader').addClass('show');
        let textForm = $('#editTextForm')[0];
        let fd = new FormData(textForm);
        let url = $('#editTextForm').attr('action');
        let type = $('#editTextForm').attr('method');

        $.ajax({
            url: url,
            type: type,
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $('.request-loader').removeClass('show');
                $('.em').html('');
                if (data == 'success') {
                    location.reload();
                }
            },
            error: function (errRes) {
                $('.em').html('');
                $('#editErr_text').text(errRes.responseJSON.error['text'][0]);
                $('.request-loader').removeClass('show');
            }
        });
    });
    // Update Lesson's Text Using AJAX Request End


    // Store Lesson's Code Using AJAX Request Start
    $('#codeSubmitBtn').on('click', function (event) {
        event.preventDefault();
        $('.request-loader').addClass('show');

        let codeForm = $('#codeForm')[0];
        let fd = new FormData(codeForm);
        let url = $('#codeForm').attr('action');
        let type = $('#codeForm').attr('method');

        $.ajax({
            url: url,
            type: type,
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $('.request-loader').removeClass('show');

                $('.em').html('');

                if (data == 'success') {
                    location.reload();
                }
            },
            error: function (errRes) {
                $('.em').html('');
                $('#err_code').text(errRes.responseJSON.error['code'][0]);
                $('.request-loader').removeClass('show');
            }
        });
    });
    // Store Lesson's Code Using AJAX Request End


    // Update Lesson's Code Using AJAX Request Start
    $('#codeUpdateBtn').on('click', function (event) {
        event.preventDefault();
        $('.request-loader').addClass('show');

        let codeForm = $('#editCodeForm')[0];
        let fd = new FormData(codeForm);
        let url = $('#editCodeForm').attr('action');
        let type = $('#editCodeForm').attr('method');

        $.ajax({
            url: url,
            type: type,
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $('.request-loader').removeClass('show');
                $('.em').html('');
                if (data == 'success') {
                    location.reload();
                }
            },
            error: function (errRes) {
                $('.em').html('');
                $('#editErr_code').text(errRes.responseJSON.error['code'][0]);
                $('.request-loader').removeClass('show');
            }
        });
    });
    // Update Lesson's Code Using AJAX Request End
    
    /*------------------------
    Highlight Js
    -------------------------- */
    hljs.initHighlightingOnLoad();

    $("#toggle-btn").on('change', function() {
        var value= null;
        if(this.checked){
        value = this.getAttribute('data-on');
        }else{
          value =this.getAttribute('data-off');
        }
        $.post(userStatusRoute,
            {
                value: value
            },
            function(data){
                history.go(0);
        });
    });
});

function cloneInput(fromId, toId, event) {
    let $target = $(event.target);
    if ($target.is(':checked')) {
        $('#' + fromId + ' .form-control').each(function (i) {
            let index = i;
            let val = $(this).val();
            let $toInput = $('#' + toId + ' .form-control').eq(index);

            if ($(this).hasClass('summernote')) {
                $toInput.summernote('code', val);
            } else if ($(this).data('role') == 'tagsinput') {
                if (val.length > 0) {
                    let tags = val.split(',');
                    tags.forEach(tag => {
                        $toInput.tagsinput('add', tag);
                    });
                } else {
                    $toInput.tagsinput('removeAll');
                }
            } else {
                $toInput.val(val);
            }
        });
    } else {
        $('#' + toId + ' .form-control').each(function (i) {
            let $toInput = $('#' + toId + ' .form-control').eq(i);
            if ($(this).hasClass('summernote')) {
                $toInput.summernote('code', '');
            } else if ($(this).data('role') == 'tagsinput') {
                $toInput.tagsinput('removeAll');
            } else {
                $toInput.val('');
            }
        });
    }
}

function storeLesson(event, moduleId) {
    event.preventDefault();
    $('.request-loader').addClass('show');

    let lessonForm = $('#lessonForm-' + moduleId)[0];
    let fd = new FormData(lessonForm);
    let url = $('#lessonForm-' + moduleId).attr('action');
    let type = $('#lessonForm-' + moduleId).attr('method');

    $.ajax({
        url: url,
        type: type,
        data: fd,
        contentType: false,
        processData: false,
        success: function (data) {
            $('.request-loader').removeClass('show');
            $('.em').each(function () {
                $(this).html('');
            });
            if (data == 'success') {
                location.reload();
            }
        },
        error: function (error) {
            $('.em').each(function () {
                $(this).html('');
            });
            for (let x in error.responseJSON.errors) {
                $('#err_' + x + '-' + moduleId).text(error.responseJSON.errors[x][0]);
            }
            $('.request-loader').removeClass('show');
        }
    });
}
