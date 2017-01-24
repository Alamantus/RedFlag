/**
 * Created by rantenesse on 1/20/2017.
 */

function formIsValid () {
    'use strict';
    var warnings = $('#warnings').val();
    var url = $('#url').val();

    $('#warningsError, #urlError').html('');
    $('#warning1, #url').removeClass('is-danger');

    if (warnings === null) {
        $('#warningsError').html('You must select at least one warning.');
        $('#warning1').addClass('is-danger');
        return false;
    }

    if (url === '') {
        $('#urlError').html('You must enter a url value.');
        $('#url').addClass('is-danger');
        return false;
    }
    if (url.indexOf('http') < 0 || url.indexOf('://') < 0) {
        $('#urlError').html('Please include the "http://" or "https://" segment of your link.');
        $('#url').addClass('is-danger');
        return false;
    }
    if (url.indexOf(window.location.hostname) >= 0) {
        $('#urlError').html('Please don&rsquo; link to this site&mdash;it causes problems when loading the link.');
        $('#url').addClass('is-danger');
        return false;
    }
    if (!re_weburl.test(url)) {
        $('#urlError').html('Please use a real, valid url.');
        $('#url').addClass('is-danger');
        return false;
    }

    return true;
}

$(document).ready(function () {
    // Initialize fancy select boxes.
    $.getJSON('./actions/fetch_warnings.php', function (data) {
        $('#warnings').select2({
            placeholder: 'Search and choose up to 3'
        ,   maximumSelectionLength: 3
        ,   data: data.map(function (item) {return {id:item.id, text:item.term}})
        ,   language: {
                noResults: function () {
                    return ('No Results Found. Do you want to propose it as a new warning?');
                }
          }
        ,   escapeMarkup: function (markup) {return markup}
        });
        $('.select2-container').css('width', '100%');
        $('#warningsControl').removeClass('is-loading');
    });

    if ($('#backButton').attr('href') === window.location.href
        || $('#backButton').attr('href') === '') {
        // If the user pastes the link into their address bar, the PHP Referrer doesn't work.
        // So instead, try reassigning the button to the back() function.
        $('#backButton').removeAttr('href');
        $('#backButton').click(function () {
            window.history.back();
        });
    }

    $('.content').each(function () {
        var markdownText = marked($(this).text());
        $(this).html(markdownText);
    });

    $('#submit').click(function () {
        'use strict';
        if (formIsValid()) {
            var warnings = $('#warnings').val();
            var url = $('#url').val();

            var href = window.location.href;
            var dir = href.substring(0, href.lastIndexOf('/')) + "/";

            var dataPacket = {
                warnings: JSON.stringify(warnings)
            ,   url: url
            };

            // console.log(dataPacket);

            $.post('actions/encode_url.php', dataPacket, function (data) {
                var link = dir + '!' + data;
                if (data === 'failed') {
                    link = 'Please try again later';
                }
                var copyButton = '<a class="button is-info" id="copyButton" data-clipboard-target="#result">Copy</a>'
                var html = '<input class="input is-expanded" id="result" type="text" readonly="readonly" value="' + link + '" />';
                $('#output').html(copyButton + html);

                new Clipboard('#copyButton');
            });
        }
    });

    $('#url').keypress(function(event){
        if(event.keyCode==13) {
            $('#submit').click();
        }
    });
});
