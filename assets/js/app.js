$(document).ready(function () {
    $.ajaxSetup({cache: false});

    //set locale of moment js
    moment.locale(AppLanugage.locale);

    //set locale for datepicker
    ;
    (function ($) {
        $.fn.datepicker.dates['custom'] = {
            days: AppLanugage.days,
            daysShort: AppLanugage.daysShort,
            daysMin: AppLanugage.daysMin,
            months: AppLanugage.months,
            monthsShort: AppLanugage.monthsShort,
            today: AppLanugage.today
        };
    }(jQuery));

    //set datepicker language

    $('body').on('click', '[data-act=ajax-modal]', function () {
        var data = {ajaxModal: 1},
                url = $(this).attr('data-action-url'),
                isLargeModal = $(this).attr('data-modal-lg'),
                title = $(this).attr('data-title');
        if (!url) {
            console.log('Ajax Modal: Set data-action-url!');
            return false;
        }
        if (title) {
            $("#ajaxModalTitle").html(title);
        } else {
            $("#ajaxModalTitle").html($("#ajaxModalTitle").attr('data-title'));
        }

        $("#ajaxModalContent").html($("#ajaxModalOriginalContent").html());
        $("#ajaxModalContent").find(".original-modal-body").removeClass("original-modal-body").addClass("modal-body");
        $("#ajaxModal").modal('show');

        $(this).each(function () {
            $.each(this.attributes, function () {
                if (this.specified && this.name.match("^data-post-")) {
                    var dataName = this.name.replace("data-post-", "");
                    data[dataName] = this.value;
                }
            });
        });
        ajaxModalXhr = $.ajax({
            url: url,
            data: data,
            cache: false,
            type: 'POST',
            success: function (response) {
                $("#ajaxModal").find(".modal-dialog").removeClass("mini-modal");
                if (isLargeModal === "1") {
                    $("#ajaxModal").find(".modal-dialog").addClass("modal-lg");
                }
                $("#ajaxModalContent").html(response);

                var $scroll = $("#ajaxModalContent").find(".modal-body"),
                        height = $scroll.height(),
                        maxHeight = $(window).height() - 200;
                if (height > maxHeight) {
                    height = maxHeight;
                    if ($.fn.mCustomScrollbar) {
                        $scroll.mCustomScrollbar({setHeight: height, theme: "minimal-dark", autoExpandScrollbar: true});
                    }
                }
            },
            statusCode: {
                404: function () {
                    $("#ajaxModalContent").find('.modal-body').html("");
                    appAlert.error("404: Page not found.", {container: '.modal-body', animate: false});
                }
            },
            error: function () {
                $("#ajaxModalContent").find('.modal-body').html("");
                appAlert.error("500: Internal Server Error.", {container: '.modal-body', animate: false});
            }
        });
        return false;
    });

    //abort ajax request on modal close.
    $('#ajaxModal').on('hidden.bs.modal', function (e) {
        ajaxModalXhr.abort();
        $("#ajaxModal").find(".modal-dialog").removeClass("modal-lg");
        $("#ajaxModal").find(".modal-dialog").addClass("mini-modal");

        $("#ajaxModalContent").html("");
    });

    //common ajax request
    $('body').on('click', '[data-act=ajax-request]', function () {
        var data = {},
                $selector = $(this),
                url = $selector.attr('data-action-url'),
                removeOnSuccess = $selector.attr('data-remove-on-success'),
                removeOnClick = $selector.attr('data-remove-on-click'),
                fadeOutOnSuccess = $selector.attr('data-fade-out-on-success'),
                fadeOutOnClick = $selector.attr('data-fade-out-on-click'),
                inlineLoader = $selector.attr('data-inline-loader'),
                reloadOnSuccess = $selector.attr('data-reload-on-success');

        var $target = "";
        if ($selector.attr('data-real-target')) {
            $target = $($selector.attr('data-real-target'));
        } else if ($selector.attr('data-closest-target')) {
            $target = $selector.closest($selector.attr('data-closest-target'));
        }

        if (!url) {
            console.log('Ajax Request: Set data-action-url!');
            return false;
        }

        //remove the target element
        if (removeOnClick && $(removeOnClick).length) {
            $(removeOnClick).remove();
        }

        //remove the target element with fade out effect
        if (fadeOutOnClick && $(fadeOutOnClick).length) {
            $(fadeOutOnClick).fadeOut(function () {
                $(this).remove();
            });
        }

        $selector.each(function () {
            $.each(this.attributes, function () {
                if (this.specified && this.name.match("^data-post-")) {
                    var dataName = this.name.replace("data-post-", "");
                    data[dataName] = this.value;
                }
            });
        });
        if (inlineLoader === "1") {
            $selector.addClass("inline-loader");
        } else {
            appLoader.show();
        }

        ajaxRequestXhr = $.ajax({
            url: url,
            data: data,
            cache: false,
            type: 'POST',
            success: function (response) {
                if (reloadOnSuccess) {
                    location.reload();
                }

                //remove the target element
                if (removeOnSuccess && $(removeOnSuccess).length) {
                    $(removeOnSuccess).remove();
                }

                //remove the target element with fade out effect
                if (fadeOutOnSuccess && $(fadeOutOnSuccess).length) {
                    $(fadeOutOnSuccess).fadeOut(function () {
                        $(this).remove();
                    });
                }

                appLoader.hide();
                if ($target.length) {
                    $target.html(response);
                }
            },
            statusCode: {
                404: function () {
                    appLoader.hide();
                    appAlert.error("404: Page not found.");
                }
            },
            error: function () {
                appLoader.hide();
                appAlert.error("500: Internal Server Error.");
            }
        });

    });

    //bind ajax tab
    $('body').on('click', '[data-toggle="ajax-tab"] a', function () {
        var $this = $(this),
                loadurl = $this.attr('href'),
                target = $this.attr('data-target');
        if (!target)
            return false;
        if ($(target).html() === "") {
            appLoader.show({container: target, css: "right:50%; bottom:auto;"});
            $.get(loadurl, function (data) {
                $(target).html(data);
            });
        }
        $this.tab('show');
        return false;
    });
    //auto load first tab
    $('[data-toggle="ajax-tab"] a').first().trigger("click");

    $('body').on('click', '[data-toggle="app-modal"]', function () {
        var sidebar = true;

        if ($(this).attr("data-sidebar") === "0") {
            sidebar = false;
        }

        appContentModal.init({url: $(this).attr("data-url"), sidebar: sidebar});
        return false;
    });




    //prepare common delete confimation
    var recordDeleteHandler = function (result, $target) {
        var callbackFunction = $target.attr("data-success-callback");

        if (callbackFunction && typeof window[callbackFunction] != 'undefined') {
            window[callbackFunction](result, $target);

            if (result.message) {
                appAlert.warning(result.message, {duration: 20000});
            }

        }
    };

    var linkDeleteConfirmationHandler = function (e) {
        deleteConfirmationHandler(e, recordDeleteHandler);
    };


    //bind the delete confimation modal which links are not in tables. because there is an another logic for datatable.
    $('body').on('click', 'a[data-action=delete-confirmation]:not(table a)', linkDeleteConfirmationHandler);

});


