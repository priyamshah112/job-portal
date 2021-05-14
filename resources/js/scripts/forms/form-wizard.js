/*=========================================================================================
    File Name: wizard-steps.js
    Description: wizard steps page specific js
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function () {
    'use strict';

    var bsStepper = document.querySelectorAll('.bs-stepper'),
        select = $('.select2'),
        horizontalWizard = document.querySelector('.horizontal-wizard-example'),
        verticalWizard = document.querySelector('.vertical-wizard-example'),
        modernWizard = document.querySelector('.modern-wizard-example'),
        modernVerticalWizard = document.querySelector('.modern-vertical-wizard-example');

    // Adds crossed class
    if (typeof bsStepper !== undefined && bsStepper !== null) {
        for (var el = 0; el < bsStepper.length; ++el) {
            bsStepper[el].addEventListener('show.bs-stepper', function (event) {
                var index = event.detail.indexStep;
                var numberOfSteps = $(event.target).find('.step').length - 1;
                var line = $(event.target).find('.step');

                // The first for loop is for increasing the steps,
                // the second is for turning them off when going back
                // and the third with the if statement because the last line
                // can't seem to turn off when I press the first item. ¯\_(ツ)_/¯

                for (var i = 0; i < index; i++) {
                    line[i].classList.add('crossed');

                    for (var j = index; j < numberOfSteps; j++) {
                        line[j].classList.remove('crossed');
                    }
                }
                if (event.detail.to == 0) {
                    for (var k = index; k < numberOfSteps; k++) {
                        line[k].classList.remove('crossed');
                    }
                    line[0].classList.remove('crossed');
                }
            });
        }
    }

    // select2
    select.each(function () {
        var $this = $(this);
        $this.wrap('<div class="position-relative"></div>');
        $this.select2({
            placeholder: 'Select value',
            dropdownParent: $this.parent()
        });
    });

    // Horizontal Wizard
    // --------------------------------------------------------------------
    if (typeof horizontalWizard !== undefined && horizontalWizard !== null) {
        var numberedStepper = new Stepper(horizontalWizard),
            $form = $(horizontalWizard).find('form');
        $form.each(function () {
            var $this = $(this);
            $this.validate({
                rules: {
                    username: {
                        required: true
                    },
                    email: {
                        required: true
                    },
                    password: {
                        required: true
                    },
                    'confirm-password': {
                        required: true,
                        equalTo: '#password'
                    },
                    'first-name': {
                        required: true
                    },
                    'last-name': {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    landmark: {
                        required: true
                    },
                    country: {
                        required: true
                    },
                    language: {
                        required: true
                    },
                    twitter: {
                        required: true,
                        url: true
                    },
                    facebook: {
                        required: true,
                        url: true
                    },
                    google: {
                        required: true,
                        url: true
                    },
                    linkedin: {
                        required: true,
                        url: true
                    }
                }
            });
        });

        $(horizontalWizard)
            .find('.btn-next')
            .each(function () {
                $(this).on('click', function (e) {
                    var isValid = $(this).parent().siblings('form').valid();
                    if (isValid) {
                        numberedStepper.next();
                    } else {
                        e.preventDefault();
                    }
                });
            });

        $(horizontalWizard)
            .find('.btn-prev')
            .on('click', function () {
                numberedStepper.previous();
            });

        $(horizontalWizard)
            .find('.btn-submit')
            .on('click', function () {
                var isValid = $(this).parent().siblings('form').valid();
                if (isValid) {
                    alert('Submitted..!!');
                }
            });
    }

    // Vertical Wizard
    // --------------------------------------------------------------------
    if (typeof verticalWizard !== undefined && verticalWizard !== null) {
        var verticalStepper = new Stepper(verticalWizard, {
            linear: false
        });
        $(verticalWizard)
            .find('.btn-next')
            .on('click', function () {
                verticalStepper.next();
            });
        $(verticalWizard)
            .find('.btn-prev')
            .on('click', function () {
                verticalStepper.previous();
            });

        $(verticalWizard)
            .find('.btn-submit')
            .on('click', function () {
                alert('Submitted..!!');
            });

        $(document).ready(function () {
            var next = 0;
            $("#add-more").on('click',function (e) {
                e.preventDefault();
                let chapterName = $("#chapter_name").val();
                if(chapterName === '' || chapterName === undefined){
                    return
                }
                var newIn = `<div class="card">
                    <div class="card-header" id="heading${next}" data-toggle="collapse" role="button" data-target="#collapse${next}"
                        aria-expanded="false" aria-controls="collapse220">
                        <span class="lead collapse-title">${chapterName}</span>
                    </div>
                    <div id="collapse${next}" class="collapse" aria-labelledby="heading${next}" data-parent="#lesson-containers">
                        <div class="card-body">                            
                            <div class="lesson_containers"></div>
                            <button type="button" class="btn btn-outline-secondary mt-2" data-toggle="modal"
                                data-target="#exampleModalScrollable">
                                <i data-feather="plus"></i>Add new Lesson
                            </button>
                        </div>
                    </div>
                </div>`;
                $("#lesson-containers").append(newIn);
                $("#chapter_name").val('')
                next++;
                $('.remove-me').click(function (e) {
                    $(this).remove();
                });                
            });

            $(`#addNewLesson`).on('click', function(e){
                e.preventDefault();                
                let lessonName = $("#lesson_name").val();
                if(lessonName === '' || lessonName === undefined){
                    return
                }
                var newIn = `
                <div class="card">
                    <div class="card-header">
                        <span class="lead collapse-title">${lessonName}</span>
                    </div>
                </div>`;
                $(".lesson_containers").append(newIn);
                $("#lesson_name").val('')
                next++;

            });

            $("input[name='customRadio']").click(function (e){
                e.preventDefault();
                if($(this).val() === 'paid') {
                    $('#price_box').show();
                    $('#date_range_box').show();
                } else {
                    $('#price_box').hide();
                    $('#date_range_box').hide();
                }
            });

            $("#add-more-objectives").click(function (e) {
                e.preventDefault();
                var addto = "#objectives" + next;
                var addRemove = "#objectives" + (next);
                next = next + 1;
                var newIn = ' <div id="objectives' + next + '" name="objectives' + next + '"><!-- Text input--><div class="row">\n' +
                    '        <div class="form-group col-md-6">\n' +
                    '            <label class="form-label" for="vertical-username">Objective</label>\n' +
                    '            <input type="text" id="vertical-username" class="form-control" placeholder="Objective"/>\n' +
                    '        </div>\n' +
                    '    </div></div>';
                var newInput = $(newIn);
                var removeBtn = '<button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >Remove</button></div></div><div id="field">';
                var removeButton = $(removeBtn);
                $(addto).after(newInput);
                $(addRemove).after(removeButton);
                $("#objectives" + next).attr('data-source', $(addto).attr('data-source'));
                $("#count").val(next);

                $('.remove-me').click(function (e) {
                    e.preventDefault();
                    var fieldNum = this.id.charAt(this.id.length - 1);
                    var fieldID = "#objectives" + fieldNum;
                    $(this).remove();
                    $(fieldID).remove();
                });
            });
        });
    }

    // Modern Wizard
    // --------------------------------------------------------------------
    if (typeof modernWizard !== undefined && modernWizard !== null) {
        var modernStepper = new Stepper(modernWizard, {
            linear: false
        });
        $(modernWizard)
            .find('.btn-next')
            .on('click', function () {
                modernStepper.next();
            });
        $(modernWizard)
            .find('.btn-prev')
            .on('click', function () {
                modernStepper.previous();
            });

        $(modernWizard)
            .find('.btn-submit')
            .on('click', function () {
                alert('Submitted..!!');
            });
    }

    // Modern Vertical Wizard
    // --------------------------------------------------------------------
    if (typeof modernVerticalWizard !== undefined && modernVerticalWizard !== null) {
        var modernVerticalStepper = new Stepper(modernVerticalWizard, {
            linear: false
        });
        $(modernVerticalWizard)
            .find('.btn-next')
            .on('click', function () {
                modernVerticalStepper.next();
            });
        $(modernVerticalWizard)
            .find('.btn-prev')
            .on('click', function () {
                modernVerticalStepper.previous();
            });

        $(modernVerticalWizard)
            .find('.btn-submit')
            .on('click', function () {
                alert('Submitted..!!');
            });
    }
});
