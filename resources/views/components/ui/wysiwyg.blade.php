@props(['value' => '', 'name', 'height' => 400])

<div>
    <textarea id="ckeditor-{{ $name }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'textarea']) }}>{!! $value !!}</textarea>
</div>

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const el = document.querySelector('#ckeditor-{{ $name }}');
            if (el) {
                const mentionables = @json(App\Mentions\Mentionables::get());

                ClassicEditor
                    .create(el, {
                        heading: {
                            options: [{
                                    model: 'paragraph',
                                    title: 'Paragraph',
                                    class: 'ck-heading_paragraph'
                                },
                                {
                                    model: 'heading1',
                                    view: 'h1',
                                    title: 'Heading 1',
                                    class: 'ck-heading_heading1'
                                },
                                {
                                    model: 'heading2',
                                    view: 'h2',
                                    title: 'Heading 2',
                                    class: 'ck-heading_heading2'
                                },
                                {
                                    model: 'heading3',
                                    view: 'h3',
                                    title: 'Heading 3',
                                    class: 'ck-heading_heading3'
                                }
                            ]
                        }
                    })
                    .then(editor => {
                        const tribute = new Tribute({
                            trigger: "@",
                            values: mentionables,
                            selectTemplate: function(item) {
                                return item.original.value;
                            },
                            menuItemTemplate: function(item) {
                                return item.original.value + " (" + item.original.key + " )";
                            }
                        });

                        const editableElement = editor.ui.getEditableElement();
                        tribute.attach(editableElement);

                        tribute.range.pasteHtml = function(html, startPos, endPos) {
                            editor.model.change(writer => {
                                const position = editor.model.document.selection.getFirstPosition();
                                writer.insertText(html, position);
                            });
                        };
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        });
    </script>
@endpush

@push('styles')
    <style>
        .ck-editor__editable_inline {
            min-height: {{ $height }}px;
        }
    </style>
@endpush
