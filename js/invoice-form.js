/* 
 ## Pancake Team Notes ##
 Item: function getRemainingAmount()
 Status: Current
 Since: Version 4 - Thu Oct 18 23:01:20 MDT 2012
 Author: Lee Tengum - lee@pancakeapp.com
 
 Notes: Calculates remaining totals for payment plans
 */

function getRemainingAmount() {

    var amount = 0;

    if ($('[name=type]').val() != "SIMPLE") {
        $('#invoice-items .details').each(function() {
            var el = $(this);
            var qty = el.find('.item_quantity').val();
            var rate = el.find('.item_rate').val();
            var tax = el.find('.tax_id option:selected').html();
            tax = parseFloat(GetBetween(tax, '(', '%)'));
            tax = tax / 100;
            if (tax > 0) {
                tax = ((qty * rate) * tax);
            } else {
                tax = 0;
            }
            amount = amount + (qty * rate) + tax;
        });
    } else {
        amount = parseFloat($('[name=amount]').val());
    }

    amount = toFixed(amount, 2);

    var amount_left = amount;

    $('.partial-inputs').each(function() {
        var val = $(this).find('input.partial-amount').val();
        var is_percentage = $(this).find('.partial-percentage select').val();

        if (is_percentage == '1') {
            amount_left = amount_left - (amount * (val / 100));
        } else {
            if (amount == 0) {
                amount_left = 0;
                return;
            } else {
                amount_left = amount_left - val;
            }
        }
    });

    if (toFixed(amount_left) == 0.00) {
        return 0;
    }

    return amount_left;

}

function toFixed(value, precision) {
    var power = Math.pow(10, precision || 0);
    return String(Math.round(value * power) / power);
}


// Hide and show Multiparts

function hideMultiparts() {
    $('.partial-addmore a span').html($('.partial-addmore a').data('disabled'));
    $('.partial-addmore a').addClass('disabled');

    if ($('.partial-inputs').length > 1) {
        $('.partial-inputs:not(:first-child)').slideUp();
        $('.partial-inputs:first-child .partial-amount').data('old-value', $('.partial-inputs:first-child .partial-amount').val()).val(100);
        $('.partial-inputs:first-child .partial-percentage select').data('old-value', $('.partial-inputs:first-child .partial-percentage select').val()).val(1);
        $('.partial-inputs:first-child .partial-percentage .selector span').html($('.partial-inputs:first-child .partial-percentage select option:selected').html());
    }
}

function showMultiparts() {
    $('.partial-addmore a span').html($('.partial-addmore a').data('enabled'));
    $('.partial-addmore a').removeClass('disabled');

    if ($('.partial-inputs').length > 1 && $('.partial-inputs:first-child .partial-amount').data('old-value') != undefined) {
        $('.partial-inputs:not(:first-child)').slideDown();
        $('.partial-inputs:first-child .partial-amount').val($('.partial-inputs:first-child .partial-amount').data('old-value'));
        $('.partial-inputs:first-child .partial-percentage select').val($('.partial-inputs:first-child .partial-percentage select').data('old-value'));
        $('.partial-inputs:first-child .partial-percentage .selector span').html($('.partial-inputs:first-child .partial-percentage select option:selected').html());
    }
}



function updatePaymentPlanTotals() {
    var invoice_type = $('[name=type]').val();
    var amount = $('[name=amount]').val();
    amount = (amount == '') ? 0 : parseFloat(amount);
    // Fetch items and calculate their amounts.

    amount = 0;

    if (invoice_type != "SIMPLE") {
        $('#invoice-items .details').each(function() {
            var el = $(this);
            var qty = el.find('.item_quantity').val();
            var rate = el.find('.item_rate').val();
            var tax = el.find('.tax_id option:selected').html();
            tax = parseFloat(GetBetween(tax, '(', '%)'));
            tax = tax / 100;
            if (tax > 0) {
                tax = ((qty * rate) * tax);
            } else {
                tax = 0;
            }
            amount = amount + (qty * rate) + tax;
        });
    } else {
        amount = parseFloat($('[name=amount]').val());
    }

    var el = $('.payment-plan-amounts');

    var symbol = $($('#currency').length == 0 ? '.amount_left' : '#currency :selected').data('symbol');

    $('.difference .value').html(amount.toFixed(2));
    $('.difference .symbol').html(symbol);
    //amountlefttobeadded
    var remaining = getRemainingAmount();
    if (remaining != 0) {
        el.find('.amount_left').addClass('remaining');
        el.find('.amount_left').html("<span class='label'>" + el.find('.amount_left').data(remaining > 0 ? 'amountlefttobeadded' : 'amounttoobig') + "</span>: <span class='symbol'>" + symbol + "</span><span class='value'></span>");
    } else {
        el.find('.amount_left').removeClass('remaining');
        el.find('.amount_left').html(el.find('.amount_left').data('noamountneeded'));
    }
    el.find('.amount_left .value').html(Math.abs(remaining).toFixed(2));

}



