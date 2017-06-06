$(document).ready(function () {
    /**
     * Toggle the FAQ context to Public.
     */
    publicFAQChoice = function () {
        location.href = buildUrlWithContextParam(location.href, 'public');
    };

    /**
     * Toggle the FAQ context to Professional.
     */
    professionalFAQChoice = function () {
        location.href = buildUrlWithContextParam(location.href, 'professional');
    };

    /**
     * Parse all parameters from the url.
     *
     * @returns object with {"param": "value"}
     */
    var parseQueryString = function () {
        // Tools
        var str = window.location.search;
        var objURL = {};

        str.replace(
            new RegExp("([^?=&]+)(=([^&]*))?", "g"),
            function ($0, $1, $2, $3) {
                objURL[$1] = $3;
            }
        );

        return objURL;
    };

    /**
     * Remove the given parameter from the given url.
     *
     * @param url the url without the given parameter
     * @param parameter the parameter to remove in the given url
     * @returns string the new url without the parameter
     */
    function removeURLParameter(url, parameter) {
        // Prefer to use l.search if you have a location/link object
        var urlParts = url.split('?');
        if (urlParts.length >= 2) {

            var prefix = encodeURIComponent(parameter) + '=';
            var pars = urlParts[1].split(/[&;]/g);

            // Reverse iteration as may be destructive
            for (var i = pars.length; i-- > 0;) {
                // Idiom for string.startsWith
                if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                    pars.splice(i, 1);
                }
            }

            url = urlParts[0] + (pars.length > 0 ? '?' + pars.join('&') : "");
            return url;
        } else {
            return url;
        }
    }

    /**
     * Build the context parameter (public/professional) for the given url.<br>
     * Add & or ? according to the other parameters already present in the given url.
     *
     * @param url the url
     * @returns string the default context param
     */
    function buildContextParam(url, defaultContext) {
        return (url.split('?')[1] ? '&' : '?') + 'context=' + defaultContext;
    }

    /**
     * Build the given url with the given context param.
     *
     * @param url the current url
     * @param contextToSet the context to add as param to the given url
     * @returns string the given url with the context param added
     */
    function buildUrlWithContextParam(url, contextToSet) {
        var cleanUrl = removeURLParameter(url, 'context');
        var contextParamToAdd = buildContextParam(cleanUrl, contextToSet);
        return cleanUrl + contextParamToAdd;
    }

    /**
     * Add the default context parameter to the url if not present or wrong.
     */
    function addContextParam() {
        // Tools
        var allowedContext = ['public', 'professional'];
        var params = parseQueryString();

        // Check in local storage
        var contextPersisted = localStorage.getItem('context');
        // Try to get the context param present in the url
        var contextValue = params['context'];

        // Check if the context param is present in the url
        if (contextValue) {
            // Check if the context value is not allowed
            if ($.inArray(contextValue, allowedContext) < 0) {
                // Persist the default context
                localStorage.setItem('context', 'public');
                // Reload the page with the default context param
                location.href = buildUrlWithContextParam(location.href, 'public');
            } else {
                // Persist the context
                localStorage.setItem('context', contextValue);
            }
        } else {
            // Check in local storage first
            if (contextPersisted) {
                // Reload the page with the context param from the local storage
                location.href = buildUrlWithContextParam(location.href, contextPersisted);
            } else {
                // Persist the default context
                localStorage.setItem('context', 'public');
                // Reload the page with the default context param
                location.href = buildUrlWithContextParam(location.href, 'public');
            }
        }
    }

    // Method called when the page has been loaded
    addContextParam();
});