//custom app form controller
(function ($) {
    $.fn.appForm = function (options) {

        var defaults = {
            ajaxSubmit: true,
            isModal: true,
            closeModalOnSuccess: true,
            dataType: "json",
            onModalClose: function () {
            },
            onSuccess: function () {
            },
            onError: function () {
                return true;
            },
            onSubmit: function () {
            },
            onAjaxSuccess: function () {
            },
            beforeAjaxSubmit: function (data, self, options) {
            }
        };
        var settings = $.extend({}, defaults, options);
        this.each(function () {
            if (settings.ajaxSubmit) {
                validateForm($(this), function (form) {
                    settings.onSubmit();


                    if (settings.isModal) {
                        maskModal($("#ajaxModalContent").find(".modal-body"));
                    } else {
                        $(form).find('[type="submit"]').attr('disabled', 'disabled');
                    }
                    $(form).ajaxSubmit({
                        dataType: settings.dataType,
                        beforeSubmit: function (data, self, options) {

                            //Modified \assets\js\jquery-validation\jquery.form.js #1015.
                            //Added data  a.push({name: n, value: v, type: el.type, required: el.required, data: $(el).data()});

                            //to set the convertDateFormat with the input fields, we used the setDatePicker function.
                            //it is the easiest way to regognize the date fields.

                            $.each(data, function (index, obj) {
                                if (obj.data && obj.data.convertDateFormat && obj.value) {
                                    data[index]["value"] = convertDateToYMD(obj.value);
                                }
                            });



                            settings.beforeAjaxSubmit(data, self, options);
                        },
                        success: function (result) {
                            settings.onAjaxSuccess(result);

                            if (result.success) {
                                settings.onSuccess(result);
                                if (settings.isModal && settings.closeModalOnSuccess) {
                                    closeAjaxModal(true);
                                }
                            } else {
                                if (settings.onError(result)) {
                                    if (settings.isModal) {
                                        unmaskModal();
                                        if (result.message) {
                                            appAlert.error(result.message, {container: '.modal-body', animate: false});
                                        }
                                    } else if (result.message) {
                                        appAlert.error(result.message);
                                    }
                                }
                            }

                            $(form).find('[type="submit"]').removeAttr('disabled');
                        }
                    });
                });
            } else {
                validateForm($(this));
            }
        });
        /*
         * @form : the form we want to validate;
         * @customSubmit : execute custom js function insted of form submission. 
         * don't pass the 2nd parameter for regular form submission
         */

        function convertDateToYMD(date) {
            if (date) {
                var dateFormat = AppHelper.settings.dateFormat || "Y.m.d",
                        dateFormat = dateFormat.toLowerCase(),
                        separator = dateFormat.charAt("1"),
                        dateFormatArray = dateFormat.split(separator),
                        yearIndex = 0,
                        monthIndex = 1,
                        dayIndex = 2;

                if (dateFormatArray[1] === "y") {
                    yearIndex = 1;
                } else if (dateFormatArray[2] === "y") {
                    yearIndex = 2;
                }

                if (dateFormatArray[0] === "m") {
                    monthIndex = 0;
                } else if (dateFormatArray[2] === "m") {
                    monthIndex = 2;
                }

                if (dateFormatArray[0] === "d") {
                    dayIndex = 0;
                } else if (dateFormatArray[1] === "d") {
                    dayIndex = 1;
                }

                var dateValue = date.split(separator);

                return dateValue[yearIndex] + "-" + dateValue[monthIndex] + "-" + dateValue[dayIndex];
            }

        }

        function validateForm(form, customSubmit) {
            //add custom method
            $.validator.addMethod("greaterThanOrEqual",
                    function (value, element, params) {
                        var paramsVal = params;
                        if (params && (params.indexOf("#") === 0 || params.indexOf(".") === 0)) {
                            paramsVal = $(params).val();
                        }
                        if (!/Invalid|NaN/.test(new Date(value))) {
                            return new Date(convertDateToYMD(value)) >= new Date(convertDateToYMD(paramsVal));
                        }
                        return isNaN(value) && isNaN(paramsVal)
                                || (Number(value) >= Number(paramsVal));
                    }, 'Must be greater than {0}.');

            //add custom method
            $.validator.addMethod("mustBeSameYear",
                    function (value, element, params) {
                        var paramsVal = params;
                        if (params && (params.indexOf("#") === 0 || params.indexOf(".") === 0)) {
                            paramsVal = $(params).val();
                        }
                        if (!/Invalid|NaN/.test(new Date(convertDateToYMD(value)))) {
                            var dateA = new Date(convertDateToYMD(value)), dateB = new Date(convertDateToYMD(paramsVal));
                            return (dateA && dateB && dateA.getFullYear() === dateB.getFullYear());
                        }
                    }, 'The year must be same for both dates.');

            $(form).validate({
                submitHandler: function (form) {
                    if (customSubmit) {
                        customSubmit(form);
                    } else {
                        return true;
                    }
                },
                highlight: function (element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error');
                },
                errorElement: 'span',
                errorClass: 'help-block',
                ignore: ":hidden:not(.validate-hidden)",
                errorPlacement: function (error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
            //handeling the hidden field validation like select2
            $(".validate-hidden").click(function () {
                $(this).closest('.form-group').removeClass('has-error').find(".help-block").hide();
            });
        }

        //show loadig mask on modal before form submission;
        function maskModal($maskTarget) {
            var padding = $maskTarget.height() - 80;
            if (padding > 0) {
                padding = Math.floor(padding / 2);
            }
            $maskTarget.append("<div class='modal-mask'><div class='circle-loader'></div></div>");
            //check scrollbar
            var height = $maskTarget.outerHeight();
            $('.modal-mask').css({"width": $maskTarget.width() + 30 + "px", "height": height + "px", "padding-top": padding + "px"});
            $maskTarget.closest('.modal-dialog').find('[type="submit"]').attr('disabled', 'disabled');
        }

        //remove loadig mask from modal
        function unmaskModal() {
            var $maskTarget = $(".modal-body");
            $maskTarget.closest('.modal-dialog').find('[type="submit"]').removeAttr('disabled');
            $(".modal-mask").remove();
        }

        //colse ajax modal and show success check mark
        function closeAjaxModal(success) {
            if (success) {
                $(".modal-mask").html("<div class='circle-done'><i class='fa fa-check'></i></div>");
                setTimeout(function () {
                    $(".modal-mask").find('.circle-done').addClass('ok');
                }, 30);
            }
            setTimeout(function () {
                $(".modal-mask").remove();
                $("#ajaxModal").modal('toggle');
                settings.onModalClose();
            }, 1000);
        }


        this.closeModal = function () {
            closeAjaxModal(true);
        };

        return this;
    };
})(jQuery);

var getWeekRange = function (date) {
    //set first and last day of week
    if (!date)
        date = moment().format("YYYY-MM-DD");

    var dayOfWeek = moment(date).format("E"),
            diff = dayOfWeek - AppHelper.settings.firstDayOfWeek,
            range = {};

    if (diff < 7) {
        range.firstDateOfWeek = moment(date).subtract(diff, 'days').format("YYYY-MM-DD");
    } else {
        range.firstDateOfWeek = moment(date).format("YYYY-MM-DD");
    }

    if (diff < 0) {
        range.firstDateOfWeek = moment(range.firstDateOfWeek).subtract(7, 'days').format("YYYY-MM-DD");
    }

    range.lastDateOfWeek = moment(range.firstDateOfWeek).add(6, 'days').format("YYYY-MM-DD");
    return range;
};

var prepareDefaultFilters = function (settings) {

    var prepareDefaultDateRangeFilterParams = function (settings) {
        if (settings.dateRangeType === "daily") {
            settings.filterParams.start_date = moment().format(settings._inputDateFormat);
            settings.filterParams.end_date = settings.filterParams.start_date;
        } else if (settings.dateRangeType === "monthly") {
            var daysInMonth = moment().daysInMonth(),
                    yearMonth = moment().format("YYYY-MM");
            settings.filterParams.start_date = yearMonth + "-01";
            settings.filterParams.end_date = yearMonth + "-" + daysInMonth;
        } else if (settings.dateRangeType === "yearly") {
            var year = moment().format("YYYY");
            settings.filterParams.start_date = year + "-01-01";
            settings.filterParams.end_date = year + "-12-31";
        } else if (settings.dateRangeType === "weekly") {
            var range = getWeekRange();
            settings.filterParams.start_date = range.firstDateOfWeek;
            settings.filterParams.end_date = range.lastDateOfWeek;
        }
        return settings;
    };


    var prepareDefaultCheckBoxFilterParams = function (settings) {
        var values = [],
                name = "";
        $.each(settings.checkBoxes, function (index, option) {
            name = option.name;
            if (option.isChecked) {
                values.push(option.value);
            }
        });
        settings.filterParams[name] = values;
        return settings;
    };

    var prepareDefaultMultiSelectilterParams = function (settings) {

        $.each(settings.multiSelect, function (index, option) {
            var values = [];
            $.each(option.options, function (index, listOption) {
                if (listOption.isChecked) {
                    values.push(listOption.value);
                }
            });

            settings.filterParams[option.name] = values;
        });

        return settings;
    };

    var prepareDefaultRadioFilterParams = function (settings) {
        $.each(settings.radioButtons, function (index, option) {
            if (option.isChecked) {
                settings.filterParams[option.name] = option.value;
            }
        });
        return settings;
    };

    var prepareDefaultDropdownFilterParams = function (settings) {
        $.each(settings.filterDropdown || [], function (index, dropdown) {
            $.each(dropdown.options, function (index, option) {
                if (option.isSelected) {
                    settings.filterParams[dropdown.name] = option.id;
                }
            });
        });
        return settings;
    };

    var prepareDefaultrSingleDatepickerFilterParams = function (settings) {
        $.each(settings.singleDatepicker || [], function (index, datepicker) {
            $.each(datepicker.options || [], function (index, option) {
                if (option.isSelected) {
                    settings.filterParams[datepicker.name] = option.value;
                }
            });
        });
        return settings;
    };


    var prepareDefaultrRngeDatepickerFilterParams = function (settings) {
        $.each(settings.rangeDatepicker || [], function (index, datepicker) {

            if (datepicker.startDate && datepicker.startDate.value) {
                settings.filterParams[datepicker.startDate.name] = datepicker.startDate.value;
            }

            if (datepicker.startDate && datepicker.endDate.value) {
                settings.filterParams[datepicker.endDate.name] = datepicker.endDate.value;
            }

        });
        return settings;
    };



    settings = prepareDefaultDateRangeFilterParams(settings);
    settings = prepareDefaultCheckBoxFilterParams(settings);
    settings = prepareDefaultMultiSelectilterParams(settings);
    settings = prepareDefaultRadioFilterParams(settings);
    settings = prepareDefaultDropdownFilterParams(settings);
    settings = prepareDefaultrSingleDatepickerFilterParams(settings);
    settings = prepareDefaultrRngeDatepickerFilterParams(settings);


    return settings;
};

var buildFilterDom = function (settings, $instanceWrapper, $instance) {


    var reloadInstance = function ($instance, settings) {
        if ($instance.is("table")) {
            $instance.appTable({reload: true, filterParams: settings.filterParams});
        } else {
            $instance.appFilters({reload: true, filterParams: settings.filterParams});
        }
    };


    //prepare search box
    if (settings.search && settings.search.show !== false) {
        var searchDom = '<div class="DTTT_container">'
                + '<input type="search" class="custom-filter-search" name="' + settings.search.name + '" placeholder="' + settings.customLanguage.searchPlaceholder + '">'
                + '</div>';
        $instanceWrapper.find(".custom-toolbar").append(searchDom);

        var wait;
        $instanceWrapper.find(".custom-filter-search").keyup(function () {
            appLoader.show();

            var $search = $(this);
            clearTimeout(wait);

            wait = setTimeout(function () {
                settings.filterParams[settings.search.name] = $search.val();
                reloadInstance($instance, settings);
            }, 700);


        });
    }

    //bind refresh icon
    if (settings.reloadSelector && $(settings.reloadSelector).length) {
        $(settings.reloadSelector).click(function () {
            appLoader.show();
            reloadInstance($instance, settings);
        });
    }



    //build date wise filter selectors
    if (settings.dateRangeType) {
        var dateRangeFilterDom = '<div class="mr15 DTTT_container">'
                + '<button data-act="prev" class="btn btn-default date-range-selector"><i class="fa fa-chevron-left"></i></button>'
                + '<button data-act="datepicker" class="btn btn-default" style="margin: -1px"></button>'
                + '<button data-act="next"  class="btn btn-default date-range-selector"><i class="fa fa-chevron-right"></i></button>'
                + '</div>';
        $instanceWrapper.find(".custom-toolbar").append(dateRangeFilterDom);

        var $datepicker = $instanceWrapper.find("[data-act='datepicker']"),
                $dateRangeSelector = $instanceWrapper.find(".date-range-selector");

        //init single day selector
        if (settings.dateRangeType === "daily") {
            var initSingleDaySelectorText = function ($elector) {
                if (settings.filterParams.start_date === moment().format(settings._inputDateFormat)) {
                    $elector.html(settings.customLanguage.today);
                } else if (settings.filterParams.start_date === moment().subtract(1, 'days').format(settings._inputDateFormat)) {
                    $elector.html(settings.customLanguage.yesterday);
                } else if (settings.filterParams.start_date === moment().add(1, 'days').format(settings._inputDateFormat)) {
                    $elector.html(settings.customLanguage.tomorrow);
                } else {
                    $elector.html(moment(settings.filterParams.start_date).format("Do MMMM YYYY"));
                }
            };
            // prepareDefaultDateRangeFilterParams();
            initSingleDaySelectorText($datepicker);

            //bind the click events
            $datepicker.datepicker({
                format: settings._inputDateFormat,
                autoclose: true,
                todayHighlight: true,
                language: "custom"
            }).on('changeDate', function (e) {
                var date = moment(e.date).format(settings._inputDateFormat);
                settings.filterParams.start_date = date;
                settings.filterParams.end_date = date;
                initSingleDaySelectorText($datepicker);

                reloadInstance($instance, settings);

            });

            $dateRangeSelector.click(function () {
                var type = $(this).attr("data-act"), date = "";
                if (type === "next") {
                    date = moment(settings.filterParams.start_date).add(1, 'days').format(settings._inputDateFormat);
                } else if (type === "prev") {
                    date = moment(settings.filterParams.start_date).subtract(1, 'days').format(settings._inputDateFormat)
                }
                settings.filterParams.start_date = date;
                settings.filterParams.end_date = date;
                initSingleDaySelectorText($datepicker);
                reloadInstance($instance, settings);
            });
        }


        //init month selector
        if (settings.dateRangeType === "monthly") {
            var initMonthSelectorText = function ($elector) {
                $elector.html(moment(settings.filterParams.start_date).format("MMMM YYYY"));
            };

            //prepareDefaultDateRangeFilterParams();
            initMonthSelectorText($datepicker);

            //bind the click events
            $datepicker.datepicker({
                format: "YYYY-MM",
                viewMode: "months",
                minViewMode: "months",
                autoclose: true,
                language: "custom",
            }).on('changeDate', function (e) {
                var date = moment(e.date).format(settings._inputDateFormat);
                var daysInMonth = moment(date).daysInMonth(),
                        yearMonth = moment(date).format("YYYY-MM");
                settings.filterParams.start_date = yearMonth + "-01";
                settings.filterParams.end_date = yearMonth + "-" + daysInMonth;
                initMonthSelectorText($datepicker);
                reloadInstance($instance, settings);
            });

            $dateRangeSelector.click(function () {
                var type = $(this).attr("data-act"),
                        startDate = moment(settings.filterParams.start_date),
                        endDate = moment(settings.filterParams.end_date);
                if (type === "next") {
                    var nextMonth = startDate.add(1, 'months'),
                            daysInMonth = nextMonth.daysInMonth(),
                            yearMonth = nextMonth.format("YYYY-MM");

                    startDate = yearMonth + "-01";
                    endDate = yearMonth + "-" + daysInMonth;

                } else if (type === "prev") {
                    var lastMonth = startDate.subtract(1, 'months'),
                            daysInMonth = lastMonth.daysInMonth(),
                            yearMonth = lastMonth.format("YYYY-MM");

                    startDate = yearMonth + "-01";
                    endDate = yearMonth + "-" + daysInMonth;
                }

                settings.filterParams.start_date = startDate;
                settings.filterParams.end_date = endDate;

                initMonthSelectorText($datepicker);
                reloadInstance($instance, settings);
            });
        }

        //init year selector
        if (settings.dateRangeType === "yearly") {
            var inityearSelectorText = function ($elector) {
                $elector.html(moment(settings.filterParams.start_date).format("YYYY"));
            };
            // prepareDefaultDateRangeFilterParams();
            inityearSelectorText($datepicker);

            //bind the click events
            $datepicker.datepicker({
                format: "YYYY-MM",
                viewMode: "years",
                minViewMode: "years",
                autoclose: true,
                language: "custom"
            }).on('changeDate', function (e) {
                var date = moment(e.date).format(settings._inputDateFormat),
                        year = moment(date).format("YYYY");
                settings.filterParams.start_date = year + "-01-01";
                settings.filterParams.end_date = year + "-12-31";
                inityearSelectorText($datepicker);
                reloadInstance($instance, settings);
            });

            $dateRangeSelector.click(function () {
                var type = $(this).attr("data-act"),
                        startDate = moment(settings.filterParams.start_date),
                        endDate = moment(settings.filterParams.end_date);
                if (type === "next") {
                    startDate = startDate.add(1, 'years').format(settings._inputDateFormat);
                    endDate = endDate.add(1, 'years').format(settings._inputDateFormat);
                } else if (type === "prev") {
                    startDate = startDate.subtract(1, 'years').format(settings._inputDateFormat);
                    endDate = endDate.subtract(1, 'years').format(settings._inputDateFormat);
                }
                settings.filterParams.start_date = startDate;
                settings.filterParams.end_date = endDate;
                inityearSelectorText($datepicker);
                reloadInstance($instance, settings);
            });
        }

        //init week selector
        if (settings.dateRangeType === "weekly") {
            var initWeekSelectorText = function ($elector) {
                var from = moment(settings.filterParams.start_date).format("Do MMM"),
                        to = moment(settings.filterParams.end_date).format("Do MMM, YYYY");
                $datepicker.datepicker({
                    format: "YYYY-MM-DD",
                    autoclose: true,
                    calendarWeeks: true,
                    language: "custom",
                    weekStart: AppHelper.settings.firstDayOfWeek
                });
                $elector.html(from + " - " + to);
            };

            //prepareDefaultDateRangeFilterParams();
            initWeekSelectorText($datepicker);

            //bind the click events
            $dateRangeSelector.click(function () {
                var type = $(this).attr("data-act"),
                        startDate = moment(settings.filterParams.start_date),
                        endDate = moment(settings.filterParams.end_date);
                if (type === "next") {
                    startDate = startDate.add(7, 'days').format(settings._inputDateFormat);
                    endDate = endDate.add(7, 'days').format(settings._inputDateFormat);
                } else if (type === "prev") {
                    startDate = startDate.subtract(7, 'days').format(settings._inputDateFormat);
                    endDate = endDate.subtract(7, 'days').format(settings._inputDateFormat);
                }
                settings.filterParams.start_date = startDate;
                settings.filterParams.end_date = endDate;
                initWeekSelectorText($datepicker);
                reloadInstance($instance, settings);
            });

            $datepicker.datepicker({
                format: settings._inputDateFormat,
                autoclose: true,
                calendarWeeks: true,
                language: "custom",
                weekStart: AppHelper.settings.firstDayOfWeek
            }).on("show", function () {
                $(".datepicker").addClass("week-view");
                $(".datepicker-days").find(".active").siblings(".day").addClass("active");
            }).on('changeDate', function (e) {
                var range = getWeekRange(e.date);
                settings.filterParams.start_date = range.firstDateOfWeek;
                settings.filterParams.end_date = range.lastDateOfWeek;
                initWeekSelectorText($datepicker);
                reloadInstance($instance, settings);
            });
        }
    }




    //build checkbox filter
    if (typeof settings.checkBoxes[0] !== 'undefined') {
        var checkboxes = "", values = [], name = "";
        $.each(settings.checkBoxes, function (index, option) {
            var checked = "", active = "";
            name = option.name;
            if (option.isChecked) {
                checked = " checked";
                active = " active";
                values.push(option.value);
            }
            checkboxes += '<label class="btn btn-default ' + active + '">';
            checkboxes += '<input type="checkbox" name="' + option.name + '" value="' + option.value + '" autocomplete="off" ' + checked + '>' + option.text;
            checkboxes += '</label>';
        });
        settings.filterParams[name] = values;
        var checkboxDom = '<div class="mr15 DTTT_container">'
                + '<div class="btn-group filter" data-act="checkbox" data-toggle="buttons">'
                + checkboxes
                + '</div>'
                + '</div>';
        $instanceWrapper.find(".custom-toolbar").append(checkboxDom);

        var $checkbox = $instanceWrapper.find("[data-act='checkbox']");
        $checkbox.click(function () {
            var $selector = $(this);
            setTimeout(function () {
                var values = [],
                        name = "";
                $selector.parent().find("input:checkbox").each(function () {
                    name = $(this).attr("name");
                    if ($(this).is(":checked")) {
                        values.push($(this).val());
                    }
                });
                settings.filterParams[name] = values;
                reloadInstance($instance, settings);
            });
        });
    }


    //build multiselect filter
    if (typeof settings.multiSelect[0] !== 'undefined') {

        $.each(settings.multiSelect, function (index, option) {

            var multiSelect = "", values = [];

            $.each(option.options, function (index, listOption) {
                var active = "";

                if (listOption.isChecked) {
                    active = " active";
                    values.push(listOption.value);
                }
                //<li class=" list-group-item clickable toggle-table-column" data-column="1">ID</li>
                multiSelect += '<li class="list-group-item clickable ' + active + '" data-name="' + option.name + '" data-value="' + listOption.value + '">';
                multiSelect += listOption.text;
                multiSelect += '</li>';
            });


            multiSelect = "<ul class='list-group dropdown-menu' data-act='multiselect'>" + multiSelect + "</ul>";

            settings.filterParams[option.name] = values;
            var multiSelectDom = '<div class="mr15 DTTT_container">'
                    + '<span class="dropdown inline-block filter-multi-select">'
                    + '<button class="btn btn-default dropdown-toggle " type="button" data-toggle="dropdown" aria-expanded="true">' + option.text + ' <span class="caret"></span> </button>'
                    + multiSelect
                    + '</span>'
                    + '</div>';

            $instanceWrapper.find(".custom-toolbar").append(multiSelectDom);

            var $multiselect = $instanceWrapper.find("[data-name='" + option.name + "']");
            $multiselect.click(function () {
                var $selector = $(this);
                $selector.toggleClass("active");
                setTimeout(function () {
                    var values = [],
                            name = "";
                    $selector.parent().find("li").each(function () {
                        name = $(this).attr("data-name");
                        if ($(this).hasClass("active")) {
                            values.push($(this).attr("data-value"));
                        }
                    });
                    settings.filterParams[name] = values;
                    reloadInstance($instance, settings);
                });
                return false;
            });

        });


    }




    //build radio button filter
    if (typeof settings.radioButtons[0] !== 'undefined') {
        var radiobuttons = "";
        $.each(settings.radioButtons, function (index, option) {
            var checked = "", active = "";
            if (option.isChecked) {
                checked = " checked";
                active = " active";
                settings.filterParams[option.name] = option.value;
            }
            radiobuttons += '<label class="btn btn-default ' + active + '">';
            radiobuttons += '<input type="radio" name="' + option.name + '" value="' + option.value + '" autocomplete="off" ' + checked + '>' + option.text;
            radiobuttons += '</label>';
        });
        var radioDom = '<div class="mr15 DTTT_container">'
                + '<div class="btn-group filter" data-act="radio" data-toggle="buttons">'
                + radiobuttons
                + '</div>'
                + '</div>';
        $instanceWrapper.find(".custom-toolbar").append(radioDom);

        var $radioButtons = $instanceWrapper.find("[data-act='radio']");
        $radioButtons.click(function () {
            var $selector = $(this);
            setTimeout(function () {
                $selector.parent().find("input:radio").each(function () {
                    if ($(this).is(":checked")) {
                        settings.filterParams[$(this).attr("name")] = $(this).val();
                    }
                });
                reloadInstance($instance, settings);
            });
        });
    }


    //build singleDatepicker filter
    if (typeof settings.singleDatepicker[0] !== 'undefined') {

        $.each(settings.singleDatepicker, function (index, datePicker) {

            var options = " ", value = "", selectedText = "";

            if (!datePicker.options)
                datePicker.options = [];

            //add custom datepicker selector
            datePicker.options.push({value: "show-date-picker", text: AppLanugage.custom});

            //prepare custom list
            $.each(datePicker.options, function (index, option) {
                var isSelected = "";
                if (option.isSelected) {
                    isSelected = "active";
                    value = option.value;
                    selectedText = option.text;
                }

                options += '<div class="list-group-item ' + isSelected + '" data-value="' + option.value + '">' + option.text + '</div>';
            });

            if (!selectedText) {
                selectedText = "- " + datePicker.defaultText + " -";
                options = '<div class="list-group-item active" data-value="">' + selectedText + '</div>' + options;
            }


            //set filter params
            if (datePicker.name) {
                settings.filterParams[datePicker.name] = value;
            }

            var reloadDatePickerFilter = function (date) {
                settings.filterParams[datePicker.name] = date;
                reloadInstance($instance, settings);
            };

            var getDatePickerText = function (text) {
                return text + "<i class='ml10 fa fa-caret-down text-off'></i>";
            };



            //prepare DOM
            var customList = '<div class="datepicker-custom-list list-group mb0">'
                    + options
                    + '</div>';

            var selectDom = '<div class="mr15 DTTT_container">'
                    + '<button name="' + datePicker.name + '" class="btn datepicker-custom-selector">'
                    + getDatePickerText(selectedText)
                    + '</button>'
                    + '</div>';
            $instanceWrapper.find(".custom-toolbar").append(selectDom);

            var $datePicker = $instanceWrapper.find("[name='" + datePicker.name + "']"),
                    showCustomRange = typeof datePicker.options[1] === 'undefined' ? false : true; //don't show custom range if options not > 1

            //init datepicker
            $datePicker.datepicker({
                format: settings._inputDateFormat,
                autoclose: true,
                todayHighlight: true,
                language: "custom",
                weekStart: AppHelper.settings.firstDayOfWeek,
                orientation: "bottom",
            }).on("show", function () {

                //has custom dates, show them otherwise show the datepicker
                if (showCustomRange) {
                    $(".datepicker-days, .datepicker-months, .datepicker-years, .datepicker-decades, .table-condensed").hide();
                    $(".datepicker-custom-list").show();
                    if (!$(".datepicker-custom-list").length) {
                        $(".datepicker").append(customList);

                        //bind click events
                        $(".datepicker .list-group-item").click(function () {
                            $(".datepicker .list-group-item").removeClass("active");
                            $(this).addClass("active");
                            var value = $(this).attr("data-value");
                            //show datepicker for custom date
                            if (value === "show-date-picker") {
                                $(".datepicker-custom-list, .datepicker-months, .datepicker-years, .datepicker-decades, .table-condensed").hide();
                                $(".datepicker-days, .table-condensed").show();
                            } else {
                                $(".datepicker").hide();

                                if (moment(value, settings._inputDateFormat).isValid()) {
                                    value = moment(value, settings._inputDateFormat).format(settings._inputDateFormat);
                                }

                                $datePicker.html(getDatePickerText($(this).html()));
                                reloadDatePickerFilter(value);
                            }
                        });
                    }
                }
            }).on('changeDate', function (e) {
                $datePicker.html(getDatePickerText(moment(e.date, settings._inputDateFormat).format("Do MMMM YYYY")));
                reloadDatePickerFilter(moment(e.date, settings._inputDateFormat).format(settings._inputDateFormat));
            });

        });
    }


    //build rangeDatepicker filter
    if (typeof settings.rangeDatepicker[0] !== 'undefined') {

        $.each(settings.rangeDatepicker, function (index, datePicker) {

            var startDate = datePicker.startDate || {},
                    endDate = datePicker.endDate || {},
                    showClearButton = datePicker.showClearButton ? true : false,
                    emptyText = '<i class="fa fa-calendar"></i>',
                    startButtonText = startDate.value ? moment(startDate.value, settings._inputDateFormat).format("Do MMMM YYYY") : emptyText,
                    endButtonText = endDate.value ? moment(endDate.value, settings._inputDateFormat).format("Do MMMM YYYY") : emptyText;

            //set filter params
            settings.filterParams[startDate.name] = startDate.value;
            settings.filterParams[endDate.name] = endDate.value;

            var reloadDateRangeFilter = function (name, date) {
                settings.filterParams[name] = date;
                reloadInstance($instance, settings);
            };


            //prepare DOM
            var selectDom = '<div class="mr15 DTTT_container">'
                    + '<div class="input-daterange input-group">'
                    + '<button class="btn btn-default form-control" name="' + startDate.name + '" data-date="' + startDate.value + '">' + startButtonText + '</button>'
                    + '<span class="input-group-addon">-</span>'
                    + '<button class="btn btn-default form-control" name="' + endDate.name + '" data-date="' + endDate.value + '">' + endButtonText + ''
                    + '</div>'
                    + '</div>';

            $instanceWrapper.find(".custom-toolbar").append(selectDom);

            var $datePicker = $instanceWrapper.find(".input-daterange"),
                    inputs = $datePicker.find('button').toArray();

            //init datepicker
            $datePicker.datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                language: "custom",
                weekStart: AppHelper.settings.firstDayOfWeek,
                orientation: "bottom",
                inputs: inputs
            }).on('changeDate', function (e) {
                var date = moment(e.date, settings._inputDateFormat).format(settings._inputDateFormat);

                //set save value if anyone is empty
                if (!settings.filterParams[startDate.name]) {
                    settings.filterParams[startDate.name] = date;
                }

                if (!settings.filterParams[endDate.name]) {
                    settings.filterParams[endDate.name] = date;
                }

                reloadDateRangeFilter($(e.target).attr("name"), date);

                //show button text
                $(inputs[0]).html(moment(settings.filterParams[startDate.name], settings._inputDateFormat).format("Do MMMM YYYY"));
                $(inputs[1]).html(moment(settings.filterParams[endDate.name], settings._inputDateFormat).format("Do MMMM YYYY"));

            }).on("show", function () {

                //show clear button
                if (showClearButton) {
                    $(".datepicker-clear-selection").show();
                    if (!$(".datepicker-clear-selection").length) {
                        $(".datepicker").append("<div class='datepicker-clear-selection p5 clickable text-center'>" + AppLanugage.clear + "</div>");

                        //bind click event for clear button
                        $(".datepicker .datepicker-clear-selection").click(function () {
                            settings.filterParams[startDate.name] = "";
                            reloadDateRangeFilter(endDate.name, "");

                            $(inputs[0]).html(emptyText);
                            $(inputs[1]).html(emptyText);
                            $(".datepicker").hide();
                        });
                    }
                }
            });

        });
    }


    //build dropdown filter
    if (typeof settings.filterDropdown[0] !== 'undefined') {
        var radiobuttons = "";
        $.each(settings.filterDropdown, function (index, dropdown) {
            var optons = "", selectedValue = "";

            $.each(dropdown.options, function (index, option) {
                var isSelected = "";
                if (option.isSelected) {
                    isSelected = "selected";
                    selectedValue = option.id;
                }
                optons += '<option ' + isSelected + ' value="' + option.id + '">' + option.text + '</option>';
            });

            if (dropdown.name) {
                settings.filterParams[dropdown.name] = selectedValue;
            }

            var selectDom = '<div class="mr15 DTTT_container">'
                    + '<select class="' + dropdown.class + '" name="' + dropdown.name + '">'
                    + optons
                    + '</select>'
                    + '</div>';
            $instanceWrapper.find(".custom-toolbar").append(selectDom);

            var $dropdown = $instanceWrapper.find("[name='" + dropdown.name + "']");
            if (window.Select2 !== undefined) {
                $dropdown.select2();
            }


            $dropdown.change(function () {
                var $selector = $(this),
                        filterName = $selector.attr("name"),
                        value = $selector.val();

                //set the new value to settings
                settings.filterParams[filterName] = value;

                //check if there any dependent files,
                //reset the dependent fields if this value is empty
                //re-load the dependent fields if this value is not empty

                if (dropdown.dependent && dropdown.dependent.length) {
                    prepareDependentFilter(filterName, value, settings.filterDropdown, $instanceWrapper, settings.filterParams);
                }

                reloadInstance($instance, settings);
            });
        });
    }

    var prepareDependentFilter = function (filterName, filterValue, filterDropdown, $wrapper, filterParams) {

        //check all droplowns and prepre the dependency dropdown list

        $.each(filterDropdown, function (index, option) {

            //is there any dependency for selected field (filterName)? Prepare the dropdown list 
            if (option.dependency && option.dependency.length && option.dependency.indexOf(filterName) !== -1) {

                var $dependencySelector = $wrapper.find("select[name=" + option.name + "]"); //select box

                //we'll call ajax to get the data list
                if (((option.selfDependency && !filterValue) || filterValue) && option.dataSource) {
                    $.ajax({
                        url: option.dataSource,
                        data: filterParams,
                        type: "POST",
                        dataType: 'json',
                        success: function (response) {

                            //if we found the dropdown list, we'll show the options in dropdown
                            if (response && response.length) {
                                var newOptions = "",
                                        firstValue = "";

                                $.each(response, function (index, value) {

                                    if (!index) {
                                        firstValue = value.id; //auto select the first option in select box
                                    }

                                    newOptions += "<option value='" + value.id + "'>" + value.text + "</option>";
                                });

                                //set the new dropdown list in select box
                                $dependencySelector.html(newOptions);
                                $dependencySelector.select2("val", firstValue);
                            }
                        }
                    });

                } else {
                    //no value selected in parent, reset the dropdown box

                    var $firstOption = $dependencySelector.find("option:first");
                    $dependencySelector.html("<option value='" + $firstOption.val() + "'>" + $firstOption.html() + "</option>");
                    $dependencySelector.select2("val", $firstOption.val());
                }

                //reset the filter param
                var $firstOption = $dependencySelector.find("option:first");
                filterParams[option.name] = $firstOption.val();

            }

        });
    };

};




if (typeof TableTools != 'undefined') {
    TableTools.DEFAULTS.sSwfPath = AppHelper.assetsDirectory + "js/datatable/TableTools/swf/copy_csv_xls_pdf.swf";
}


(function ($) {
    //appTable using datatable
    $.fn.appTable = function (options) {

        //set default display length
        var displayLength = AppHelper.settings.displayLength * 1;

        if (isNaN(displayLength) || !displayLength) {
            displayLength = 10;
        }

        var defaults = {
            source: "", //data url
            xlsColumns: [], // array of excel exportable column numbers
            pdfColumns: [], // array of pdf exportable column numbers
            printColumns: [], // array of printable column numbers
            columns: [], //column title and options
            order: [[0, "asc"]], //default sort value
            hideTools: false, //show/hide tools section
            displayLength: displayLength, //default rows per page
            dateRangeType: "", // type: daily, weekly, monthly, yearly. output params: start_date and end_date
            checkBoxes: [], // [{text: "Caption", name: "status", value: "in_progress", isChecked: true}] 
            multiSelect: [], // [{text: "Caption", name: "status", options:[{text: "Caption", value: "in_progress", isChecked: true}]}] 
            radioButtons: [], // [{text: "Caption", name: "status", value: "in_progress", isChecked: true}] 
            filterDropdown: [], // [{id: 10, text:'Caption', isSelected:true}] 
            singleDatepicker: [], // [{name: '', value:'', options:[]}] 
            rangeDatepicker: [], // [{startDate:{name:"", value:""},endDate:{name:"", value:""}}] 
            stateSave: true, //save user state
            isMobile: window.outerWidth < 800 ? true : false,
            responsive: window.outerWidth < 800 ? true : false, //by default, apply the responsive design only on the mobile view
            stateDuration: 60 * 60 * 24 * 60, //remember for 60 days
            columnShowHideOption: true, //show a option to show/hide the columns,
            tableRefreshButton: false, //show a option to refresh the table
            filterParams: {datatable: true}, //will post this vales on source url
            onDeleteSuccess: function () {
            },
            onUndoSuccess: function () {
            },
            onInitComplete: function () {
            },
            customLanguage: {
                noRecordFoundText: AppLanugage.noRecordFound,
                searchPlaceholder: AppLanugage.search,
                printButtonText: AppLanugage.print,
                excelButtonText: AppLanugage.excel,
                printButtonToolTip: AppLanugage.printButtonTooltip,
                today: AppLanugage.today,
                yesterday: AppLanugage.yesterday,
                tomorrow: AppLanugage.tomorrow
            },
            footerCallback: function (row, data, start, end, display) {
            },
            rowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            },
            summation: "", /* {column: 5, dataType: 'currency'}  dataType:currency, time */
            onRelaodCallback: function () {
            }
        };

        var $instance = $(this);

        //check if this binding with a table or not
        if (!$instance.is("table")) {
            console.log("appTable: Element must have to be a table", this);
            return false;
        }


        var settings = $.extend({}, defaults, options);


        // reload

        if (settings.reload) {
            var table = $(this).dataTable();
            var instanceSettings = window.InstanceCollection[$(this).selector];

            if (!instanceSettings) {
                instanceSettings = settings;
            }

            table.fnReloadAjax(instanceSettings.filterParams);

            if ($(this).data("onRelaodCallback")) {
                $(this).data("onRelaodCallback")(table, instanceSettings.filterParams);
            }

            return false;
        }

        // add/edit row
        if (settings.newData) {

            var table = $(this).dataTable();

            if (settings.dataId) {
                //check for existing row; if found, delete the row; 

                var $row = $(this).find("[data-post-id='" + settings.dataId + "']");

                if (!$row.length) {
                    $row = $(this).find("[data-index-id='" + settings.dataId + "']");
                }

                if ($row.length) {
                    // .fnDeleteRow($row.closest('tr'));

                    table.api().row(table.api().row($row.closest('tr')).index()).data(settings.newData);

                    table.fnUpdateRow(null, table.api().page()); //update existing row
                } else {
                    table.fnUpdateRow(settings.newData); //add new row
                }


            } else if (settings.rowDeleted) {
                table.fnUpdateRow(settings.newData, table.api().page(), true); //refresh row after delete
            } else {
                table.fnUpdateRow(settings.newData); //add new row
            }

            return false;
        }

        //add nowrap class in responsive view
        if (settings.responsive) {
            $instance.addClass("nowrap");
        }



        var _prepareFooter = function (settings, page, lable) {
            var tr = "",
                    trSection = '';

            if (page === "all") {
                trSection = 'data-section="all_pages"';
            }

            tr += "<tr " + trSection + ">";

            $.each(settings.columns, function (index, column) {

                var thAttr = "class = 'tf-blank' ",
                        thLable = " ";


                if (settings.summation[0] && settings.summation[0].column - 1 === index) {
                    thLable = lable;
                    thAttr = "class = 'tf-lable' ";
                }

                $.each(settings.summation, function (fIndex, sumColumn) {
                    if (sumColumn.column === index) {
                        thAttr = "class = 'tf-result text-right' ";
                        thAttr += 'data-' + page + '-page="' + sumColumn.column + '"';
                    }
                });

                tr += "<th " + thAttr + ">";
                tr += thLable;
                tr += "</th>";

            });
            tr += "</tr>";

            return tr;

        };

        //add summation footer 
        //don't add it on mobile view. We'll show another field in mobile view.

        if (settings.summation && settings.summation.length && !settings.isMobile) {
            var content = "<tfoot>";

            content += _prepareFooter(settings, 'current', AppLanugage.total);
            content += _prepareFooter(settings, 'all', AppLanugage.totalOfAllPages);

            content += "</tfoot>";

            $instance.html(content);
        }




        settings._visible_columns = [];
        $.each(settings.columns, function (index, column) {
            if (column.visible !== false) {
                settings._visible_columns.push(index);
            }
        });


        settings._exportable = settings.xlsColumns.length + settings.pdfColumns.length + settings.printColumns.length;
        settings._firstDayOfWeek = AppHelper.settings.firstDayOfWeek || 0;
        settings._inputDateFormat = "YYYY-MM-DD";


        settings = prepareDefaultFilters(settings);



        var datatableOptions = {
            // sAjaxSource: settings.source,
            ajax: {
                url: settings.source,
                type: "POST",
                data: settings.filterParams
            },
            sServerMethod: "POST",
            columns: settings.columns,
            bProcessing: true,
            iDisplayLength: settings.displayLength,
            aLengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, AppLanugage.all]],
            bAutoWidth: false,
            bSortClasses: false,
            order: settings.order,
            stateSave: settings.stateSave,
            responsive: settings.responsive,
            fnStateLoadParams: function (oSettings, oData) {

                //if the stateSave is true, we'll remove the search value after next reload. 
                if (oData && oData.search) {
                    oData.search.search = "";
                }

            },
            stateDuration: settings.stateDuration,
            fnInitComplete: function () {
                settings.onInitComplete(this);
            },
            language: {
                lengthMenu: "_MENU_",
                zeroRecords: settings.customLanguage.noRecordFoundText,
                info: "_START_-_END_ / _TOTAL_",
                sInfo: "_START_-_END_ / _TOTAL_",
                infoFiltered: "(_MAX_)",
                search: "",
                searchPlaceholder: settings.customLanguage.searchPlaceholder,
                sInfoEmpty: "0-0 / 0",
                sInfoFiltered: "(_MAX_)",
                sInfoPostFix: "",
                sInfoThousands: ",",
                sProcessing: "<div class='table-loader'><span class='loading'></span></div>",
                "oPaginate": {
                    "sPrevious": "<i class='fa fa-angle-double-left'></i>",
                    "sNext": "<i class='fa fa-angle-double-right'></i>"
                }

            },
            sDom: "",
            footerCallback: function (row, data, start, end, display) {
                var instance = this;
                if (settings.summation) {

                    var pageInfo = instance.api().page.info(),
                            summationContent = "",
                            pageTotalContent = "",
                            allPageTotalContent = "";

                    if (pageInfo.recordsTotal) {
                        $(instance).find("tfoot").show();
                    } else {
                        $(instance).find("tfoot").hide();
                        return false;
                    }

                    $.each(settings.summation, function (index, option) {
                        // total value of current page
                        var pageTotal = calculateDatatableTotal(instance, option.column, function (currentValue) {

                            //if we get <b> tag, we'll assume that is a group total. ignore the value
                            if (currentValue && !currentValue.startsWith("<b>")) {
                                if (option.dataType === "currency") {
                                    return unformatCurrency(currentValue);
                                } else if (option.dataType === "time") {
                                    return moment.duration(currentValue).asSeconds();
                                } else if (option.dataType === "number") {
                                    return unformatCurrency(currentValue);
                                } else {
                                    return currentValue;
                                }
                            } else {
                                return 0;
                            }

                        }, true);

                        if (option.dataType === "currency") {
                            pageTotal = toCurrency(pageTotal, option.currencySymbol);
                        } else if (option.dataType === "time") {
                            pageTotal = secondsToTimeFormat(pageTotal);
                        } else if (option.dataType === "number") {
                            pageTotal = toCurrency(pageTotal, "none");
                        }

                        var pagTotalTitle = table.column(option.column).header();
                        if (pagTotalTitle) {
                            pageTotalContent += "<div class='box'><div class='box-content'>" + $(pagTotalTitle).html() + "</div><div class='box-content text-right'>" + pageTotal + "</div></div>";
                        }

                        $(instance).find("[data-current-page=" + option.column + "]").html(pageTotal);

                        // total value of all pages
                        if (pageInfo.pages > 1) {
                            $(instance).find("[data-section='all_pages']").show();
                            var total = calculateDatatableTotal(instance, option.column, function (currentValue) {

                                //if we get <b> tag, we'll assume that is a group total. ignore the value
                                if (currentValue && !currentValue.startsWith("<b>")) {
                                    if (option.dataType === "currency") {
                                        return unformatCurrency(currentValue);
                                    } else if (option.dataType === "time") {
                                        return moment.duration(currentValue).asSeconds();
                                    } else if (option.dataType === "number") {
                                        return unformatCurrency(currentValue);
                                    } else {
                                        return currentValue;
                                    }
                                } else {
                                    return 0;
                                }
                            });

                            if (option.dataType === "currency") {
                                total = toCurrency(total, option.currencySymbol);
                            } else if (option.dataType === "time") {
                                total = secondsToTimeFormat(total);
                            } else if (option.dataType === "number") {
                                total = toCurrency(total, "none");
                            }

                            var title = table.column(option.column).header();
                            if (title) {
                                allPageTotalContent += "<div class='box'><div class='box-content'>" + $(title).html() + "</div><div class='box-content text-right'>" + total + "</div></div>";
                            }

                            $(instance).find("[data-all-page=" + option.column + "]").html(total);
                        } else {
                            $(instance).find("[data-section='all_pages']").hide();
                        }
                    });



                    //add summation section for mobile view.

                    if (settings.isMobile) {
                        if (pageTotalContent) {
                            summationContent += "<div class='box'><div class='box-content strong'>" + AppLanugage.total + "</div></div>" + pageTotalContent;
                        }
                        if (allPageTotalContent) {
                            summationContent += "<div class='box'><div class='box-content strong'>" + AppLanugage.totalOfAllPages + "</div></div>" + allPageTotalContent;
                        }

                        $(".summation-section").html(summationContent);
                    }

                }

                settings.footerCallback(row, data, start, end, display, instance);
            },
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                settings.rowCallback(nRow, aData, iDisplayIndex, iDisplayIndexFull);
            }
        };



        //to save the datatatable state in cookie, we'll use the user's reference.
        //sometime the same user (most of the time the admin user) will login to different account to check. 
        //since the table columns are different for different users, 
        //we'll save the coockie based on table reference + user reference 

        if (AppHelper.userId) {

            datatableOptions.stateSaveParams = function (settings, data) {
                if (settings.sInstance.indexOf("-user-ref-") === -1) {
                    settings.sInstance += "-user-ref-" + AppHelper.userId;
                }
            };


            datatableOptions.stateLoadCallback = function (settings) {
                if (settings.sInstance.indexOf("-user-ref-") === -1) {
                    settings.sInstance += "-user-ref-" + AppHelper.userId;
                }
                try {
                    return JSON.parse(
                            (settings.iStateDuration === -1 ? sessionStorage : localStorage).getItem(
                            'DataTables_' + settings.sInstance + '_' + location.pathname
                            )
                            );
                } catch (e) {
                }
            };
        }


        //set custom toolbar
        if (!settings.hideTools) {
            datatableOptions.sDom = "<'datatable-tools'<'col-md-2 toolbar-left-top'l><'col-md-10 custom-toolbar'f>r>t<'datatable-tools clearfix'<'col-md-3'i><'col-md-9'p>>";
        }


        if (settings._exportable) {
            var datatableButtons = [];

            if (settings.xlsColumns.length) {
                //add excel button

                datatableButtons.push({
                    extend: 'excelHtml5',
                    footer: true,
                    text: settings.customLanguage.excelButtonText,
                    exportOptions: {
                        columns: ':visible:not(.option)'
                    }
                });

                /* flash button
                 datatableButtons.push({
                 sExtends: "xls",
                 sButtonText: settings.customLanguage.excelButtonText,
                 mColumns: settings.xlsColumns
                 });
                 */
            }

            if (settings.pdfColumns.length) {
                //add pdf button

                datatableButtons.push({
                    extend: 'pdfHtml5',
                    exportOptions: {
                        // columns: settings.pdfColumns
                        columns: ':visible:not(.option)'
                    }
                });

                /*
                 datatableButtons.push({
                 sExtends: "pdf",
                 mColumns: settings.pdfColumns
                 });
                 */
            }

            if (settings.printColumns.length) {
                datatableButtons.push({
                    extend: 'print',
                    autoPrint: false,
                    text: settings.customLanguage.printButtonText,
                    footer: true,
                    exportOptions: {
                        //  columns: settings.printColumns
                        columns: ':visible:not(.option)'
                    },
                    customize: function (win) {
                        $(win.document.body).closest("html").addClass("dt-print-view");
                    },
                    customizeData: function (a, b, c) {

                    }
                });

            }
            if (!settings.hideTools) {
                datatableOptions.sDom = "<'datatable-tools'<'col-md-2 toolbar-left-top'l><'col-md-10 custom-toolbar'f<'datatable-export DTTT_container'B>>r>t<'datatable-tools clearfix'<'col-md-3'<'summation-section'> i><'col-md-9'p>>";
            }
            datatableOptions.buttons = datatableButtons;

            // datatableOptions.oTableTools = {aButtons: datatableButtons};
        }
        var oTable = $instance.dataTable(datatableOptions),
                $instanceWrapper = $instance.closest(".dataTables_wrapper");

        $instanceWrapper.find('.DTTT_button_print').tooltip({
            placement: 'bottom',
            container: 'body'
        });
        $instanceWrapper.find("select").select2({
            minimumResultsForSearch: -1
        });


        //add the column show/hide option
        if (settings.columnShowHideOption) {

            var tableId = $instance.attr("id");
            table = $instance.DataTable();

            //prepare a popover
            var popover = '<div class="DTTT_container pull-left"><button class="btn btn-default column-show-hide-popover ml15" data-container="body" data-toggle="popover" data-placement="bottom"><i class="fa fa-eye-slash"></button></div>';
            $instanceWrapper.find(".toolbar-left-top").append(popover);

            //prepare the list of columns when opening the popover
            $instanceWrapper.find(".column-show-hide-popover").popover({
                html: true,
                content: function () {
                    var tableColumns = "";

                    $.each(settings.columns, function (index, column) {
                        //in coulmn list, show only the visible columns
                        if (column.visible !== false) {

                            var tableColumn = table.column(index),
                                    columnHiddenClass = "";

                            if (!tableColumn.visible()) {
                                columnHiddenClass = "active";
                            }

                            //prepare a list of columns
                            tableColumns += "<li class='" + columnHiddenClass + " list-group-item clickable toggle-table-column' data-column='" + index + "'>" + column.title + "</li>"
                        }
                    });

                    return "<ul class='list-group' data-table='" + tableId + "'>" + tableColumns + "</ul>";

                }
            });


            //show/hide column when clicking on the list items    

            $instanceWrapper.find(".column-show-hide-popover").on('shown.bs.popover', function () {
                $(".toggle-table-column").on('click', function () {

                    var instanceId = $(this).closest(".list-group").attr("data-table");

                    var column = $("#" + instanceId).DataTable().column($(this).attr('data-column'));


                    // check the actual status of the table column and toggle it
                    if (column) {
                        column.visible(!column.visible());

                        $(this).toggleClass("active");
                    }

                });
            });

        }



        if (settings.tableRefreshButton) {
            //prepare a refreshButton

            var refreshButton = '<div class="DTTT_container pull-left "><button class="btn btn-default at-table-refresh-button ml15"><i class="fa fa-refresh"></i></button></div>';
            $instanceWrapper.find(".toolbar-left-top").append(refreshButton);

            $instanceWrapper.find(".at-table-refresh-button").on('click', function () {
                $instance.appTable({reload: true, filterParams: settings.filterParams});
            });
        }



        //hide popover when clicks on outside of the popover
        if (!$('body').hasClass("destroy-popover")) {
            $('body').addClass("destroy-popover"); //don't initiate this multiple time

            $('.destroy-popover').on('click', function (e) {
                if ($(e.target).closest("button").attr("data-toggle") !== "popover" && !$(e.target).closest(".popover").length && !$(e.target).hasClass("editable")) {
                    var visiblePopoverId = $(".popover.in").attr("id");
                    $("[aria-describedby=" + visiblePopoverId + "]").trigger("click");

                }
            });
        }



        //set onReloadCallback
        $instance.data("onRelaodCallback", settings.onRelaodCallback);


        buildFilterDom(settings, $instanceWrapper, $instance);

        var undoHandler = function (eventData) {
            $('<a class="undo-delete" href="javascript:;"><strong>Undo</strong></a>').insertAfter($(eventData.alertSelector).find(".app-alert-message"));
            $(eventData.alertSelector).find(".undo-delete").bind("click", function () {
                $(eventData.alertSelector).remove();
                appLoader.show();
                $.ajax({
                    url: eventData.url,
                    type: 'POST',
                    dataType: 'json',
                    data: {id: eventData.id, undo: true},
                    success: function (result) {
                        appLoader.hide();
                        if (result.success) {
                            $instance.appTable({newData: result.data, rowDeleted: true});
                            //fire success callback
                            settings.onUndoSuccess(result);
                        }
                    }
                });
            });
        };


        var rowDeleteHandler = function (result, $target) {
            var tr = $target.closest('tr'),
                    table = $instance.DataTable(),
                    undo = $target.attr('data-undo'),
                    url = $target.attr('data-action-url'),
                    id = $target.attr('data-id');

            oTable.fnDeleteRow(table.row(tr).index(), function () {
                table.page(table.page()).draw('page');
            }, false);

            var alertId = appAlert.warning(result.message, {duration: 20000});

            //fire success callback
            settings.onDeleteSuccess(result);

            //bind undo selector
            if (undo !== "0") {
                undoHandler({
                    alertSelector: alertId,
                    url: url,
                    id: id
                });
            }
        };

        var appTableDeleteConfirmationHandler = function (e) {
            deleteConfirmationHandler(e, rowDeleteHandler);
        };

        var appTableSimpleDeleteHandler = function (e) {
            deleteHandler(e, rowDeleteHandler);
        };

        var updateHandler = function (e) {
            appLoader.show();
            var $target = $(e.currentTarget);

            if (e.data && e.data.target) {
                $target = e.data.target;
            }

            var url = $target.attr("data-action-url");

            $.ajax({
                url: url,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $(".dataTable:visible").appTable({newData: response.data, dataId: response.id});
                        appAlert.success(response.message, {duration: 10000});
                    } else {
                        appAlert.error(response.message);
                    }
                    appLoader.hide();
                }
            });
        };


        window.InstanceCollection = window.InstanceCollection || {};
        window.InstanceCollection[$(this).selector] = settings;



        $('body').find($instance).on('click', 'a[data-action=delete]', appTableSimpleDeleteHandler);
        $('body').find($instance).on('click', 'a[data-action=delete-confirmation]', appTableDeleteConfirmationHandler);
        $('body').find($instance).on('click', '[data-action=update]', updateHandler);

        $.fn.dataTableExt.oApi.getSettings = function (oSettings) {
            return oSettings;
        };

        $.fn.dataTableExt.oApi.fnReloadAjax = function (oSettings, filterParams) {
            this.fnClearTable(this);
            this.oApi._fnProcessingDisplay(oSettings, true);
            var that = this;
            $.ajax({
                url: oSettings.ajax.url,
                type: "POST",
                dataType: "json",
                data: filterParams,
                success: function (json) {
                    /* Got the data - add it to the table */
                    for (var i = 0; i < json.data.length; i++) {
                        that.oApi._fnAddData(oSettings, json.data[i]);
                    }

                    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
                    that.fnDraw(that);
                    that.oApi._fnProcessingDisplay(oSettings, false);
                }
            });
        };
        $.fn.dataTableExt.oApi.fnUpdateRow = function (oSettings, data, page, renderBeforePageChange) {
            //oSettings is not any parameter, we'll get it automatically.

            if (data) {
                this.oApi._fnAddData(oSettings, data);
            }

            if (renderBeforePageChange) {
                this.fnDraw(this);
            }

            if (page) {
                this.oApi._fnPageChange(oSettings, page, true);
            } else {
                this.fnDraw(this);
            }

        };

    };
})(jQuery);


