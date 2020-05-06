<template>
    <div class="d-flex flex-wrap align-items-center justify-content-end mb-3">
        <label class="mb-0 mr-2">Select date: </label>
        <date-range-picker
            opens="left"
            :date-range="{
                startDate: params.from,
                endDate: params.to,
            }"
            :locale-data="localeData"
            :ranges="false"
            @update="(ranges) => filter(handleUpdate(ranges))"
        >
            <template v-slot:input="picker" style="min-width: 320px;">
                {{ getDateByFormat(picker.startDate) }} - {{ getDateByFormat(picker.endDate) }}
            </template>
        </date-range-picker>
        <button type="button" class="btn btn-outline-secondary ml-2" @click="clearFilter">Clear</button>
    </div>
</template>

<script>
    import DateRangePicker from "vue2-daterange-picker";
    import "vue2-daterange-picker/dist/vue2-daterange-picker.css";

    export default {
        components: {
            DateRangePicker,
        },

        props: {
            params: {
                type: Object,
                required: true,
                default() {
                    return {
                        from: null,
                        to: null,
                    }
                }
            },

            filter: {
                type: Function,
                required: true,
                default() {
                    return () => {
                    };
                }
            }
        },

        data() {
            return {
                localeData: {
                    format: 'yyyy-mm-dd',
                },
            }
        },

        methods: {
            getDateByFormat(date) {
                return date && date.toISOString().split('T')[0];
            },

            handleUpdate(ranges) {
                return {
                    from: this.getDateByFormat(ranges.startDate),
                    to: this.getDateByFormat(ranges.endDate),
                }
            },

            clearFilter() {
                this.filter({
                    from: null,
                    to: null,
                })
            }
        }
    }
</script>