$('.partial-payment-delete').live('click', function() {
    $(this).parents('.partial-inputs').slideUp(function() {
        $(this).remove();
        updatePaymentPlanTotals();
    });
    return false;
});

$('#invoice-items .delete').live('click', function() {
    if ($(this).parents('table:first').parents('tbody').children('tr').length > 1) {
        $(this).parents('table:first').parents('tr:first').fadeOut(function() {
            $(this).remove();
            updatePaymentPlanTotals();
        });
    }
    return false;
});


function GetBetween($content, $start, $end) {
    var $r = explode($start, $content);
    if (!empty($r[1])) {
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}

$(function() {
    if ($('.partial-payment-details').length == 0) {
        $('div.partial-inputs .partial-notes').width(386);
    }

    $('.partial-payment-delete:first').hide();

    currentSymbol = '';

    $('#currency').change(function() {
        updatePaymentPlanTotals();
        currentSymbol = $(this).find(':selected').data('symbol');
        $('.partial-percentage option[value=0]').html(currentSymbol);
        $('.partial-percentage .selector').each(function() {
            if ($(this).find('select').val() == 0) {
                $(this).find('span').html(currentSymbol);
            }
        });
    });

    $('select[name^=partial-is_percentage]').change(function() {
        updatePaymentPlanTotals();
    });

    $('input.partial-amount').livequery(function() {
        $(this).forceNumeric();
    });

    $('#is_recurring').change(function() {
        if ($(this).val() == '1') {
            // This invoice is recurring, partial payments are disabled.
            hideMultiparts();
        } else {
            // This invoice is NOT recurring, partial payments are enabled.
            showMultiparts();
        }
    });

    $('.partial-addmore a').click(function() {
        if (!$(this).is(':disabled')) {
            // Button is not disabled, let's create another row for partial payments.

            newLength = ($('.partial-inputs').length + 1);
            // Destroy the first date picker, then rebuild it after cloning.
            $('.partial-inputs:first-child .datePicker').datepicker('destroy');
            newPartial = $('.partial-inputs:first-child').clone();
            newPartial.find('.datePicker').attr('name', 'partial-due_date' + '[' + newLength + ']').datepicker('destroy');
            // Set the new name, then call datepicker again.
            $('.partial-inputs:first-child .datePicker').each(function() {
                $(this).datepicker({
                    dateFormat: datePickerFormat,
                    altFormat: '@',
                    altField: $('[name=' + $(this).data('old-name').replace('[', '\\[').replace(']', '\\]') + ']')
                });
            });

            newPartial.find('a').data('details', newLength).removeClass('key_1').addClass('key_' + newLength);
            newPartial.find('.partial-payment-details span').html($('.partial-input-container').data('markaspaid'));
            newPartial.find('input:not([type=checkbox])').val('');
            var remaining_amount = getRemainingAmount();
            remaining_amount = remaining_amount < 0 ? 0 : round(remaining_amount, 2);
            newPartial.find('input.partial-amount').val(remaining_amount);
            newPartial.find('input[type=checkbox]:checked').click();
            newPartial.find('input:not(.datePicker), select').each(function() {
                $(this).attr('name', $(this).attr('name').replace('[1]', '[' + newLength + ']'))
            });
            select = newPartial.find('select');
            check = newPartial.find('input[type=checkbox]');

            check.attr('id', check.attr('id') + newLength);
            select.attr('id', select.attr('id') + newLength);
            select.val(0);

            newPartial.find('input[type=text]').each(function() {
                $(this).attr('id', $(this).attr('id') + newLength);
            });

            $(newPartial).find('.partial-percentage > .selector').replaceWith(select);

            $(newPartial).find('.checker').replaceWith(check);
            $(newPartial).find('.partial-payment-delete').show();
            newPartial.hide().appendTo('.partial-input-container');
            $('.partial-input-container *:hidden').slideDown('normal');
            $('.partial-payment-delete:first').hide();
            updatePaymentPlanTotals();
            return false;

        }
    });

    $('input[name=type], #client').change();

    $("input.item_name").livequery(function() {

        var cache = {};
        var input = $(this);

        input.autocomplete({
            minLength: 2,
            source: function(request, response) {
                var term = request.term;
                if (term in cache) {
                    response(cache[ term ]);
                    return;
                }

                $.post(baseURL + 'admin/items/ajax_auto_complete', request, function(data) {
                    cache[ term ] = data;
                    response(data);
                }, 'json');
            },
            select: function(event, ui) {

                details = $(input).closest('tr.details');
                description = details.next('tr.description');

                cost = ui.item.qty * ui.item.rate;

                $('input.item_name', details).val(ui.item.name);
                $('input.item_quantity', details).val(ui.item.qty);
                $('input.item_rate', details).val(ui.item.rate);
                $('select.tax_id', details).val(ui.item.tax_id);
                $('input.item_cost', details).val(cost);
                $('span.item_cost', details).text(cost);
                $('select.type', details).val(ui.item.type);

                $('textarea.item_description', description).val(ui.item.description);
                updatePaymentPlanTotals();
            }
        });
    });

    // Count up a row total
    $('input.item_quantity, input.item_rate').forceNumeric().live('keyup', Billing.update_total);

    // Add a new row
    $('a#add-row').click(function() {

        // Remove if there are others to clone
        details = $('#invoice-items tbody tr.details:first');
        description = $('#invoice-items tbody tr.description:first');

        if ($('#invoice-items tbody').children('tr.details:visible').length == 0) {
            details = details.show();
            description = description.show();
        }
        else {
            details = details.clone();
            description = description.clone();
        }

        $('input.item_name', details).val('');
        $('input.item_quantity', details).val(1);
        $('input.item_rate', details).val('1.00');
        $('input.tax_id', details).val('0');
        $('input.item_type_id', details).val('');
        $('input.item_time_entries', details).val('');
        $('input.item_cost', details).val('1.00');
        $('span.item_cost', details).text('1.00');
        $('.type-row select', details).val('standard');

        $('textarea.item_description', description).val('');

        $('#invoice-items > tbody').append('<tr class="parent-line-item-table-row"><td colspan="7" class="parent-line-item-table-cell"><table class="sub-invoice-table"></table></td></tr>');

        $('#invoice-items > tbody > tr:last table').append(details);
        $('#invoice-items > tbody > tr:last table').append(description);

        $('.type-row select', details).each(Billing.update_item_type);

        updatePaymentPlanTotals();
        return false;
    });

    // Remove (or at least hide) a row
    $('a.remove.icon').live('click', function() {

        // Last one, keep it!
        if ($('#invoice-items tbody').children('tr.details').length == 1)
        {
            row = $(this).closest('tr.details').hide();
            row.next('tr.description').hide();
            row.find('input').val('');
        }

        // Remove if there are others to clone
        else
        {
            row = $(this).closest('tr.details');
            row.next('tr.description').andSelf().remove();
        }
        return false;
    });

    $('#add-file-input').click(function(e) {
        e.preventDefault();
        $('#file-inputs').append('<li><input name="invoice_files[]" type="file" /></li>');
    });

    $('.remove_file').click(function() {
        $(this).parent().parent().toggleClass('file_remove');
    });

    $('#add_files_edit').click(function() {
        $('#files tbody').append('<tr><td colspan="4"><input name="invoice_files[]" type="file" /></td></tr>');
        return false;
    });

    /*	$('#description, #notes').htmlarea({
     toolbar: Pancake.toolbars.basic,
     css: Pancake.site_url+"third_party/themes/admin/pancake/css/jHtmlArea.Editor.css",
     });
     */

    $('select[name=is_recurring]').change(function() {

        this.value == 1
                ? $('div#recurring-options').slideDown('slow')
                : $('div#recurring-options').slideUp('slow')

        return false;
    }).change();

    $('body').on('change keyup', 'input.partial-amount, select[id^=partial-percentage], #invoice-items .item_quantity, #invoice-items .item_rate, #invoice-items .tax_id', updatePaymentPlanTotals);
    updatePaymentPlanTotals();

    $('table#invoice-items tbody.make-it-sortable').sortable({
        handle: 'a.sort',
        items: '> tr'
    });

});

function count(o) {
    var c = 0;
    for (k in o) {
        if (o.hasOwnProperty(k)) {
            c++;
        }
    }
    return c;
}

$(document).on('change', '[name=type]', function() {
    var type = this.value;

    $('.type-wrapper').hide();
    if (type == 'ESTIMATE') {
        $('.hide-estimate').hide();
    }
    else {
        $('.hide-estimate').show();
    }

    if (type != 'SIMPLE') {
        $('#DETAILED-wrapper').show();
    }

    var new_text = type == 'ESTIMATE' ? 'estimate' : 'invoice';
    var new_text_ucfirst = type == 'ESTIMATE' ? 'Estimate' : 'Invoice';
    var old_text_ucfirst = type == 'ESTIMATE' ? 'Invoice' : 'Estimate';
    var old_text = type == 'ESTIMATE' ? 'invoice' : 'estimate';
    var update = function(el) {
        el.each(function() {
            $(this).html($(this).html().split(old_text).join(new_text).split(old_text_ucfirst).join(new_text_ucfirst));
        });
    };

    $('.user_permissions_item_type').val(new_text + 's');
    update($('.assigned_users_list p, .assigned_users_list span, .assigned_users_list option, label[for=invoice_number]'));
});

$(document).on('change', '#client', function() {
    var project_id_select = $('#project_id');
    var projects = ['<option value="">' + $('#project_id option:first').text() + '</option>'];
    var value = $(this).val();

    if (typeof (projects_per_client[value]) !== 'undefined') {
        $.each(project_order_per_client[value], function(key, project_id) {
            projects.push('<option value="' + project_id + '">' + projects_per_client[value][project_id] + '</option>');
        });
    }

    project_id_select.html(projects.join(''));

    var original_edit_value = project_id_select.data('original-edit-value');

    if (original_edit_value) {
        project_id_select.find('[value="' + original_edit_value + '"]').attr('selected', 'selected');
    }

});

var Billing = {
    init: function() {
        $(document)
                .on('change', '.type-row select', Billing.update_item_type)
                .on('change', '#project_id', Billing.update_all_item_types)
                .on('change', 'select.item_name', Billing.update_item_id)
                .on('click', '.filter-time-entries', Billing.show_time_entries_modal)
                .on('change', '.toggle_time_entry_inclusion', Billing.toggle_time_entry_inclusion)
                ;

        $('.type-row select').each(function() {
            Billing.update_item_type.call(this, is_editing_invoice);
        });
    },
    toggle_time_entry_inclusion: function() {
        // Expects this to be ".toggle_time_entry_inclusion"
        var el = $(this);
        var id = 0;
        var item = {};
        var line_item = $('.parent-line-item-table-cell:nth(' + el.data('line-item-index') + ')');
        var project_id = parseInt($('#project_id').val(), 10);
        project_id = isNaN(project_id) ? '' : project_id;
        var item_type_id = $('select.item_name', line_item).find(':selected').data('item-type-value');
        item_type_id = typeof item_type_id === 'undefined' ? line_item.find('.item_type_id').val() : item_type_id;
        var new_time_entries = line_item.find('.item_time_entries').val().split(',');
        if (el.is(':checked')) {
            new_time_entries.push(el.data('time-entry-id').toFixed(0));
        } else {
            var key = $.inArray(el.data('time-entry-id').toFixed(0), new_time_entries);
            if (key !== '-1') {
                new_time_entries.splice(key, 1);
            }
        }

        line_item.find('.item_time_entries').val(new_time_entries.join(','));

        if (item_type_id.indexOf("MILESTONE_") !== -1) {
            id = (item_type_id.substr("MILESTONE_".length));
            item = time_entries[project_id].milestones[id];
        } else if (item_type_id.indexOf("TASK_") !== -1) {
            id = (item_type_id.substr("TASK_".length));
            item = time_entries[project_id].tasks[id];
        }

        var details = Billing.calculate_details(item.time_entries, new_time_entries);
        $('input.item_quantity', line_item).val(details.quantity);
        $('input.item_rate', line_item).val(details.rate).each(Billing.update_total);
        $('.item_description', line_item).val(details.notes);

    },
    show_time_entries_modal: function() {
        // Expects this to be ".filter-time-entries"
        var el = $(this);
        var line_item = el.parents('.parent-line-item-table-cell');

        var line_item_index = $('.parent-line-item-table-cell').index(line_item);

        var time_entry_records = {};

        var project_id = parseInt($('#project_id').val(), 10);
        project_id = isNaN(project_id) ? '' : project_id;

        var item_type_id = $('select.item_name', line_item).find(':selected').data('item-type-value');
        item_type_id = typeof item_type_id === 'undefined' ? line_item.find('.item_type_id').val() : item_type_id;

        if (item_type_id.indexOf("MILESTONE_") !== -1) {
            // Milestone
            time_entry_records = time_entries[project_id].milestones[item_type_id.substr("MILESTONE_".length)].time_entries;
        } else if (item_type_id.indexOf("TASK_") !== -1) {
            // Task
            time_entry_records = time_entries[project_id].tasks[item_type_id.substr("TASK_".length)].time_entries;
        }

        var selected_time_entries = line_item.find('.item_time_entries').val().split(',');

        var time_entries_help = show_task_time_interval_help ? '<p>Time entries are rounded up to the nearest ' + task_time_interval + '.<br />You can change this in the "Time Entry Rounding" setting.</p>' : '';

        var html = '<div class="row"><div class="height_transition">' + time_entries_help + '<div class="view_entries_table"><table id="view-entries" class="listtable pc-table table-activity" style="width: 100%;"><thead><tr><th class="cell1">Include in invoice?</th><th class="cell2">User</th><th class="cell3">Date</th><th class="cell4">Duration</th></tr></thead><tbody>';

        $.each(time_entry_records, function(id, row) {
            html += '<tr><td class="cell1 pic"><label style="display:block;"><input type="checkbox" data-line-item-index="' + line_item_index + '" class="toggle_time_entry_inclusion" ' + ($.inArray(row.id, selected_time_entries) !== -1 ? 'checked="checked"' : '') + ' data-item-type-id="' + item_type_id + '" data-time-entry-id="{id}"></label></td>';
            html += '<td class="cell2 user"><img src="http://www.gravatar.com/avatar/{email_md5}?s=40&amp;d=mm&amp;r=g" class="members-pic"> <span class="time-sheet-name">{user_display_name}</span></td>';
            html += '<td class="cell3 date"><span>{date}</span></td>';
            html += '<td class="cell4 duration">{duration}<br /><small>(<span class="start_time"><strong>From:</strong> <span>{start_time}</span><span class="end_time"><strong>To:</strong> <span>{end_time}</span>)</small></td>';

            html = html.split('{id}').join(row.id);
            html = html.split('{email_md5}').join(row.email_md5);
            html = html.split('{user_display_name}').join(row.user_display_name);
            html = html.split('{date}').join(row.date);
            html = html.split('{start_time}').join(row.start_time);
            html = html.split('{end_time}').join(row.end_time);
            html = html.split('{duration}').join(row.duration);
            html = html.split('{note}').join(row.note);
        });

        html += '</tbody></table></div></div>';

        open_reveal(html);
        return false;
    },
    update_all_item_types: function() {
        $('.parent-line-item-table-row .type-row select').each(Billing.update_item_type);
    },
    update_total: function() {
        // Expects this to be "input.item_quantity, input.item_rate"
        var row = $(this).closest('tr');
        var qty = $('input.item_quantity', row).val();
        var rate = $('input.item_rate', row).val();
        var cost = (Math.round((qty * rate) * 100) / 100).toFixed(2);

        $('input.item_cost', row).val(cost);
        $('span.item_cost', row).text(cost);
    },
    update_item_id: function(do_not_recalculate_time_entries) {
        
        if (typeof do_not_recalculate_time_entries !== 'boolean') {
            do_not_recalculate_time_entries = false;
        }
        
        // Expects this to be "select.item_name"
        var el = $(this);
        var line_item = el.parents('.parent-line-item-table-cell');
        var project_id = parseInt($('#project_id').val(), 10);
        project_id = isNaN(project_id) ? '' : project_id;
        var item_type_id = el.find(':selected').data('item-type-value');
        item_type_id = typeof item_type_id === 'undefined' ? line_item.find('.item_type_id').val() : item_type_id;
        var id = 0;
        var item = {};
        var details = {};
        var new_time_entries = [];

        if (do_not_recalculate_time_entries) {
            new_time_entries = $('.item_time_entries', line_item).val();
            if (new_time_entries === '') {
                new_time_entries = [];
            } else {
                new_time_entries = new_time_entries.split(',');
            }
        }

        if (item_type_id.indexOf("MILESTONE_") !== -1) {
            // Milestone
            id = (item_type_id.substr("MILESTONE_".length));
            item = time_entries[project_id].milestones[id];

            if (!do_not_recalculate_time_entries) {
                // Preselect all time entries.
                $.each(item.time_entries, function(key, v) {
                    new_time_entries.push(key);
                });
            }

            details = Billing.calculate_details(item.time_entries, new_time_entries);

            $('.item_time_entries', line_item).val(new_time_entries.join(','));
            $('.item_description', line_item).val(details.notes);
            $('input.item_quantity', line_item).val(details.quantity);
            $('input.item_rate', line_item).val(details.rate).each(Billing.update_total);
        } else if (item_type_id.indexOf("TASK_") !== -1) {
            // Task
            id = (item_type_id.substr("TASK_".length));
            item = time_entries[project_id].tasks[id];

            if (!do_not_recalculate_time_entries) {
                // Preselect all time entries.
                $.each(item.time_entries, function(key, v) {
                    new_time_entries.push(key);
                });
            }
 
            details = Billing.calculate_details(item.time_entries, new_time_entries);

            $('.item_time_entries', line_item).val(new_time_entries.join(','));
            $('.item_description', line_item).val(details.notes);
            $('input.item_quantity', line_item).val(details.quantity);
            $('input.item_rate', line_item).val(details.rate).each(Billing.update_total);
        } else if (item_type_id.indexOf("EXPENSE_") !== -1) {
            // Expense
            id = (item_type_id.substr("EXPENSE_".length));
            item = expenses[project_id][id];

            $('.item_description', line_item).val(item.description);
            $('input.item_quantity', line_item).val(parseFloat(item.qty));
            $('input.tax_id', line_item).val(item.tax_id);
            $('input.item_rate', line_item).val(parseFloat(item.rate)).each(Billing.update_total);
        }

        $('.item_type_id', line_item).val(item_type_id);
    },
    calculate_details: function(time_entries_records, selected_time_entries) {
        var rate = 0;
        var quantity = 0;
        var total = 0;
        var notes = [];
        var task_notes = {};

        $.each(time_entries_records, function(time_entry_id, row) {
            if (typeof selected_time_entries === 'undefined' || $.inArray(row.id, selected_time_entries) !== -1) {
                var task = time_entries[row.project_id].tasks[row.task_id];

                if ((task.notes != '' && task.notes !== null) || settings.include_time_entry_dates == '1') {
                    task_notes[row.task_id] = task.notes;
                }

                var hours = parseFloat(row.minutes) / 60;
                var item_extra = '';
                quantity += hours;
                total += hours * parseFloat(task.rate);

                if ((row.note != '' && row.note !== null) || settings.include_time_entry_dates == '1') {
                    item_extra = settings.include_time_entry_dates == '1' ? row.date + " (" + row.start_time + " - " + row.end_time + ")\n" : '';
                    notes.push(item_extra + row.note);
                }

            }
        });

        var join = function(o, s) {
            var r = [];
            for (var i in o) {
                r.push(o[i]);
            }
            return r.join(s);
        };

        rate = total / quantity;
        rate = parseFloat(rate.toFixed(2));
        quantity = parseFloat(quantity.toFixed(2));
        if (isNaN(rate)) {
            rate = 0;
        }

        if (isNaN(quantity)) {
            quantity = 0;
        }

        task_notes = join(task_notes, "\n\n---\n\n");
        if (task_notes != '') {
            task_notes = task_notes + "\n\n---\n\n";
        }

        notes = task_notes + notes.join("\n\n---\n\n");

        return {
            rate: rate,
            quantity: quantity,
            notes: notes
        };
    },
    update_item_type: function(do_not_update_id) {
        // Expects this to be ".type-row select"

        do_not_update_id = typeof do_not_update_id !== 'undefined' && do_not_update_id;

        var el = $(this);
        var line_item = el.parents('.parent-line-item-table-cell');
        var current_item_id = line_item.find('.item_type_id').val();
        var item_name = line_item.find('.item_name');
        var old_type = item_name.data('item-type');
        old_type = typeof old_type === 'undefined' ? 'standard' : old_type;
        var old_project_id = item_name.data('project-id');
        old_project_id = typeof old_project_id === 'undefined' ? 0 : parseInt(old_project_id, 10);
        var new_el = '';
        var value = el.val();
        var project_id = parseInt($('#project_id').val(), 10);
        var suffix = '';
        var item_type = '';
        var selected_id = '';

        project_id = isNaN(project_id) ? 0 : project_id;

        switch (value) {
            case 'expense':
                if (old_type !== 'expense' || old_project_id !== project_id) {

                    if (old_type !== 'expense') {
                        $('input.item_type_id', line_item).val('');
                        $('input.item_time_entries', line_item).val('');
                    }

                    new_el = '<span class="dropdown-arrow"><select class="item_name" data-project-id="' + project_id + '" data-item-type="expense" name="invoice_item[name][]" >';
                    if (project_id === 0) {
                        new_el = new_el + '<option value="">-- Select a project first --</option>';
                    } else {
                        if (typeof expenses[project_id] === 'undefined') {
                            new_el = new_el + '<option value="">-- No unbilled expenses --</option>';
                        } else {
                            new_el = new_el + '<option value="">-- Select expense --</option>';

                            item_type = "EXPENSE_";
                            selected_id = current_item_id.indexOf(item_type) !== -1 ? (current_item_id.substr(item_type.length)) : null;

                            $.each(expenses[project_id], function(expense_id, expense) {
                                new_el += "<option data-item-type-value='" + item_type + expense_id + "' " + (selected_id === expense_id ? 'selected="selected"' : '') + ">" + expense.name + "</option>";
                            });
                        }
                    }
                    new_el = new_el + '</select></span>';
                    item_name.parents('.name-row').html(new_el);
                    if (!do_not_update_id) {
                        $('select.item_name', line_item).each(function() {
                            Billing.update_item_id.call(this, true);
                        });
                    }
                }
                break;
            case 'time_entry':
                if (old_type !== 'time_entry' || old_project_id !== project_id) {

                    if (old_type == 'expense') {
                        $('input.item_type_id', line_item).val('');
                        $('input.item_time_entries', line_item).val('');
                    }

                    new_el = '<span class="dropdown-arrow"><select class="item_name" data-project-id="' + project_id + '" data-item-type="time_entry" name="invoice_item[name][]" >';
                    if (project_id === 0) {
                        new_el += '<option value="">-- Select a project first --</option>';
                    } else {
                        if (typeof time_entries[project_id] === 'undefined') {
                            new_el += '<option value="">-- No unbilled time entries --</option>';
                        } else {
                            new_el += '<option value="">-- Select time entry --</option>';

                            suffix = '<div class="filter-time-entries"><a href="#" class="blue-btn"><span>Modify Time Entries</span></a></div>';

                            item_type = "MILESTONE_";
                            selected_id = current_item_id.indexOf(item_type) !== -1 ? (current_item_id.substr(item_type.length)) : null;

                            new_el += '<optgroup label="Milestones">';
                            $.each(time_entries[project_id].milestones, function(task_id, task) {
                                new_el += "<option data-item-type-value='" + item_type + task_id + "' " + (selected_id === task_id ? 'selected="selected"' : '') + ">" + task.name + "</option>";
                            });
                            new_el += '</optgroup>';

                            item_type = "TASK_";
                            selected_id = current_item_id.indexOf(item_type) !== -1 ? (current_item_id.substr(item_type.length)) : null;

                            new_el += '<optgroup label="Tasks">';
                            $.each(time_entries[project_id].tasks, function(milestone_id, milestone) {
                                new_el += "<option data-item-type-value='" + item_type + milestone_id + "' " + (selected_id === milestone_id ? 'selected="selected"' : '') + ">" + milestone.name + "</option>";
                            });
                            new_el += '</optgroup>';

                        }
                    }
                    new_el += '</select></span>' + suffix;
                    item_name.parents('.name-row').html(new_el);
                    if (!do_not_update_id) {
                        $('select.item_name', line_item).each(function() {
                            Billing.update_item_id.call(this, true);
                        });
                    }
                }
                break;
            default:
                if (old_type === 'expense' || old_type === 'time_entry') {
                    // It was one of the above before, so now it needs turning back to text.
                    new_el = '<input type="text" class="item_name" data-project-id="' + project_id + '" data-item-type="standard" name="invoice_item[name][]" />';

                    item_name.parents('.name-row').html(new_el);
                    $('input.item_type_id', line_item).val('');
                    $('input.item_time_entries', line_item).val('');
                }
                break;
        }

    }
};

Billing.init();