deleteHandler = function (e, callback) {
    appLoader.show();
    var $target = $(e.currentTarget);

    if (e.data && e.data.target) {
        $target = e.data.target;
    }

    var url = $target.attr('data-action-url'),
            id = $target.attr('data-id');

    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: {id: id},
        success: function (result) {
            if (result.success) {

                if (callback) {
                    callback(result, $target);
                }

            } else {
                appAlert.error(result.message);
            }
            appLoader.hide();
        }
    });
}


deleteConfirmationHandler = function (e, callback) {
    var $deleteButton = $("#confirmDeleteButton"),
            $target = $(e.currentTarget);
    //copy attributes

    $target.each(function () {
        $.each(this.attributes, function () {
            if (this.specified && this.name.match("^data-")) {
                $deleteButton.attr(this.name, this.value);
            }

        });
    });

    $target.attr("data-undo", "0"); //don't show undo

    //bind click event
    $deleteButton.unbind("click");
    $deleteButton.on("click", {target: $target}, function (e) {
        deleteHandler(e, callback);
    });

    $("#confirmationModal").modal('show');
};



// appAlert
(function (define) {
    define(['jquery'], function ($) {
        return (function () {
            var appAlert = {
                info: info,
                success: success,
                warning: warning,
                error: error,
                options: {
                    container: "body", // append alert on the selector
                    duration: 0, // don't close automatically,
                    showProgressBar: true, // duration must be set
                    clearAll: true, //clear all previous alerts
                    animate: true //show animation
                }
            };

            return appAlert;

            function info(message, options) {
                this._settings = _prepear_settings(options);
                this._settings.alertType = "info";
                _show(message);
                return "#" + this._settings.alertId;
            }

            function success(message, options) {
                this._settings = _prepear_settings(options);
                this._settings.alertType = "success";
                _show(message);
                return "#" + this._settings.alertId;
            }

            function warning(message, options) {
                this._settings = _prepear_settings(options);
                this._settings.alertType = "warning";
                _show(message);
                return "#" + this._settings.alertId;
            }

            function error(message, options) {
                this._settings = _prepear_settings(options);
                this._settings.alertType = "error";
                _show(message);
                return "#" + this._settings.alertId;
            }

            function _template(message) {
                var className = "info";
                if (this._settings.alertType === "error") {
                    className = "danger";
                } else if (this._settings.alertType === "success") {
                    className = "success";
                } else if (this._settings.alertType === "warning") {
                    className = "warning";
                }

                if (this._settings.animate) {
                    className += " animate";
                }

                return '<div id="' + this._settings.alertId + '" class="app-alert alert alert-' + className + ' alert-dismissible " role="alert">'
                        + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                        + '<div class="app-alert-message">' + message + '</div>'
                        + '<div class="progress">'
                        + '<div class="progress-bar progress-bar-' + className + ' hide" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%">'
                        + '</div>'
                        + '</div>'
                        + '</div>';
            }

            function _prepear_settings(options) {
                if (!options)
                    var options = {};
                options.alertId = "app-alert-" + _randomId();
                return this._settings = $.extend({}, appAlert.options, options);
            }

            function _randomId() {
                var id = "";
                var keys = "abcdefghijklmnopqrstuvwxyz0123456789";
                for (var i = 0; i < 5; i++)
                    id += keys.charAt(Math.floor(Math.random() * keys.length));
                return id;
            }

            function _clear() {
                if (this._settings.clearAll) {
                    $("[role='alert']").remove();
                }
            }

            function _show(message) {
                _clear();
                var container = $(this._settings.container);
                if (container.length) {
                    if (this._settings.animate) {
                        //show animation
                        setTimeout(function () {
                            $(".app-alert").animate({
                                opacity: 1,
                                right: "40px"
                            }, 500, function () {
                                $(".app-alert").animate({
                                    right: "15px"
                                }, 300);
                            });
                        }, 20);
                    }

                    $(this._settings.container).prepend(_template(message));
                    _progressBarHandler();
                } else {
                    console.log("appAlert: container must be an html selector!");
                }
            }

            function _progressBarHandler() {
                if (this._settings.duration && this._settings.showProgressBar) {
                    var alertId = "#" + this._settings.alertId;
                    var $progressBar = $(alertId).find('.progress-bar');

                    $progressBar.removeClass('hide').width(0);
                    var css = "width " + this._settings.duration + "ms ease";
                    $progressBar.css({
                        WebkitTransition: css,
                        MozTransition: css,
                        MsTransition: css,
                        OTransition: css,
                        transition: css
                    });

                    setTimeout(function () {
                        if ($(alertId).length > 0) {
                            $(alertId).remove();
                        }
                    }, this._settings.duration);
                }
            }
        })();
    });
}(function (d, f) {
    window['appAlert'] = f(window['jQuery']);
}));


