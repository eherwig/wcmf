
// dynamically define requirements
var requirements = [
    "dojo/_base/declare"
];

// add display type renderers to requirements
var displayTypes = appConfig.displayTypes;
for (var key in displayTypes) {
    requirements.push(displayTypes[key]);
}

define(
    requirements
,
function(
) {
    // extract requirements manually from arguments object
    var declare = arguments[0];
    var Renderer = declare(null, {
    });

    Renderer.renderers = {};
    var i=0;
    for (var key in displayTypes) {
        renderers[key] = arguments[++i];
    }


    /**
     * Render the given value according to the given display type.
     * @param value The value
     * @param displayType The display type
     * @returns String
     */
    Renderer.render = function(value, displayType) {
        var renderer = Renderer.getRenderer(displayType);
        if (renderer instanceof Function) {
            return renderer(value);
        }
        return value;
    };

    Renderer.getRenderer = function(displayType) {
        var displayTypes = Renderer.renderers;

        // get best matching renderer
        var bestMatch = '';
        for (var rendererDef in displayTypes) {
            if (displayType.indexOf(rendererDef) === 0 && rendererDef.length > bestMatch.length) {
                bestMatch = rendererDef;
            }
        }
        // get the renderer
        if (bestMatch.length > 0) {
            var controlClass = displayTypes[bestMatch];
            return controlClass;
        }
        // default
        return "js/ui/data/display/renderer/Text";
    };

    return Renderer;
});