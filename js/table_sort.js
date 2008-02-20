/*
 * @url         $URL:$
 * @date        $Date:$
 * @version     $Revision:$
 * @author      $Author:$
 * @license     GPL

When a table has an attribute of sortable="true" we take the last row in the thead block, and assume it's the sortable keys
We then make all the cells clickable to sort, unless a cell a has the attribute of sortable="false"

Once a cell is clicked, it sorts all the contents of the tbody block, and saves the info to the session

It uses two css classes to define the look
       link: text that was turned into a link
  sortarrow: arrow that displays which direction the sort is going in

Example table
<table id="unique" sortable="true">
 <caption>This is a title of the table</caption>
 <thead>
  <tr>
   <td>Col 1</td>
   <td>Col 2</td>
   <td>Col 3</td>
   <td sortable="false">Col 4</td>
  </tr>
 </thead>
 <tbody>
  <tr>..data</tr>
 </tbody>
 <tfoot>
  <tr><td colspan="4">Total: blah</td></tr>
 </tfoot>
</table>

Valid attributes

    Table
        sortable        bool        Can we sort this table?
        multisort       bool        Do we allow multisort?
        sort_hint       string      What sorting function to use. Normally we autodetect it, but if this is set, we'll use that instead
    TD
        sortable        bool        used in a thead, allows the col to be sorted or not
        sort_value      string      used in a tbody, allows one to set the value to sort by rather then the cell contents

*/

Event.observe(window, 'load',  function() {
// Not a dom v3 supported browser?
    if (typeof document.body.textContent == 'undefined') {
    // Let's work around for IE
        if (typeof document.body.innerText != 'undefined') {
            HTMLElement.prototype.__defineGetter__("textContent", function () {
                return this.innerText;
            });
        }
    // And now Safari
        else {
            HTMLElement.prototype.__defineGetter__("textContent", function () {
                return this.innerHTML;
            });
        }
    }
});

var SortableTables = {
    tables:                     [],
    callback_presort:           null,
    callback_postsort:          null,
    callback_preloads:          null,
    callback_postload:          null,

    start:                      function() {
        $$('table[sortable=true]').each(SortableTables.setupTable);
    },

    setupTable:                 function(table) {
        if (this.callback_preload)
            this.callback_preload(table);

        SortableTables.tables[table.id] = new SortableTable(table);

        if (this.callback_postload)
            this.callback_postload(table);
    },

    sort:                       function(table_id, index) {
        if (this.callback_presort)
            this.callback_presort(table_id, index);
        if (this.tables[table_id].callback_presort)
            this.tables[table_id].callback_presort(table_id, index);

        this.tables[table_id].sort(index);

        if (this.tables[table_id].callback_postsort)
            this.tables[table_id].callback_postsort(table_id, index);
        if (this.callback_postsort)
            this.callback_postsort(table_id, index);
    }
};

Event.observe(window, 'load', SortableTables.start);

