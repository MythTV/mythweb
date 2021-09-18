/**
 * Javascript Table sorting lib
 *
 * @license     LGPL
 *
/**/

document.observe('dom:loaded', function () {
    var supported = 0;
// Not a dom v3 supported browser?
    if (typeof document.body.textContent == 'undefined') {
    // Let's work around for IE
        if (typeof document.body.innerText != 'undefined') {
            if (typeof HTMLElement != 'undefined') {
                supported = 1;
                HTMLElement.prototype.__defineGetter__('textContent', function () {
                    return this.innerText;
                });
            }
        }
    // And now Safari
        else {
            supported = 1;
            HTMLElement.prototype.__defineGetter__('textContent', function () {
                return this.innerHTML;
            });
        }
    }
    else {
        supported = 1;
    }

    if (supported == 1)
        SortableTables.start();
});

var SortableTables = {
    tables:                     [],
    callback_presort:           null,
    callback_postsort:          null,
    callback_preload:           null,
    callback_postload:          null,

    currently_sorting_table:    null,

    start:                      function () {
        $$('table[sortable=true]').each(SortableTables.setupTable);
    },

    setupTable:                 function (table) {
        if (this.callback_preload)
            this.callback_preload(table);
    // We require a unique id
        if (table.id == '' || ( this.tables && this.tables[table.id] ))
            return;
        SortableTables.tables[table.id] = new SortableTable(table);
        if (this.callback_postload)
            this.callback_postload(table);
    },

    sort:                       function (table_id, header_index) {
    // 25% speed boost on large tables (900 rows+) by not allowing multiple sorts at the same time.
        if (this.currently_sorting_table != null)
            return;
        if (this.callback_presort)
            this.callback_presort(table_id, heder_index);
        if (this.tables[table_id].callback_presort)
            this.tables[table_id].callback_presort(table_id, header_index);
        this.tables[table_id].sort(header_index);
        if (this.tables[table_id].callback_postsort)
            this.tables[table_id].callback_postsort(table_id, header_index);
        if (this.callback_postsort)
            this.callback_postsort(table_id, header_index);
    }
};

