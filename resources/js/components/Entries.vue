<template>
    <div>
        <div class="relative mb-4" v-if="new_entries">
            <button @click="download_open = !download_open" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center mt-4">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
                <span>Download</span>
            </button>
            <div v-if="download_open" class="absolute mt-1 py-2 w-48 bg-white rounded-lg shadow-xl">
                <a href="javascript:" @click.prevent="downloadList('json')" class="block px-4 py-2 text-gray-800 hover:bg-indigo-500 hover:text-white">JSON</a>
                <a href="javascript:" @click.prevent="downloadList('csv')" class="block px-4 py-2 text-gray-800 hover:bg-indigo-500 hover:text-white">CSV</a>
                <a href="javascript:" @click.prevent="downloadList('xml')" class="block px-4 py-2 text-gray-800 hover:bg-indigo-500 hover:text-white">XML</a>
            </div>
        </div>

        <div v-for="(item,index) in new_entries" :key="`index_${item.id}`" class="flex items-center -mx-2">
            <label class="block px-2">
                <input class="form-input mt-1 block w-full" v-model="new_entries[index]['country']">
            </label>
            <label class="block px-2">
                <input class="form-input mt-1 block w-full" v-model="new_entries[index]['capital']">
            </label>
            <button @click.prevent="removeEntry(item)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">
                Delete
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'entries',

        props: ['entries'],

        watch: {
            entries(items) {
                this.new_entries = items.data;
            },
        },

        data: () => ({
            new_entries: false,
            download_open: false,
        }),

        methods: {
            removeEntry(item) {
                this.new_entries = this.new_entries.filter((obj) => obj.id !== item.id );
            },
            downloadList(type) {
               axios.post('/api/generate-list', {
                   'type': type,
                   'items': this.new_entries,
               }).then((response) => {
                    console.log(type, response.data);
                });
            },
        },
    }
</script>