(function (define) {
    define(['jquery'], function ($) {
        return (function () {
            var appLoader = {
                show: show,
                hide: hide,
                options: {
                    container: 'body',
                    zIndex: "auto",
                    css: "",
                }
            };

            return appLoader;

            function show(options) {
                var $template = $("#app-loader");
                this._settings = _prepear_settings(options);
                if (!$template.length) {
                    var $container = $(this._settings.container);
                    if ($container.length) {
                        $container.append('<div id="app-loader" class="app-loader" style="z-index:' + this._settings.zIndex + ';' + this._settings.css + '"><div class="loading"></div></div>');
                    } else {
                        console.log("appLoader: container must be an html selector!");
                    }

                }
            }

            function hide() {
                var $template = $("#app-loader");
                if ($template.length) {
                    $template.remove();
                }
            }

            function _prepear_settings(options) {
                if (!options)
                    var options = {};
                return this._settings = $.extend({}, appLoader.options, options);
            }
        })();
    });
}(function (d, f) {
    window['appLoader'] = f(window['jQuery']);
}));

/*prepare html form data for suitable ajax submit*/
function encodeAjaxPostData(html) {
    html = replaceAll("=", "~", html);
    html = replaceAll("&", "^", html);
    return html;
}

//replace all occurrences of a string
function replaceAll(find, replace, str) {
    return str.replace(new RegExp(find, 'g'), replace);
}


