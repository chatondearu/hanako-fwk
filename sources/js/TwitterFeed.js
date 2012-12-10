/**
 * @name TwitterFeed.js
 * @description get TwitterFeed and show it.
 * @dependency Jquery >= 1.7.1
 * @author Romain Lienard <me@rlienard.fr>
 * @http: http://rlienard.fr
 * @copyright (c)2012 rlienard (Romain Lienard)
 * @version 0.0.1
 * @package ***
 * @date: 26/11/2012
 * @time: 11:59
 *
 *	Permission is hereby granted, free of charge, to any person obtaining a copy of this
 *	software and associated documentation files (the "Software"), to deal in the Software
 *	without restriction, including without limitation the rights to use, copy, modify, merge,
 *	publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons
 *	to whom the Software is furnished to do so, subject to the following conditions:
 *
 * 	The above copyright notice and this permission notice shall be included in all copies
 *	or substantial portions of the Software.
 *
 *	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING
 *	BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 *	NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 *	DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * 	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 **/


(function(window, jQuery, undefined){
    'use strict';

////////////////////////////////////
    /*
     * Set up global to TwitterFeed and all Modul
     *
     * Root
     * */
    var TwitterFeedRoot,
    //Get all environment's arguments

        document = window.document,
        location = window.location,
        navigator = window.navigator,

    // Copy Jquery Frameworks
        _Jquery = window.jQuery || (window.jQuery = {}),
        if_Jquery = !!(_Jquery.jquery != 'none'),

    //Constante of TwitterFeed params
        conf = {
            DEBUG:true
        },

    //Set the local copy of Core definition
        TwitterFeed = function(){
            return new TwitterFeed.fn.init(TwitterFeedRoot);
        };


    /**
     * @name TwitterFeed.fn
     *
     * @description we Initialize TwitterFeed Object and instantiates TwitterFeed.fn
     * @type {Object}
     */
    TwitterFeed.fn = TwitterFeed.prototype = {
        constructor : TwitterFeed,
        init : function(TwitterFeedRoot) {


            return TwitterFeedRoot = this;
        },
        // The current version of TwitterFeed being used
        twitterFeed: "0.0.1",
        // The default length of a TwitterFeed object is 0
        length: 0
    };

    TwitterFeed.fn.init.prototype = TwitterFeed.fn;

    function loaded() {
        $(function() {

            var twitter_API_BaseURL = 'https://api.twitter.com/1/statuses/user_timeline.json?screen_name=Sxmcrow&count=10';
            var html = '';

            $('<ul />').appendTo('#twitter');

            $.getJSON(twitter_API_BaseURL, function(json) {
                $.each(json, function(i, item) {
                    var text = $.toLink(item.text);
                    var profileImageURL = item.user.profile_image_url;
                    html += '<li><img src="' + profileImageURL + '" />' + text + '</li>';
                });
                $('ul', '#twitter').html(html);
            });

            console.log(html);

        });
    }

    loaded();

    window.TwitterFeed = TwitterFeed();

})(window, jQuery);