<template>
    <div>
        <div class="flex items-center justify-center">
            <file-upload
                ref="upload"
                name="import_file"
                v-model="import_file"
                post-action="api/upload"
                @input-file="inputFile"
                @input="updateSelectedFile"
            >
                <button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow mr-2">
                    {{ selected_file }}
                </button>
            </file-upload>
            <button v-show="!$refs.upload || !$refs.upload.active" @click.prevent="$refs.upload.active = true" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Upload
            </button>
        </div>

        <entries :entries="entries"></entries>
    </div>
</template>

<script>
    import Entries from "./Entries";

    export default {
        name: 'upload',

        components: {Entries},

        data: () => ({
            import_file: [],
            entries: false,
            selected_file: 'Select file',
        }),

        methods: {
            /**
             * Has changed
             * @param  Object|undefined   newFile   Read only
             * @param  Object|undefined   oldFile   Read only
             * @return undefined
             */
            inputFile: function (newFile, oldFile) {
                if (newFile && oldFile && !newFile.active && oldFile.active) {
                    if (newFile.xhr) {
                        this.entries = JSON.parse(newFile.xhr.response);
                    }
                }
            },

            updateSelectedFile(value) {
                this.selected_file = value[0].name;
            }
        },
    }
</script>
