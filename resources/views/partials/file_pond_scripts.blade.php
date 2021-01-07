<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>

<script>
    FilePond.registerPlugin(FilePondPluginImagePreview);
    FilePond.setOptions({
        allowDrop: true,
        allowReplace: false,
        instantUpload: true,
        allowMultiple: false,
        allowReorder: true,
        imagePreviewHeight: 120,
        server: {
            url: "{{route('upload.image')}}",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
        }
    });

    function createFilePond(inputName, hiddenName) {
        const hiddenElement = $("#" + hiddenName);
        function getArray() {
            const hiddenText = hiddenElement.val()
            return hiddenText.split(',').filter(a => a !== "")
        }
        function setArray(files) {
            var array = files.map(a => a.serverId).filter(a => a);
            hiddenElement.val(array.join(","));
        }
        const pond = FilePond.create(document.getElementById(inputName), {
            files: getArray().map(fileName => ({
                source: fileName,
                options: {
                    type: 'local'
                }
            }))
        });
        pond.on('processfile', (error, file) => {
            if (error) return;
            setArray(pond.getFiles());
        });
        pond.on('removefile', (file) => {
            setArray(pond.getFiles());
        })
        pond.on('reorderfiles', (files) => {
            setArray(files);
        })
    }
</script>
