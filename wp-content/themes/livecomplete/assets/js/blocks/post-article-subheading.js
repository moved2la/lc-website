(function (blocks, element, blockEditor) {
    var el = element.createElement;
    var RichText = blockEditor.RichText;

    blocks.registerBlockType('theme-blocks/post-article-subheading', {
        title: 'Post Article Subheading',
        icon: 'heading',
        category: 'livecomplete',
        attributes: {
            subheadingText: {
                type: 'string',
                default: 'Conclusion'
            }
        },
        edit: function (props) {
            return el(
                'div',
                { className: 'post-article-subheading' },
                el(RichText, {
                    tagName: 'div',
                    className: 'post-article-subheading',
                    value: props.attributes.subheadingText,
                    onChange: function (newText) {
                        props.setAttributes({ subheadingText: newText });
                    },
                    placeholder: 'Enter subheading text...'
                })
            );
        },
        save: function () {
            return null; // Dynamic block, render callback handles the frontend
        }
    });
})(window.wp.blocks, window.wp.element, window.wp.blockEditor); 