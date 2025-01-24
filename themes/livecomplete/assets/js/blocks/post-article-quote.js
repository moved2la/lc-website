(function(blocks, element, blockEditor) {
    var el = element.createElement;
    var RichText = blockEditor.RichText;

    blocks.registerBlockType('theme-blocks/post-article-quote', {
        title: 'Post Article Quote',
        icon: 'format-quote',
        category: 'livecomplete',
        attributes: {
            quoteText: {
                type: 'string',
                default: ''
            }
        },
        edit: function(props) {
            return el(
                'div',
                { className: 'post-article-quote' },
                el('div', 
                    { className: 'quote-figure' },
                    [
                        el('div', { className: 'divider' }),
                        el(RichText, {
                            tagName: 'div',
                            className: 'quote-text',
                            value: props.attributes.quoteText,
                            onChange: function(newText) {
                                props.setAttributes({ quoteText: newText });
                            },
                            placeholder: 'Enter quote text...'
                        })
                    ]
                )
            );
        },
        save: function() {
            return null;  // Using server-side render
        }
    });
})(window.wp.blocks, window.wp.element, window.wp.blockEditor); 