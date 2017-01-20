/**
 * Created by rantenesse on 1/20/2017.
 */

function formIsValid () {
    'use strict';
    var warnings = [
        $('#warning1').val()
    ,   $('#warning2').val()
    ,   $('#warning3').val()
    ];
    var url = $('#url').val();

    $('#warningsError, #urlError').html('');
    $('#warning1, #url').removeClass('is-danger');

    var aWarningIsSelected = warnings.some(function (warning) {
        return warning !== '';
    });

    if (!aWarningIsSelected) {
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
    $('#submit').click(function () {
        'use strict';
        if (formIsValid()) {
            var warnings = [
                $('#warning1').val()
            ,   $('#warning2').val()
            ,   $('#warning3').val()
            ];
            var url = $('#url').val();

            var href = window.location.href;
            var dir = href.substring(0, href.lastIndexOf('/')) + "/";

            var warningPathString = '';
            for (var i = 0; i < warnings.length; i++) {
                if (warnings[i] !== '') {
                    warningPathString += warnings[i] + '|';
                }
            }

            $.post('actions/encode_url.php', {url: warningPathString + url}, function (data) {
                var link = dir + '!' + data;
                var html = '<input class="input is-expanded" id="result" type="text" readonly="readonly" value="' + link + '" />';
                var copyButton = '<a class="button is-info" id="copyButton" data-clipboard-target="#result">Copy</a>'
                $('#output').html(html + copyButton);

                new Clipboard('#copyButton');
            });
        }
    });
});
