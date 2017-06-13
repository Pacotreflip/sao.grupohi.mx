/**
 * Created by JFEsquivel on 13/06/2017.
 */

$(function ()  {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': App.csrfToken
        }
    });
});