var SortableTable = Class.create({
    initialize:                 function (table) {
    // Class vars
        this.table                  = null;
        this.header                 = null;
        this.body                   = null;
        this.rows                   = null;

        this.cache_sort_functions   = new Array();
        this.cache_has_attribute    = new Array();
        this.cache_sorted_index     = null;
        this.cache_previous_sorts   = new Array();
        this.cache_sort_hash        = new Array();
        this.cache_sort_direction   = false;

        this.multisort              = false;
        this.zebra_stripe           = false;

        this.sort_cell_index        = null;
        this.sort_header_index      = null;

        this.callback_presort       = null;
        this.callback_postsort      = null;

    // Make sure the table is valid for sorting
        if (table.tBodies[0].rows.length < 2)
            return;

        this.table  = $(table);
        this.header = this.table.tHead.rows[table.tHead.rows.length-1];
        this.body   = this.table.tBodies[0]
        this.rows   = this.body.rows;

        this.multisort = this.table.readAttribute('multisort');

        if (this.rows[0].className.match(/even/) || this.rows[0].className.match(/odd/))
            this.zebra_stripe = true;

    // Setup the header with links
        var cells           = this.header.cells;
        var cells_count     = cells.length;
        var cell_coloffset  = 0;
        for (var i = 0; i < cells_count; i++) {
            var cell                = cells[i];
            var cell_colspan        = 1;
            var cell_index          = i + cell_coloffset;
            var header_index        = i;
            this.cache_sort_hash[i] = cell_index;
        // Handle colspans...
            if (cell.hasAttribute('colspan'))
                cell_coloffset += cell.readAttribute('colspan')-1;

            if (cell.readAttribute('sortable') == 'false')
                continue;
        // This should fix a bug with safari (as of version 2.0.2 at least), which does not understand cellIndex correctly
            cell.setAttribute('onclick','SortableTables.sort("'+this.table.id+'","'+header_index+'");return false;');
            cell.addClassName('link');
        // Heat the cache...
            this.cache_has_attribute[cell_index]   = false;
        // Precache the sort function...
            this.cache_sort_functions[cell_index]  = this.getSortFunction(header_index, cell_index);
        }
    },

    getSortFunction:            function (header_index) {
        var cell_index = this.cache_sort_hash[header_index];
    // Default sort function to use
        var sort_function = 'sortCaseInsensitive';
    // Do we have sort_values?
        this.cache_has_attribute[header_index] = this.rows[0].cells[cell_index].hasAttribute('sort_value');
        if (this.header.cells[header_index].hasAttribute('sort_hint'))
            sort_function = this.header.cells[header_index].readAttribute('sort_hint');
        else {
            if (this.cache_has_attribute[header_index])
                var value = this.rows[0].cells[cell_index].readAttribute('sort_value');
            else
                var value = this.rows[0].cells[cell_index].textContent;

        // Figure out the function to use...
            if (value.match(/^\w+ \d+[,] \d\d\d\d/))
                sort_function = 'sortEnglishDate';
            else if (value.match(/^\w+[,] \w+ \d+[,] \d+[:]\d+ \w+$/))
                sort_function = 'sortLongEnglishDate';
            else if (value.match(/^\d+ days$/) || value=='Today' || value=='Tomorrow' || value=='Yesterday')
                sort_function = 'sortExpiration';
            else if (value.match(/^\d\d[\/-]\d\d[\/-]\d\d\d\d$/))
                sort_function = 'sortDate';
            else if (value.match(/^\d\d[\/-]\d\d[\/-]\d\d$/))
                sort_function = 'sortDate';
            else if (value.match(/^\W+ \d+$/))
                sort_function = 'sortMonthDay';
            else if (value.match(/^[-]?[\d\.]+[%]*$/))
                sort_function = 'sortNumeric';
            else if (value.match(/^[£$]/))
                sort_function = 'sortCurrency';
        }
        return eval('SortableTableSorts.'+sort_function);
    },

    sort:                       function (header_index) {
        this.sort_header_index = header_index;
        this.sort_cell_index   = this.cache_sort_hash[header_index]

    // Spawn into an array
        var row_length = this.rows.length;
        var rows       = new Array();
        for (var i=0; i<row_length; i++)
            rows.push(this.rows[i]);

    // Check to see if we're already sorted, and if so, just invert it
        if (this.cache_previous_sorts.last() == this.sort_cell_index)
            rows.reverse();
        else {
            SortableTables.currently_sorting_table = this;
            var sort_function = SortableTables.tables[this.table.id].doSort;
            rows.sort(sort_function);
            SortableTables.currently_sorting_table = null;
        }

    // Move back to the table...
        for (var i=0; i<row_length; i++)
            this.body.appendChild(rows[i]);

    // Setup the arrows...
        this.doHeaderArrows();
    // Fix any zebra striping
        this.fixZebraStripes();
    // Remove the current index fromt he previous sorts and make sure it's uniq
        this.cache_previous_sorts = this.cache_previous_sorts.without(this.sort_cell_index).uniq();
    // Add in the sorted col
        this.cache_previous_sorts.push(this.sort_cell_index);
    },

    doSort:                     function (a, b, cell_index) {
    // Are we overriding the cell index (for multisort)
        if (!cell_index)
            cell_index = SortableTables.currently_sorting_table.sort_cell_index;

    // Use the sort hint?
        if (SortableTables.currently_sorting_table.cache_has_attribute[cell_index]) {
            var value_a = a.cells[cell_index].readAttribute('sort_value');
            var value_b = b.cells[cell_index].readAttribute('sort_value');
        }
        else {
            var value_a = a.cells[cell_index].textContent;
            var value_b = b.cells[cell_index].textContent;
        }

        if ( value_a != value_b)
            var comparison = SortableTables.currently_sorting_table.cache_sort_functions[cell_index](value_a,value_b);
        else
            var comparison = 0;

        if (SortableTables.currently_sorting_table.multisort && !comparison && SortableTables.currently_sorting_table.cache_previous_sorts.length) {
            var multisort_index = SortableTables.currently_sorting_table.cache_previous_sorts.pop();
            comparison          = SortableTables.currently_sorting_table.doSort(a, b, multisort_index);
            SortableTables.currently_sorting_table.cache_previous_sorts.push(multisort_index);
        }
        return comparison;
    },

    doHeaderArrows:             function () {
    // Remove any current span arrows
        $$('#'+this.table.id+' thead span.sortArrow').each(function (span) {span.update('&nbsp;&nbsp;&nbsp;');});
        var arrow_span = this.header.cells[this.sort_header_index].select('span.sortArrow').reduce();
        if (!arrow_span) {
            arrow_span = new Element('span', { 'class': 'sortArrow'});
            this.header.cells[this.sort_header_index].insert(arrow_span);
        }
        if (this.cache_previous_sorts.last() == this.sort_cell_index && this.cache_sort_direction) {
            arrow_span.update('&nbsp;&nbsp;&uarr;');
            this.cache_sort_direction = false;
        }
        else {
            arrow_span.update('&nbsp;&nbsp;&darr;');
            this.cache_sort_direction = true;
        }
    },

    fixZebraStripes:            function () {
        if (!this.zebra_stripe)
            return;
        var length = this.rows.length;
        var even   = false;
        for (var i=0; i<length; i++) {
            var row = this.rows[i];
            if (even)
                row.className = row.className.replace(/odd/g, 'even');
            else
                row.className = row.className.replace(/even/g, 'odd');
            even = !even;
        }
    }
});

