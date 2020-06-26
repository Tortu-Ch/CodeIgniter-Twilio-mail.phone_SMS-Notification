/*
 Based on jQuery.ganttView v.0.8.8
 */

/*
 Options
 -----------------
 showWeekends: boolean
 data: object
 cellWidth: number
 cellHeight: number
 slideWidth: number
 dataUrl: string
 behavior: {
 clickable: boolean,
 draggable: boolean,
 resizable: boolean,
 onClick: function,
 onDrag: function,
 onResize: function
 }
 */
var addDaysToDate = function (date, days) {
    return moment(date).add(days, 'days').toDate();
};
var getFullYear = function (date) {
    return moment(date).format("Y");
};
var getMonth = function (date) {
    return moment(date).format("M");
};
var getDateOfMonth = function (date) {
    return moment(date).date();
};
var getDayOfWeek = function (date) {
    return moment(date).day();
};

var compareDateTo = function (start, end) {
    var diff = moment(start).diff(end, 'days');
    if (diff > 0)
        return 1;
    else if (diff < 0)
        return -1;
    else
        return 0;
};

var checkDifferentTimeZone = function (date) {
    //check if the timezone giving the different values with actual dates
    if (jQuery.type(date) === "string") {
        var splitStartDate = date.split("-");
        var parseStartDate = new Date(Date.parse(date));
        var startDate = parseStartDate.getDate().toString();

        if (startDate.length === 1) {
            startDate = "0" + startDate;
        }
        if (startDate !== splitStartDate[2]) {
            return 1;
        } else {
            return 0;
        }
    }
};