var SortableTable = Class.create({
    table:                      null,
    header:                     null,
    body:                       null,
    rows:                       null,

    cache_sort_functions:       [],
    cache_has_attribute:        [],
    cache_sorted_index:         null,
    cache_previous_sorts:       [],

    multisort:                  false,
    zebra_stripe:               false,

    sort_invert:                false,
    sort_cell_index:            null,

    callback_presort:           null,
    callback_postsort:          null,

    initialize:                 function(table) {
    // Make sure the table is valid for sorting
        if (table.tBodies[0].rows.length < 2)
            return;

        this.table  = $(table);
        this.header = $(table.tHead.rows[table.tHead.rows.length-1]);
        this.body   = $(table.tBodies[0]);
        this.rows   = this.body.rows;

        this.multisort = this.table.readAttribute('multisort');

        if (this.rows[0].className.match(/even/) || this.rows[0].className.match(/odd/))
            this.zebra_stripe = true;

    // Setup the header with links
        var cells = this.header.cells;
        var cells_count = cells.length;
        for (var i = 0; i < cells_count; i++) {
            var cell = $(cells[i]);
            if (cell.readAttribute("sortable") == 'false')
                continue;
        // This should fix a bug with safari (as of version 2.0.2 at least), which does not understand cellIndex correctly
            cell.setAttribute('onclick','SortableTables.sort("'+this.table.id+'","'+i+'");return false;');
            cell.addClassName('link');
        // Precache the sort function...
            this.getSortFunction(i);
        }
    },

    setupHeaderArrows:          function(cell_index, sort_direction) {
    // Remove any current span arrows
        $$('#'+this.table.id+' thead span.sortArrow').each(function (span) {span.innerHTML = '&nbsp;&nbsp;&nbsp;';});
        var arrow_span      = this.header.cells[cell_index].select('span.sortArrow').reduce();
        if (!arrow_span) {
            arrow_span = new Element('span', { 'class': 'sortArrow'});
            this.header.cells[cell_index].insert(arrow_span);
        }

        if (sort_direction == 'Ascend' )
            arrow_span.update('&nbsp;&nbsp;&darr;');
        else
            arrow_span.update('&nbsp;&nbsp;&uarr;');
    },

    sort:                       function(cell_index) {
        this.sort_cell_index = cell_index;

    // Get the new sort direction...
        var sort_direction  = this.header.cells[cell_index].readAttribute('sort_direction');

        if (sort_direction  == 'Ascend' ) {
            sort_direction   = 'Decend';
            this.sort_invert = true;
        }
        else {
            sort_direction   = 'Ascend';
            this.sort_invert = false;
        }

    // Spawn into an array
        var rows        = new Array();
        var row_length  = this.rows.length;
        for (var i=0; i<row_length; i++)
            rows.push(this.rows[i]);

    // Check to see if we're already sorted, and if so, just invert it
        if (this.cache_previous_sorts.last() == cell_index)
            rows.reverse();
        else {
            var sort_function = SortableTables.tables[this.table.id].doSort.bind(this);
            rows.sort(sort_function);
        }

    // Move back to the table...
        for (var i=0; i<row_length; i++)
            this.body.appendChild(rows[i]);

    // Store that we sorted...
        this.header.cells[cell_index].writeAttribute({ 'sort_direction': sort_direction });
    // Setup the arrows...
        this.setupHeaderArrows(cell_index, sort_direction);
    // Fix any zebra striping
        this.fixZebraStripes();
    // Remove the current index fromt he previous sorts and make sure it's uniq
        this.cache_previous_sorts = this.cache_previous_sorts.without(cell_index).uniq();
    // Add in the sorted col
        this.cache_previous_sorts.push(cell_index);
    },

    getSortFunction:            function(index) {
    // Default sort function to use
        var sort_function = 'sortCaseInsensitive';
        if (this.header.cells[index].readAttribute('sort_hint'))
            var sort_function = this.header.cells[index].readAttribute('sort_hint');
        else {
            var value         = this.rows[0].cells[index].readAttribute('sort_value');
            this.cache_has_attribute[index] = true;
            if (!value) {
                value         = this.rows[0].cells[index].innerText;
                this.cache_has_attribute[index] = false;
            }
            if (!value)
                value         = this.rows[0].cells[index].innerHTML;
        // Figure out the function to use...
            if (value.match(/^\w+ \d+[,] \d\d\d\d/))
                sort_function = 'sortEnglishDate';
            else if (value.match(/^\w+[,] \w+ \d+[,] \d+[:]\d+ \w+$/))
                sort_function = 'sortLongEnglishDate';
            else if (value.match(/^\d+ days$/) || value=='Today' || value=='Tomorrow')
                sort_function = 'sortExpiration';
            else if (value.match(/^\d\d[\/-]\d\d[\/-]\d\d\d\d$/))
                sort_function = 'sortDate';
            else if (value.match(/^\d\d[\/-]\d\d[\/-]\d\d$/))
                sort_function = 'sortDate';
            else if (value.match(/^\W+ \d+$/))
                sort_function = 'sortMonthDay';
            else if (value.match(/^[\d\.]+[%]*$/))
                sort_function = 'sortNumeric';
            else if (value.match(/^[£$]/))
                sort_function = 'sortCurrency';
        }

        this.cache_sort_functions[index] = eval('SortableTableSorts.'+sort_function);
    },

    fixZebraStripes:            function() {
        if (!this.zebra_stripe)
            return;
        var length = this.rows.length;
        var even   = false;
        for (var i=0; i<length; i++) {
            var row = this.rows[i];
            if (even) {
                even = false;
                row.className = row.className.replace(/odd/g, 'even');
            }
            else {
                even = true;
                row.className = row.className.replace(/even/g, 'odd');
            }
        }
    },

    doSort:                     function(a, b, cell_index) {
    // Are we overriding the cell index (for multisort)
        if (!cell_index)
            cell_index = this.sort_cell_index;
    // Pull out the cells...
        var cell_a = a.cells[cell_index];
        var cell_b = b.cells[cell_index];
    // Use the sort hint?
        if (this.cache_has_attribute[cell_index]) {
            value_a = cell_a.readAttribute('sort_value');
            value_b = cell_b.readAttribute('sort_value');
        }
        else {
            value_a = cell_a.textContent;
            value_b = cell_b.textContent;
        }

        var comparison = this.cache_sort_functions[cell_index](value_a,value_b);

        if (comparison == 0 && this.multisort && this.cache_previous_sorts.length > 0) {
            var multisort_index = this.cache_previous_sorts.pop();
            comparison          = this.doSort(a, b, multisort_index);
            this.cache_previous_sorts.push(multisort_index);
        }
        return this.sort_invert ? -comparison : comparison;
    }
});

