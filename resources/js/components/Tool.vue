<script>
export default {
    data: function () {
        return {
            changelog: [],
            isLoading: true,
            nextLink: "",
            previousLink: "",
        };
    },

    mounted: function () {
        this.loadChangelog();
    },

    methods: {
        loadChangelog: function (minorVersion = "") {
            var self = this;

            Nova.request().get("/genealabs/laravel-changelog/api/entries/" + minorVersion)
                .then(function (response) {
                    console.log(response.data);
                    self.changelog = response.data;
                    self.nextLink = response.next;
                    self.previousLink = response.previous;
                    self.isLoading = false;
                })
                .catch(function (error) {
                    console.error(error, error.data);
                });
        },
    },
};
</script>

<template>
    <div>
        <h1 class="mb-6">Change Log</h1>

        <loading-view
            :loading="isLoading"
        >
            <div 
                v-for="(entry, index) in changelog"
                :key="index"
            >
                <div v-if="entry.details">
                    <h2 class="mb-2">
                        <span v-text="entry.version"></span>
                        <span class="text-70 font-normal ml-6" v-text="entry.date"></span>
                    </h2>
                    <card class="mb-8 p-4">
                        <p class="details" v-html="entry.details"></p>
                    </card>
                </div>
            </div>
        </loading-view>
    </div>
</template>

<style scoped lang="scss">
    //
</style>