(function (define) {
    define(['jquery'], function ($) {
        return (function () {
            var appContentModal = {
                init: init,
                destroy: destroy,
                options: {
                    url: "",
                    css: "",
                    sidebar: true
                }
            };

            return appContentModal;

            function escKeyEvent(e) {
                if (e.keyCode === 27) {
                    destroy();
                }
            }

            function init(options) {
                this._settings = _prepear_settings(options);
                _load_template(this._settings);
            }

            function destroy() {
                $(".app-modal").remove();
                $(document).unbind("keyup", escKeyEvent);
                if (typeof appModalXhr !== 'undefined') {
                    appModalXhr.abort();
                }
            }

            function _prepear_settings(options) {
                if (!options)
                    options = {};

                return this._settings = $.extend({}, appLoader.options, options);
            }

            function _load_template(settings) {

                var sidebar = "<div class='app-modal-sidebar hidden-xs'>\
                                        <div class='app-modal-close'><span>&times;</span></div>\
                                        <div class='app-moadl-sidebar-scrollbar'>\
                                            <div class='app-modal-sidebar-area'>\
                                            </div>\
                                        </div>\
                                    </div>";
                var controlIcon = "<i class='fa fa-expand expand hidden-xs'></i>";

                if (settings.sidebar === false) {
                    sidebar = "";
                    controlIcon = "<div class='app-modal-close app-modal-fixed-close-button'><span>&times;</span></div>";
                }

                var template = "<div class='app-modal loading'>\
                                <i class='fa fa-compress compress'></i>\
                                <div class='app-modal-body'>\
                                    <div class='app-modal-content'>" + controlIcon +
                        "<div class='hide app-modal-close'><span>&times;</span></div>\
                                        <div class='app-modal-content-area'>\
                                        </div>\
                                    </div>" + sidebar +
                        "</div>\
                            </div>";
                destroy();
                $("body").prepend(template);


                setTimeout(function () {
                    var windowHeight = $(window).height() - 60;
                    if ($(".app-modal-content-area").prop("scrollHeight") > windowHeight) {
                        $(".app-modal-content-area").css({"max-height": windowHeight + "px", "overflow-y": "scroll"});
                    }


                    if ($.fn.mCustomScrollbar) {
                        $('.app-moadl-sidebar-scrollbar').mCustomScrollbar({setHeight: windowHeight, theme: "minimal-dark", autoExpandScrollbar: true});
                    }
                }, 200);


                $(".expand").click(function () {
                    $(".app-modal").addClass("full-content");
                });

                $(".compress").click(function () {
                    $(".app-modal").removeClass("full-content");
                });
                $(".app-modal-close").click(function () {
                    destroy();
                });
                $(document).bind("keyup", escKeyEvent);
                appLoader.show({container: '.app-modal', css: "top:35%; right:48%;"});

                appModalXhr = $.ajax({
                    url: settings.url || "",
                    data: {},
                    cache: false,
                    type: 'POST',
                    success: function (response) {
                        var $content = $(response);
                        $(".app-modal-content-area").html($content.find(".app-modal-content").html());
                        $(".app-modal-sidebar-area").html($content.find(".app-modal-sidebar").html());
                        $content.remove();
                        $(".app-modal").removeClass("loading");
                        appLoader.hide();
                    },
                    statusCode: {
                        404: function () {
                            appContentModal.destroy();
                            appAlert.error("404: Page not found.");
                        }
                    },
                    error: function () {
                        appContentModal.destroy();
                        appAlert.error("500: Internal Server Error.");
                    }
                });

            }
        })();
    });
}(function (d, f) {
    window['appContentModal'] = f(window['jQuery']);
}));