var SortableTableSorts = {
// Sort: DD-MM-YY or DD-MM-YYYY
// y2k notes: two digit years less than 50 are treated as 20XX, greater than 50 are treated as 19XX
    sortDate:                   function (a,b) {
        if (a.length == 10)
            dt1 = a.substr(6,4)+a.substr(3,2)+a.substr(0,2);
        else {
            yr = a.substr(6,2);
            if (parseInt(yr) < 50)
                 yr = '20'+yr;
            else
                yr = '19'+yr;
            dt1 = yr+a.substr(3,2)+a.substr(0,2);
        }
        if (b.length == 10)
            dt2 = b.substr(6,4)+b.substr(3,2)+b.substr(0,2);
        else {
            yr = b.substr(6,2);
            if (parseInt(yr) < 50)
                 yr = '20'+yr;
            else
                yr = '19'+yr;
            dt2 = yr+b.substr(3,2)+b.substr(0,2);
        }
        if (dt1==dt2)
            return 0;
        if (dt1<dt2)
            return -1;
        return 1;
    },

// Sort MM-DD-YY or MM-DD-YYYY
// y2k notes: two digit years less than 50 are treated as 20XX, greater than 50 are treated as 19XX
    sortDateUs:                 function (a,b) {
        if (a.length == 10)
            dt1 = a.substr(6,4)+a.substr(0,2)+a.substr(3,2);
        else {
            yr = a.substr(6,2);
            if (parseInt(yr) < 50)
                 yr = '20'+yr;
            else
                yr = '19'+yr;
            dt1 = yr+a.substr(0,2)+a.substr(3,2);
        }
        if (b.length == 10)
            dt2 = b.substr(6,4)+b.substr(0,2)+b.substr(3,2);
        else {
            yr = b.substr(6,2);
            if (parseInt(yr) < 50)
                 yr = '20'+yr;
            else
                yr = '19'+yr;
            dt2 = yr+b.substr(0,2)+b.substr(3,2);
        }
        if (dt1 == dt2)
            return 0;
        if (dt1 < dt2)
            return -1;
        return 1;
    },

// This function handles Mon day, year sorting
// Falls back to alpha-comparison, if date-comparison can't make a decision.
    sortEnglishDate:            function (a,b) {
        if (a == 'none' || a.length == 0)
            return -1;
        if (b == 'none' || b.length == 0)
            return 1;

        var aa_mon  = SortableTableSorts.englishMonthToNumber (a.substr(0,3));
        aa          = a.substr(4);
        var aa_year = parseFloat(aa.substr(aa.length-4));
        var aa_day  = parseFloat(aa.substr(0, aa.length-6));

        var bb_mon  = SortableTableSorts.englishMonthToNumber (b.substr(0,3));
        bb          = b.substr(4);
        var bb_year = parseFloat(bb.substr(bb.length-4));
        var bb_day  = parseFloat(bb.substr(0, bb.length-6));
        if (!aa_year || !aa_mon || !aa_day || !bb_year || !bb_mon || !bb_day)
            return SortableTableSorts.sortCaseSensitive(a,b);
        if (aa_year < bb_year)
            return -1;
        if (aa_year > bb_year)
            return 1;
        if (aa_mon < bb_mon)
            return -1;
        if (aa_mon > bb_mon)
            return 1;
        if (aa_day < bb_day)
            return -1;
        return 1;
    },

// This function handles Mon day, year sorting
// Jan 21, 2006
    sortEnglishDateInvert:      function (a,b) {
        return SortableTableSorts.sortEnglishDate(b,a);
    },

// This function sorts based on month day format
// Jan 21
    sortMonthDay:               function (a, b) {
        if (a.length == 0)
            return -1;
        if (b.length == 0)
            return 1;

        var a_mon  = SortableTableSorts.englishMonthToNumber (a.substr(0,3));
        a          = parseFloat(a.substr(4));
        var b_mon  = SortableTableSorts.englishMonthToNumber (b.substr(0,3));
        b          = parseFloat(b.substr(4));
        if (a_mon < b_mon)
            return -1;
        if (a_mon > b_mon)
            return 1;
        if (a < b)
            return -1;
        return 1;
    },

// This function handles DDD, Mon Day, Hour:Min A/PM
// we also assume it's the same year, as we can't figure it out otherwise
    sortLongEnglishDate:        function (a,b) {
        var aa = a.substr(5).split(/,/);
        var bb = b.substr(5).split(/,/);
        var aatmp = aa[1].split(/:/);
        var aa_hour = aatmp[0];
        var aa_min  = aatmp[1].substr(0,2);
        if (aatmp[1].substr(3).toLowerCase() == 'pm')
            aa_hour += 12;
        var bbtmp = bb[1].split(/:/);
        var bb_hour = bbtmp[0];
        var bb_min  = bbtmp[1].substr(0,2);
        if (bbtmp[1].substr(3).toLowerCase() == 'pm')
            bb_hour += 12;
        aa = aa[0];
        bb = bb[0];
        if (aa == bb)
            return 0;
        if (aa == 'none' || aa.length == 0)
            return -1;
        if (bb == 'none' || bb.length == 0)
            return 1;
        var aa_mon  = SortableTableSorts.englishMonthToNumber (aa.substr(0,3));
        var aa_day  = aa.substr(4);
        var bb_mon  = SortableTableSorts.englishMonthToNumber (bb.substr(0,3));
        var bb_day  = bb.substr(4);
        if (!aa_mon || !aa_day || !bb_mon || !bb_day)
            return -1;
        if (aa_mon < bb_mon)
            return -1;
        if (aa_mon > bb_mon)
            return 1;
        if (aa_day < bb_day)
            return -1;
        if (aa_day > bb_day)
            return 1;
        if (aa_hour < bb_hour)
            return -1;
        if (aa_hour > bb_hour)
            return 1;
        if (aa_minute < bb_minute)
            return -1;
        return 1;
    },

// This function sorts expiration dates, such as in the quote list
    sortExpiration:             function (a,b) {
        a = a.split(/ /)[0];
        b = b.split(/ /)[0];
        switch (a) {
            case 'Yesterday':   a = -1; break;
            case 'Today':       a =  0; break;
            case 'Tomorrow':    a =  1; break;
            default:            a = parseFloat(a);
        }
        switch (b) {
            case 'Yesterday':   b = -1; break;
            case 'Today':       b =  0; break;
            case 'Tomorrow':    b =  1; break;
            default:            b = parseFloat(b);
        }

        if (a > b)
            return 1;
        if (a < b)
            return -1;
        return 0;
    },

    englishMonthToNumber:       function (mon) {
        switch (mon.toLowerCase()) {
            case 'jan' : return 1;
            case 'feb' : return 2;
            case 'mar' : return 3;
            case 'apr' : return 4;
            case 'may' : return 5;
            case 'jun' : return 6;
            case 'jul' : return 7;
            case 'aug' : return 8;
            case 'sep' : return 9;
            case 'oct' : return 10;
            case 'nov' : return 11;
            case 'dec' : return 12;
        }
        return 0;
    },

    sortCurrency:               function (a,b) {
        return parseFloat(a.replace(/[^0-9.]/g,'')) - parseFloat(b.replace(/[^0-9.]/g,''));
    },

// A non number or a blank is always less then a number.
    sortNumeric:                function (a,b) {
        b = parseFloat(b);
        if (isNaN(b))
            return 1;
        a = parseFloat(a);
        if (isNaN(a))
            return -1;
        return a-b;
    },

// A non number or a blank is always less then a number.
    sortNumericInvert:          function (a,b) {
        return SortableTableSorts.sortNumeric(b,a);
    },

    sortCaseInsensitive:        function (a,b) {
        a = a.toLowerCase();
        b = b.toLowerCase();

        if (a > b)
            return 1;
        if (a < b)
            return -1;
        return 0;
    },

    sortCaseSensitive:          function (a,b) {
        if (a > b)
            return 1;
        if (a < b)
            return -1;
        return 0;
    },

    sortMythwebPlayTime:        function (a,b) {
        if (a == b)
            return 0;

        var a_hrs = a.match(/([0-9]*) hr/);
        var a_min = a.match(/([0-9]*) min/);
        var a_val = 0;
        if (a_hrs)
            a_val += a_hrs[1]*60;
        if (a_min)
            a_val += a_min[1]*1;

        var b_hrs = b.match(/([0-9]*) hr/);
        var b_min = b.match(/([0-9]*) min/);
        var b_val = 0;
        if (b_hrs)
            b_val += b_hrs[1]*60;
        if (b_min)
            b_val += b_min[1]*1;

        return SortableTableSorts.sortNumeric(a_val, b_val);
    },

    sortMythwebChannel:         function (a,b) {
        if (a == b)
            return 0;
        var a_channel = a.match(/([0-9]*) -/);

        if (a_channel)
            a_channel = a_channel[1];
        else
            a_channel = 0;

        var b_channel = b.match(/([0-9]*) -/);

        if (b_channel)
            b_channel = b_channel[1];
        else
            b_channel = 0;

        return SortableTableSorts.sortNumeric(a_channel, b_channel);
    },

// Some compat wrappers
    date_us:                    function (a,b) {
        return SortableTableSorts.sortDateUs(a,b);
    },

    numeric:                    function (a,b) {
        return SortableTableSorts.sortNumeric(a,b);
    },

    numeric_invert:             function (a,b) {
        return SortableTableSorts.sortNumericInvert(a,b);
    }
};