var SortableTableSorts = {
// Sort: DD-MM-YY or DD-MM-YYYY
    sortDate:                   function (a,b) {
        if (a == b)
            return 0;
    // y2k notes: two digit years less than 50 are treated as 20XX, greater than 50 are treated as 19XX
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
    sortDateUs:                 function (a,b) {
        if (a == b)
            return 0;
    // y2k notes: two digit years less than 50 are treated as 20XX, greater than 50 are treated as 19XX
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
        if (a == b)
            return 0;
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
    sortEnglishDateInvert:      function (a,b) {
        return SortableTableSorts.sortEnglishDate(b,a);
    },

// This function sorts based on month day format
    sortMonthDay:               function (a, b) {
        if (a == b)
            return 0;
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
        if (a == b)
            return 0;
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
    sortExpiration:             function(a,b) {
        if ( a == b )
            return 0;
        a = a.split(/ /)[0];
        b = b.split(/ /)[0];
        if (a == 'Today')
            a = 0;
        if (a == 'Tomorrow')
            a = -1;
        if (b == 'Today')
            b = 0;
        if (b == 'Tomorrow')
            b = -1;
        if (parseFloat(a) < parseFloat(b))
            return -1;
        return 1;
    },

    englishMonthToNumber:       function(mon) {
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

    sortCurrency:               function(a,b) {
        if (a == b)
            return 0;
        a = a.replace(/[^0-9.]/g,'');
        b = b.replace(/[^0-9.]/g,'');
        return parseFloat(a) - parseFloat(b);
    },

// A non number or a blank is always less then a number.
    sortNumeric:                function(a,b) {
        if (a == b)
            return 0;
        a = parseFloat(a);
        if (isNaN(a))
            return -1;
        b = parseFloat(b);
        if (isNaN(b))
            return 1;
        if (a > b)
            return 1;
        if (a < b)
            return -1;
        return 0;
    },

// A non number or a blank is always less then a number.
    sortNumericInvert:          function(a,b) {
        return SortableTableSorts.sortNumeric(b,a);
    },

    sortCaseInsensitive:        function(a,b) {
        if (a == b)
            return 0;
        a = a.toLowerCase();
        b = b.toLowerCase();
        if (a == b)
            return 0;
        if (a < b)
            return -1;
        return 1;
    },

    sortCaseSensitive:          function(a,b) {
        if (a == b)
            return 0;
        if (a < b)
            return -1;
        return 1;
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