//custom daterange controller
(function ($) {
    $.fn.appDateRange = function (options) {

        var defaults = {
            dateRangeType: "yearly",
            filterParams: {},
            onChange: function (dateRange) {
            },
            onInit: function (dateRange) {
            }
        };
        var settings = $.extend({}, defaults, options);
        settings._inputDateFormat = "YYYY-MM-DD";

        this.each(function () {

            var $instance = $(this);

            var dom = '<div class="ml15">'
                    + '<button data-act="prev" class="btn btn-default date-range-selector"><i class="fa fa-chevron-left"></i></button>'
                    + '<button data-act="datepicker" class="btn btn-default" style="margin: -1px"></button>'
                    + '<button data-act="next"  class="btn btn-default date-range-selector"><i class="fa fa-chevron-right"></i></button>'
                    + '</div>';
            $instance.append(dom);

            var $datepicker = $instance.find("[data-act='datepicker']"),
                    $dateRangeSelector = $instance.find(".date-range-selector");

            if (settings.dateRangeType === "yearly") {
                var inityearSelectorText = function ($elector) {
                    $elector.html(moment(settings.filterParams.start_date).format("YYYY"));
                };

                inityearSelectorText($datepicker);

                //bind the click events
                $datepicker.datepicker({
                    format: "YYYY-MM",
                    viewMode: "years",
                    minViewMode: "years",
                    autoclose: true,
                    language: "custom",
                }).on('changeDate', function (e) {
                    var date = moment(e.date).format(settings._inputDateFormat),
                            year = moment(date).format("YYYY");
                    settings.filterParams.start_date = year + "-01-01";
                    settings.filterParams.end_date = year + "-12-31";
                    settings.filterParams.year = year;
                    inityearSelectorText($datepicker);
                    settings.onChange(settings.filterParams);
                });

                //init default date
                var year = moment().format("YYYY");
                settings.filterParams.start_date = year + "-01-01";
                settings.filterParams.end_date = year + "-12-31";
                settings.filterParams.year = year;
                settings.onInit(settings.filterParams);


                $dateRangeSelector.click(function () {
                    var type = $(this).attr("data-act"),
                            startDate = moment(settings.filterParams.start_date),
                            endDate = moment(settings.filterParams.end_date);
                    if (type === "next") {
                        startDate = startDate.add(1, 'years').format(settings._inputDateFormat);
                        endDate = endDate.add(1, 'years').format(settings._inputDateFormat);
                    } else if (type === "prev") {
                        startDate = startDate.subtract(1, 'years').format(settings._inputDateFormat);
                        endDate = endDate.subtract(1, 'years').format(settings._inputDateFormat);
                    }

                    settings.filterParams.start_date = startDate;
                    settings.filterParams.end_date = endDate;
                    settings.filterParams.year = moment(startDate).format("YYYY");

                    inityearSelectorText($datepicker);
                    settings.onChange(settings.filterParams);
                });


            }
        });
    };
})(jQuery);


