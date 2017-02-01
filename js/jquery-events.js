/**
 * Created by rantenesse on 1/20/2017.
 */

var allWarnings = [];
var fusejsOptions = {
    shouldSort: true,
    threshold: 0.25,
    location: 0,
    distance: 100,
    maxPatternLength: 32,
    minMatchCharLength: 1,
    keys: [
        'text'
    ]
};

var validate = {
    linkForm: function () {
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
,   newWarning: function () {
        'use strict';
        var newWarning = $('#newWarning').val();

        $('#newWarningError').html('');
        $('#newWarning').removeClass('is-danger');

        var fuse = new Fuse(allWarnings, fusejsOptions); // "list" is the item array
        var fuzzySearch = fuse.search(newWarning);

        if (newWarning === '') {
            $('#newWarningError').html('You must enter a New Warning value.');
            $('#newWarning').addClass('is-danger');
            return false;
        }
        if (fuzzySearch.length > 0) {
            $('#newWarningError').html('Are you sure your warning isn&rsquo;t listed?');
            $('#newWarning').addClass('is-warning');
            return false;
        }
        if (/[^a-z0-9áéíóúñü \.\/,_-–—]/gi.test(newWarning)) {
            $('#newWarningError').html('Please use letters, numbers, hyphens, etc. only&mdash;no parentheses or code.');
            $('#newWarning').addClass('is-warning');
            return false;
        }

        return true;
    }
}

$(document).ready(function () {
    // Initialize fancy select boxes.
    $.getJSON('./actions/fetch_warnings.php', function (data) {
        allWarnings = data.map(function (item) {
            return {
                id: item.id
            ,   text: item.term
            ,   isProposed: (item['is_proposed'] === '1')
            };
        });

        $('#warnings').select2({
            placeholder: 'Search and choose up to 3'
        ,   maximumSelectionLength: 3
        ,   data: allWarnings
        ,   language: {
                noResults: function () {
                    return ('No Results Found. Do you want to <a href="/newwarning">propose it as a new warning</a>?');
                }
          }
        ,   escapeMarkup: function (markup) {return markup}
        ,   templateResult: function (data, container) {
                var note = '';

                if (data.isProposed) {
                    note = '<span class="tag is-warning">User-Added Warning</span>';
                }

                var output = '<div class="level is-mobile"><div class="level-left">'
                    + '<div class="level-item">'
                        + data.text
                    + '</div>'
                    + '<div class="level-item">'
                        + note
                    + '</div>'
                + '</div></div>';

                return output;
            }
        }).select2('val', [$('#preselectedWarning').val()]);

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

    $('.nav-toggle').click(function () {
        'use strict';
        console.log('hello');
        $('.nav-menu').toggleClass('is-active');
    })

    $('#getLink').click(function () {
        'use strict';
        if (validate.linkForm()) {
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

    $('#submitNewWord').click(function () {
        'use strict';
        if (validate.newWarning()) {
            var newWarning = $('#newWarning').val();

            var dataPacket = {
                new_warning: newWarning
            };

            // console.log(dataPacket);

            $.post('actions/new_warning.php', dataPacket, function (data) {
                var response = data;
                if (data === 'no warning') {
                    response = '<p>No warning was provided. Please try again later.</p>';
                }
                if (data === 'failed') {
                    response = '<p>Could not add warning. Please try again later.</p>';
                }

                $('#output').html('<div class="level"><div class="level-left">' + response + '</div></div>');
            });
        }
    });

    $('#url').keypress(function(event){
        if (event.keyCode === 13) {
            $('#getLink').click();
        }
    });

    $('#newWarning').keypress(function(event){
        if (event.keyCode === 13) {
            $('#submitNewWord').click();
        }
    });

    $('#newWarning').on('input', function(event){
        var newWarning = $(this).val();
        var fuse = new Fuse(allWarnings, fusejsOptions); // "list" is the item array
        var fuzzySearch = fuse.search(newWarning);

        if (fuzzySearch.length > 0) {
            var searchList = '<ul>';
            for (var i = 0; i < fuzzySearch.length; i++) {
                searchList += ''
                    + '<li>'
                        + '<a href="/~' + fuzzySearch[i].id + '" title="Use this choice">'
                            + fuzzySearch[i].text
                        + '</a>'
                    + '</li>'
                ;
            }
            searchList += '</ul>';
            $('#alreadyListedHelp').show();
            $('#alreadyListed').html(searchList);
        } else {
            $('#alreadyListedHelp').hide();
            $('#alreadyListed').html('');
        }
    });
});