(function (jQuery) {

    jQuery.fn.ganttView = function () {

        var args = Array.prototype.slice.call(arguments);
        if (args.length == 1 && typeof (args[0]) == "object") {
            build.call(this, args[0]);
        }

        if (args.length == 2 && typeof (args[0]) == "string") {
            handleMethod.call(this, args[0], args[1]);
        }
    };
    function build(options) {

        var els = this;
        var defaults = {
            showWeekends: false,
            cellWidth: 25,
            cellHeight: 31,
            slideWidth: 400,
            vHeaderWidth: 100,
            behavior: {
                clickable: true,
                draggable: true,
                resizable: true
            },
            monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            dayText: "day",
            daysText: "days",
        };
        var opts = jQuery.extend(true, defaults, options);
        if (opts.data) {
            build();
        } else if (opts.dataUrl) {
            jQuery.getJSON(opts.dataUrl, function (data) {
                opts.data = data;
                build();
            });
        }

        function build() {

            var minDays = Math.floor((opts.slideWidth / opts.cellWidth) + 5);
            var startEnd = DateUtils.getBoundaryDatesFromData(opts.data, minDays);
            opts.start = startEnd[0];
            opts.end = startEnd[1];
            els.each(function () {

                var container = jQuery(this);
                jQuery(container).html("");
                var div = jQuery("<div>", {"class": "ganttview"});
                new Chart(div, opts).render();
                container.append(div);
                var w = jQuery("div.ganttview-vtheader", container).outerWidth() +
                        jQuery("div.ganttview-slide-container", container).outerWidth();
                // container.css("width", (w + 2) + "px");
                new Behavior(container, opts).apply();

                scrollToCurrentMonth();
            });
        }


        function scrollToCurrentMonth() {
            var d = new Date(),
                    $sliderDiv = $(".ganttview-slide-container");
            var currentMonthColumnId = "#gantt-month-" + (d.getMonth() + 1) + "-" + d.getFullYear();

            if ($(currentMonthColumnId).length) {
                var scrollLeft = $(currentMonthColumnId).position().left - $sliderDiv.position().left;
                if (scrollLeft) {
                    $sliderDiv.animate({scrollLeft: scrollLeft}, 'slow');
                }
            }
        }
    }

    function handleMethod(method, value) {

        if (method == "setSlideWidth") {
            var div = $("div.ganttview", this);
            div.each(function () {
                var vtWidth = $("div.ganttview-vtheader", div).outerWidth();
                $(div).width(vtWidth + value + 1);
                //$("div.ganttview-slide-container", this).width(value);
            });
        }
    }



    var Chart = function (div, opts) {

        function render() {
            addVtHeader(div, opts.data, opts.cellHeight);
            var slideDiv = jQuery("<div>", {
                "class": "ganttview-slide-container"
            });
            dates = getDates(opts.start, opts.end);
            addHzHeader(slideDiv, dates, opts.cellWidth);
            addGrid(slideDiv, opts.data, dates, opts.cellWidth, opts.showWeekends);
            addBlockContainers(slideDiv, opts.data);
            addBlocks(slideDiv, opts.data, opts.cellWidth, opts.start);
            div.append(slideDiv);
            applyLastClass(div.parent());
        }


        // Creates a 3 dimensional array [year][month][day] of every day 
        // between the given start and end dates
        function getDates(start, end) {
            var dates = [];
            dates[getFullYear(start)] = [];
            dates[getFullYear(start)][getMonth(start)] = [start]
            var last = start;
            while (compareDateTo(last, end) == -1) {
                var next = addDaysToDate(last, 1);
                if (!dates[getFullYear(next)]) {
                    dates[getFullYear(next)] = [];
                }
                if (!dates[getFullYear(next)][getMonth(next)]) {
                    dates[getFullYear(next)][getMonth(next)] = [];
                }
                dates[getFullYear(next)][getMonth(next)].push(next);
                last = next;
            }
            return dates;
        }

        function addVtHeader(div, data, cellHeight) {
            var headerDiv = jQuery("<div>", {"class": "ganttview-vtheader"});
            for (var i = 0; i < data.length; i++) {
                var itemDiv = jQuery("<div>", {"class": "ganttview-vtheader-series"});
                itemDiv.append(jQuery("<div>", {
                    "class": "ganttview-vtheader-group-name toggle-grid",
                    "data-target": "row-group-" + i
                }).append(data[i].name));
                var seriesDiv = jQuery("<div>", {"class": "ganttview-vtheader-series row-group-" + i});
                for (var j = 0; j < data[i].series.length; j++) {
                    seriesDiv.append(jQuery("<div>", {"class": "ganttview-vtheader-series-row"})
                            .append(data[i].series[j].name));
                }
                itemDiv.append(seriesDiv);
                headerDiv.append(itemDiv);
            }
            div.append(headerDiv);
        }

        function addHzHeader(div, dates, cellWidth) {
            var headerDiv = jQuery("<div>", {"class": "ganttview-hzheader"});
            var monthsDiv = jQuery("<div>", {"class": "ganttview-hzheader-months"});
            var daysDiv = jQuery("<div>", {"class": "ganttview-hzheader-days"});
            var totalW = 0;
            for (var y in dates) {
                for (var m in dates[y]) {
                    var w = dates[y][m].length * cellWidth;
                    totalW = totalW + w;
                    monthsDiv.append(jQuery("<div>", {
                        "id": "gantt-month-" + m + "-" + y,
                        "class": "ganttview-hzheader-month",
                        "css": {"width": (w - 1) + "px"}
                    }).append(opts.monthNames[m - 1] + " - " + y));
                    for (var d in dates[y][m]) {
                        daysDiv.append(jQuery("<div>", {"class": "ganttview-hzheader-day"})
                                .append(getDateOfMonth(dates[y][m][d])));
                    }
                }
            }
            monthsDiv.css("width", totalW + "px");
            daysDiv.css("width", totalW + "px");
            headerDiv.append(monthsDiv).append(daysDiv);
            div.append(headerDiv);
        }

        function addGrid(div, data, dates, cellWidth, showWeekends) {
            var gridDiv = jQuery("<div>", {"class": "ganttview-grid"});
            var rowDiv = jQuery("<div>", {"class": "ganttview-grid-row"});
            for (var y in dates) {
                for (var m in dates[y]) {
                    for (var d in dates[y][m]) {
                        var firstDayClass = "";


                        var cellDiv = jQuery("<div>", {"class": "ganttview-grid-row-cell " + firstDayClass});
                        if (DateUtils.isWeekend(dates[y][m][d]) && showWeekends) {
                            cellDiv.addClass("ganttview-weekend");
                        }
                        rowDiv.append(cellDiv);

                        if (d == 0) {
                            cellDiv.prev().addClass("ganttview-last-day");
                        }
                    }
                }
            }
            var w = jQuery("div.ganttview-grid-row-cell", rowDiv).length * cellWidth;
            rowDiv.css("width", w + "px");
            gridDiv.css("width", w + "px");
            for (var i = 0; i < data.length; i++) {
                gridDiv.append(jQuery("<div>", {
                    "class": "ganttview-grid-header"
                }));
                for (var j = 0; j < data[i].series.length; j++) {
                    var newDiv = rowDiv.clone();
                    newDiv.addClass("row-group-" + i);
                    gridDiv.append(newDiv);

                }
            }


            div.append(gridDiv);
        }

        function addBlockContainers(div, data) {
            var blocksDiv = jQuery("<div>", {"class": "ganttview-blocks"});

            for (var i = 0; i < data.length; i++) {
                blocksDiv.append(jQuery("<div>", {
                    "class": "ganttview-grid-header",
                    "data-target": "row-group-" + i
                }));
                for (var j = 0; j < data[i].series.length; j++) {
                    var container = jQuery("<div>", {"class": "ganttview-block-container"});
                    container.addClass("row-group-" + i);
                    blocksDiv.append(container);
                }

            }
            div.append(blocksDiv);
        }

        function addBlocks(div, data, cellWidth, start) {

            var rows = jQuery("div.ganttview-blocks div.ganttview-block-container", div);
            var rowIdx = 0;
            for (var i = 0; i < data.length; i++) {
                for (var j = 0; j < data[i].series.length; j++) {
                    var series = data[i].series[j];
                    var size = DateUtils.daysBetween(series.start, series.end, series.start) + 1;
                    var offset = DateUtils.daysBetween(start, series.start, series.start);
                    var sizeText = (size > 1) ? opts.daysText : opts.dayText;
                    
                    var cellWidthLess = 9;
                    if (checkDifferentTimeZone(series.start) === 1) {
                        cellWidthLess = 32;
                    }

                    var blockText = jQuery(series.name),
                            taskName = blockText.text();
                    blockText.text(size + " " + sizeText);

                    var block = jQuery("<div>", {
                        "class": "ganttview-block",
                        "title": taskName + ", " + size + " " + sizeText,
                        "css": {
                            "width": ((size * cellWidth) - cellWidthLess) + "px",
                            "margin-left": ((offset * cellWidth) + 3) + "px"
                        }
                    });

                    addBlockData(block, data[i], series);
                    if (data[i].series[j].class) {
                        block.addClass(data[i].series[j].class);
                    }
                    if (data[i].series[j].color) {
                        block.css("background-color", data[i].series[j].color);
                    }


                    block.append(jQuery("<div>", {"class": "ganttview-block-text"}).html(blockText));


                    jQuery(rows[rowIdx]).append(block);
                    rowIdx = rowIdx + 1;
                }
            }
        }

        function addBlockData(block, data, series) {
            // This allows custom attributes to be added to the series data objects
            // and makes them available to the 'data' argument of click, resize, and drag handlers
            var blockData = {id: data.id, name: data.name};
            jQuery.extend(blockData, series);
            block.data("block-data", blockData);
        }

        function applyLastClass(div) {
            jQuery("div.ganttview-grid-row div.ganttview-grid-row-cell:last-child", div).addClass("last");
            jQuery("div.ganttview-hzheader-days div.ganttview-hzheader-day:last-child", div).addClass("last");
            jQuery("div.ganttview-hzheader-months div.ganttview-hzheader-month:last-child", div).addClass("last");
        }


        return {
            render: render
        };
    }

    var Behavior = function (div, opts) {

        function apply() {

            if (opts.behavior.clickable) {
                bindBlockClick(div, opts.behavior.onClick);
            }

            if (opts.behavior.resizable) {
                bindBlockResize(div, opts.cellWidth, opts.start, opts.behavior.onResize);
            }

            if (opts.behavior.draggable) {
                bindBlockDrag(div, opts.cellWidth, opts.start, opts.behavior.onDrag);
            }
        }

        function bindBlockClick(div, callback) {
            jQuery('div.toggle-grid').on('click', div, function () {
                var target = $(this).attr("data-target");
                if ($(this).hasClass("grid-hidden")) {
                    $(this).removeClass("grid-hidden");
                    $("." + target).fadeIn();
                } else {
                    $(this).addClass("grid-hidden");
                    $("." + target).fadeOut();
                }

                /*
                 if (callback) {
                 callback(jQuery(this).data("block-data"));
                 }*/
            });

            var clicked = false, clickX,
                    $ganttContainer = $(".ganttview-slide-container");
            $ganttContainer.on({
                'mousemove': function (e) {
                    clicked && updateScrollPos(e);
                },
                'mousedown': function (e) {
                    clicked = true;
                    clickX = e.pageX;
                },
                'mouseup': function () {
                    clicked = false;
                }
            });

            var updateScrollPos = function (e) {
                $ganttContainer.scrollLeft($ganttContainer.scrollLeft() + ((clickX - e.pageX) ? (clickX - e.pageX) / 2 : 0));
            }

        }

        function bindBlockResize(div, cellWidth, startDate, callback) {
            /*
             jQuery("div.ganttview-block", div).resizable({
             grid: cellWidth, 
             handles: "e,w",
             stop: function () {
             var block = jQuery(this);
             updateDataAndPosition(div, block, cellWidth, startDate);
             if (callback) { callback(block.data("block-data")); }
             }
             });
             */
        }

        function bindBlockDrag(div, cellWidth, startDate, callback) {
            /*
             jQuery("div.ganttview-block", div).draggable({
             axis: "x", 
             grid: [cellWidth, cellWidth],
             stop: function () {
             var block = jQuery(this);
             updateDataAndPosition(div, block, cellWidth, startDate);
             if (callback) { callback(block.data("block-data")); }
             }
             });
             */
        }

        function updateDataAndPosition(div, block, cellWidth, startDate) {
            var container = jQuery("div.ganttview-slide-container", div);
            var scroll = container.scrollLeft();
            var offset = block.offset().left - container.offset().left - 1 + scroll;
            // Set new start date
            var daysFromStart = Math.round(offset / cellWidth);
            var newStart = addDaysToDate(startDate, daysFromStart);
            block.data("block-data").start = newStart;
            // Set new end date
            var width = block.outerWidth();
            var numberOfDays = Math.round(width / cellWidth) - 1;
            block.data("block-data").end = addDaysToDate(newStart, numberOfDays);
            jQuery("div.ganttview-block-text", block).text(numberOfDays + 1);
            // Remove top and left properties to avoid incorrect block positioning,
            // set position to relative to keep blocks relative to scrollbar when scrolling
            block.css("top", "").css("left", "")
                    .css("position", "relative").css("margin-left", offset + "px");
        }

        return {
            apply: apply
        };
    }

    var ArrayUtils = {
        contains: function (arr, obj) {
            var has = false;
            for (var i = 0; i < arr.length; i++) {
                if (arr[i] == obj) {
                    has = true;
                }
            }
            return has;
        }
    };
    var DateUtils = {
        daysBetween: function (start, end, stringStart) {
            if (!start || !end) {
                return 0;
            }

            var toAddOneDay = checkDifferentTimeZone(stringStart);

            start = Date.parse(start);
            end = Date.parse(end);
            if (getFullYear(start) == 1901 || getFullYear(end) == 8099) {
                return 0;
            }
            var count = 0, date = addDaysToDate(start, 0);
            while (compareDateTo(date, end) == -1) {
                count = count + 1;
                date = addDaysToDate(date, 1);
            }

            if (toAddOneDay === 1) {
                return count + 1;
            } else {
                return count;
            }
        },
        isWeekend: function (date) {
            return getDayOfWeek(date) % 6 == 0;
        },
        getBoundaryDatesFromData: function (data, minDays) {
            var minStart = new Date(),
                    maxEnd = new Date();

            for (var i = 0; i < data.length; i++) {
                for (var j = 0; j < data[i].series.length; j++) {
                    var stringStart = data[i].series[j].start;
                    var start = new Date(Date.parse(data[i].series[j].start));
                    var end = new Date(Date.parse(data[i].series[j].end));

                    if (i == 0 && j == 0) {
                        minStart = start;
                        maxEnd = end;
                    }
                    if (compareDateTo(minStart, start) == 1) {
                        minStart = start;
                    }
                    if (compareDateTo(maxEnd, end) == -1) {
                        maxEnd = end;
                    }
                }
            }

            // Insure that the width of the chart is at least the slide width to avoid empty
            // whitespace to the right of the grid
            if (DateUtils.daysBetween(minStart, maxEnd, stringStart) < minDays) {
                maxEnd = addDaysToDate(minStart, minDays);
            }
            //minStart = moment(minStart).startOf('month').toDate();
            maxEnd = moment(maxEnd).endOf('month').toDate();

            return [minStart, maxEnd];
        }
    };
})(jQuery);