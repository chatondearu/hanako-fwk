/*
 @from: http://davidwalsh.name/jquery-objects
 */

(function() {

    // Utility method to get and set objects that may or may not exist
    var objectifier = function(splits, create, context) {
        var result = context || window;
        for(var i = 0, s; result && (s = splits[i]); i++) {
            result = (s in result ? result[s] : (create ? result[s] = {} : undefined));
        }
        return result;
    };

    // Gets or sets an object
    jQuery.obj = function(name, value, create, context) {
        // Setter
        if(value != undefined) {
            var splits = name.split("."), s = splits.pop(), result = objectifier(splits, true, context);
            return result && s ? (result[s] = value) : undefined;
        }
        // Getter
        else {
            return objectifier(name.split("."), create, context);
        }
    };

})();