var loadFilterView = function (settings) {
    if (settings.source && settings.targetSelector) {
        $.ajax({
            url: settings.source,
            data: settings.filterParams,
            cache: false,
            type: 'POST',
            success: function (response) {
                $(settings.targetSelector).html(response);
                appLoader.hide();
            },
            statusCode: {
                404: function () {
                    appLoader.hide();
                    appAlert.error("404: Page not found.", {container: '.modal-body', animate: false});
                }
            },
            error: function () {
                appLoader.hide();
                appAlert.error("500: Internal Server Error.", {container: '.modal-body', animate: false});
            }
        });
    }
};

//custom filters controller
(function ($) {

    $.fn.appFilters = function (options) {
        appLoader.show();

        var defaults = {
            source: "", //data url
            targetSelector: "",
            reloadSelector: "",
            dateRangeType: "", // type: daily, weekly, monthly, yearly. output params: start_date and end_date
            checkBoxes: [], // [{text: "Caption", name: "status", value: "in_progress", isChecked: true}] 
            multiSelect: [], // [{text: "Caption", name: "status", options:[{text: "Caption", value: "in_progress", isChecked: true}]}] 
            radioButtons: [], // [{text: "Caption", name: "status", value: "in_progress", isChecked: true}] 
            filterDropdown: [], // [{id: 10, text:'Caption', isSelected:true}] 
            singleDatepicker: [], // [{name: '', value:'', options:[]}] 
            rangeDatepicker: [], // [{startDate:{name:"", value:""},endDate:{name:"", value:""}}] 
            filterParams: {customFilter: true}, //will post this vales on source url
            search: {show: false},
            customLanguage: {
                searchPlaceholder: AppLanugage.search,
                today: AppLanugage.today,
                yesterday: AppLanugage.yesterday,
                tomorrow: AppLanugage.tomorrow
            },
            beforeRelaodCallback: function () {},
            afterRelaodCallback: function () {},
            onInitComplete: function () {},
        };

        var $instance = $(this),
                $instanceWrapper = $instance; //$instanceWrapper is same as instance in this case

        $instanceWrapper.append("<div class='custom-toolbar'></div>");

        var settings = $.extend({}, defaults, options);

        if (settings.reload) {
            var instance = $(this);
            var instanceSettings = window.InstanceCollection[instance.selector];


            if (instance.data("beforeRelaodCallback")) {
                instance.data("beforeRelaodCallback")(instance, instanceSettings.filterParams);
            }


            loadFilterView(instanceSettings);

            if (instance.data("afterRelaodCallback")) {
                instance.data("afterRelaodCallback")(instance, instanceSettings.filterParams);
            }


            return false;
        }

        settings._firstDayOfWeek = AppHelper.settings.firstDayOfWeek || 0;
        settings._inputDateFormat = "YYYY-MM-DD";


        settings = prepareDefaultFilters(settings);

        buildFilterDom(settings, $instanceWrapper, $instance);

        window.InstanceCollection = window.InstanceCollection || {};
        window.InstanceCollection[$instance.selector] = settings;


        if (settings.onInitComplete) {
            settings.onInitComplete($instance, settings.filterParams);
        }

        loadFilterView(settings);


        //bind calbacks
        $instance.data("beforeRelaodCallback", settings.beforeRelaodCallback);
        $instance.data("afterRelaodCallback", settings.afterRelaodCallback);

    };
})(jQuery);



//find and replace all search string
replaceAllString = function (string, find, replaceWith) {
    return string.split(find).join(replaceWith);
};

//convert a number to curency format
toCurrency = function (number, currencySymbol) {

    if (AppHelper.settings.noOfDecimals == "0") {
        number = Math.round(parseFloat(number)) + ".00"; //round it and the add static 2 decimals
    } else {
        number = parseFloat(number).toFixed(2);
    }

    if (!currencySymbol) {
        currencySymbol = AppHelper.settings.currencySymbol;
    }
    var result = number.replace(/(\d)(?=(\d{3})+\.)/g, "$1,");

    //remove (,) if thousand separator is (space)
    if (AppHelper.settings.thousandSeparator === " ") {
        result = result.replace(',', ' ');
    }

    if (AppHelper.settings.decimalSeparator === ",") {
        result = replaceAllString(result, ".", "_");
        result = replaceAllString(result, ",", ".");
        result = replaceAllString(result, "_", ",");
    }

    if (currencySymbol === "none") {
        currencySymbol = "";
    }


    if (AppHelper.settings.noOfDecimals == "0") {
        result = result.slice(0, -3); //remove decimals
    }

    if (AppHelper.settings.currencyPosition === "right") {
        return  result + "" + currencySymbol;
    } else {
        if (result.indexOf("-") == "0") {
            result = result.replace('-', '');
            return "-" + currencySymbol + result;
        } else {
            return  currencySymbol + "" + result;
        }
    }
};


calculateDatatableTotal = function (instance, columnNumber, valueModifier, currentPage) {
    var api = instance.api(),
            columnOption = {};
    if (currentPage) {
        columnOption = {page: 'current'};
    }

    return api.column(columnNumber, columnOption).data()
            .reduce(function (previousValue, currentValue, test, test2) {
                if (valueModifier) {
                    return previousValue + valueModifier(currentValue);
                } else {
                    return previousValue + currentValue;
                }
            }, 0);
};

// rmove the formatting to get integer data
unformatCurrency = function (currency) {
    currency = currency.toString();
    if (currency) {
        currency = currency.replace(/[^0-9.,-]/g, '');
        if (currency.indexOf(".") == 0 || currency.indexOf(",") == 0) {
            currency = currency.slice(1);
        }

        if (AppHelper.settings.decimalSeparator === ",") {
            currency = replaceAllString(currency, ".", "");
            currency = replaceAllString(currency, ",", ".");
        } else {
            currency = replaceAllString(currency, ",", "");
        }
        currency = currency * 1;
    }
    if (currency) {
        return currency;
    }
    return 0;
};


// convert seconds to hours:minutes:seconds format
secondsToTimeFormat = function (sec) {
    var sec_num = parseInt(sec, 10),
            hours = Math.floor(sec_num / 3600),
            minutes = Math.floor((sec_num - (hours * 3600)) / 60),
            seconds = sec_num - (hours * 3600) - (minutes * 60);
    if (hours < 10) {
        hours = "0" + hours;
    }
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
    if (seconds < 10) {
        seconds = "0" + seconds;
    }
    var time = hours + ':' + minutes + ':' + seconds;
    return time;
};

//clear datatable state
clearAppTableState = function (tableInstance) {
    if (tableInstance) {
        setTimeout(function () {
            tableInstance.api().state.clear();
        }, 200);
    }
};

//show/hide datatable column
showHideAppTableColumn = function (tableInstance, columnIndex, visible) {
    tableInstance.fnSetColumnVis(columnIndex, !!visible);
};

//appMention using at.js
(function ($) {

    $.fn.appMention = function (options) {

        var defaults = {
            at: "@",
            dataType: "json",
            source: "",
            data: {}
        };

        var settings = $.extend({}, defaults, options);

        var selector = this;

        $.ajax({
            url: settings.source,
            data: settings.data,
            dataType: settings.dataType,
            method: "POST",
            success: function (result) {
                if (result.success) {
                    $(selector).atwho({
                        at: settings.at,
                        data: result.data,
                        insertTpl: '${content}'
                    });
                }
            }
        });

    };
})(jQuery);

//appMention using at.js
(function ($) {

    $.fn.appMention = function (options) {

        var defaults = {
            at: "@",
            dataType: "json",
            source: "",
            data: {}
        };

        var settings = $.extend({}, defaults, options);

        var selector = this;

        $.ajax({
            url: settings.source,
            data: settings.data,
            dataType: settings.dataType,
            method: "POST",
            success: function (result) {
                if (result.success) {
                    $(selector).atwho({
                        at: settings.at,
                        data: result.data,
                        insertTpl: '${content}'
                    });
                }
            }
        });

    };
})(jQuery);